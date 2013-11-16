<h1>Album1(<a href="">upload photo</a>)</h1>

<div class="image-navigation" style="padding-left: 0; padding-top: 0;">

    <a href="{{ asset('uploads/1.jpg') }}" class="photo-link" style="float:left">
        <img src="{{ asset('uploads/1.jpg') }}" alt="First">
    </a>
    <div style="float:left; width:30%">
        <p>Album name</p>
        <p>Place: Itally</p>
        <p>Created at: 2013-05-04</p>
        <p>Title photo: 1.jpg</p>
        <p>Album fool description ashsadjhasd lorem iso packo maco laco chacho kanate late</p>
        <p><input type="submit" value="EDIT"\>
        <input type="submit" value="DELETE ALBUM"\></p>
    </div>

    <div class="clear"></div>
    <hr>
</div>

<div class="image-navigation" style="border: 1px solid red">
    <b>Upload:</b>
    {{ Form::open(array('route' => 'photo.upload', 'files'=> true, 'method' => 'post')) }}

    <p>{{ Form::label('photoName', 'Photo name') }}</p>
    <p>{{--Form::text('photoName', $photoName)--}}</p>
    <p>{{ Form::text('photoName') }}</p>

    <p>{{ Form::label('shDescription', 'Photo short description') }}</p>
    <p>{{ Form::text('shDescription') }}</p>

    <p>{{ Form::label('placeTaken', 'Fotographed at') }}</p>
    <p>{{ Form::text('placeTaken') }}</p>

    <p>{{ Form::file('photo') }}</p>

    <p>{{ Form::label('titlePhoto', 'Make album title photo?') }}</p>
    <p>{{ Form::checkbox('titlePhoto', 'true', false) }}</p>

    <p>{{ Form::submit('Create') }}</p>

    {{ Form::token() }}
    {{ Form::close() }}
</div>

</br></br>

<div class="photo-link">
    <a href="uploads/1.jpg">
        <img src="uploads/1.jpg" alt="First">
    </a>
    <p><input type="submit" value="DELETE"\></p>
</div>
<div class="photo-link">
    <a href="uploads/3.jpg">
        <img src="uploads/3.jpg" alt="First">
    </a>
    <p><input type="submit" value="DELETE"\></p>
</div>
<div class="photo-link">
    <a href="uploads/4.jpg">
        <img src="uploads/4.jpg" alt="First">
    </a>
    <p><input type="submit" value="DELETE"\></p>
</div>
<div class="photo-link">
    <a href="uploads/1.jpg">
        <img src="uploads/1.jpg" alt="First">
    </a>
    <p><input type="submit" value="DELETE"\></p>
</div>
<div class="photo-link">
    <a href="uploads/3.jpg">
        <img src="uploads/3.jpg" alt="First">
    </a>
    <p><input type="submit" value="DELETE"\></p>
</div>
<div class="photo-link">
    <a href="uploads/4.jpg">
        <img src="uploads/4.jpg" alt="First">
    </a>
    <p><input type="submit" value="DELETE"\></p>
</div>
<div class="photo-link">
    <a href="uploads/1.jpg">
        <img src="uploads/1.jpg" alt="First">
    </a>
    <p><input type="submit" value="DELETE"\></p>
</div>
<div class="photo-link">
    <a href="uploads/4.jpg">
        <img src="uploads/4.jpg" alt="First">
    </a>
    <p><input type="submit" value="DELETE"\></p>
</div>
<div class="photo-link">
    <a href="uploads/3.jpg">
        <img src="uploads/3.jpg" alt="First">
    </a>
    <p><input type="submit" value="DELETE"\></p>
</div>

<div class="clear"></div>