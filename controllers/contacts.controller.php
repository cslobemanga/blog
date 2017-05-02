<?php
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
            
            if( $this->model->save( $_POST ) ) {
                Session::setFlash( translate( 'lng.flash.success.insert' ) );
                
            } else {
                Session::setFlash( translate( 'lng.flash.error.insert' ) );
            }
        }
    }
    
    public function admin_index()
    {
     
        $this->data = $this->model->getList();
    }
}