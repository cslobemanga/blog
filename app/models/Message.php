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
        
        return parent::findAll( $this->table, $params );
    }

    public function save( $data, $id=null )
    {
        if( !isset( $data['name'] ) || !isset( $data['email'] ) 
                || !isset( $data['message'] ) )
            return false;
        
        $id         = ( int )$id;
        $name       = $data['name'];
        $email      = $data['email'];
        $message    = $data['message'];
        
        if( !$id ) { // Then add a new record
            $sql = "INSERT INTO $this->table (Name,Email,Message) VALUES(?,?,?)";
            
            $result = $this->getDB()->query( $sql, [$name, $email, $message], false );
            
        } else {  // Then update an existing record
            $sql = "UPDATE $this->table SET Name=?, Email=?, Message=? WHERE MessageId=?";
            
            $result = $this->getDB()->query( $sql, [$name, $email, $message, $id], false );
        }
        return $result;
    }
    
    public function remove( int $comment_id )
    {
        $column = array( 'key' => 'ColumnId', 'value' => (int) $comment_id );
        
        return parent::delete( $column, $this->table );
    }
}