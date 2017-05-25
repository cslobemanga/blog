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
    
    public function __construct() 
    {
        parent::__construct();
        
        $this->table = 'messages';
    }
    
    public function getAll()
    {
        $params = array( 'IsPublished' => 1 );
        
        $order_by =  "MessageId DESC";
        
        return parent::findAll( $this->table, $params, $order_by );
    }

    public function saveMessage( $data )
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
        
        return parent::save( $columns, $this->table );
    }
    
    public function remove( int $comment_id )
    {
        $column = array( 'key' => 'ColumnId', 'value' => (int) $comment_id );
        
        return parent::delete( $column, $this->table );
    }
}