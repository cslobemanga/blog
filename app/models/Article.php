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
    
    /**
     * The constructor, initializes the tables and inherits
     * a database connection instance from the parent class
     */
    public function __construct() 
    {
        parent::__construct();
        
        $this->table                    = 'articles';
        $this->table_view['author']     = 'author_articles';
        $this->table_view['comments']   = 'article_comments';
    }
    
    /**
     * Returns all the records satisfying the condition $only_published
     * 
     * @see Model::findAll()
     * @param bool $only_published
     * @return type
     */
    public function getAll( bool $only_published=true )
    {
        $table  = $this->table_view['author'];
        $params = $only_published ? [ 'IsPublished' => 1 ] : [];
        
        $order  = "DatePublished DESC";
        
        return parent::findAll( $table, $params, $order );     
    }

    /**
     * Returns an article given its article_id.
     * 
     * @param int $article_id
     * @return type
     */
    public function getById( int $article_id )
    {
        $column = [ 'ArticleId' => $article_id ];
        
        $result = parent::findByColumn( $this->table, $column ); 
        
        return $result[0] ?? null;
    }
    
    /**
     * Returns the author of an article given the article id.
     * 
     * @param int $article_id
     * @return type
     */
    public function getAuthor( int $article_id )
    {
        $table_view = $this->table_view['author'];
        
        $sql ="SELECT Login, Email FROM $table_view WHERE ArticleID=?";
        
        $result = $this->getDB()->query( $sql, [$article_id] );
        
        return $result[0] ?? null;
    }
    
    /**
     * Returns all the comments related to the current article.
     * 
     * @param int $article_id
     * @return type
     */
    public function getComments( int $article_id )
    {
        $table_view = $this->table_view['comments'];
        
        $sql = "SELECT * FROM $table_view WHERE Article=? ORDER BY DatePublished DESC";
        
        $result = $this->getDB()->query( $sql, [$article_id] );
        
        return $result;
    }
    
    /**
     * Finds all the articles published in a given month of a given year
     * 
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getArchives( int $month, int $year ):array
    {
        $sql = "SELECT ArticleId, Title, DatePublished FROM $this->table";
        
        $conditions = [ 'MONTH(DatePublished)'  => $month, 
                        'YEAR(DatePublished)'    => $year ];
        
        $order_by = "DatePublished DESC";
        
        return parent::findAll( $this->table, $conditions, $order_by );
    }
   
    /**
     * Adds a new article
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

            return parent::save( $this->table, $columns );
            
        } catch ( PDOException $ex ) {
            echo 'Error: ' . $ex->getMessage();
        }
        
        return false;
    }
    
    /**
     * Edits an existing article
     * 
     * @param type $data
     * @param int $article_id
     * @return type
     */
    public function edit( $data, int $article_id )
    {
        try {
            $content = trim( $data['content'] );
            $is_published = isset( $data['is_published'] ) ? 1 : 0;
            
            $columns = [ 'Content'      => $content, 
                         'IsPublished'  => $is_published,
                         'ArticleId'     => $article_id ];
            
            return parent::save( $this->table, $columns, $article_id );
            
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
        $column = [ 'ArticleId' => (int)$article_id ];
        
        return parent::delete( $this->table, $column );
    }
}