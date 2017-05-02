<?php
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
    
    public function getByID( $id )
    {
        $sql = "SELECT * FROM $this->table WHERE CommentID=? AND IsPublished=1";
        
        $result = $this->getDB()->query( $sql, [$id] );
        
        return $result[ 0 ] ?? false;
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
}

