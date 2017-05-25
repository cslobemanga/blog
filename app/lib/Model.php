<?php
namespace Application\Lib;

use Application\Lib\Interfaces\IModel;

error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Model implements IModel
{
    
    protected $db;
    protected $table;
    protected $table_view;

    /**
     * Constructor
     * Initializes the DB-connection and the view tables
     */
    public function __construct() 
    {
        $this->db = App::getDB();
        
        $this->table_view = [];
    }
    
    /**
     * Access the private attribut $db with this getter
     * 
     * @return \Application\Lib\Database
     */
    public function getDB(): Database
    {
    	return $this->db;
    }
    
    /**
     * Returns all the items satisfying $conditions from a table 
     * 
     * @param string $table
     * @param array $conditions
     * @param string $order_by
     * @return type
     */
    public function findAll( string $table=null, array $conditions=[], string $order_by=null )
    {
        $sql    = "SELECT * FROM $table";
        $params = [];
        $count  = 0;
        
        if( $conditions ) {
            $sql .= " WHERE ";
            
            foreach ( $conditions as $key => $value ) {
                
                if( $count === 0 ) {
                    $sql .= $key . "=? ";
   
                } else {
                    if( $count === count( $conditions)-1 ) {
                        $sql .= "AND $key=? ";
                    } else {
                        $sql .= ", $key=? ";
                    }
                }
                $params[] = $value;
                $count++;
            }
        }
        
        if( $order_by ) {
            $sql .= " ORDER BY $order_by";
        }
        $result = $this->getDB()->query( $sql, $params );
        
        return $result;
    }
    
    /**
     * Find the corresponding row from a given column
     * 
     * @param array $column
     * @param string $table
     * @return type
     */
    public function findByColumn( array $column, string $table )
    {   
        $key    = array_keys($column)[0];
        $value  = $column[$key];
        
        $sql    = "SELECT * FROM $table WHERE $key = ?";
        $result = $this->getDB()->query( $sql, [$value] );
        
        return $result;
    } 
    
    /**
     * Save a new item, or update an existing item falls $id not null
     * 
     * @param array $columns
     * @param string $table
     * @param int $id
     */
    public function save( array $columns, string $table, int $id=null )
    {
        $id     = ( int )$id;
        $params = [];
        $count  = 0;
        
        // Adding a new record or updating an existing one
        if( $id ) {
            $sql = "UPDATE $table SET ";
        
            foreach ( $columns as $key => $value ) {
                
                if( $count == count($columns)-1 ) {
                    $sql .= "WHERE $key=?";
                    
                } elseif ( $count == count($columns)-2 ) {
                    $sql .= $key . "=? ";
                
                } else {
                    $sql .= $key . "=?, ";
                } 
                
                $params[] = $value;
                $count++;
            }
            
        } else {
            $sql = "INSERT INTO $table SET ";
            
            foreach ( $columns as $key => $value ) {
                
                $sql .= ($count == count($columns)-1 ) ? "$key=? " : "$key=?, ";
                
                $params[] = $value;
                $count++;
            }
        }
        
        $result = $this->getDB()->query( $sql, $params, false );
        
        return $result;
    }


    /**
     * Removes an item with the specified key/value from a given table
     * 
     * @param array $columns
     * @param string $table
     * @return type
     */
    public function delete( array $columns, string $table )
    {
        
        $sql    = "DELETE FROM $table WHERE ";
        $params = [];
            
        foreach ( $columns as $key => $value ) {
          $sql      .= $key . "=?";
          $params[]  = $value;
          break;
        }
        
        return $this->getDB()->query( $sql, $params, false );        
    }
    
    /**
     * Creates the corresponding language table pages_<lg>
     * in the database
     * 
     * @param string $lang_code
     * @return bool
     */
    public function createLanguageTable( string $lang_code ): bool
    {
        
        $sql = "CALL sp_create_language_table( ? )";
        
        return $this->getDB()->query( $sql, [$lang_code], false );     
    }
}