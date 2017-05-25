<?php

/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

namespace Application\Models;

use Application\Lib\Model;

/**
 * Description of SocialNetwork
 *
 * @author Charles S. Lobe-Manga <charles@lobe-manga.com>
 */
class SocialNetwork extends Model
{
    
    public function __construct() 
    {
        
        parent::__construct();
        
        $this->table = 'social_networks';
    }
    
    public function getAll()
    {
        $params = ['IsActive' => 1 ];
        
        return parent::findAll( $this->table, $params );
    }
}