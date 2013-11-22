jQuery(document).ready(function(){
    //comment
    jQuery('body').delegate(".album-comment-button", "click",function () {
        jQuery.ajax({
            type: "POST",
            url: '../comment-in-album',
            data: {
                albumId: jQuery('input[name="albumId"]').val(),
                comment: jQuery('input[name="comment"]').val()
            }
        }).done(function( msg ) {
                //alert(msg);
                window.location.reload();
            });
    });

    //like album
    jQuery('body').delegate(".album-like-button", "click",function () {
        jQuery.ajax({
             type: "POST",
             url: '../like-album',
             data: {
                albumId: jQuery('input[name="albumId"]').val()
             }
        }).done(function( msg ) {
                //alert(msg);
             });
    });

    //delete photo
    jQuery('body').delegate("#delete-photo", "click",function () {
        var photoIdToDelete = $(this).parents('.photo-link').data('id');
        jQuery.ajax({
            type: "POST",
            url: '../delete-photo',
            data: {
                photoId: photoIdToDelete
            }
        }).done(function( msg ) {
                //alert(msg);
                //window.location.reload();
                jQuery('.alert-messege').html(msg);
            });
    });

    //delete album
    jQuery('body').delegate("#delete-album", "click",function () {
        var done = true;
        var albumIdToDelete = $(this).parents('li').data('albumid');
        jQuery.ajax({
            type: "POST",
            url: '../delete-album(temporary)',
            data: {
                albumId: albumIdToDelete
            }
        }).done(function( msg ) {
                //alert(msg);
                //window.location.reload();
                jQuery('.alert-messege').html(msg);
            });
    });

    //for forms displaying
    $('#edit-button').click(function () {
        jQuery('#edit-form').removeClass('form-hidden');
        jQuery('#upload-form').addClass('form-hidden');
    });
    $('#upload-button').click(function () {
        jQuery('#upload-form').removeClass('form-hidden');
        jQuery('#edit-form').addClass('form-hidden');
    });

});