<?php
namespace Application\Controllers;

use Application\Lib\Controller;
use Application\Models\User;
use Application\Lib\App;
use Application\Lib\Session;
use Application\Lib\Router;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class UsersController extends Controller
{
    
    public function __construct( $pData = array() ) 
    {
        parent::__construct( $pData );
        
        $this->model = new User();
    }
    
    public function logout()
    {
        Router::redirect( '/' . App::getRouter()->getLanguage() );
        Session::setFlash( 'User was successfully logged out!', Session::SEVERITY_SUCCESS );
        
        Session::destroy();
    }

    public function admin_index()
    {
        $this->data['users']    = $this->model->getAll( false );
        $this->data['language'] = App::getRouter()->getLanguage();
    }
    
    public function admin_add()
    {
        if( $_POST )
        {
            $result = $this->model->register( $_POST, true );
            
            if( $result ) {
                Session::setFlash( 'User was successfully registered!', Session::SEVERITY_SUCCESS );
                
            } else {
                Session::setFlash( 'Error: User could not be created.', Session::SEVERITY_WARNING );
            }
            Router::redirect( '/admin/' . App::getRouter()->getLanguage() . '/users' );
        }
    }
    
    public function admin_edit()
    {
        if( $_POST && isset( $_POST['user_id'] ) ) {
                
            $id = ( $_POST['user_id'] ?? null );

            $result = $this->model->update( $_POST, $id );

            if( $result ) {
                Session::setFlash( 'The user was successfully updated!', Session::SEVERITY_SUCCESS );
                Router::redirect( '/admin/' . App::getRouter()->getLanguage() . '/users' );
                
            } else {
                Session::setFlash( 'Error: User data could not be edited!', Session::SEVERITY_WARNING );
                Router::redirect( '/admin/' . App::getRouter()->getLanguage() . '/users' );
            }
        }
        
        if( isset( $this->params[0] ) ) {
            $id = (int) $this->params[0];
            $this->data['user'] = $this->model->getById( $id, false );
            
        } else {
            Session::setFlash ( 'Wrong page requested!', 'alert-warning' );
            Router::redirect( '/admin/' . App::getRouter()->getLanguage() . '/users' );
        }
    }

    public function admin_delete()
    {
        
        $params = App::getRouter()->getParams();
        
        if( isset( $params[0] ) ) {
            
            $result = $this->model->remove( (int) $params[0] );
            
            if( $result ) {
                Session::setFlash ( 'The selected user was successfully deleted!', Session::SEVERITY_SUCCESS );
                
            } else {
                Session::setFlash ( 'Error: User could not be deleted!', Session::SEVERITY_WARNING );
            }
            
            Router::redirect( '/admin/' . App::getRouter()->getLanguage() . '/users' );
        }
    }

    public function login()
    {
        
        if( isset( $_POST ) && isset( $_POST['login'] ) && isset( $_POST['password'] ) ) {
            
            $user = $this->model->getByLogin( $_POST['login'] );
            
            if( !$user ) {
                Session::setFlash( 'User unknown!', Session::SEVERITY_WARNING );
            }
            
            $result = $this->model->login( $_POST['login'], $_POST['password'] );
            
            if( $result ) {
            
                Session::set( 'user', $user );
                Session::setFlash( 'Herzlich Willkomen ' . $_POST['login'] );
                
                $lang = App::getRouter()->getLanguage();
                
                if( $user['Role'] == 1 ) {
                    Router::redirect( '/admin/' . $lang );
                
                } else {
                    Router::redirect( '/' . $lang ); 
                }
            
            } else {
                Session::setFlash( 'Zugangsdaten sind ungültig!', Session::SEVERITY_WARNING );
            }
        }
    }
    
    public function common_register( $redirect_path, bool $by_admin )
    {
        if( isset( $_POST['login'] ) && isset( $_POST['password'] ) ) {
            
            $result = $this->model->register( $_POST, $by_admin );
            
            if( $result ) {
                Session::setFlash( 'User successfully registerd', Session::SEVERITY_SUCCESS );
                Router::redirect( $redirect_path );
                
            } else
                Session::setFlash( 'Error: User could not be registered.', Session::SEVERITY_WARNING );
        } 
    }
    
    public function register()
    {
        $redirect_path = '/'. App::getRouter()->getLanguage() . '/users/login';
        
        $this->common_register( $redirect_path, false );
    }

    public function admin_logout()
    {
        
        $this->logout();
    }
}