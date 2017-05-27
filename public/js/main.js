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
    
    // Redirect language url
    $('#lang_option').change( function()
    {
       var url = $(this).val();
       
       if( url ) {
           window.location = '/' + url;
       }
       
       return false;
    });
    
    // Enable comment text-area
    $( '.textarea-author' ).click( function()
    {
        var textarea_id = $(this).attr('id');
        
        $( ".textarea-author[id*='" + textarea_id + "']" )
            .attr( 'readonly', false )
            .addClass( 'w3-border' );
    
        $( '#div-edit-author').css( 'visibility', 'visible' );
        
    })
});

