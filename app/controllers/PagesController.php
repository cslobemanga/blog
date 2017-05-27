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
        
        $this->data['language'] = App::getRouter()->getLanguage();
    }
    
    public function admin_index()
    {
        $this->data['pages'] = $this->model->getAll( false );
        $this->data['language'] = App::getRouter()->getLanguage();
    }
    
    public function admin_add()
    {
        if( $_POST ) {
            $result = $this->model->register( $_POST );
            
            if( $result ) {
                $router = App::getRouter();
                $file_path = LANG_PATH_FILES .DS. $router->getLanguage() .DS. $_POST['alias'] . '.txt';
                 
                if( $file = fopen( $file_path, 'w' ) ) {
                    
                    $text = '<h3>' . $_POST['title'] . '</h3>';
                    
                    fwrite( $file, $text );
                    fclose( $file );
                    
                } else {
                    Session::setFlash ( 'Error: Content file could not be created!', Session::SEVERITY_WARNING );
                }
                    
                Session::setFlash ( 'The new page was successfully created!', Session::SEVERITY_SUCCESS );
            
            } else {
                Session::setFlash ( 'Error: page could not be created!', Session::SEVERITY_WARNING );
            }
            Router::redirect( '/admin/pages' );
        }
    }
    
    public function admin_edit()
    {
        
        if( $_POST ) {
            
            $result = $this->model->edit( $_POST );
            
            if( $result ) {
                Session::setFlash( 'The new page was successfully edited!', Session::SEVERITY_SUCCESS );
            } else {
                Session::setFlash( 'Error: page could not be edited!', Session::SEVERITY_WARNING);
            }
            
            Router::redirect( '/admin/' . App::getRouter()->getLanguage() . '/pages' );
        }
        
        if( isset( $this->params[0] ) ) {
            
            $page_id =( int ) $this->params[0];
            $this->data['page'] = $this->model->getById( $page_id );
        
        } else {
            Session::setFlash ( 'Wrong page requested!' );
            Router::redirect( '/admin/' . App::getRouter()->getLanguage() . '/pages' );
        }
    }
    
    
    public function admin_delete()
    {
        
        $params = App::getRouter()->getParams();
        
        if( isset( $params[0] ) ) {
            
            $result = $this->model->remove( (int) $params[0] );
            
            if( $result ) {
                Session::setFlash ( 'The selected page was successfully deleted!', Session::SEVERITY_SUCCESS );
            } else {
                Session::setFlash ( 'Error: page could not be deleted!', Session::SEVERITY_WARNING );
            }
            Router::redirect( '/admin/pages' );
        }
    }
}