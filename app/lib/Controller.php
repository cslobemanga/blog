<?php
namespace Application\Lib;

use Application\Models\Page;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Controller
{
    
    protected $data;
    
    protected $model;
    
    protected $params;
    
    protected $redirect_path;



    public function __construct( $pData = [] ) 
    {
        $this->data     = $pData;
        $this->params   = App::getRouter()->getParams();
        
        $this->loadStaticPages();
    }

    public function getData() {
        return $this->data;
    }

    public function getModel() {
        return $this->model;
    }

    public function getParams() {
        return $this->params;
    }
    
    protected function loadStaticPages()
    {
        
        $this->data['static_pages'] = [];
  
        $pages = new Page();
        
        foreach ( $pages->findAll() as $page ) {
        
            $this->data['static_pages'][] = $page;
        }
    }
    
    protected function redirect()
    {
        
        Router::redirect( $this->redirect_path );
    }
}