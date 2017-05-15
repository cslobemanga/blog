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

    public function register( $data, $id=null )
    {
        if( !isset( $data['name'] ) || !isset( $data['email'] ) 
                || !isset( $data['message'] ) )
            return false;
        
        $id         = ( int )$id;
        $name       = $data['name'];
        $email      = $data['email'];
        $message    = $data['message'];
        
        $columns    = [ 'Name' => $name,
                        'Email' => $email,
                        'Message' => $message ];
        
        if( $id ) {
            $columns += [ 'MessageId' => $id ];
        }
        
        return parent::save( $columns, $this->table, $id );
    }
    
    public function remove( int $comment_id )
    {
        $column = array( 'key' => 'ColumnId', 'value' => (int) $comment_id );
        
        return parent::delete( $column, $this->table );
    }
}