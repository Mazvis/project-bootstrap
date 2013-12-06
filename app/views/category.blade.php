<div class="row">
    <div class="col-sm-6 col-md-4">
        <h1>Category({{ $catName }})</h1>
        <p>@if($photos) {{ $photos[0]->category_description }} @endif</p>
        @if(sizeOf($photos)< 1)
            <span>There is no photos with this category.</span>
        @endif
    </div>
    <div class="clear"></div>
    @for ($i = 0; $i < sizeOf($photos); $i++)
    <div class="col-sm-6 col-md-4">
        <h3>{{ $photos[$i]->photo_name }}</h3>
        <p>Album: {{ HTML::link('albums/'.$photos[$i]->album_id.'/photo/'.$photos[$i]->photo_id, $photos[$i]->album_name) }} </p>
        <div class="thumbnail">

            <a href="{{ URL::to('albums/'.$photos[$i]->album_id.'/photo/'.$photos[$i]->photo_id) }}">
                @if($photos[$i]->photo_thumbnail_destination_url && is_file($photos[$i]->photo_thumbnail_destination_url))
                {{ HTML::image($photos[$i]->photo_thumbnail_destination_url, $photos[$i]->photo_short_description) }}
                @else
                {{ HTML::image('assets/img/no-image-thumb.jpg', $photos[$i]->photo_short_description, array('width' => '200', 'height' => '200')) }}
                @endif
            </a>
            @if(Auth::check() && Auth::user()->role_id == 1)
            <div id="delete-photo-data" class="caption photo-link" data-id="{{ $photos[$i]->photo_id }}">
                <p>
                    {{ HTML::link(URL::to('albums/'.$photos[$i]->album_id.'/photo/'.$photos[$i]->photo_id), 'Edit', array('class' => 'btn btn-primary', 'role' => 'button')) }}
                    {{ Form::submit('Delete', array('id' => 'delete-photo-in-tag-page', 'class' => 'btn btn-danger')) }}
                </p>
            </div>
            @endif
        </div>
    </div>
    @endfor
</div>