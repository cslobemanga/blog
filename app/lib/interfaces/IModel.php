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
	
	public function getDB(): Database;
}
