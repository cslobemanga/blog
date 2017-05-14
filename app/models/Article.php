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
        
        $table_view = $this->table_view['author'];
        $params     = array( 'IsPublished' => 1 );
        $order      = " ORDER BY DatePublished DESC";
        
        $result     = parent::findAll( $table_view, $params, $order );
        
        return $result; 
    }

    public function getById( int $id )
    {
        $column = array( 'key' => 'ArticleId', 'value' => $id );
        
        $result = parent::findByColumn( $column, $this->table ); 
        
        return $result[0] ?? null;
    }
    
    public function getByAuthor( int $author_id )
    {
        $column = array( 'key' => 'AuthorId', 'value' => $author_id );
        
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
        
        $sql = "SELECT * FROM $table_view WHERE Article=?";
        
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
    public function save( $data, bool $by_admin=false ):bool
    {
        try {
            $sql = "INSERT INTO $this->table (AuthorId, Title, Content) VALUES(?,?,?)";
            
            $params = [ $data['user_id'], $data['title'], $data['content'] ];

            $result = $this->getDB()->query( $sql, $params, $by_admin );
            
            return true;
            
        } catch ( PDOException $ex ) {
            echo 'Error: ' . $ex->getMessage();
        }
        
        return false;
    }
    
    public function remove( int $article_id )
    {
        $column = array( 'key' => 'ArticleId', 'value' => $article_id );
        
        return parent::delete( $column, $this->table );
    }
}