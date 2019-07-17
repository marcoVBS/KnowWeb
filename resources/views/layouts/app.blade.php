<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
        <title>KnowWeb - @yield('title')</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>

        <!-- Menu Horizontal -->
        <div class="top-menu">
            <nav class="light-green lighten-5">
                <div class="nav-wrapper">
                    <a href="#" id="logoDesk" class="brand-logo green-text darken-4"><img src="{{ asset('img/app/logo.png') }}" alt="logo_knowweb"></a>
                    <a href="#" id="logoMobile" class="brand-logo green-text darken-4"><img src="{{ asset('img/app/logo2.png') }}" alt="logo_knowweb"></a>
                    <ul class="left">
                        <li><a href="#" data-target="slide-out" class="sidenav-trigger green-text darken-4"><i class="material-icons">menu</i></a></li>
                    </ul>                  

                    <ul class="right">
                        <li>
                            <a class="green-text darken-4" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <b><i class="material-icons left">exit_to_app</i>Sair</b>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

        </div>

        <!-- Menu Lateral -->
        <div class="side-menu">
            <ul id="slide-out" class="sidenav sidenav-fixed green darken-4">
                <li>
                    <div class="user-view">
                        <div class="background">
                            <img src="{{ asset('img/app/back_user.jpg') }}">
                        </div>

                        @if (Auth::user()->foto)
                            <img class="circle" src="{{ Auth::user()->foto }}">
                        @else    
                            <img class="circle" src="{{ asset('img/app/usuario-icon.png') }}">                    
                        @endif

                        <h6 class="white-text">{{ Auth::user()->nome }}</h6>
                        <div class="divider"></div>
                        <a href="#email"><i class="tiny material-icons">build</i> Editar Perfil</a>
                    </div>
                </li>
                <li><a class="waves-effect white-text" href="#"><i class="material-icons white-text">library_books</i>Artigos</a></li>
                <li><a class="waves-effect white-text" href="#"><i class="material-icons white-text">computer</i>Computadores</a></li>
                <li><a class="waves-effect white-text" href="{{ route('archives') }}"><i class="material-icons white-text">archive</i>Arquivos</a></li>
                <li><a class="waves-effect white-text" href="#"><i class="material-icons white-text">router</i>Equipamentos</a></li>
                <li><a class="waves-effect white-text" href="#"><i class="material-icons white-text">security</i>Senhas</a></li>
                <li><a class="waves-effect white-text" href="{{ route('helpdesks') }}"><i class="material-icons white-text">help_outline</i>Atendimentos</a></li>
                <li><a class="waves-effect white-text" href="{{ route('categories') }}"><i class="material-icons white-text">more</i>Categorias</a></li>
                <li><a class="waves-effect white-text" href="{{ route('sectors') }}"><i class="material-icons white-text">domain</i>Setores</a></li>
                <li><a class="waves-effect white-text" href="#"><i class="material-icons white-text">supervisor_account</i>Usuários</a></li>
            </ul>
        </div>
        
        <div class="content" id="app">      
            <vue-snotify></vue-snotify>
            @yield('content')
        </div>
    
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>
