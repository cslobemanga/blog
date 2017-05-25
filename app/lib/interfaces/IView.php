<?php

/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

namespace Application\Lib\Interfaces;

/**
 * Description of IView
 *
 * @author Charles S. Lobe-Manga <charles@lobe-manga.com>
 */
interface IView 
{
    
    public function render(): string;    
}
