<?php
namespace Application\Models;

use Application\Lib\Model;

error_reporting( E_ALL );
/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

/**
 * Description of comments
 *
 * @author Charles S. Lobe-Manga <charles@lobe-manga.com>
 */
class Comment extends Model
{
    
    public function __construct() 
    {
        parent::__construct();
        
        $this->table                    = 'comments';
        $this->table_view['author']     = 'author_comments';
        $this->table_view['article']    = 'article_comments';
    }
    
    public function getAll()
    {
        $params = [ 'IsPublished' => 1 ];
        $order_by = "ORDER BY DatePublished DESC";
        
        return parent::findAll( $this->table, $params, $order_by );
    }

        public function getByID( $id )
    {
        $column = array( 'key' => 'CommentId', 'value' => $id );
   
        $result = parent::findByColumn( $this->table, $column );
        
        return $result[0] ?? false;
    }
    
    public function getArticle( $comment_id )
    {
        $sql = "SELECT ArticleID FROM $this->table_view WHERE CommentID=?";
        
        $result = $this->getDB()->query( $sql, [$comment_id] );
        
        return $result[0] ?? false;
    }
    
    public function getAuthor()
    {
        
    }
    
    /**
     * Saves a new comment to the article <article_id>
     * or edits an  existing one falls 
     * 
     * @param array $data
     * @param int $comment_id
     */
    public function add( array $data )
    {
        try {
            $article_id = $data['article_id'];
            $author_id  = $data['author_id'];
            $content    = trim( $data['content'] );
            
            $columns = [ 'ArticleId' => (int) $article_id, 
                         'AuthorId'   => (int) $author_id, 
                         'Content'   => $content ];
            
            return parent::save( $columns, $this->table );
            
        } catch ( \Exception $ex) {
            echo 'Error: ' . $ex->getMessage();
        }
    }
}
