<?php
error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Session
{
    protected static $flash_message;
    
    public static function setFlash( $message, $severity='alert-info' )
    {
        
        self::$flash_message = $message;
        self::set( 'severity', $severity );
    }
    
    public static function hasFlash()
    {
        
        return ( !is_null( self::$flash_message ) );
    }
    
    public static function flash()
    {
        
        echo self::$flash_message;
        
        self::$flash_message = null;
    }
    
    public static function getFlash()
    {
        
        return self::$flash_message;
    }

    public static function set( $key, $value )
    {
        
        $_SESSION[ $key ] = $value;
    }
    
    public static function get( $key )
    {
        
        return ( $_SESSION[ $key ] ?? null );
    }
    
    public static function delete( $key )
    {
        
        if( isset( $_SESSION[ $key ] ) )
            unset( $_SESSION[ $key ] );
    }
    
    public static function destroy()
    {
        self::delete( 'user' );
        
        session_destroy();
    }
}