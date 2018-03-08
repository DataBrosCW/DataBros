
@extends('layout.dashboard')

@section('dashboard-content')

    <div class="container">
        <h3>Search result for: '{{$search}}'</h3>

        <div class="row mt-2">

            @foreach($products as $product)
                <div class="col-4 mb-4">
                    <div class="card">
                        <img class="card-img-top img-fluid" style="height: 150px;" src="{{$product->img}}" alt="{{$product->title}}">
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
                                <a href="/products/{{$product->id}}"class="btn btn-primary btn-block">Buy ${{$product->price}}</a>
                            @else
                                <p>Something went wrong with this product...</p>
                            @endif
                        </footer>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection