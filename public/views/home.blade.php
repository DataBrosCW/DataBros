@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1>Welcome to Databros</h1>
    </div>

    <div class="row">
        <div class="col-12 mb-3" align="center">
            <p>Your personalised ebay experience</p>
        </div>

        @if (auth_check())

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        <h3><a href="/categories">{{count(auth_user()->followedCategories())}}</a></h3>
                    </div>
                    <div class="card-footer text-center">
                        Number of followed categories
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        <h3><a href="/followed-products">{{count(auth_user()->followedProducts())}}</a></h3>
                    </div>
                    <div class="card-footer text-center">
                        Number of favourite products
                    </div>
                </div>
            </div>
            @if (auth_user()->mostVisitedProduct())
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{auth_user()->mostVisitedProduct()->link}}">
                                {{auth_user()->mostVisitedProduct()->title}}
                            </a>
                        </div>
                        <div class="card-footer text-center">
                            Your most visited item
                        </div>
                    </div>
                </div>
            @endif

        @endif
    </div>



@endsection