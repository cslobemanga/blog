<?php
namespace Application\Controllers;

error_reporting( E_ALL );
/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

namespace Application\Controllers;

use Application\Lib\Controller;
use Application\Models\Comment;
use Application\Lib\Session;
use Application\Lib\App;

/**
 * Description of CommentsController
 *
 * @author Charles S. Lobe-Manga <charles@lobe-manga.com>
 */
class CommentsController extends Controller
{
 
    public function __construct( $pData = array() ) 
    {
        parent::__construct($pData);
        
        $this->model = new Comment();
    }
    
    public function index()
    {
        $this->data['comments'] = $this->model->getAll();
    }
    
    public function add()
    {
        $lang = App::getRouter()->getLanguage();
        
        if( !Session::get('user') ) {
            $this->redirect_path = '/' . $lang . '/users/login';
            $this->redirect();
        }
        
        if( !isset( $_POST['article_id'] ) || !isset( $_POST['content'] ) ||
                !isset( $_POST['author_id'] ) ) {
            return false;
        }
        
        $article_id = $_POST['article_id'];
        
        if( $this->model->add( $_POST ) ) {
            
            Session::setFlash( 'Your comment was successfully added!', 'alert-success' );
            $this->redirect_path = '/' . $lang . '/articles/view/' . $article_id;
            $this->redirect();
            
        } else {
             Session::setFlash( 'Error: Your comment could not be added!', 'alert-warning' );
        }
    }
}
