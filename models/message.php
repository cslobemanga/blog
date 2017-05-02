<?php
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
    
    public function getList()
    {
        $sql = "SELECT * FROM $this->table";
        
        return $this->getDB()->query( $sql );
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
    
    public function delete( $id )
    {
        
        $id = ( int )$id;
        
        $sql = "DELETE FROM $this->table WHERE MessageId = ?";
        
        $result = $this->getDB()->query( $sql, [$id], false );
        
        return $result;
    }
}