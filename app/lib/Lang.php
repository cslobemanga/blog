<?php
namespace Application\Lib;

use Application\Lib\Interfaces\ILang;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Lang implements ILang
{
    protected static $data;
    
    /**
     * Loads the content of the corresponding language file.
     * 
     * @param string $land_code
     * @throws \Exception
     */
    public static function load( string $land_code )
    {
        $lang_file_path = ROOT.DS . 'app' .DS. 'lang' . DS . strtolower( $land_code ) . '.php';
        
        if( file_exists( $lang_file_path ) ) {
            
            self::$data = include ( $lang_file_path );
        
        } else {
            
            throw new \Exception( 'Language not found: ' . $lang_file_path );
        }
    }
    
    /**
     * Returns the translated string.
     * 
     * @param string $key
     * @param string $default_value
     * @return string
     */
    public static function get( string $key, string $default_value='' ): string
    {
        
        return self::$data[ strtolower( $key ) ] ?? $default_value;
    }
}
