<?php
use PHPUnit\Framework\TestCase;
use Application\Models\User;

/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class UserTest extends TestCase
{
    
    /**
     * @test
     */
    public function testGetAllNotNull(): void
    {
        $this->assertEquals( 2, 1+1 );
    }
}