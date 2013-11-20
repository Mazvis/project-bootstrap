<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Gallery</title>

        <!-- Style css-->
        {{ HTML::style('assets/css/style.css') }}

        {{ HTML::script('js/jquery-1.10.2.min.js') }}

    </head>

    <body class="{{ $bodyclass }}">
        <div class="body-container">

            <div class="navigation_left">
                <div class="header">
                    @if(Auth::check())
                    {{ HTML::link('logout', 'Logout (' . Auth::user()->username . ')') }}
                    @else
                    {{ HTML::link('login', 'Login') }}
                    @endif
                </div>
                <a href="">
                    <div class="navigation_left_logo"></div>
                </a>
                <div class="navigation_left_item">
                    {{ HTML::link('/', 'Home') }}
                </div>
                <div class="navigation_left_item">
                    {{ HTML::link('/albums', 'All albums') }}
                </div>
                <div class="navigation_left_item open">
                    {{ HTML::link('/albums', 'Albums') }}
                    <ul class="subMenu">
                        <li>
                            {{ HTML::link('/albums/1', 'album1') }}
                        </li>
                        <li>
                            {{ HTML::link('/albums/2', 'album2') }}
                        </li>
                        <li>
                            {{ HTML::link('/albums/3', 'album3') }}
                        </li>
                    </ul>
                </div>
                <div class="navigation_left_item">
                    <a href="">
                        Info
                    </a>
                </div>
            </div>

            <div id="contents_and_footer">

                <div class="contents">
                    {{ $content }}
                </div>
            </div>

        <!-- Scripts -->
        {{ HTML::script('js/script.js') }}

    </body>

</html>