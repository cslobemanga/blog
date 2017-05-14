<?php
namespace Application\Controllers;

use Application\Lib\Controller;
use Application\Models\Page;
use Application\Lib\App;
use Application\Lib\Session;
use Application\Lib\Router;

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
        $this->data['pages'] = $this->model->getAll();
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
        $this->data['pages'] = $this->model->getAll();
    }
    
    public function admin_add()
    {
        if( $_POST ) {
            
            $result = $this->model->save( $_POST );
            
            if( $result ) {
            
                //TODO SOON CLM Creating the corresponding content files
                $router = App::getRouter();
                
                $file_path = LANG_PATH .DS. $router->getLanguage() .DS. $_POST['alias'] . '.txt';
                 
                if( $file = fopen( $file_path, 'w' ) ) {
                    
                    $text = '<h3>' . $_POST['title'] . '</h3>';
                    
                    fwrite( $file, $text );
                    
                    fclose( $file );
                    
                } else 
                    Session::setFlash ( 'Error: Content file could not be created!', 'alert-warning' );
                    
                Session::setFlash ( 'The new page was successfully created!', 'alert-success' );
            
            } else
                Session::setFlash ( 'Error: page could not be created!', 'alert-warning' );
            
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
            $this->data['page'] = $this->model->findByColumn( $page_id );
        
        } else {
            Session::setFlash ( 'Wrong page requested!' );
            Router::redirect( '/admin/pages' );
        }
    }
    
    
    public function admin_delete()
    {
        
        $params = App::getRouter()->getParams();
        
        if( isset( $params[0] ) ) {
            
            $result = $this->model->remove( (int) $params[0] );
            
            Session::setFlash ( $result ? 'The selected page was successfully deleted!' : 'Error: page could not be deleted!' );
            
            Router::redirect( '/admin/pages' );
        }
    }
}