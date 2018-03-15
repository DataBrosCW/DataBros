@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1>Register</h1>

        <div class="col-12 col-sm-8 col-md-6 mx-auto">
            <form class="mt-3 text-left pb-5" method="POST" action="/register" id="registerForm">
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
                    <label for="exampleInputPassword1">Password (8 char. minimum)</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password Confirmation</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                           placeholder="Password Confirmation">
                </div>
                <button id="submitBtn" class="btn btn-success btn-block btn-lg" style="margin-top: 30px">Register</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="application/javascript">
        $( document ).ready(function() {
            $('#submitBtn').click(function(){
                event.preventDefault();
                if ( $('#password').val().length>7 && $('#password_confirm').val().length>7 ){
                    $('#registerForm').submit();
                } else {
                    if ($('#password').val().length<8){
                        $('#password').attr('class', $('#password').attr('class')+' has-error');
                    }
                    if ($('#password_confirm').val().length<8){
                        $('#password_confirm').attr('class', $('#password_confirm').attr('class')+' has-error');
                    }
                }
            });

            $('#password').change(function () {
                if ($('#password').val()>7){
                    $('#password').attr('class','form-control');
                }
                if ($('#password_confirm').val()>7){
                    $('#password_confirm').attr('class','form-control');
                }
            })
        });
    </script>


@endpush