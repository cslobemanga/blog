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
        
        $router         = App::getRouter();
        $loader_path    = VIEWS_PATH . DS . $router->getController();
        
        if( Config::get('use_twig') ) {
            try {
                self::$twig_loader  = new \Twig_Loader_Filesystem( $loader_path );
                self::$twig_engine  = new \Twig_Environment( self::$twig_loader, 
                                [ 'cache' => false,
                                  'debug' => true ] );

            } catch ( \Exception $tel ) {
                echo $tel->getMessage();
            }
        }
        
        return VIEWS_PATH . DS . $controller_dir . DS . $template_name;
    }

    public function __construct( $data = [], $path = null ) 
    {
        if( !$path ) 
            $path = self::getDefaultViewPath();
        
        if( !file_exists( $path ) ) {
            throw new \Exception ( "Template file is not found in path $path!" );
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
            
            $template_file = App::getRouter()->getMethodPrefix() . App::getRouter()->getAction() . '.html.twig';
            return self::$twig_engine->render( $template_file, $data );
            
        } else {
            return $content;
        }
    }
}