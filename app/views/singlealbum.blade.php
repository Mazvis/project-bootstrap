<h1>Album1(<a href="">upload photo</a>)</h1>

<div class="image-navigation" style="padding-left: 0; padding-top: 0;">

    <a href="{{ URL::to($album_info_array['photo_destination_url']) }}" class="photo-link" style="float:left">
        <img src="{{ URL::to($album_info_array['photo_destination_url']) }}" alt="First">
    </a>

    <div style="float:left; width:30%">
        <p>Album name: {{ $album_info_array['album_name'] }}</p>
        <p>Place: {{ $album_info_array['album_place'] }}</p>
        <p>Created at: {{ $album_info_array['album_created_at'] }}</p>
        <p>Title photo: {{ $album_info_array['album_title_photo_id'] }}</p>
        <p>Album fool description: {{ $album_info_array['album_full_description'] }}</p>
        <p>Album photos count: {{ $album_info_array['album_photos_count'] }}</p>


        <li><input id="upload-button" type="submit" value="Upload"\></li>
        <li><input id="edit-button" type="submit" value="EDIT"\></li>
        <li data-albumid="{{ $album_info_array['album_id'] }}"><input id="delete-album"type="submit" value="DELETE ALBUM"\></li>


    </div>

    <div class="clear"></div>
    <hr>
</div>

<div class="image-navigation" style="border: 1px solid red">
    <b>Edit:</b>
    {{ Form::open(array('route' => 'album.edit', 'files'=> true, 'method' => 'post', 'id' => 'edit-form', 'class' => 'form-hidden')) }}

    {{ Form::hidden('albumId', $albumId)}}

    <p>{{ Form::label('albumName', 'Album name') }}</p>
    <p>{{ Form::text('albumName', $album_info_array['album_name']) }}</p>

    <p>{{ Form::label('shDescription', 'Album short description') }}</p>
    <p>{{ Form::text('shDescription', $album_info_array['album_short_description']) }}</p>

    <p>{{ Form::label('fullDescription', 'Album full description') }}</p>
    <p>{{ Form::text('fullDescription', $album_info_array['album_full_description']) }}</p>

    <p>{{ Form::label('placeTaken', 'Fotographed at') }}</p>
    <p>{{ Form::text('placeTaken', $album_info_array['album_place']) }}</p>

    <p>{{ Form::label('albumTitlePhoto', 'Title photo') }}</p>
    <p>{{ Form::file('albumTitlePhoto') }}</p>

    <p>{{ Form::submit('Edit') }}</p>

    {{ Form::token() }}
    {{ Form::close() }}
</div>

<div class="image-navigation" style="border: 1px solid red">
    <b>Upload:</b>
    {{ Form::open(array('route' => 'photo.upload', 'files'=> true, 'method' => 'post', 'id' => 'upload-form', 'class' => 'form-hidden')) }}
    <!--<form method="POST" action="javascript:;" accept-charset="UTF-8" id="upload" enctype="multipart/form-data" style="display: inherit;">-->

    {{ Form::hidden('albumId', $albumId)}}

    <p>{{ Form::label('photoName', 'Photo name') }}</p>
    <p>{{ Form::text('photoName') }}</p>

    <p>{{ Form::label('shDescription', 'Photo short description') }}</p>
    <p>{{ Form::text('shDescription') }}</p>

    <p>{{ Form::label('placeTaken', 'Fotographed at') }}</p>
    <p>{{ Form::text('placeTaken') }}</p>

    <p>{{ Form::label('tags', 'add tags') }}</p>
    <p>{{ Form::select('tags[]', $allExistingTags, null, array('multiple'=>true, 'id' => 'tags')) }}</p>

    <p>{{ Form::file('photos', array('multiple'=>true, 'id' => 'photos_id')) }}</p>

    <p>{{ Form::label('titlePhoto', 'Make album title photo?') }}</p>
    <p>{{ Form::checkbox('titlePhoto', true, array('class' => 'check')) }}</p>

    <p>{{ Form::submit('Upload') }}</p>

    {{ Form::token() }}
    {{ Form::close() }}
    <p>{{--Form::submit('Upload', array('class' => 'submit-upload'))--}}</p>
</div>

</br></br>
<div class="aaa"></div>

<div id="photos">
    @for ($i = 0; $i < sizeOf($album_photos_info_array); $i++)
    <div class="photo-link" data-id="{{ $album_photos_info_array[$i]['photo_id'] }}">
        <a href="{{ URL::to('albums/'.$albumId.'/photo/'.$album_photos_info_array[$i]['photo_id']) }}">
            <img src="{{ URL::to($album_photos_info_array[$i]['photo_destination_url']) }}" alt="First">
        </a>
        <p><input id="delete-photo" type="submit" value="DELETE"\></p>
    </div>
    @endfor

    <div class="clear"></div>
</div>


<div class='div_komentaru_blokas'>
    <span>comments:</span>
    <div class='div_komentaro_blokas'>
        <p>{{ Form::submit('Like', array('class' => 'album-like-button')) }}</p>
        <p>{{ $all_likes_count }}</p>
        @for ($i = 0; $i < sizeOf($likes_array); $i++)
            {{ $likes_array[$i] }},
        @endfor
    </div>

        @for ($i = 0; $i < sizeOf($comments_array); $i++)
        <div class='div_komentaro_blokas'>
            <div class='div_komentaro_pav'>
                #{{ $comments_array[$i]['user_id'] }}
            </div>
            <div class='div_komentaras_irasas'>
                <b id='user'>{{ $comments_array[$i]['username'] }}: </b>{{ $comments_array[$i]['comment'] }}
            </div>
            <div class='div_kom_data'>
                {{ $comments_array[$i]['created_at'] }}
            </div>
        </div>
        @endfor

        <div class="div_komentaro_blokas">
            <div class="div_komentaro_pav">
                *
            </div>
            {{--Form::open(array('route' => 'album.comment', 'method' => 'post', 'id' => 'comment-album'))--}}
                <div class="div_komentaras_irasas">
                    {{ Form::text('comment', 'write here', array('class' => 'komentaras')) }}
                </div>
                <div class="div_kom_submit">
                    <div class="div_kom_submitL">
                    </div>
                    <div class="div_kom_submitR">

                        {{ Form::submit('Comment', array('class' => 'album-comment-button')) }}
                    </div>
                    <div class="div_kom_submitC">
                    </div>
                </div>
            {{--Form::token()--}}
            {{--Form::close()--}}
        </div>

</div>


{{--HTML::script('js/jquery-1.10.2.min.js')--}}
<!-- Required script for photos showing on home page -->
{{ HTML::script('js/upload-and-show-photos.js') }}