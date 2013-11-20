jQuery(document).ready(function(){
    var jsArray;
    jQuery.ajax({
        type: "POST",
        url: 'show-photos'
    }).done(function( msg ) {
            jsArray = JSON.parse(msg);
            for ( var i = 0; i < jsArray.length; i++ ) {
                jQuery('#photos').append('<a href="'+jsArray[i]+'" class="photo-link"><img src="'+jsArray[i]+'" alt="First"></a>');
            }
        });

});