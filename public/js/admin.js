/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

function confirmDelete()
{
    if( confirm( "Delete this item? \nAll related data - Artikel, comments - will also be deleted!" ) )
        return true;
    
    else
        return false;
}

$( document ).ready( function() {
    
    $('#lang_option').change( function()
    {
       var url = $(this).val();
       
       if( url ) {
           window.location = '/' + url;
       }

//       alert( url );
       return false;
    });
});

