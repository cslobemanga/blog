<?php
 namespace Application\Lib;
 
 error_reporting( E_ALL ); 
 
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Router
{
    
    protected $uri;
    
    protected $controller;
    
    protected $action;
    
    protected $params;
    
    protected $route;
    
    protected $method_prefix;

    protected $language;


    public function __construct( string $pUri ) 
    {
        $this->uri = urldecode( trim( $pUri, '/' ) );
        
        // Setting defaults
        $routes                 = Config::get( 'routes' );
        $languages              = Config::get( 'languages' );
        
        $this->route            = Config::get( 'default_route' );
        $this->language         = Config::get( 'default_language' );
        $this->controller       = Config::get( 'default_controller' );
        $this->action           = Config::get( 'default_action' );
        $this->method_prefix    = $routes[ $this->route ] ?? '';
        
        // Parsing the url
        $uri_parts  = explode( '?', $this->uri );
        $path       = $uri_parts[ 0 ];
        $path_parts = explode( '/', $path );
        
        if( count( $path_parts ) ) {
            
            // Get route and method prefix at first
            if( in_array(strtolower(current($path_parts)), array_keys($routes) )) {
                $this->route = strtolower(current($path_parts) );
                $this->method_prefix = $routes[ $this->route ] ?? '';
                array_shift( $path_parts );
            
            } 
            
            // next element: language
            if ( in_array(strtolower(current($path_parts)), $languages )) {
                $this->language = strtolower(current( $path_parts ));
                array_shift( $path_parts );
            }
            
            // next: controller
            if( current( $path_parts ) ) {
                $this->controller = strtolower(current( $path_parts ) );
                array_shift( $path_parts );
            } 
            
            // next: action
            if( current( $path_parts ) ) {
                $this->action = strtolower(current( $path_parts ) );
                array_shift( $path_parts );
            }
            
            // next: the parameters
            $this->params = $path_parts;
        }        
    }
    
    public static function redirect( $location )
    {
        header( "Location: $location" );
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getParams(): array
    {
        return $this->params;
    }
    
    public function getRoute(): string
    {
        return $this->route;
    }

    public function getMethodPrefix(): string
    {
        return $this->method_prefix;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }
}