@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1>Register</h1>

        <div class="col-12 col-sm-8 col-md-6 mx-auto">
            <form class="mt-3 text-left" method="POST" action="/register">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputEmail1">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                           placeholder="Enter first name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                           placeholder="Enter last name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="email" name="email"
                           placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password Confirmation</label>
                    <input type="password_confirm" class="form-control" id="password_confirm" name="password_confirm"
                           placeholder="Password Confirmation">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
    </div>

@endsection