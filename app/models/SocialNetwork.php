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
    
    /**
     * The constructor, initializes the tables and inherits
     * a database connection instance from the parent class
     */
    public function __construct() 
    {
        parent::__construct();
        
        $this->table = 'social_networks';
    }
    
    /**
     * Returns all the social networks links to be published on the site.
     * 
     * @return type
     */
    public function getAll()
    {
        $params = ['IsActive' => 1 ];
        
        return parent::findAll( $this->table, $params );
    }
}