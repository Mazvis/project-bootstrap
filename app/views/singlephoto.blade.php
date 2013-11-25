<h1>Photo1(<a href="">Edit photo</a>)</h1>

<div class="image-navigation" style="padding-left: 0; padding-top: 0;">

    <a href="{{ URL::to($photo_data_array['photo_destination_url']) }}" class="photo-link" style="float:left">
        <img src="{{ URL::to($photo_data_array['photo_destination_url']) }}" alt="First">
    </a>
    <div style="float:left; width:30%">
        <p>Photo Name: {{ $photo_data_array['photo_name'] }}</p>
        <p>Album: {{ HTML::link('albums/'.$photo_data_array['photo_album_id'] ,$photo_data_array['photo_album_name']) }}</p>
        <p>Place taken: {{ $photo_data_array['photo_taken_at'] }}</p>
        <p>Created at: {{ $photo_data_array['photo_created_at'] }}</p>
        <p>Photo description {{ $photo_data_array['photo_short_description'] }}</p>
        <p>Author: {{ $photo_data_array['photo_user_name'] }}</p>
        <p>Tags: @for ($i = 0; $i < sizeOf($tags); $i++) {{ HTML::link('tag/'.$tags[$i], $tags[$i]) }}, @endfor</p>
        <p>Views: {{ $viewsCount }}</p>

        <li><input id="edit-button" type="submit" value="EDIT"\></li>
        <li data-photoid="{{ $photo_data_array['photo_id'] }}"><input id="delete-single-photo" type="submit" value="DELETE THIS PHOTO FROM ALBUM"\></li>
        <!--<p>{{ $photo_data_array['photo_id'] }}</p>
        <p>{{ $photo_data_array['photo_name'] }}</p>
        <p>{{ $photo_data_array['photo_short_description'] }}</p>
        <p>{{ $photo_data_array['photo_taken_at'] }}</p>
        <p>{{ $photo_data_array['photo_destination_url'] }}</p>
        <p>{{ $photo_data_array['photo_thumbnail_destination_url'] }}</p>
        <p>{{ $photo_data_array['photo_created_at'] }}</p>
        <p>{{ $photo_data_array['photo_album_id'] }}</p>
        <p>{{ $photo_data_array['photo_user_id'] }}</p>
        <p>{{ $photo_data_array['photo_user_name'] }}</p>
        <p>{{ $photo_data_array['photo_album_name'] }}</p>-->

    </div>

    <div class="clear"></div>

</div>

<div class="image-navigation" style="border: 1px solid red">
    <b>Edit:</b>
    {{ Form::open(array('route' => 'photo.edit', 'files'=> true, 'method' => 'post', 'id' => 'edit-form', 'class' => 'form-hidden')) }}

    {{ Form::hidden('albumId', $albumId)}}
    {{ Form::hidden('photoId', $photoId)}}

    <p>{{ Form::label('photoName', 'Photo name') }}</p>
    <p>{{ Form::text('photoName', $photo_data_array['photo_name']) }}</p>

    <p>{{ Form::label('shDescription', 'Photo short description') }}</p>
    <p>{{ Form::text('shDescription', $photo_data_array['photo_short_description']) }}</p>

    <p>{{ Form::label('placeTaken', 'Fotographed at') }}</p>
    <p>{{ Form::text('placeTaken', $photo_data_array['photo_taken_at']) }}</p>

    <p>{{ Form::label('tags', 'edit tags') }}</p>
    <p>{{ Form::select('tags[]', $allExistingTags, null, array('multiple'=>true, 'id' => 'tags')) }}</p>

    <p>{{ Form::label('albumTitlePhoto', 'Make this title album photo?') }}</p>
    <p>{{ Form::checkbox('albumTitlePhoto', true, array('class' => 'check', 'checked' => '')) }}</p>

    <p>{{ Form::submit('Edit', array('class' => 'photo-edit-button') ) }}</p>

    {{ Form::token() }}
    {{ Form::close() }}
</div>

<div class='div_komentaru_blokas'>
    <span>comments:</span>
    <div class='div_komentaro_blokas'>
        {{ Form::hidden('photoId', $photoId)}}
        <p>{{ Form::submit('Like', array('class' => 'photo-like-button')) }}</p>
        <p>{{ $all_likes_count }}</p>
        @for ($i = 0; $i < sizeOf($likes_data); $i++)
        {{ $likes_data[$i] }},
        @endfor
    </div>

    @for ($i = 0; $i < sizeOf($comments_array); $i++)
    <div class='div_komentaro_blokas'>
        <div class='div_komentaro_pav'>
            #{{ $comments_array[$i]['user_id'] }}
        </div>
        <div class='div_komentaras_irasas'>
            <b id='user'>{{ $comments_array[$i]['username']--}}: </b>{{ $comments_array[$i]['comment'] }}
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
        {{--Form::open(array('method' => 'post', 'id' => 'comment-photo'))--}}
        <div class="div_komentaras_irasas">
            {{ Form::text('comment', 'write here', array('class' => 'komentaras')) }}
        </div>
        <div class="div_kom_submit">
            <div class="div_kom_submitL">
            </div>
            <div class="div_kom_submitR">

                {{ Form::submit('Comment', array('class' => 'photo-comment-button')) }}
            </div>
            <div class="div_kom_submitC">
            </div>
        </div>
        {{--Form::token()--}}
        {{--Form::close()--}}
    </div>

</div>

{{ HTML::script('js/upload-and-show-photos.js') }}