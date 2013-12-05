{{ Form::open(array('route' => 'login.try', 'method' => 'post', 'id' => 'login-form', 'class' => 'form-signin')) }}

<div class="row">
    <div class="col-sm-12 text-center">
        <a class="logo-link" href="">
            <img src="assets/img/logo.png" alt="gallery">
        </a>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger"  @if (!Session::get('tried_login')) style="display:none" @endif >
        <strong>Oh snap!</strong> We didn't recognize your sign-in details. Please check your username and password, then try again.
    </div>
</div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <!--<label class="control-label" for="sign-in-name"></label>-->
            {{ Form::label('username', 'Username', array('class' => 'control-label', 'for' => 'sign-in-name')) }}
            {{--Form::text('username', Session::get('tried_login'), array('class' => 'form-control', 'id' => 'sign-in-name', 'required' => true))--}}
            <input name="username" type="text" class="form-control" id="sign-in-name" value="@if (Session::get('tried_login')){{ Session::get('tried_login') }} @endif" required>
        </div>
        <div class="form-group">
            <!--<label class="control-label" for="sign-in-password">Password</label>
            <input name="password" type="password" class="form-control" id="sign-in-password" value="" required>-->
            {{ Form::label('password', 'password', array('class' => 'control-label', 'for' => 'sign-in-password')) }}
            {{ Form::password('password', array('class' => 'form-control', 'id' => 'sign-in-password', 'required' => true)) }}
        </div>

        <div class="row">
            <div class="col-sm-12">
                <!--<button type="submit" class="btn btn-default">Sign in</button>-->
                {{ Form::submit('Login', array('class' => 'btn btn-default')) }}
                &nbsp;or&nbsp;<a href="{{ route('registration') }}">Create a new account</a>
            </div>
        </div>
    </div>
</div>

{{ Form::token() }}
{{ Form::close() }}