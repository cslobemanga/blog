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

    public function getAll( bool $only_published=true )
    {
        $params = $only_published ? [ 'IsPublished' => 1 ] : [];
   
        $result = parent::findAll( $this->table, $params );
        
        return $result;
    }
    
    public function getByAlias( $pAlias )
    {           
        $column = array( 'Alias' => $pAlias );
   
        $result = parent::findByColumn( $this->table, $column );
        
        return $result[0] ?? false;
    }
    
    public function getById( $pId )
    {           
        $column = array( 'PageId' => $pId );
   
        $result = parent::findByColumn( $this->table, $column );
        
        return $result[0] ?? false;
    }
    
    /**
     * Updates the page page id
     * 
     * @param type $data
     * @param type $id
     * @return boolean
     */
    public function edit( $data )
    {
        if( !isset( $data['page_id'] ) || !isset( $data['title'] ) ) {
            return false;
        }
        
        $page_id        = ( int )$data['page_id'];
        $title          = $data['title'];
        $is_published   = isset( $data['is_published'] ) ? 1 : 0;
        
        $columns        = [ 'Title'        => $title, 
                            'IsPublished'  => $is_published,
                            'PageId'       => $page_id ];
        
        return parent::save( $columns, $this->table, $page_id );
    }
    
    /**
     * * Creates a new page
     * 
     * @param type $data
     * @param type $id
     * @return boolean
     */
    public function register( $data )
    {
        if( !isset( $data['alias'] ) || !isset( $data['title'] ) ) {  
            return false;
        }
        
        $alias          = $data['alias'];
        $title          = $data['title'];
        $is_published   = isset( $data['is_published'] ) ? 1 : 0;
        
        $columns        = array( 'Title' => $title, 
                                 'Alias' => $alias, 
                                 'IsPublished' => $is_published );
        
        return parent::save( $columns, $this->table );
    }
    
    /**
     * Delete the selected page
     * 
     * @param int $id
     */
    public function remove( int $id )
    {
        $column = array( 'PageId' => (int)$id );
         
        $result = parent::delete( $column, $this->table );

    }
    
    /**
     * 
     * @param string $lang_code
     * @return type
     */
    public function createLanguageTable( string $lang_code ): bool 
    {
        
        return parent::createLanguageTable( $lang_code );
    }
}