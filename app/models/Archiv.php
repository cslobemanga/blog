<?php

/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

namespace Application\Models;

use Application\Lib\Model;

/**
 * Description of Archiv
 *
 * @author Charles S. Lobe-Manga <charles@lobe-manga.com>
 */
class Archiv extends Model
{
 
    public function __construct() 
    {
        parent::__construct();
        
        $this->table = 'articles_by_month_and_year';
    }
    
    public function getAll(): array
    {
        
        return parent::findAll( $this->table );
    }
}