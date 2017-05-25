<?php
namespace Application\Lib;

error_reporting( E_ALL );

use Application\Lib\Interfaces\IView;
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class View implements IView
{
    protected $data; 
    protected $path;
   
    /**
     * 
     * @return boolean
     */
    protected function getDefaultViewPath(): string
    {
        $router = App::getRouter();
        
        if ( !$router ) {
            return false;
        }
        
        $controller_dir = $router->getController();
        $template_name  = $router->getMethodPrefix() . $router->getAction() . '.phtml';
        
        return VIEWS_PATH .DS. $controller_dir .DS. $template_name;
    }

    public function __construct( $data = [], $path = null ) 
    {
        if( !$path ) {
            $path = $this->getDefaultViewPath();
        }
        
        if( !file_exists( $path ) ) {
            throw new \Exception ( "Template file is not found in path $path" );
        }
        
        $this->data = $data;
        $this->path = $path;
    }
    
    /**
     * 
     * @return string
     */
    public function render(): string
    {
        $data = $this->data;
        
        ob_start();
        include ( $this->path );
        
        $content = ob_get_clean();

        return $content;
    }
}