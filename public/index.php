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
define( 'LANG_PATH_CONFIG',     ROOT. DS . 'app' .DS. 'lang' );
define( 'LANG_PATH_FILES',      ROOT .DS.  'lang' );
define( 'VENDOR_PATH',          ROOT. DS . 'vendor' );

require __DIR__ . '../../vendor/autoload.php';

require ROOT.DS. 'app' .DS. 'config' .DS. 'settings.php';
require ROOT.DS. 'app' .DS. 'config' .DS. 'utils.php';

use Application\Lib\App;

App::run( $_SERVER['REQUEST_URI'] );
