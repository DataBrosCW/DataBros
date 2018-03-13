
@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1>Ebay Authorisation</h1>
    </div>
    <div class="auth-container">
        <div class="row">
            <div class="col" align="center">
                <p>Please allow DataBros to access your Ebay data!</p>
                <a  href="{{userTokenRoute()}}"><button type="button" class="btn btn-success btn-lg"><i class="fas fa-unlock"></i> Allow access</button></a>
            </div>
        </div>
    </div>


@endsection