<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Databros @yield('title')</title>

    <!-- CSRF Token -->
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    <meta name="lang" content="en">

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- JS Header Required only -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

    <!-- CSS and JS straight in HTML to avoid having to deal with static assets (not goal of CW) -->
    <style type="text/css">

        #app {
            background-color: rgb(242, 248, 254);
            min-height: 100vh;
        }

        .navbar{
            background-color: white;
        }

        .content-block {
            background-color: white;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0px 2px 4px rgba(0,0,0,0.4);
            margin-bottom: 20px;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 300;
            line-height: 1.2;
        }

        .navbar.navbar-databros {
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, .05);
            border-bottom: 1px solid rgb(222, 226, 230);
        }

        .wrapper{
            display: flex;
        }

        .card{
            height: 100%;
        }

        .cards{
            display: flex;
        }

        .section{
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .left.section p{

            margin: 20px 30px;
        }

        .left.section h1{
            margin-bottom: 30px;
        }

        .price{
            color: green;
        }

        .left.section .card p{

            margin: 0px;
            margin-top: 10px;
        }

        .right.section h1{
            margin: 20px;
        }

        .category-show img.graph{

            max-width: 350px;
            margin: 20px 0;
        }

        .singleItemPageImg{
            width: 250px;
            margin-bottom: 60px;
        }

        .singleItemPageGraph{
            width: 240px;
        }

        .singleItemPageBtn {
            width: 170px;
        }

        .singleItemPageContainer {
            text-align:center;

        }

        .img-header {
            height: 300px;
            background-position: center center;
            background-size: contain;
            background-repeat: no-repeat;
            border-radius: 3px 3px 0px 0px;
        }

        .auth-container{

            display: flex;
            justify-content: center;
            padding-top: 50px;
        }

        .auth-container .btn{
            margin-top: 30px;
        }

    </style>

</head>

<body>
<div id="app">

    @yield('content')

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script type="application/javascript">

</script>

@stack('scripts')

</body>
</html>