<?php
namespace Application\Controllers;

use Application\Lib\Controller;
use Application\Models\Article;
use Application\Lib\Session;
use Application\Lib\App;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class ArticlesController extends Controller
{
    
    public function __construct( $pData = array() ) 
    {
        parent::__construct( $pData );
        
        $this->model = new Article();
    }
    
    public function index()
    {
        
        $this->data['articles'] = $this->model->getAll();
        $this->data['language'] = App::getRouter()->getLanguage();
    }
    
    public function view()
    {
        if( isset( $this->params[0] ) ) {
            
            $article_id = ( int ) $this->params[0];
            
            $this->data['article']  = $this->model->getById( $article_id ) ;
            $this->data['author']   = $this->model->getAuthor($article_id );
            $this->data['comments'] = $this->model->getComments( $article_id );
            $this->data['language'] = App::getRouter()->getLanguage();
        }
    }
    
    public function archiv()
    {
        if( count($this->params) === 2 ) {
        
            $month  = (int) $this->params[0];
            $year   = (int) $this->params[1];

            $this->data['results'] = $this->model->getArchives( $month, $year );
        }
    }

        /**
     * Adding a new article
     */
    public function add()
    {
        $lang = App::getRouter()->getLanguage();
        
        if( !Session::get( 'user' ) ) {
            $this->redirect_path = '/' . $lang . '/users/login';
            $this->redirect();
        }
        
        if( !isset( $_POST['title'] ) || !isset( $_POST['content'] ) )
            return false;
        
        if( $this->model->add( $_POST ) ) {
            
            Session::setFlash( 'A new page was successfully created!', Session::SEVERITY_SUCCESS );
            
            $this->redirect_path = '/' . $lang;
            $this->redirect();
        
        } else {
            Session::setFlash( 'Error: A new page could not be created!', Session::SEVERITY_WARNING );
        }
    }
    
    public function admin_index()
    {
        $this->data['articles'] = $this->model->getAll( false );
        $this->data['language'] = App::getRouter()->getLanguage();
        
    }
    
    public function admin_edit()
    {
        $param = App::getRouter()->getParams();
        $lang  = App::getRouter()->getLanguage();
        
        if( !isset( $param[0] ) )
            return false;
        
        $this->data['article'] = $this->model->getById( (int) $param[0] );
        
        if( !isset( $_POST['article_id'] ) ) {
            return false;
        }
        
        $article_id = $_POST['article_id'];
        
        $result = $this->model->edit( $_POST, $article_id );

        if( $result ) {
            Session::setFlash( 'Article was successfully edited', Session::SEVERITY_SUCCESS );
            
        } else {
            Session::setFlash( 'Error: The required article could not be updated', Session::SEVERITY_WARNING );
        }
        
        $this->redirect_path = '/admin/' . $lang;
        $this->redirect();
    }
    
    public function admin_delete()
    {
        
        $params = App::getRouter()->getParams();
        $lang   = App::getRouter()->getLanguage();
        
        if( isset( $params[0] ) ) {
            
            $result = $this->model->remove( (int) $params[0] );
            
            if( $result ) {
                Session::setFlash ( 'The selected article was successfully deleted!', Session::SEVERITY_SUCCESS );
                
            } else {
                Session::setFlash ( 'Error: article could not be deleted!', Session::SEVERITY_WARNING );
            }
            $this->redirect_path = '/admin/' . $lang;
            $this->redirect();
        }
    }
    
    public function admin_add()
    {
        $lang = App::getRouter()->getLanguage();
        
        if( !Session::get( 'user' ) ) {
            $this->redirect_path = '/' . $lang . '/users/login';
            $this->redirect();
        }
        
        if( !isset( $_POST['title'] ) || !isset( $_POST['content'] ) )
            return false;
        
        if( $this->model->add( $_POST ) ) {
            
            Session::setFlash( 'A new page was successfully created!', Session::SEVERITY_SUCCESS );
            
            $this->redirect_path = '/admin/' . $lang;
            $this->redirect();
        
        } else {
            Session::setFlash( 'Error: A new page could not be created!', Session::SEVERITY_WARNING );
        }
    }
}

