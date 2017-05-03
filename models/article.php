<?php
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
    
    public function getList( $only_published = false )
    {
        $table_view = $this->table_view['author'];
        
        $sql ="SELECT * FROM $table_view";
        
        if( $only_published )
            $sql .= " WHERE IsPublished=1";
        
        $sql .= " ORDER BY DatePublished";
        
        $result = $this->getDB()->query( $sql );
        
        return $result;
    }


    public function getById( $id )
    {
        
        $sql = "SELECT * FROM $this->table WHERE ArticleID=? AND IsPublished=1";
        
        $result = $this->getDB()->query( $sql, [ (int)$id ] );
        
        return $result[0] ?? false;
    }
    
    public function getByAuthor( $author_id )
    {
        
        $sql = "SELECT * FROM $this->table WHERE AuthorID=? AND IsPublished=1";
        
        $result = $this->getDB()->query( $sql, [$author_id] );
        
        return $result;
    }
    
    public function getAuthor( $article_id )
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
}

