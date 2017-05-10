<?php
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
        
        $this->data['articles'] = $this->model->getList();
        
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
        $this->data['articles'] = $this->model->getList();
    }
    
    public function admin_edit()
    {
        
    }
    
    public function admin_delete()
    {
        
    }
    
    public function admin_add()
    {
        
    }
}

