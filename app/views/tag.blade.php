<h1>Tag({{ $tagName }}, {{ $tagId }})</h1>

<div id="photos">
    @for ($i = 0; $i < sizeOf($photo_data_array); $i++)
    <div class="photo-link" data-id="{{ $photo_data_array[$i]['photo_id'] }}">
        <a href="{{ URL::to('albums/'.$photo_data_array[$i]['photo_album_id'].'/photo/'.$photo_data_array[$i]['photo_id']) }}">
            <img src="{{ URL::to($photo_data_array[$i]['photo_destination_url']) }}" alt="First">
        </a>
    </div>
    @endfor

    <div class="clear"></div>

</div>