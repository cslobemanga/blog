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
    /**
     * The constructor initializes the instance model
     * 
     * @param type $pData
     */
    public function __construct( $pData = array() ) 
    {
        parent::__construct( $pData );
        
        $this->model = new User();
    }
    
    /**
     * Logs the user out after destroying the current session
     */
    public function logout()
    {
        Session::destroy();
        session_start();
        
        Router::redirect( '/' . App::getRouter()->getLanguage() );
        Session::setFlash( 'User was successfully logged out!', Session::SEVERITY_SUCCESS );
        
    }

    /**
     * Users control: the users list
     */
    public function admin_index()
    {
        $this->data['users']    = $this->model->getAll( false );
        $this->data['language'] = App::getRouter()->getLanguage();
    }
    
    /**
     * Users control: adding a new user
     */
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
    
    /**
     * Users control: updating an existing user
     */
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

    /**
     * Users control: Deleting an existing user
     */
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

    /**
     * Login function,  checks the input credentials from the user's form
     */
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
    
    /**
     * Common register function, saves the new user in the database
     * 
     * @param string $redirect_path
     * @param bool $by_admin
     */
    public function register()
    {
        if( isset( $_POST['login'] ) && isset( $_POST['password'] ) ) {
            
            $result = $this->model->register( $_POST );
            
            if( $result ) {
                $redirect_path = '/'. App::getRouter()->getLanguage() . '/users/login';
                
                Session::setFlash( 'User successfully registerd', Session::SEVERITY_SUCCESS );
                $this->redirect();
                
            } else {
                Session::setFlash( 'Error: User could not be registered.', Session::SEVERITY_WARNING );
            }
        } 
    }
}