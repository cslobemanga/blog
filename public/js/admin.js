/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

function confirmDelete()
{
    if( confirm( "Delete this item? <br>All related data - Artikel, comments - will alos be deleted!" ) )
        return true;
    
    else
        return false;
}

