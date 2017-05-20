<?php
namespace Application\Lib\Traits;

/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

/**
 * Implements the static method getInstance()
 *
 * @author Charles S. Lobe-Manga <charles@lobe-manga.com>
 */
trait Singleton 
{

    public static function getInstance()
    {
        static $instance = NULL;
        
        $class = __CLASS__;
        
        return $instance ?: $instance = new $class;
        
  
    }
}
