<?php
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

    public function getList( $only_published = false )
    {
        $sql = "SELECT * FROM $this->table where 1";
        
        if( $only_published ) 
            $sql .= " AND IsPublished = 1";
        
        return $this->getDB()->query( $sql );
    }
    
    public function getByAlias( $pAlias )
    {           
        $sql = "SELECT * FROM $this->table WHERE Alias = ? LIMIT 1";
        
        $result = $this->getDB()->query( $sql, [ $pAlias ] );
        
        return $result[0] ?? false;
    }
    
    public function getById( $pId )
    {           
        $sql = "SELECT * FROM $this->table WHERE PageId = ? LIMIT 1";
        
        $result = $this->getDB()->query( $sql, [ $pId ] );
        
        return $result[0] ?? false;
    }
    
    public function save( $data, $id=null )
    {
        if( !isset( $data['alias'] ) || !isset( $data['title'] ) 
                || !isset( $data['content'] ) )
            return false;
        
        $id             = ( int )$id;
        $alias          = $data['alias'];
        $title          = $data['title'];
        $content        = $data['content'];
        $is_published   = isset( $data['is_published'] ) ? 1 : 0;
        
        if( !$id ) { // Then add a new record
            $sql = "INSERT INTO $this->table (Alias,Title,Content,IsPublished) VALUES(?,?,?,?)";
            
            $result = $this->getDB()->query( $sql, [$alias, $title, $content, $is_published], false );
            
        } else {  // Then update an existing record
            $sql = "UPDATE $this->table SET Alias=?, Title=?, Content=?, IsPublished=? WHERE PageId=?";
            
            $result = $this->getDB()->query( $sql, [$alias, $title, $content, $is_published, $id], false );
        }
        return $result;
    }
    
    public function delete( $id )
    {
        if( !$id )
            return false;
        
        $sql = "DELETE FROM $this->table WHERE PageId=?";
        
        $result = $this->getDB()->query( $sql, [$id], false );
        
        return $result;
    }
}