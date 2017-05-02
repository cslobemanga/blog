<?php
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
        
        foreach ( $pages->getList() as $page ) {
        
            $this->data['static_pages'][] = $page;
        }
    }
}