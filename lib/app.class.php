<?php
error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>
 */

class App
{
    
    protected static $router;
    protected static $db;

    public static function getRouter(): Router
    {
        return self::$router;
    }
    
    public static function getDB(): DB
    {
        return self::$db;
    }

    public static function run( $uri )
    {
        self::$router   = new Router( $uri );
        self::$db       = DB::getInstance();
        
        Lang::load( self::$router->getLanguage() );
        
        $controller_class = ucfirst( self::$router->getController() ) . 'Controller';
        $controller_method = strtolower( self::$router->getMethodPrefix() . self::$router->getAction() );
        
        $layout = self::$router->getRoute();
         
        if( $layout == 'admin' && Session::get( 'user' )['Role'] == Config::get( 'default_user_role' ) ) {
             
             if( $controller_method != 'admin_logout' ) {
                 
                 Router::redirect ( '/users/login' );
             }
         }
        
        // Calling controller's method
        $controller_object = new $controller_class();
        
        if( method_exists( $controller_object, $controller_method ) ) {
            
            // Controller's action may return a view path
            $view_path      = $controller_object->$controller_method();
            $view_object    = new View( $controller_object->getData(), $view_path );
            
            $static_pages   = $controller_object->getData()['static_pages'] ?? [];
            $content        = $view_object->render();
        }
        else 
            throw new Exception ( "Method $controller_method of class $controller_class does not exist!" );
        
        // Layout
        $layout_path        = VIEWS_PATH . DS . $layout . '.phtml';
        $layout_view_object = new View( array(
                                'dynamic'   => compact('content'), 
                                'static'    => $static_pages ), $layout_path );
        
        echo $layout_view_object->render();
    }   
}