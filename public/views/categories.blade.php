@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1 class="text-center">Categories</h1>
        <a class="btn btn-success text-right" href="/categories/update">Refresh <i class="fas fa-sync-alt"></i>
        </a>
    </div>

    <div class="container mt-3">

        <div class="row">
            @foreach($categories as $category)
                <div class="col-4 mt-4">
                    <div class="card mb-4 box-shadow">
                        <div class="card-body" style="min-height: 160px;">
                            <h3 class="text-center">{{$category->name}}</h3>
                            <p class="card-text">{{$category->description}}</p>
                            <div class="text-center">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-primary" href="/categories/{{$category->id}}">View</a>
                                    <a class="btn btn-sm btn-{{$category->stats()?($category->stats()->followed?'danger':'success'):'success'}}"
                                       href="/categories/{{$category->id}}/favourite">{{$category->stats()?($category->stats()->followed?'Unfollow':'Follow'):'Follow'}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>

@endsection