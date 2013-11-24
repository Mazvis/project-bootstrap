(function($){
    //album comment
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

    //photo comment
    $('body').delegate(".photo-comment-button", "click",function () {
        $.ajax({
            type: "POST",
            url: '../../../comment-in-photo',
            data: {
                photoId: $('input[name="photoId"]').val(),
                comment: $('input[name="comment"]').val()
            }
        }).done(function( msg ) {
                //alert(msg);
                window.location.reload();
            });
    });

    //photo edit
    $('body').delegate(".photo-edit-form", "click",function () {
        alert($('.check').prop('checked'));
        /*$.ajax({
            type: "POST",
            url: '../../../edit-photo-info',
            data: {
                photoId: $('input[name="photoId"]').val(),
                photoName: $('input[name="photoName"]').val(),
                shDescription: $('input[name="shDescription"]').val(),
                placeTaken: $('input[name="placeTaken"]').val(),
                albumTitlePhoto: $('#check').prop('checked')
            }
        }).done(function( msg ) {
                //alert(msg);
                //window.location.reload();
            });*/
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
    //like photo
    $('body').delegate(".photo-like-button", "click",function () {
        //alert($('input[name="photoId"]').val());
        $.ajax({
            type: "POST",
            url: '../../../like-photo',
            data: {
                photoId: $('input[name="photoId"]').val()
            }
        }).done(function( msg ) {
                alert(msg);
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
                alert(msg);
            });
    });

    //delete photo from single photo page
    $('body').delegate("#delete-single-photo", "click",function () {
        var photoIdToDelete = $(this).parents('li').data('photoid');
        $.ajax({
            type: "POST",
            url: '../../../delete-photo-from-album',
            data: {
                albumId: $('input[name="albumId"]').val(),
                photoId: photoIdToDelete
            }
        }).done(function( msg ) {
                alert(msg);
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