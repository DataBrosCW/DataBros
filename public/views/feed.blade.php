
@extends('layout.dashboard')

@section('dashboard-content')

    <div class="container">
        <div class="header-databros pt-md-3 text-center mx-auto">
            <h1>Feed </h1>
        </div>

        @if(!$categories)

            <p>The feeds uses your tastes to suggest you products. Therefore, you must follow at least one category to access the feed.</p>
            <div class="text-center">
                <a href="/categories" class="btn btn-primary">Add a category</a>
            </div>
        @endif

        @if($products)
            <div class="row mt-2">
            @foreach($products as $product)
                <div class="col-4 mb-4">
                    <div class="card">
                        <div class="img-header" style="background-image: url({{$product->img}})"></div>
                        <div class="card-body" style="position: relative;">
                            <h5 class="card-title">{{$product->title}}
                            </h5>
                            {{--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
                            @if($product->avg_price_graph())
                                <i class="fas fa-signal text-primary" style="position: absolute;right: 5px;bottom: 5px;"></i>
                            @endif
                        </div>
                        <footer class="card-footer">
                            @if(isset($product->id))
                                <a href="/products/{{$product->id}}"class="btn btn-primary btn-block">See (${{$product->price}})</a>
                            @else
                                <p>Something went wrong with this product...</p>
                            @endif
                        </footer>
                    </div>
                </div>
            @endforeach
            </div>
        @endif


    </div>

@endsection