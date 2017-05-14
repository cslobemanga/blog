<?php
namespace Application\Models;

use Application\Lib\Model;

error_reporting( E_ALL );

/**
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com> 
 */

class Page extends Model
{
    
    public function __construct() 
    {
        parent::__construct();
        
        $this->table = 'pages';
    }

    public function getAll()
    {
        $params = array( 'IsPublished' => 1 );
   
        $result = parent::findAll( $this->table, $params );
        
        return $result;
    }
    
    public function getByAlias( $pAlias )
    {           
        $column = array( 'key' => 'Alias', 'value' => $pAlias );
   
        $result = parent::findByColumn( $column, $this->table );
        
        return $result[0] ?? false;
    }
    
    public function getById( $pId )
    {           
        $column = array( 'key' => 'PageId', 'value' => $pId );
   
        $result = parent::findByColumn( $column, $this->table );
        
        return $result[0] ?? false;
    }
    
    public function save( $data, $id=null )
    {
        if( !isset( $data['alias'] ) || !isset( $data['title'] ) ) {
            
            return false;
        }
        
        $id             = ( int )$id;
        $alias          = $data['alias'];
        $title          = $data['title'];
        $is_published   = isset( $data['is_published'] ) ? 1 : 0;
        
        if( !$id ) { // Then add a new record
            $sql = "INSERT INTO $this->table (Alias,Title,IsPublished) VALUES(?,?,?)";
            
            $result = $this->getDB()->query( $sql, [$alias, $title, $is_published], false );
            
        } else {  // Then update an existing record
            $sql = "UPDATE $this->table SET Alias=?, Title=?, IsPublished=? WHERE PageId=?";
            
            $result = $this->getDB()->query( $sql, [$alias, $title, $is_published, $id], false );
        }
        
        return $result;
    }
    
    public function remove( int $id )
    {
        $column = array( 'key' => 'PageId', 'value' => (int)$id );
         
        $result = parent::delete( $column, $this->table );

    }
}