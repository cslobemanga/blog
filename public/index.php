<?php
 error_reporting( E_ALL );
 
 /* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */
 
define( 'DS',                   DIRECTORY_SEPARATOR );
define( 'ROOT',                 dirname(dirname( __FILE__) ) );
define( 'VIEWS_PATH',           ROOT. DS . 'views' );
define( 'LANG_PATH',            ROOT. DS . 'lang' );
define( 'VENDOR_PATH',          ROOT. DS . 'vendor' );

require_once ROOT.DS . 'lib' . DS . 'init.php';

session_start();

App::run( $_SERVER['REQUEST_URI'] );
?>