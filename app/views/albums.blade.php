<h1>Albums(<a href="">create new</a> | <a href="">Edit</a>)</h1>

<div class="image-navigation" style="border: 1px solid red">
    <b>Create new:</b>
    {{ Form::open(array('route' => 'albums.get', 'method' => 'post')) }}

    <p>{{ Form::label('name', 'Album name') }}</p>
    <p>{{ Form::text('name', null, array('class'=>'form-control')) }}</p>

    <p>{{ Form::label('shDescription', 'Album short description') }}</p>
    <p>{{ Form::text('shDescription') }}</p>

    <p>{{ Form::label('description', 'Album full description') }}</p>
    <p>{{ Form::text('description') }}</p>

    <p>{{ Form::label('place', 'Fotographet place') }}</p>
    <p>{{ Form::text('place') }}</p>

    <p>{{ Form::submit('Create') }}</p>

    {{ Form::token() }}
    {{ Form::close() }}
</div>

</br></br>

<div id="albums">
    @for ($i = 0; $i < sizeOf($album_photos_info_array); $i++)
    <div class="photo-link data-id="{{ $album_photos_info_array[$i]['album_id'] }}">
        <p>{{ HTML::link('albums/'.$album_photos_info_array[$i]['album_id'], $album_photos_info_array[$i]['album_name']) }}</p>
        <a href="{{ URL::to('albums/'.$album_photos_info_array[$i]['album_id']) }}" class="photo-link">
            <img src="{{ URL::to($album_photos_info_array[$i]['photo_destination_url']) }}" alt="First">
        </a>
        <p>{{ $album_photos_info_array[$i]['album_short_description'] }}</p>
        <p><input id="delete-album" type="submit" value="DELETE"\></p>
    </div>
    @endfor

    <div class="clear"></div>
</div>

{{ HTML::script('js/upload-and-show-photos.js') }}
