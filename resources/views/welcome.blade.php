<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>UABC</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
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
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Inicio</a>
                    @else
                        <a href="{{ route('login') }}">Iniciar Sesión</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    SPUABC
                </div>

                <div class="content">
                    Servicio de Prestamos
                </div>
                <br>
                <br>

                <div class="content">
                    Al usar esta plataforma, estas de acuerdo al reglamento general de la<br> 
                    Facultad de Ciencias de la Ingeniería y Tecnología<br> 
                    acerca del del préstamo de material, equipo y herramientas.
                </div>
                <a href="http://citecuvp.tij.uabc.mx/ime/reglamentos-y-horarios/" target="_blank">Reglamento</a>

                <div style="position: absolute; bottom: 0; right: 0; width: 500px; text-align:right;">
                    Desarrollado por: Alejandro Jimenez Bustillos
                </div>

                <div style="position: absolute; bottom: 0; left: 0; width: 500px; text-align:left;">
                    Desarrollado utilizando el framework <a href="https://laravel.com/">laravel</a>
                </div>
            </div>
        </div>
    </body>
</html>
