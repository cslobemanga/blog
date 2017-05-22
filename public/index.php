<?php
session_start();
error_reporting( E_ALL );
 
 /* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */
 
define( 'DS',                   DIRECTORY_SEPARATOR );
define( 'ROOT',                 dirname(dirname( __FILE__) ) );
define( 'VIEWS_PATH',           ROOT. DS . 'views' );
define( 'LANG_PATH',            ROOT. DS . 'app' .DS. 'lang' );
define( 'VENDOR_PATH',          ROOT. DS . 'vendor' );

require __DIR__ . '../../vendor/autoload.php';

require ROOT.DS. 'app' .DS. 'config' .DS. 'settings.php';

use Application\Lib\App;
use Application\Lib\Lang;
use Application\Lib\Session;

App::run( $_SERVER['REQUEST_URI'] );


/**
 * Globale �bersetzungsfunktion
 * 
 * @param string $key
 * @param string $default_value
 * @return string
 */
function translate( string $key, $default_value= '' ):string
{
	return Lang::get( $key, $default_value );
}

/**
 * Hilfsfunktion zur Konsole-Ausgabe
 * 
 * @param unknown $data
 */
function display( $data )
{
	echo '<pre>';
	print_r( $data );
	echo '</pre>';
}

/**
 * Checks equality between article editor and comment editor
 * 
 * @param string $login
 * @return bool
 */
function authorComment( string $login ): bool
{
    if( is_null( Session::get('user') ) ) {
        return false;
    }
    
    $author = Session::get('user');
    
    return ( $author['Login'] == $login );
}