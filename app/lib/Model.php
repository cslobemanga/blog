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

    public function __construct() 
    {
        $this->db = App::getDB();
        
        $this->table_view = [];
    }
    
    public function getDB(): Database
    {
    	return $this->db;
    }
    
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
}