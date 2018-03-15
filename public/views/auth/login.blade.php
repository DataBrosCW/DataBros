@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1>Login</h1>

        <div class="col-12 col-sm-8 col-md-6 mx-auto">
            <form class="mt-3 text-left" method="POST" action="/login">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" class="form-control" id="email" name="email"
                           placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                </div>
                <button type="submit" class="btn btn-success btn-block btn-lg">Login</button>
            </form>
        </div>
    </div>

@endsection