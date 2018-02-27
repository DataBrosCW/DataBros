@extends('layout.app')

@section('content')

    <header class="navbar navbar-databros navbar-expand-sm">
        <a class="navbar-brand" href="/">Databros</a>
        <ul class="navbar-nav px-3">
            @if(auth_check())
            <a class="nav-link" href="/feed">
                Feed
            </a>
            <a class="nav-link" href="/just-for-you">
                Just for you
            </a>
            <a class="nav-link" href="/categories">
                Categories
            </a>
            @endif
        </ul>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#toggable-nav" aria-controls="toggable-nav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="toggable-nav">
            <ul class="navbar-nav ml-auto px-3">

                @if(auth_check() && isset($user))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{$user->getFullName()}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/logout">Logout
                            </a>
                        </div>
                    </li>
                @else
                    <li>
                        <a class="p-2 text-dark" href="#">Infos
                        </a>
                        <a class="p-2 text-dark" href="/login">Login
                        </a>
                    </li>
                @endif
            </ul>
            @if(!auth_check())
                <a class="btn btn-outline-primary" href="/register">Sign up</a>
            @endif
        </div>
    </header>

    <div class="container">
        <div class="error-messages pt-3">
            <?php
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            if ( $msg->hasMessages() ) {
                $msg->display();
            }
            ?>
        </div>
        @yield('dashboard-content')
    </div>

@endsection