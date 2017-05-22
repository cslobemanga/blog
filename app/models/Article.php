<?php
namespace Application\Models;

use Application\Lib\Model;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Article extends Model
{
    
    public function __construct() 
    {
        parent::__construct();
        
        $this->table                    = 'articles';
        $this->table_view['author']     = 'author_articles';
        $this->table_view['comments']   = 'article_comments';
    }
    
    public function getAll()
    {
        
        $table  = $this->table_view['author'];
        $params = array( 'IsPublished' => 1 );
        $order  = " ORDER BY DatePublished DESC";
        
        $result     = parent::findAll( $table, $params, $order );
        
        return $result; 
    }

    public function getById( int $article_id )
    {
        $column = array( 'ArticleId' => $article_id );
        
        $result = parent::findByColumn( $column, $this->table ); 
        
        return $result[0] ?? null;
    }
    
    public function getByAuthor( int $author_id )
    {
        $column = array( 'AuthorId' => $author_id );
        
        $result = parent::findByColumn( $column, $this->table );
        
        return $result[0] ?? null;
    }
    
    public function getAuthor( int $article_id )
    {
        $table_view = $this->table_view['author'];
        
        $sql ="SELECT Login, Email FROM $table_view WHERE ArticleID=?";
        
        $result = $this->getDB()->query( $sql, [$article_id] );
        
        return $result[0] ?? null;
    }
    
    public function getComments( $article_id )
    {
        $table_view = $this->table_view['comments'];
        
        $sql = "SELECT * FROM $table_view WHERE Article=? ORDER BY DatePublished DESC";
        
        $result = $this->getDB()->query( $sql, [$article_id] );
        
        return $result;
    }
   
    /**
     * Saves a new article or edit an existing one
     * 
     * @param type $data
     * @param bool $by_admin
     * @return bool
     */
    public function add( $data, bool $by_admin=false ):bool
    {
        try {
            if( !isset( $data['slug'] ) ) {
                $slug = explode( ' ', trim( strtolower( $data['title'] ) ) );
                $slug = implode( '-', $slug );
                
            } else {
                $slug = $data['slug'];
            }
            
            $columns = [ 'AuthorId' => $data['user_id'], 
                         'Title'    => trim( $data['title'] ), 
                         'Slug'     => trim( $data['slug'] ),
                         'Content'  => trim( $data['content'] ) ];

            return parent::save( $columns, $this->table );
            
        } catch ( PDOException $ex ) {
            echo 'Error: ' . $ex->getMessage();
        }
        
        return false;
    }
    
    public function edit( $data, int $article_id )
    {
        try {
            $content = trim( $data['content'] );
            $is_published = isset( $data['is_published'] ) ? 1 : 0;
            
            $columns = [ 'Content'      => $content, 
                         'IsPublished'  => $is_published,
                         'ArticleId'     => $article_id ];
            
            return parent::save( $columns, $this->table, $article_id );
            
        } catch ( Exception $ex ) {
            echo 'Error: ' . $ex->getMessage();
        }
    }

        /**
     * Deletes an article given the id
     * 
     * @param int $article_id
     * @return type
     */
    public function remove( int $article_id )
    {
        $column = array( 'key' => 'ArticleId', 'value' => $article_id );
        
        return parent::delete( $column, $this->table );
    }
}