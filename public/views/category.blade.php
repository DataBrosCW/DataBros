
@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1>{{$category->name}}</h1>
    </div>

    <div class="row category-show">

        <div class="col-12">

            @if($category->description)
            <p>{{$category->description}}</p>
            @endif

            <div>
            <a href="/categories/" class="btn btn-outline-primary singleItemPageBtn mt-2"><i class="fas fa-long-arrow-alt-left"></i> Back to categories</a>
                <br>
            @if ($userCategory->followed == 0)
                <a href="/categories/{{$category->id}}/favourite" class="btn btn-primary singleItemPageBtn mt-2"><i class="fas fa-star"></i> Add to favourite</a>
            @else
                <a href="/categories/{{$category->id}}/favourite" class="btn btn-danger singleItemPageBtn mt-2"><i class="far fa-star"></i> Remove favourite</a>
            @endif
            </div>

            <div class="row">
                <div class="col-12">
                    <h4 class="text-center">Top Items</h4>
                    <div class="row">
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
                                        <div class="text-center">
                                            {{$product->price}}
                                        </div>
                                    </div>
                                    <footer class="card-footer">
                                        <a href="/products/old/{{$product->epid}}"class="btn btn-primary btn-block">See (${{$product->price}})</a>
                                    </footer>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{--<div class="col-12 col-sm-6">--}}
                    {{--<div class="col-4">--}}
                        {{--<h1>Statistics</h1>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>


    </div>


    <!-- <div class="card" style="width: 50%">
            <img class="card-img-top" style="height: 100%; max-width: 500px" src="https://staticshop.o2.co.uk/product/images/oneplus-5t-sku-header.png?cb=4939cdd3741b5731c0045aff76793d48" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">iPad</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary btn-block">Buy 500$</a>
            </div>
        </div>
    </div> -->

@endsection