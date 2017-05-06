<?php
error_reporting( E_ALL );
/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com> 
 */

class Model
{
    /**
     * We do need extra table to make sure we collect
     * all the infos we need
     */
    protected $db;
    protected $table;
    protected $table_view;

    public function __construct()
    {
        $this->db = App::getDB();

        $this->table_view = [];
    }

    public function getDB(): DB
    {
        return $this->db;
    }
}
