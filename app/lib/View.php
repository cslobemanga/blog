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
     * Returns the file name of the default layout, used in the case there's
     * no controller specified and/or the path is null.
     * 
     * @return boolean|string
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

    /**
     * Constructor, initializes the path and data values.
     * 
     * @param array $data
     * @param type $path
     * @throws \Exception
     */
    public function __construct( array $data=[], string $path=null ) 
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
     * Renders the complete view by including the template file and saving the 
     * variables needed in the view.
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