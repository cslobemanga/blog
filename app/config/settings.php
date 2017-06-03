<?php
use Application\Lib\Config;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>
 */

define( 'user_config', array(
    
        'site_name'             => 'CSLM AG',
        'languages'             => [ 'en' => 'English',
                                     'de' => 'Deutsch', 
                                     'fr' => 'Français' ],
        'routes'                => [ 'default'   => '',
                                     'admin'     => 'admin_' ],
    
        // Routes
        'default_route'         =>  'default',
        'default_language'      =>  'en',
        'default_controller'    =>  'articles',
        'default_action'        =>  'index',
    
        // DB-Verbindung
        'db.host'               =>  'localhost',
        'db.dbname'             =>  'db_mvc',
        'db.user'               =>  '',
        'db.password'           =>  '',
    
        'default_user_role'     =>  0,
        'default_user_status'   =>  1,
    
        'content_length'        =>  100,
    
        'datetime_zone'         => 'Europe/Berlin',
    
        'smtp.host'             => 'smtp.gmail.com',
        'smtp.port'             => 587,
        'smtp.auth'             => true,
        'smtp.username'         => '',
        'smtp.password'         => '',
        'smtp.debug'            => 2,
        'smtp.sender.email'     => 'charles@lobe-manga.com',
        'smtp.sender.name'      => 'Charles Lobe-Manga',
    
        'mail.subject'          => 'Standard PHPMailer test message',
        'mail.addresses'        => [
                                    [ 'email' => 'lobe-manga@web.de', 
                                      'name'  => 'Charles Lobe-Manga' ],
            
                                    [ 'email' => 'elsa-gogia@web.de', 
                                      'name'  => 'Eliza Gogia']
                                   ],
        'mail.standard.message' => 'Sehr geehrte Damen und Herren,<br/><br/>' .
            'im Anhang dieser E-Mail finden Sie das Protokoll zum heutigen Test' .
            'der produktiven Systeme.<br/><br/>Sollten Sie Fragen dazu haben, ' .
            'stehen wir Ihnen gerne zur Verfügung.<br/><br/>Wir wünschen Ihnen ' . 
            'einen angenehmen und erfolgreichen Tag und viel Spaß bei der Arbeit ' . 
            'mit AdWorks.<br/><br/>Ihr<br/>financeTec Support Team<br/><br/>' . 
            'financeTec AG<br/>Korngasse 2<br/>67547 Worms<br/><br/>' . 
            'Tel. 069-401570200<br/>Fax. 069-401570222<br/>' . 
            'Mail: support@financetec.de',
    )
);

foreach ( user_config as $key => $value ) {
    
    Config::set( $key, $value );
}
