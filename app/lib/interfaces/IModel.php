<?php
namespace Application\Lib\Interfaces;

use Application\Lib\Database;

error_reporting( E_ALL );

/**
 *  SinkaCom Bewerbertest: Leitungsplan
 *  
 *  Datum: 13.05.2017
 *  @version: 1.0
 *  @author: Charles Lobe-Manga.
 */

interface IModel
{

    /**
     * Returns the single instance of the database.
     */
    public function getDB(): Database;
    
    /**
     * Returns in the specified order all the records from the table 
     * statisfying the conditions.
     * 
     * @param string $table
     * @param array $conditions
     * @param string $order_by
     */
    public function findAll( string $table, array $conditions=[], string $order_by=null );
    
    /**
     *  Find the corresponding row from a given column.
     * 
     * @param string $table
     * @param array $column
     * @param array $condition
     */
    public function findByColumn( string $table, array $column, array $condition=[] );
    
    /**
     * Save a new item, or update an existing item falls $id not null.
     * 
     * @param string $table
     * @param array $columns
     * @param int $id
     */
    public function save( string $table, array $columns, int $id=null );
    
    /**
     * Removes an item with the specified key/value from a given table.
     * 
     * @param string $table
     * @param int $id
     */
    public function delete( string $table, array $columns );
}
