    <h1>Profile</h1>

    <div style="" class="image-navigation">Create gallery:</div>
    {{ Form::open(array('url' => '/', 'method' => 'post')) }}
    {{ Form::label('name', 'Album name') }}
    {{ Form::text('name') }}
    {{ Form::label('shDescription', 'Album short description') }}
    {{ Form::text('shDescription') }}
    {{ Form::label('description', 'Album full description') }}
    {{ Form::text('description') }}
    {{ Form::label('place', 'Fotographet place') }}
    {{ Form::text('place') }}
    {{ Form::token() }}
    {{ Form::submit('Create') }}
    {{ Form::close() }}

    </br></br></br></br>
    {{ Form::open(array('url' => '/', 'files' => true)) }}
    {{ Form::label('file', 'Photo Uploading:(Not work)') }}
    {{ Form::file('file') }}
    {{ Form::submit('Upload') }}
    {{ Form::close() }}

    </br></br></br></br>

    <a href="uploads/3.jpg" class="photo-link">
        <img src="uploads/3.jpg" alt="First">
    </a>
    <a href="uploads/4.jpg" class="photo-link">
        <img src="uploads/4.jpg" alt="First">
    </a>

    <p>{{ Form::select('title_photo', array(
        'Cats' => array('leopard' => 'Leopard'),
        'Dogs' => array('spaniel' => 'Spaniel'),
        )) }}</p>