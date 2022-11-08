<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Universidad</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <!style="background-color: #EFB810;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Universidad
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Ingresar') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </li>
                            @endif
                        @else
                            <button type="button" name="ok_button" id="ok_button" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal">Solicitar Prestamo</button>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </a>
@can('AccesoAdmin')
                                    <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        Administrar Usuarios
                                    </a>

                                    <a class="dropdown-item" href="{{ route('admin.almacenes.index') }}">
                                        Administrar Almacenes
                                    </a>
@endcan
@can('AccesoAlmacenista')
                                    <a class="dropdown-item" href="{{ route('Al.productos.index') }}">
                                        Administrar Productos
                                    </a>
@endcan
                                    <a class="dropdown-item" href="{{ route('Ped.Pedido.index') }}">
                                        Pedidos
                                    </a>

                                    <a class="dropdown-item" data-toggle="modal" data-target="#contra">
                                        Cambiar contraseña
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>

                            </li>

                        @endguest



                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @include('Mensajes.Alertas')
            @yield('content')

        </main>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Solicitud de Prestamo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="GET" id="sample_form" action="{{ route('BuscarConsulta') }}" class="form-horizontal" >
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-4">Almacen : </label>
                            <div class="col-md-8">
                                <select class="form-control" id="inlineFormCustomSelectPref" name="almacen">
                                    <option selected>Selecciona...</option>
                                    @foreach ($Alm ?? '' as $Al)
                                        <option value={{$Al->Matricula}}>{{$Al->Matricula}} ( {{$Al->name}} )</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">Fecha : </label>
                            <div class="col-md-8">
                                <input name="fecha"  class="ui-icon-calendar" type="text" id="datepicker">
                            </div>
                        </div>

                        <label class="control-label col-md-4">Tiempo : </label>
                        <div class="col-md-4">
                            <select class="form-control mb-2" id="inlineFormInput" name="hi">
                                <option selected>Hora inicial</option>
                                @for ($i = 8; $i <= 15; $i++)
                                    <option value={{$i}}>{{$i}}:00</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select class="form-control mb-2" id="inlineFormInput" name="hf">
                                <option selected>Hora final</option>
                                @for ($i = 9; $i <= 16; $i++)
                                    <option value={{$i}}>{{$i}}:00</option>
                                @endfor
                            </select>
                        </div>


                        <br />
                        <div class="form-group" align="center">
                            <input type="submit" class="btn btn-warning" value="Enviar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="contra" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cambio de contraseña</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="GET" id="sample_form" action="{{ route('nuevaContra') }}" class="form-horizontal" >
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña Actual : </label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="C" autocomplete="C">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Nueva Contraseña : </label>
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="NC" autocomplete="C">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Confirmar Nueva Contraseña : </label>
                            <div class="col-md-6">
                                <input id="new_confirm_password" type="password" class="form-control" name="CNC" autocomplete="C">
                            </div>
                        </div>


                        <br />
                        <div class="form-group" align="center">
                            <input type="submit" class="btn btn-warning" value="Cambiar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<script>
    $( function() {
        $( "#datepicker" ).datepicker({
            minDate: '0',
            maxDate: "15D",
            showOn: "button",
            buttonImage: "../images/calendario.png",
            buttonImageOnly: true,
            buttonText: "Select date",
            beforeShowDay: $.datepicker.noWeekends


        });
        $( "#datepicker" ).datepicker( "option", "dateFormat", 'yy-mm-dd');


    } );



</script>
</head>
<body>
