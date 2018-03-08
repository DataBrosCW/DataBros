
@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1 class="text-center">Categories</h1>
        <a class="btn btn-success text-right" href="/categories/update">Refresh</a>
    </div>

    <div class="container mt-3">

        <div class="row">
                @foreach($categories as $category)
                    <div class="card mb-4 box-shadow col-4">
                        <div class="card-body">
                            <h3>{{$category->name}}</h3>
                            <p class="card-text">{{$category->description}}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-secondary" href="/categories/example">View</a>
                                    <a class="btn btn-sm btn-outline-secondary" href="#">Follow</a>
                                </div>
                                <small class="text-muted pl-3">3451 recently added items</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection