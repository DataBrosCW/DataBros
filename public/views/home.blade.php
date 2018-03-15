@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1>Welcome to Databros</h1>
    </div>

    <div class="row">
        <div class="col-12 mb-3" align="center">
            <p>Your personalised ebay experience</p>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header">
                    Number of followed categories
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header">
                    Number of favourite products
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
        @if (auth_user()->mostVisitedProduct())
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header">
                    Your most visited item
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
        @endif
    </div>



@endsection