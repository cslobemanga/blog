<?php
error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class PagesController extends Controller
{
    public function __construct( $pData = array() ) 
    {
        parent::__construct( $pData );
        
        $this->model = new Page();
    }

    public function index() 
    {
        $this->data['pages'] = $this->model->getList();
    }
    
    public function view()
    {
        $params = App::getRouter()->getParams();
        
        if( isset( $params[0] ) ) {
            $alias = strtolower ( $params[0] );
            $this->data['page'] = $this->model->getByAlias( $alias );
        }
    }
    
    public function admin_index()
    {
        $this->data['pages'] = $this->model->getList();
    }
    
    public function admin_add()
    {
        if( $_POST ) {
            
            $result = $this->model->save( $_POST );
            
            Session::setFlash ( $result ? 'The new page was successfully created!' : 'Error: page could not be created!' );
            
            Router::redirect( '/admin/pages' );
        }
    }
    
    public function admin_edit()
    {
        
        if( $_POST ) {
            
            $id = ( $_POST['page_id'] ?? null );
            
            $result = $this->model->save( $_POST, $id );
            
            Session::setFlash( $result ? 'The new page was successfully edited!' : 'Error: page could not be edited!' );
            
            Router::redirect( '/admin/pages' );
        }
        
        if( isset( $this->params[0] ) ) {
            
            $page_id =( int ) $this->params[0];
            $this->data['page'] = $this->model->getById( $page_id );
        
        } else {
            Session::setFlash ( 'Wrong page requested!' );
            Router::redirect( '/admin/pages' );
        }
    }
    
    
    public function admin_delete()
    {
        
        $params = App::getRouter()->getParams();
        
        if( isset( $params[0] ) ) {
            
            $result = $this->model->delete( (int) $params[0] );
            
            Session::setFlash ( $result ? 'The selected page was successfully deleted!' : 'Error: page could not be deleted!' );
            
            Router::redirect( '/admin/pages' );
        }
    }
}