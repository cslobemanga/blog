<?php
namespace Application\Lib;

use Application\Models\Page;
use Application\Models\Archiv;
use Application\Models\SocialNetwork;

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
        $this->loadArchives();
        $this->loadSocialNetworks();
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
    
    /**
     *  Loads the pages titles to be viewed on the sidebar
     */
    protected function loadStaticPages()
    {
        $this->data['static_pages'] = [];
  
        $page = new Page();
        
        try {
        
            $clt = $page->createLanguageTable( App::getRouter()->getLanguage() );
            
        } catch ( \PDOException $exc ) {
            echo $exc->getMessage();
        }
        
        foreach ( $page->getAll() as $p ) {
        
            $this->data['static_pages'][] = $p;
        }
    }
    
    /**
     * Loads the archive captions for month and year of publication
     * 
     */
    protected function loadArchives()
    {
        $this->data['archives'] = [];
        
        $archiv = new Archiv();
        
        foreach ( $archiv->getAll() as $a ) {
            
            $this->data['archives'][] = $a;
        }
    }
    
    /**
     * Loads the social networks on the sidebar
     */
    protected function loadSocialNetworks()
    {
        $this->data['social_networks'] = [];
        
        $social_network = new SocialNetwork();
        
        foreach ( $social_network->getAll() as $sn ) {
            
            $this->data['social_networks'][] = $sn;
        }
        
    }

    protected function redirect()
    {
        
        Router::redirect( $this->redirect_path );
    }
}