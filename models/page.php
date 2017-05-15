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

    public function getAll()
    {
        $params = array( 'IsPublished' => 1 );
   
        $result = parent::findAll( $this->table, $params );
        
        return $result;
    }
    
    public function getByAlias( $pAlias )
    {           
        $column = array( 'Alias' => $pAlias );
   
        $result = parent::findByColumn( $column, $this->table );
        
        return $result[0] ?? false;
    }
    
    public function getById( $pId )
    {           
        $column = array( 'PageId' => $pId );
   
        $result = parent::findByColumn( $column, $this->table );
        
        return $result[0] ?? false;
    }
    
    public function register( $data, $id=null )
    {
        if( !isset( $data['alias'] ) || !isset( $data['title'] ) ) {
            
            return false;
        }
        
        $id             = ( int )$id;
        $alias          = $data['alias'];
        $title          = $data['title'];
        $is_published   = isset( $data['is_published'] ) ? 1 : 0;
        
        $columns        = array( 'Title' => $title, 
                                 'Alias' => $alias, 
                                 'IsPublished' => $is_published );
        
        if( $id ) { // Then add a new record
            $columns += array( 'PageId' =>$id );
        }
        
        return parent::save( $columns, $this->table, $id );
    }
    
    public function remove( int $id )
    {
        $column = array( 'key' => 'PageId', 'value' => (int)$id );
         
        $result = parent::delete( $column, $this->table );

    }
}