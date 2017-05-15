<?php
<<<<<<< HEAD:controllers/articles.controller.php
=======
namespace Application\Controllers;

use Application\Lib\Controller;
use Application\Models\Article;
use Application\Lib\Session;
use Application\Lib\App;
use Application\Lib\Router;

>>>>>>> maroc:app/controllers/ArticlesController.php
error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class ArticlesController extends Controller
{
    
    public function __construct( $pData = array() ) 
    {
        parent::__construct($pData);
        
        $this->model = new Article();
    }
    
    public function index()
    {
        
        $this->data['articles'] = $this->model->getAll();
    }
    
    public function view()
    {
        
        if( isset( $this->params[0] ) ) {
            
            $article_id = ( int ) $this->params[0];
            
            $this->data['article']  = $this->model->getById( $article_id ) ;
            $this->data['author']   = $this->model->getAuthor($article_id );
            $this->data['comments'] = $this->model->getComments( $article_id );
        }
    }
    
    /**
     * Adding a new article
     */
    public function add()
    {
        if( !Session::get( 'user' ) ) {
            $this->redirect_path = '/' . App::getRouter()->getLanguage() . '/users/login';
            $this->redirect();
        }
        
        if( !isset( $_POST['title'] ) || !isset( $_POST['content'] ) )
            return false;
        
        if( $this->model->save( $_POST ) ) {
            
            Session::setFlash( 'A new page was successfully created!', 'alert-info' );
            
            $this->redirect_path = '/' . App::getRouter()->getLanguage();
            $this->redirect();
        
        } else {
            Session::setFlash( 'Error: A new page could not be created!', 'alert-danger' );
        }
    }
    
    public function admin_index()
    {
        $this->data['articles'] = $this->model->getAll();
    }
    
    public function admin_edit()
    {
        $param = App::getRouter()->getParams();
        
        if( !isset( $param[0] ) )
            return false;
        
        $this->data['article'] = $this->model->getById( $param[0] );
    }
    
    public function admin_delete()
    {
        
        $params = App::getRouter()->getParams();
        
        if( isset( $params[0] ) ) {
            
            $result = $this->model->remove( (int) $params[0] );
            
            Session::setFlash ( $result ? 'The selected article was successfully deleted!' : 'Error: article could not be deleted!' );
            
            Router::redirect( '/admin' );
        }
    }
    
    public function admin_add()
    {
        
    }
}

