<?php
error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>
 */

Config::set( 'site_name',           'CSLM AG' );

Config::set( 'languages',           [ 'en', 'de', 'fr' ] );

Config::set( 'routes',              array(
                                        'default'   => '',
                                        'admin'     => 'admin_'
                                    ) );

// Routes
Config::set( 'default_route',       'default' );
Config::set( 'default_language',    'en' );
Config::set( 'default_controller',  'articles' );
Config::set( 'default_action',      'index' );

// DB-Verbindung
Config::set( 'db.host',             'localhost' );
Config::set( 'db.dbname',           'db_mvc' );
Config::set( 'db.user',             'pma' );
Config::set( 'db.password',         'HBdv419!' );

// Security
Config::set( 'salt',                'Huj23lHalw8CyjsldiKPlb0m' );
Config::set( 'default_user_role',   0 );
Config::set( 'default_user_status', 1 );

// Formatierung
Config::set('content_length',       100 );