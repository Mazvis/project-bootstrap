(function($){
    //comment
    $('body').delegate(".album-comment-button", "click",function () {
        $.ajax({
            type: "POST",
            url: '../comment-in-album',
            data: {
                albumId: $('input[name="albumId"]').val(),
                comment: $('input[name="comment"]').val()
            }
        }).done(function( msg ) {
                //alert(msg);
                window.location.reload();
            });
    });

    //like album
    $('body').delegate(".album-like-button", "click",function () {
        $.ajax({
             type: "POST",
             url: '../like-album',
             data: {
                albumId: $('input[name="albumId"]').val()
             }
        }).done(function( msg ) {
                //alert(msg);
             });
    });

    //delete photo
    $('body').delegate("#delete-photo", "click",function () {
        var photoIdToDelete = $(this).parents('.photo-link').data('id');
        $.ajax({
            type: "POST",
            url: '../delete-photo',
            data: {
                photoId: photoIdToDelete
            }
        }).done(function( msg ) {
                //alert(msg);
                //window.location.reload();
                $('.alert-messege').html(msg);
            });
    });

    //delete album
    $('body').delegate("#delete-album", "click",function () {
        var done = true;
        var albumIdToDelete = $(this).parents('li').data('albumid');
        $.ajax({
            type: "POST",
            url: '../delete-album(temporary)',
            data: {
                albumId: albumIdToDelete
            }
        }).done(function( msg ) {
                //alert(msg);
                //window.location.reload();
                $('.alert-messege').html(msg);
            });
    });

    //for forms displaying
    $('#edit-button').click(function () {
        $('#edit-form').removeClass('form-hidden');
        $('#upload-form').addClass('form-hidden');
    });
    $('#upload-button').click(function () {
        $('#upload-form').removeClass('form-hidden');
        $('#edit-form').addClass('form-hidden');
    });

})(jQuery);