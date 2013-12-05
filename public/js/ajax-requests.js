(function($){

/*
Home page
 */
    //delete photo
    $('body').delegate("#delete-photo-in-home", "click",function () {
        var photoIdToDelete = $(this).parents('.photo-link').data('id');
        $.ajax({
            type: "POST",
            url: 'delete-photo',
            data: {
                photoId: photoIdToDelete
            }
        }).done(function( msg ) {
                alert(msg);
                window.location.reload();
                //showPhotosInAlbumPage();
            });
    });

/*
Login page
 */
    //login
    //formlogin('#login-form', 'login-to-page');

/*
Albums page
 */
    //create album
    form('#create-album-form', 'create-album');
    /*$('#create-album-form').submit(function(){
        showAlbumsInAlbumPage();
    });*/

    //delete album
    $('body').delegate("#delete-album-in-albums", "click",function (){
        var albumIdToDelete = $(this).parents('#delete-album-data').data('albumid');
        $.ajax({
            type: "POST",
            url: 'delete-album',
            data: {
                albumId: albumIdToDelete
            }
        }).done(function( msg ) {
                alert(msg);
                window.location.reload();
                //showAlbumsInAlbumPage();
            });
    });

    /*function showAlbumsInAlbumPage(){
        $.ajax({
            type: "POST",
            url: 'show-albums'
        }).done(function( msg ) {
                $('#albums').html(msg);
            });
    }*/

/*
Single album page
 */
    //upload photos
    form('#upload-photos-to-album-form', '../upload-photos-to-album');

    /*$('body').delegate("#upload-photo-button", "click",function () {
        showPhotosInAlbumPage(); //not realy good place
    });*/

    //edit album
    form('#edit-album-data-form', '../edit-album-data');

    //delete album(not needed)
    /*$('body').delegate("#delete-album-in-album-page", "click",function () {
        var albumIdToDelete = $(this).parents('li').data('albumid');
        $.ajax({
            type: "POST",
            url: '../delete-album',
            data: {
                albumId: albumIdToDelete
            }
        }).done(function( msg ) {
                alert(msg);
                //window.location.reload();
                //$('.alert-messege').html(msg);
            });
    });*/

    //delete album
    $('body').delegate("#delete-album-in-album-page", "click",function () {
        var albumIdToDelete = $(this).parents('#delete-album-data').data('albumid');
        $.ajax({
            type: "POST",
            url: '../delete-album',
            data: {
                albumId: albumIdToDelete
            }
        }).done(function( msg ) {
                alert(msg);
                window.location.reload();
                //$('.alert-messege').html(msg);
            });
    });

    //var url = window.location.href;
    //alert(url.match(/[\d]+$/));

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
                window.location.reload();
                //showPhotosInAlbumPage();
            });
    });

    //album comment
    $('body').delegate(".album-comment-button", "click",function () {
        $.ajax({
            type: "POST",
            url: '../comment-in-album',
            data: {
                albumId: $('input[name="albumId"]').val(),
                comment: $('textarea[name="comment"]').val()
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
                alert(msg);
                window.location.reload();
            });
    });

    /*function showPhotosInAlbumPage(){
        //alert($('input[name="albumId"]').val());
        $.ajax({
            type: "POST",
            url: '../show-album-photos',
            data: {
                albumId: $('input[name="albumId"]').val()
            }
        }).done(function( msg ) {
                $('#album-photos').html(msg);
            });
    }*/

/*
Single photo page
 */
    //edit photo
    form('#edit-photo-data-form', '../../../edit-photo-data');

    //photo edit
    /*$('body').delegate(".photo-edit-form", "click",function () {
        alert($('.check').prop('checked'));
        $.ajax({
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
         });
    });*/

    //delete photo from single photo page
    $('body').delegate("#delete-single-photo", "click",function () {
        var photoIdToDelete = $(this).parents('div').data('photoid');
        $.ajax({
            type: "POST",
            url: '../../../delete-photo-from-album',
            data: {
                albumId: $('input[name="albumId"]').val(),
                photoId: photoIdToDelete
            }
        }).done(function( msg ) {
                alert(msg);
                window.location.reload();
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
                comment: $('textarea[name="comment"]').val()
            }
        }).done(function( msg ) {
                //alert(msg);
                window.location.reload();
            });
    });
/*
User profile page
*/
    $('body').delegate("#delete-album-in-user-page", "click",function () {
        var albumIdToDelete = $(this).parents('#delete-album-data').data('albumid');
        $.ajax({
            type: "POST",
            url: '../delete-album',
            data: {
                albumId: albumIdToDelete
            }
        }).done(function( msg ) {
                alert(msg);
                window.location.reload();
                //$('.alert-messege').html(msg);
            });
    });

/*
Tag page
 */
    $('body').delegate("#delete-photo-in-tag-page", "click",function () {
        var photoIdToDelete = $(this).parents('#delete-photo-data').data('id');
        $.ajax({
            type: "POST",
            url: '../delete-photo',
            data: {
                photoId: photoIdToDelete
            }
        }).done(function( msg ) {
                alert(msg);
                window.location.reload();
            });
    });


/*--------------------------------------------------------------------------------------------------------------------*/
    function form(formId, routeUrl){
        $(formId).submit(function() {
            var form = new FormData($(this)[0]);
            $.ajax({
                url: routeUrl,
                type: 'POST',
                xhrFields: {
                    withCredentials: true
                },
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                beforeSend: function () {
                    $("#output_process").html("Uploading, please wait....");
                },
                success: function () {
                    $("#output_process").html("Upload success.");
                },
                complete: function () {
                    $("#output_process").html("upload complete.");
                },
                error: function () {
                    //alert("ERROR in upload");
                    location.reload();
                }
            }).done(function(msg) {
                    alert(msg);
                    alert('Event created successfully..');
                    //window.location = msg;
                    window.location.reload();
                }).fail(function() {
                    alert(msg);
                    alert("fail!");
                });
            event.preventDefault();
        });
    }

    function formlogin(formId, routeUrl){
        $(formId).submit(function() {
            var form = new FormData($(this)[0]);
            $.ajax({
                url: routeUrl,
                type: 'POST',
                xhrFields: {
                    withCredentials: true
                },
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                beforeSend: function () {
                    $("#output_process").html("Uploading, please wait....");
                },
                success: function () {
                    $("#output_process").html("Upload success.");
                },
                complete: function () {
                    $("#output_process").html("upload complete.");
                },
                error: function () {
                    alert("ERROR in upload");
                    location.reload();
                }
            }).done(function(msg) {
                    alert('Event created successfully..');
                    window.location = msg;
                }).fail(function() {
                    alert(msg);
                    //alert("fail!");
                });
            event.preventDefault();
        });
    }

})(jQuery);