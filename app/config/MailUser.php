<?php
namespace Application\Config;

use Application\Lib\Config;

/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

/**
 * Description of MailUser
 *
 * @author Charles S. Lobe-Manga <charles@lobe-manga.com>
 */
class MailUser extends \PHPMailer
{
   
    public function __construct( $exceptions = null ) {
        
        parent::__construct( $exceptions );
        
        
        $this->isSMTP();
        $this->isHTML();
        
        $this->Host         = Config::get( 'smtp.host' );
        $this->Port         = Config::get( 'smtp.port' );
        $this->SMTPAuth     = Config::get( 'smtp.auth' );
        $this->Username     = Config::get( 'smtp.username' );
        $this->Password     = Config::get( 'smtp.password' );

        $this->SMTPDebug    = Config::get( 'smtp.debug' );
        $this->Subject      = Config::get( 'mail.subject' );
        
        $this->Body         = nl2br( Config::get( 'mail.standard.message' ) );

        $this->setFrom( Config::get( 'smtp.sender.email' ), 
                        Config::get( 'smtp.sender.name' ) );
        
        $mail_addresses     = Config::get( 'mail.addresses' );
        
        foreach ( $mail_addresses as $address ) {
            
            $this->addAddress( $address['email'], $address['name'] );
        }
    }  
}