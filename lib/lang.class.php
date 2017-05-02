<?php
error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Lang
{
    protected static $data;
    
    public static function load( $pLandCode )
    {
        $lang_file_path = ROOT.DS . 'lang' . DS . strtolower( $pLandCode ) . '.php';
        
        if( file_exists( $lang_file_path ) ) {
            
            self::$data= include ( $lang_file_path );
        
        } else {
            
            throw new Exception ( 'Language not found: ' . $lang_file_path );
        }
    }
    
    public static function get( $key, $default_value = '' )
    {
        
        return self::$data[ strtolower( $key ) ] ?? $default_value;
    }
}
