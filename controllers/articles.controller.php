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
        
        $this->data = $this->model->getList();
    }
    
    public function view()
    {
        $params = App::getRouter()->getParams();
        
        if( isset( $params[0] ) ) {
            
            $article_id = ( int )$params[0];
            
            $this->data['article']  = $this->model->getById( $article_id ) ;
            $this->data['author']   = $this->model->getAuthor($article_id );
            $this->data['comments'] = $this->model->getComments( $article_id );
        }
    }
    
    public function add()
    {
        
    }
    
    public function admin_index()
    {
        $this->data = $this->model->getList();
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

