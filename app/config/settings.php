<?php
use Application\Lib\Config;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>
 */

define( 'user_config', array(
    
        'site_name'             => 'CSLM AG',
        'languages'             => [ 'en', 'de', 'fr' ],
        'routes'                => [ 'default'   => '',
                                     'admin'     => 'admin_'
                                   ],
    
        // Routes
        'default_route'         =>  'default',
        'default_language'      =>  'en',
        'default_controller'    =>  'articles',
        'default_action'        =>  'index',
    
        // DB-Verbindung
        'db.host'               =>  'localhost',
        'db.dbname'             =>  'db_mvc',
        'db.user'               =>  'pma',
        'db.password'           =>  'HBdv419!',
    
        'default_user_role'     =>  0,
        'default_user_status'   =>  1,
    
        'content_length'        =>  100,
        'use_twig'              =>  false
    )
);

foreach ( user_config as $key => $value ) {
    
    Config::set( $key, $value );
}
