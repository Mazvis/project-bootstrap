jQuery(document).ready(function(){
    /*function
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
*/
    /*var done = true;
    var jsArray;
    function uploadPhotos(){
        if(done == true){
            done = false;
            setTimeout(function(){
                jQuery.ajax({
                    type: "POST",
                    url: 'upload-and-show-photos'
                    //data: $('#upload').serialize()
                    /*,
                    data: {
                        currentAlbumId: jQuery('input[name="albumId"]').val(),
                        photoName: jQuery('input[name="photoName"]').val(),
                        shortDescription: jQuery('input[name="shDescription"]').val(),
                        placeTaken: jQuery('input[name="placeTaken"]').val(),
                        photoFile: jQuery('input[name="photo"]').val(),
                        titlePhoto: jQuery('input[name="titlePhoto"]').val()
                    }* /
                }).done(function( msg ) {
                        alert(msg);
                        jQuery('#photos').html(msg);
                        //window.location.reload();
                        done = true;
                        //jQuery('.loading').removeClass('loading');
                    });
            }, 700);
        }
    }*/
    /*$('#upload').submit(function() {
        // submit the form
        uploadPhotos();
        // return false to prevent normal browser submit and page navigation
        return false;
    });

    jQuery('body').delegate(".add-or-del-to-list", "click",function () {
    jQuery('#friend-search').keyup(function(){
        searchContacts();
        jQuery('#friend-search').addClass('loading');
    });*/
    $('#upload').submit(function(){
        /*alert(jQuery('input[name="albumId"]').val()+
            jQuery('input[name="photoName"]').val()+
            jQuery('input[name="shDescription"]').val()+
            jQuery('input[name="placeTaken"]').val()+
            jQuery('input[name="photos"]').val()+
            $('#titlePhoto').prop('checked')
        );*/
        jQuery.ajax({
            type: "POST",
            url: '../upload-and-show-photos',
            data: {
                albumId: jQuery('input[name="albumId"]').val(),
                photoName: jQuery('input[name="photoName"]').val(),
                shDescription: jQuery('input[name="shDescription"]').val(),
                placeTaken: jQuery('input[name="placeTaken"]').val(),
                photos: jQuery('input[name="photos"]').val(),
                titlePhoto: $('#titlePhoto').prop('checked')
            }
        }).done(function( msg ) {
                alert(msg);
                //window.location.reload();
                //jQuery('#photos').html(msg);
            });
    });
    //submit for photo upload
    jQuery('body').delegate(".submit-upload", "click",function () {
        var button = $(this).val();
        //alert($('#titlePhoto').prop('checked'));
        alert($('input[name="photos"]')[0].files[0]);
        /*jQuery.ajax({
            type: "POST",
            url: '../upload-and-show-photos',
            data: {
                albumId: jQuery('input[name="albumId"]').val(),
                photoName: jQuery('input[name="photoName"]').val(),
                shDescription: jQuery('input[name="shDescription"]').val(),
                placeTaken: jQuery('input[name="placeTaken"]').val(),
                photos: jQuery('input[name="photos"]').val(),
                titlePhoto: $('#titlePhoto').prop('checked')
            }
        }).done(function( msg ) {
                alert(msg);
                //window.location.reload();
                //jQuery('#photos').html(msg);
            });*/
    });
/**********************************************************************************************************************/
    //like album
    jQuery('body').delegate(".album-like-button", "click",function () {
        jQuery.ajax({
         type: "POST",
         url: '../like-album',
         data: {
            albumId: jQuery('input[name="albumId"]').val()
         }
         }).done(function( msg ) {
            alert(msg);
         });
    });

    //delete photo
    jQuery('body').delegate("#delete-photo", "click",function () {
        var done = true;
        var photoIdToDelete = $(this).parents('.photo-link').data('id');
        //alert(photoIdToDelete);
        jQuery.ajax({
            type: "POST",
            url: '../delete-photo',
            data: {
                photoId: photoIdToDelete
            }
        }).done(function( msg ) {
                alert(msg);
                window.location.reload();
                //jQuery('#photos').html(msg);
            });
    });

    //delete album
    jQuery('body').delegate("#delete-album", "click",function () {
        var done = true;
        var albumIdToDelete = $(this).parents('li').data('albumid');
        //alert(albumIdToDelete);
        jQuery.ajax({
            type: "POST",
            url: '../delete-album(temporary)',
            data: {
                albumId: albumIdToDelete
            }
        }).done(function( msg ) {
                alert(msg);
                window.location.reload();
                //jQuery('#photos').html(msg);
            });
    });




    $('#edit').css('display','none');
    $('#upload').css('display','none');
    var eb = false;
    var ub = false;
    jQuery('body').delegate("#edit-button", "click",function () {
        if(eb == false){
            $('#edit').css('display','inherit');
            $('#upload').css('display','none');
            eb = true;
        }
        else{
            $('#edit').css('display','none');
            eb = false;
        }
    });
    jQuery('body').delegate("#upload-button", "click",function () {
        if(ub == false){
            $('#upload').css('display','inherit');
            $('#edit').css('display','none');
            ub = true;
        }
        else{
            $('#upload').css('display','none');
            ub = false;
        }

    });

});