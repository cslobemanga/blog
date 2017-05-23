<?php
namespace Application\Lib;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class View
{
    
    protected static $twig_loader;
    protected static $twig_engine;
    
    protected $data; 
    protected $path;
   
    /**
     * 
     * @return boolean
     */
    protected static function getDefaultViewPath(): string
    {
        $router = App::getRouter();
        
        if ( !$router )
            return false;
        
        $controller_dir = $router->getController();
        $template_name  = $router->getMethodPrefix() . $router->getAction() . '.phtml';
        
        if( Config::get('use_twig') ) {
            $template_file = $controller_dir .DS. 'html' .DS. 
                    $router->getMethodPrefix() . $router->getAction() . '.twig';

            return VIEWS_PATH .DS. $template_file;
        
        } else {
        
            return VIEWS_PATH .DS. $controller_dir .DS. $template_name;
        }
    }

    public function __construct( $data = [], $path = null ) 
    {
        if( !$path ) 
            $path = self::getDefaultViewPath();
        
        if( !file_exists( $path ) ) {
            throw new \Exception ( "Template file is not found in path $path" );
        }
        
        $this->data = $data;
        $this->path = $path;
    }
    
    public function render()
    {
        $data = $this->data;
        
        ob_start();
        include ( $this->path );
        $content = ob_get_clean();
        
        if( Config::get('use_twig') ) {
            
            $router = App::getRouter();
            
            self::$twig_loader  = new \Twig_Loader_Filesystem( 
                    [ VIEWS_PATH.DS. 'html', 
                      VIEWS_PATH.DS. $router->getController() ] 
                    );
            
            self::$twig_engine  = new \Twig_Environment( self::$twig_loader, 
                                    [ 'cache' => false,
                                      'debug' => true ] );
            
            $template_file  = 'html' .DS. $router->getMethodPrefix() . 
                    $router->getAction() . '.twig';
            
            return self::$twig_engine->render( $template_file, $data );
            
        } else {
            return $content;
        }
    }
}