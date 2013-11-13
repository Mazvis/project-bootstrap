<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Gallery</title>

        <!-- Style css-->
        <link href="assets/css/style.css" rel="stylesheet">

        <script>
            $(document).ready(function() {
                $(".navigation_left_item>a").click(function(event){
                    var li = $(this).parent();
                    if (li.find("ul").length > 0) {
                        event.preventDefault ? event.preventDefault() : event.returnValue = false;
                        li.toggleClass("open");
                    }
                });
            });
        </script>

    </head>

    <body class="{{ $bodyclass }}">
        <div class="body-container">

            <!--<div class="footer">
                footer
            </div>-->

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
                <div class="navigation_left_item open">
                    {{ HTML::link('/albums', 'Albums') }}
                    <ul class="subMenu">
                        <li>
                            {{ HTML::link('/singlealbum', 'album1') }}
                        </li>
                        <li>
                            {{ HTML::link('/singlealbum', 'album2') }}
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

                <div class="contents" style="padding-top: 30px;">
                    {{ $content }}
                </div>
            </div>

    </body>

</html>