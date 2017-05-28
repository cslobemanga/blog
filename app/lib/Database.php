<?php
namespace Application\Lib;

use Application\Lib\Traits\Singleton;

/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Database
{ 
    /**
     * The single static instance of the class
     * 
     * @var type 
     */
    protected static $instance;
    
    /**
     * The database connection instance of type PDO
     * 
     * @var type 
     */
    protected $connection;


    /**
     * This constructor initializes the database connection
     */
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

    /**
     * To prevent a duplication of the single instance
     * 
     * @return boolean
     */
    private function __clone() 
    {
        return false;
    }
    
    /**
     * To prevent a duplication of the single instance
     * 
     * @return boolean
     */
    private function __wakeup() 
    {
        return false;
    }

    public static function getInstance(): Database
    {
        if( self::$instance === null ) {
            self::$instance = new static();
        }
        
        return self::$instance;
    }
    
    /**
     * Generic method to query the database
     * 
     * The third parameter specifies wether it's a SELECT-query or not
     * In case of a SELECT query the method returns an array, otherwise
     * it returns a boolean about the success of the operation.
     * 
     * @param string $sql
     * @param type $params
     * @param bool $select
     * @return boolean|array
     */
    public function query( string $sql, $params=[], bool $select=true )
    {
        if( !$this->connection ) {
            return false;
        }
        
        try {
            $statement = $this->connection->prepare( $sql );
            $statement->execute( $params );
            
        } catch ( \PDOException $ex ) {
            echo 'Error ' . $ex->getCode() . ': ' . $ex->getMessage();
            return $ex->getCode();
        }
        
        if( !$select )
            return true;
        
       $data = [];
       
       foreach ( $statement->fetchAll() as $row ) 
       {    
           $data[] = $row;
       }
       
       return $data;
    }
}