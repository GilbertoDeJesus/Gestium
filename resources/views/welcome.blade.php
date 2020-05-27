<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background: url(material/img/Home1.png)no-repeat center fixed;
                background-repeat: no-repeat;
	            -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-color: #fff;
                color: #fff;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                text-shadow: 2px 2px 2px #333232;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 90px;

            }

            .links > a {
                color: #fff;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 170px;
                padding-bottom: 0px;
            }

            .mentop{
                letter-spacing: .2rem;
                 line-height: 120px;
            }

            .submenu{
                font-size: 23px;
                line-height: 0px;
            }
            .content .m-b-md .mentop{
                padding: 0px;
                margin: 0px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height" id="app">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Gestium Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Iniciar sesión</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <p class="mentop">Gestium</p>
                    <div class="subtitle">
                        <p class="submenu">Aplicación de administración</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

