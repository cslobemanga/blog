<?php

/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

namespace Application\Lib\Interfaces;

/**
 * Description of IDatabase
 *
 * @author Charles S. Lobe-Manga <charles@lobe-manga.com>
 */
interface IDatabase 
{
 
    public function query( string $sql, array $params=[], bool $select=true );
}