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

<div class="photo-link">
    <p><a href="">Album1</a></p>
    <a href="" class="photo-link">
        <img src="uploads/1.jpg" alt="First">
    </a>
    <p>short description</p>
    <p><input type="submit" value="DELETE"\></p>
</div>

<div class="photo-link">
    <p><a href="">Album2</a></p>
    <a href="" class="photo-link">
        <img src="uploads/4.jpg" alt="First">
    </a>
    <p>short description</p>
    <p><input type="submit" value="DELETE"\></p>
</div>

<div class="photo-link">
    <p><a href="">Album3</a></p>
    <a href="" class="photo-link">
        <img src="uploads/3.jpg" alt="First">
    </a>
    <p>short description</p>
    <p><input type="submit" value="DELETE"\></p>
</div>

<div class="photo-link">
    <p><a href="">Album4</a></p>
    <a href="" class="photo-link">
        <img src="uploads/1.jpg" alt="First">
    </a>
    <p>short description</p>
    <p><input type="submit" value="DELETE"\></p>
</div>

<div class="photo-link">
    <p><a href="">Album5</a></p>
    <a href="" class="photo-link">
        <img src="uploads/3.jpg" alt="First">
    </a>
    <p>short description</p>
    <p><input type="submit" value="DELETE"\></p>
</div>

<div class="photo-link">
    <p><a href="">Album6</a></p>
    <a href="" class="photo-link">
        <img src="uploads/4.jpg" alt="First">
    </a>
    <p>short description</p>
    <p><input type="submit" value="DELETE"\></p>
</div>

<div class="clear"></div>