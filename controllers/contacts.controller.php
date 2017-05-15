<?php
<<<<<<< HEAD:controllers/contacts.controller.php
=======
namespace Application\Controllers;

use Application\Lib\Controller;
use Application\Models\Message;
use Application\Lib\Session;
use Application\Lib\Router;
use Application\Lib\App;

>>>>>>> maroc:app/controllers/ContactsController.php
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
            
            if( $this->model->register( $_POST ) ) {
                Session::setFlash( translate( 'lng.flash.success.insert' ), 'alert-success' );
                Router::redirect( '/' . App::getRouter()->getLanguage() );
                
            } else {
                Session::setFlash( translate( 'lng.flash.error.insert' ), 'alert-warning' );
            }
        }
    }
    
    public function admin_index()
    {
     
        $this->data = $this->model->getAll();
    }
}