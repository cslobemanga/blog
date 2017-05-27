<?php
namespace Application\Controllers;

use Application\Lib\Controller;
use Application\Models\Message;
use Application\Lib\Session;
use Application\Lib\Router;
use Application\Lib\App;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class ContactsController extends Controller
{
    
    public function __construct( $pData = array() ) 
    {
        parent::__construct( $pData );
        
        $this->model = new Message();
    }

    public function index()
    {
        if( $_POST ) {
            
            if( $this->model->saveMessage( $_POST ) ) {
                Session::setFlash( translate( 'lng.flash.success.insert' ), Session::SEVERITY_SUCCESS );
                Router::redirect( '/' . App::getRouter()->getLanguage() );
                
            } else {
                Session::setFlash( translate( 'lng.flash.error.insert' ), Session::SEVERITY_WARNING );
            }
        }
    }
    
    public function admin_index()
    {
     
        $this->data['messages'] = $this->model->getAll();
    }
}