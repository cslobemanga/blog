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
    
    /**
     * The constructor, initializes the tables and inherits
     * a database connection instance from the parent class
     */
    public function __construct() 
    {
        parent::__construct();
        
        $this->table = 'pages';
    }

    /**
     * Returns all the pages to be published in the layout template.
     * 
     * @param bool $only_published
     * @return type
     */
    public function getAll( bool $only_published=true )
    {
        $params = $only_published ? [ 'IsPublished' => 1 ] : [];
   
        $result = parent::findAll( $this->table, $params );
        
        return $result;
    }
    
    /**
     * Returns a page given its alias.
     * 
     * @param string $pAlias
     * @return type
     */
    public function getByAlias( string $pAlias )
    {           
        $column = array( 'Alias' => $pAlias );
   
        $result = parent::findByColumn( $this->table, $column );
        
        return $result[0] ?? false;
    }
    
    /**
     * Returns a page given its id.
     * 
     * @deprecated since version 1.1
     * @param int $pId
     * @return type
     */
    public function getById( int $pId )
    {           
        $column = array( 'PageId' => $pId );
   
        $result = parent::findByColumn( $this->table, $column );
        
        return $result[0] ?? false;
    }
    
    /**
     * Updates the page page id
     * 
     * @param array $data
     * @param type $id
     * @return boolean
     */
    public function edit( array $data )
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
        
        return parent::save( $this->table, $columns, $page_id );
    }
    
    /**
     * * Creates a new page
     * 
     * @param array $data
     * @param type $id
     * @return boolean
     */
    public function register( array $data )
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
        
        return parent::save( $this->table, $columns );
    }
    
    /**
     * Delete the selected page
     * 
     * @param int $id
     */
    public function remove( int $id )
    {
        $column = array( 'PageId' => (int)$id );
         
        return parent::delete( $this->table, $column );
    }
    
    /**
     * Creates a table for each language in the application.
     * 
     * For translating purposes, this avoids having numerouns
     * columns for each language in the same table.
     * 
     * @param string $lang_code
     * @return bool
     */
    public function createLanguageTable( string $lang_code ): bool 
    {
        
        return parent::createLanguageTable( $lang_code );
    }
}