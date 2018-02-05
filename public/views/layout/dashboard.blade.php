@extends('layout.app')

@section('content')

<header class="navbar navbar-databros">
    <a class="navbar-brand" href="/">Databros</a>
    <ul class="navbar-nav ml-auto px-3">
        <li>
            <a class="p-2 text-dark" href="#">Infos
            </a>
        </li>
    </ul>
    <a class="btn btn-outline-primary" href="/register">Sign up</a>
</header>

<div class="container">
    <div class="error-messages pt-3">
    <?php
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        if ($msg->hasErrors()) {
            $msg->display();
        }
    ?>
    </div>
    @yield('dashboard-content')
</div>

@endsection