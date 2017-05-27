<?php
namespace Application\Lib;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Session
{
    const SEVERITY_INFO     = 1;
    const SEVERITY_SUCCESS  = 2;
    const SEVERITY_WARNING  = 3;
    const SEVERITY_ERROR    = 4;

    protected static $flash_message;
    
    /**
     * 
     * @param type $message
     * @param type $severity
     */
    public static function setFlash( $message, int $severity=self::SEVERITY_INFO )
    {
        self::set( 'flash_message', $message );
//        self::$flash_message = $message;
        
        self::set( 'severity', $severity );
    }
    
    /**
     * 
     * @return bool
     */
    public static function hasFlash(): bool
    {
        return ( !is_null( self::get( 'flash_message' ) ) );
    }
    
    /**
     * 
     */
    public static function flash()
    {
        $message = "<p class='w3-margin w3-round-xlarge w3-padding-large w3-" . 
                self::getFlashBackground() . " flash-message fadeOut' >";
        
        $message .= '<b>' . self::get( 'flash_message' ) . '</b></p>';
        
        echo $message;
        
//        self::$flash_message = null;
    }
    
    /**
     * Set the background color of the flash message box
     * 
     * @return string
     */
    public static function getFlashBackground()
    {
        $color = 'blue';
        
        switch ( self::get( 'severity' ) ) {
            
            case self::SEVERITY_ERROR:
                $color = 'red';
                break;
            case self::SEVERITY_WARNING:
                $color = 'orange';
                break;
            case self::SEVERITY_SUCCESS:
                $color = 'green';
                break;
            default:
                $color = 'blue';
                break;
        }
        
        return $color;
    }
    
    /**
     * 
     * @return string
     */
    public static function getFlash(): string
    {
        return self::get( 'flash_message' );
    }

    /**
     * 
     * @param string $key
     * @param type $value
     */
    public static function set( string $key, $value )
    {
        $_SESSION[ $key ] = $value;
    }
    
    /**
     * 
     * @param int $key
     * @return type
     */
    public static function get( $key )
    {
        return ( $_SESSION[ $key ] ?? null );
    }
    
    /**
     * 
     * @param int $key
     */
    public static function delete( string $key )
    {
        if( isset( $_SESSION[ $key ] ) ) {
            unset( $_SESSION[ $key ] );
        }
    }
    
    /**
     * 
     */
    public static function destroy()
    {
        self::delete( 'user' );
        
        session_destroy();
    }
}