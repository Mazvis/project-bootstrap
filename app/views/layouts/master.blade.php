<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gallery</title>

    <!-- Bootstrap core CSS -->
    {{ HTML::style('assets/bootstrap-3.0.0/dist/css/bootstrap.min.css') }}
    <!-- Style css-->
    {{ HTML::style('assets/css/style.css') }}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {{ HTML::script('assets/bootstrap-3.0.0/assets/js/html5shiv.js') }}
    {{ HTML::script('assets/bootstrap-3.0.0/assets/js/respond.min.js') }}
    <![endif]-->

</head>

<body class="{{ $bodyclass }}">
<div class="container">
    {{----------------------------------------------------------------------------}}
    @if (Session::get('just_reg') == "yes")

    <div class="col-sm-12">
        <div class="alert alert-success">
            <strong>@lang('registration.great')</strong>
            @lang('registration.success')
        </div>
    </div>

    {{ Session::forget('just_reg') }}
    @endif
    {{----------------------------------------------------------------------------}}
    <div class="container">

        <div style="position: relative;">
            <nav class="navbar navbar-default navbar-absolute" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button class="toggle-sidebar navbar-toggle" type="button" data-target=".main-sidebar" title="Toggle sidebar">
                        <span class="sr-only">Toggle sidebar</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" title="Toggle menu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {{ HTML::link('/', 'Home', array('class' => 'navbar-brand')) }}
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active">{{ HTML::link('/albums', 'Albums') }}</li>
                        <li>{{ HTML::link('/albums/1', 'album1') }}</li>
                        <li>{{ HTML::link('/albums/1/photo/1', 'photo1') }}</li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Help<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">sth</a></li>
                                <li><a href="#">About project</a></li>
                            </ul>
                        </li>
                    </ul>

                    @if(Auth::check())
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ URL::to('logout') }}">logout({{ Auth::user()->username }})&nbsp;<i class="glyphicon glyphicon-log-out"></i></a></li>
                    </ul>
                    @else
                    {{ Form::open(array('route' => 'login.try', 'method' => 'post', 'id' => 'login-form', 'class' => 'navbar-form navbar-right')) }}
                    <div class="form-group">
                        <input name="username" type="text" class="form-control" id="sign-in-name" value="@if (Session::get('tried_login')){{ Session::get('tried_login') }} @endif" required>
                    </div>
                    <div class="form-group">
                        {{ Form::password('password', array('class' => 'form-control', 'id' => 'sign-in-password', 'required' => true)) }}
                    </div>
                    <button type="submit" class="btn btn-outline-inverse">Sign in</button>
                    {{ Form::token() }}
                    {{ Form::close() }}

                    {{--Form::submit('Register', array('class' => 'btn btn-outline-inverse'))--}}
                    @endif

                </div><!-- /.navbar-collapse -->
            </nav>
        </div>
        <div class="page-content">

            <aside class="main-sidebar">
                <div class="user-status">
                    @if(Auth::check())
                    {{ HTML::link('/profile', Auth::user()->username, array('class' => 'profile-link')) }}
                    <form class="online-status">
                        <select>
                            <option selected>online</option>
                            <option>invisible</option>
                        </select>
                    </form>
                    @else
                    {{ HTML::link('/login', 'Not Logged in', array('class' => 'profile-link')) }}
                    @endif

                </div>
                <div class="contact-search">
                    {{ Form::open(array('id' => 'search-form')) }}
                    <input type="search" placeholder="Search photos" class="form-control" name="friend-search" id="friend-search" autocomplete="off">
                    {{ Form::token() }}
                    {{ Form::close() }}
                </div>
                <address class="copyright">
                    &copy; 2013 xMx
                </address>
                <div class="tagsBlock">
                    <div class="thumbnail">
                        <h5>All tags</h5>
                        @for($i = 0; $i < sizeOf($existingTags); $i++)
                        {{ HTML::link('tag/'.$existingTags[$i]->tag_name, $existingTags[$i]->tag_name) }}@if($i < sizeOf($existingTags)-1), @endif
                        @endfor
                    </div>
                </div>

            </aside>

            <!-- main content -->
            <div class="main-content">
                {{ $content }}
            </div>
            <!-- main content end -->

        </div>

    </div>
</div>

<!-- Placed at the end of the document so the pages load faster -->
{{ HTML::script('assets/bootstrap-3.0.0/assets/js/jquery.js') }}
{{ HTML::script('assets/bootstrap-3.0.0/dist/js/bootstrap.min.js') }}
{{ HTML::script('assets/bootstrap-3.0.0/dist/js/bootstrap.js') }}
{{ HTML::script('assets/bootstrap-3.0.0/assets/js/holder.js') }}
{{ HTML::script('assets/bootstrap-3.0.0/assets/js/application.js') }}

<!-- Scripts -->
{{ HTML::script('js/script.js') }}
{{ HTML::script('js/ajax-requests.js') }}
{{ HTML::script('js/validation.js') }}

</body>
</html>