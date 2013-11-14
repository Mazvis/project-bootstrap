    {{ Form::open(array('url' => 'login', 'method' => 'post', 'class' => 'form-signin')) }}
    <!-- check for login errors flash var -->
    @if (Session::has('login_errors'))
    <span class="error">Username or password incorrect.</span>
    @endif

    <!-- username field -->
    <p>{{ Form::label('username', 'Username', array('class' => 'checkbox')) }}</p>
    <p>{{ Form::text('username', null, array('class' => 'form-control')) }}</p>

    <p>{{ Form::label('email', 'Email: ', array('class' => 'checkbox')) }}</p>
    <p>{{ Form::text('email', null, array('class' => 'form-control')) }}</p>

    <!-- password field -->
    <p>{{ Form::label('password', 'Password', array('class' => 'checkbox')) }}</p>
    <p>{{ Form::password('password', array('class' => 'form-control')) }}</p>

    <!-- submit button -->
    <p>{{ Form::submit('Login', array('class' => 'form-control')) }}</p>

    {{ Form::close() }}