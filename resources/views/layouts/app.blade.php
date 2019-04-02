<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>KnowWeb - @yield('title')</title>

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
                        <a href="#user"><img class="circle" src="{{ asset('img/app/usuario-icon.png') }}"></a>
                        <h5 class="white-text">Fulano de Tal</h5>
                        <div class="divider"></div>
                        <a href="#email"><i class="material-icons">build</i> Editar Perfil</a>
                    </div>
                </li>
                <li><a class="waves-effect white-text" href="#"><i class="material-icons white-text">cloud</i>Item com Icone</a></li>
                <li><a class="subheader">Item Desabilitado</a></li>
                <li><a class="waves-effect" href="#!">Item com efeito Waves</a></li>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                        <a class="collapsible-header">Dropdown<i class="material-icons">arrow_drop_down</i></a>
                        <div class="collapsible-body">
                            <ul class="green darken-3">
                            <li><a href="#!">First</a></li>
                            <li><a href="#!">Second</a></li>
                            <li><a href="#!">Third</a></li>
                            <li><a href="#!">Fourth</a></li>
                            </ul>
                        </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        
        <div class="content" id="app">
            <vue-snotify></vue-snotify>
            @yield('content')
        </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>
