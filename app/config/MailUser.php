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
   
    protected $message = 
            'Sehr geehrte Damen und Herren,<br/><br/>' .
            'im Anhang dieser E-Mail finden Sie das Protokoll zum heutigen Test' .
            'der produktiven Systeme.<br/><br/>Sollten Sie Fragen dazu haben, ' .
            'stehen wir Ihnen gerne zur Verfügung.<br/><br/>Wir wünschen Ihnen ' . 
            'einen angenehmen und erfolgreichen Tag und viel Spaß bei der Arbeit ' . 
            'mit AdWorks.<br/><br/>Ihr<br/>financeTec Support Team<br/><br/>' . 
            'financeTec AG<br/>Korngasse 2<br/>67547 Worms<br/><br/>' . 
            'Tel. 069-401570200<br/>Fax. 069-401570222<br/>' . 
            'Mail: support@financetec.de';
           
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
        
        $this->Body         = nl2br( $this->message );

        $this->setFrom( Config::get( 'smtp.sender.email' ), 
                        Config::get( 'smtp.sender.name' ) );
        
        $mail_addresses     = Config::get( 'mail.addresses' );
        
        foreach ( $mail_addresses as $address ) {
            
            $this->addAddress( $address['email'], $address['name'] );
        }
    }  
}