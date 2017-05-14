<?php
namespace Application\Lib;

/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Database
{ 
    protected static $instance;
    protected $connection;


    private function __construct() 
    {
        try {
            $this->connection = new \PDO( 
                    sprintf( "mysql:host=%s;dbname=%s", 
                            Config::get('db.host'), 
                            Config::get('db.dbname') ), 
                            Config::get('db.user'), 
                            Config::get('db.password') );
            
            $this->connection->setAttribute( \PDO::ATTR_ERRMODE, 
                                             \PDO::ERRMODE_EXCEPTION );
            $this->connection->setAttribute( \PDO::ATTR_DEFAULT_FETCH_MODE, 
                                             \PDO::FETCH_ASSOC );
        
        } catch ( \PDOException $ex) {
            echo 'Verbindung fehlgeschlagen: '. $ex->getMessage();
        }
    }

    private function __clone() 
    {
        return false;
    }
    
    private function __wakeup() 
    {
        return false;
    }

    public static function getInstance(): Database
    {
        if( self::$instance === null )
            self::$instance = new static();
        
        return self::$instance;
    }
    
    public function query( $sql, $params=[], $select=true )
    {
        if( !$this->connection ) {
            return false;
        }
        
        try {
            $statement = $this->connection->prepare( $sql );
            $statement->execute( $params );
            
        } catch ( \PDOException $ex ) {
            echo 'Error ' . $ex->getCode() . ': ' . $ex->getMessage();
        }
        
        if( !$select )
            return true;
        
       $data = [];
       
       foreach ( $statement->fetchAll() as $row ) {
           
           $data[] = $row;
       }
       
       return $data;
    }
}