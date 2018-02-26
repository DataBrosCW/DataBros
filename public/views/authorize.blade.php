
@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1>Databros</h1>
    </div>

    <p>
        You must allow Databros to interract with your ebay account to go further with the app. <br>
        <a href="{{userTokenRoute()}}">Click here to do so!</a>
    </p>

@endsection