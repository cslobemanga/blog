<?php

/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

namespace Application\Lib\Interfaces;

/**
 * Description of ILang
 *
 * @author Charles S. Lobe-Manga <charles@lobe-manga.com>
 */
interface ILang 
{
    
    public static function load( string $lang_code );
    
    public static function get( string $key, string $default_value='' ): string;
}
