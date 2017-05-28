<?php
namespace Application\Models;

use Application\Lib\Model;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Message extends Model
{
    
    /**
     * The constructor, initializes the tables and inherits
     * a database connection instance from the parent class
     */
    public function __construct() 
    {
        parent::__construct();
        
        $this->table = 'messages';
    }
    
    /**
     * Returns all the published messages from contact the form.
     * 
     * @return type
     */
    public function getAll()
    {
        $params = array( 'IsPublished' => 1 );
        
        $order_by =  "MessageId DESC";
        
        return parent::findAll( $this->table, $params, $order_by );
    }

    /**
     * Saves the message, the email address may be added to the mailing list.
     * 
     * @param array $data
     * @return boolean
     */
    public function saveMessage( array $data )
    {
        if( !isset( $data['name'] ) || !isset( $data['email'] ) 
                || !isset( $data['message'] ) )
            return false;
        
        $name       = trim( $data['name'] );
        $email      = trim( $data['email'] );
        $message    = trim( $data['message'] );
        
        $columns    = [ 'Name' => $name,
                        'Email' => $email,
                        'Message' => $message ];
        
        return parent::save( $this->table, $columns );
    }
    
    /**
     * Deletes a message, and the contact address may also be deleted.
     * 
     * @param int $comment_id
     * @return type
     */
    public function remove( int $comment_id )
    {
        $column = array( 'key' => 'ColumnId', 'value' => (int) $comment_id );
        
        return parent::delete( $this->table, $column );
    }
}