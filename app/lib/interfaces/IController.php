<?php

/*
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

namespace Application\Lib\Interfaces;

/**
 * Description of IController
 *
 * @author Charles S. Lobe-Manga <charles@lobe-manga.com>
 */
interface IController 
{
    
    public function getData(): array;
    
    public function getModel(): IModel;
    
    public function getParams(): array;
}
