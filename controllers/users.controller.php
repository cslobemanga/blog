<?php
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
        
        $this->common_logout( '/' . App::getRouter()->getLanguage() );
    }

    public function admin_index()
    {
        $this->data['users'] = $this->model->getAll();
    }
    
    public function admin_add()
    {
        if( $_POST )
        {
            $result = $this->model->register( $_POST, true );
            
            Session::setFlash( $result ? 'User was successfully added!' : 'Error: User could not be created.' );
            
            Router::redirect( '/admin/users' );
        }
    }
    
    public function admin_edit()
    {
        if( $_POST ) {
            
            $id = ( $_POST['user_id'] ?? null );
            
            $result = $this->model->update( $_POST, $id );
            
            Session::setFlash( $result ? 'The user successfully updated!' : 'Error: User data could not be edited!' );
            
            Router::redirect( '/admin/users' );
        }
        
        if( isset( $this->params[0] ) ) {
            
            $user_id =( int ) $this->params[0];
            $this->data['user'] = $this->model->getById( $user_id );
        
        } else {
            Session::setFlash ( 'Wrong page requested!' );
            Router::redirect( '/admin/users' );
        }
    }

    public function admin_delete()
    {
        
        $params = App::getRouter()->getParams();
        
        if( isset( $params[0] ) ) {
            
            $result = $this->model->delete( (int) $params[0] );
            
            Session::setFlash ( $result ? 'The selected user was successfully deleted!' : 'Error: User could not be deleted!' );
            
            Router::redirect( '/admin/users' );
        }
    }

    public function login()
    {
        
        if( isset( $_POST ) && isset( $_POST['login'] ) && isset( $_POST['password'] ) ) {
            
            $user = $this->model->getByLogin( $_POST['login'] );
            
            if( !$user )
                Session::setFlash( 'User unknown!' );
            
            $result = $this->model->login( $_POST['login'], $_POST['password'] );
            
            if( $result ) {
            
                Session::set( 'user', $user );
                Session::setFlash( 'Herzlich Willkomen ' . $_POST['login'], 'alert-info' );
                
                $lang = App::getRouter()->getLanguage();
                
                if( $user['Role'] == 1 )
                    Router::redirect( '/admin' );
                
                else
                    Router::redirect( '/' . $lang ); 
            
            } else
                Session::setFlash( 'Zugangsdaten sind ungültig!', 'alert-danger' );
        }
    }
    
    public function common_register( $redirect_path )
    {
        if( isset( $_POST['login'] ) && isset( $_POST['password'] ) ) {
            
            $result = $this->model->register( $_POST );
            
            if( $result ) {
                Session::setFlash( 'User successfully registerd', 'alert-success' );
                Router::redirect( $redirect_path );
                
            } else
                Session::setFlash( 'Error: User could not be registered.', 'alert-warning' );
        
        } else 
            Session::flash ();
    }
    
    public function register()
    {
        $redirect_path = '/'. App::getRouter()->getLanguage() . '/users/login';
        
        $this->common_register( $redirect_path );
    }
    
    public function admin_register()
    {
        
        $this->common_register( '/admin/users' );
    }

    public function admin_logout()
    {
        
        $this->common_logout( '/admin' );
    }
    
    protected function common_logout( $redirect_path )
    {
        
        Session::destroy();
        
        Router::redirect( $redirect_path );
    }
}