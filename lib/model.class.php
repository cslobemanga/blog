<?php
error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class Model
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
    
<<<<<<< HEAD:lib/model.class.php
    public function getDB(): DB
=======
    /**
     * Access the private attribut $db with this getter
     * 
     * @return \Application\Lib\Database
     */
    public function getDB(): Database
>>>>>>> maroc:app/lib/Model.php
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
        
        if( $conditions ) {
            $sql .= " WHERE ";
            
            foreach ( $conditions as $key => $value ) {
                $sql .= $key . "=? ";
                $params[] = $value;
            }
        }
        
        if( $order_by ) {
            $sql .= $order_by;
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
                    
//                } elseif ( $count == count($columns-2 ) ) {
//                    $sql .= $key . "=? ";
                
                } else {
                    $sql .= "$key=?, ";
                } 
                
                $params[] = $value;
                $count++;
            }
            echo $sql;
            
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
     * @param array $column
     * @param string $table
     * @return type
     */
    public function delete( array $column, string $table )
    {
        if( !isset($column['key']) || !isset($column['value']) )
            return null;
        
        $key    = $column['key'];
        $value  = $column['value'];
        
        $sql    = "DELETE FROM $table WHERE $key = ?";
        
        return $this->getDB()->query( $sql, [$value], false );
    }
}