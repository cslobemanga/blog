<?php
error_reporting( E_ALL );

use Application\Lib\Lang;
use Application\Lib\Session;

/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

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
    if( is_null(Session::get('user') ) ) {
        return false;
    }
    
    $author = Session::get('user');
    
    return ( $author['Login'] == $login );
}

function dateIsToday( DateTime $date ): bool
{
    $today  = new DateTime();

    return ( $today->format('d') === $date->format('d') &&
             $today->format('m') === $date->format('m') &&
             $today->format('y') === $date->format('y') );
}