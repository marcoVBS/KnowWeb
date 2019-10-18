<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>KnowWeb - @yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
            <nav class="light-green lighten-3">
                <div class="nav-wrapper">
                    <ul class="right">
                        <div>
                            @auth
                                <li><a class="green-text darken-4" href="{{ url('/home') }}"><b>Home</b></a></li>
                            @else
                                @if (Request::route()->getName() == 'register')
                                    <li><a class="green-text darken-4" href="{{ route('login') }}"><b>
                                        <i class="material-icons left">lock_open</i> Login</b></a></li>
                                @endif

                                @if (Request::route()->getName() == 'login')
                                    <li><a class="green-text darken-4" href="{{ route('register') }}"><b> 
                                        <i class="material-icons left">person_add</i> Registrar-se</b></a></li>
                                @endif
                            @endauth
                        </div>
                    </ul>
                </div>
            </nav>

        <div class="content-begin" id="app">
            <vue-snotify></vue-snotify>
            @yield('content_begin')
        </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    
    <!-- Preview imagem usuário -->
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
    
                reader.onload = function (e) {
                    $('#image_upload_preview').attr('src', e.target.result);
                }
    
                reader.readAsDataURL(input.files[0]);
            }
        }
    
        $("#foto").change(function () {
            readURL(this);
        });
    </script>
    </body>
</html>