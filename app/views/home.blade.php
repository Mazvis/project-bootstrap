    <div class="image-navigation">All resent photos:</div>

    @for ($i = 0; $i < sizeOf($photos_url); $i++)
        <a href="{{ $photos_url[$i] }}" class="photo-link">
            <img src="{{ $photos_url[$i] }}" alt="First">
        </a>
    @endfor

    <div id="photos"></div>

    <div class="clear"></div>

    <div style="" class="image-navigation">
      <span>
        Previos | Next</br>
      </span>
    </div>

    {{--HTML::script('js/jquery-1.10.2.min.js')--}}
    <!-- Required script for photos showing on home page -->
    {{ HTML::script('js/show-photos.js') }}