@extends('layout.dashboard')

@section('dashboard-content')

    <div>

        @if($followedProducts)
            <div class="header-databros pt-md-3 text-center mx-auto">
                <h1>Favourite Products</h1>
            </div>

            @if(count($followedProducts)>0)

                <h3 class="mt-5 mb-3">Products you follow</h3>
                <div class="card-deck">
                    @foreach($followedProducts as $product)
                        <div class="col-sm-6 col-md-4 col-12 py-3">
                            <div class="card">
                                <div class="img-header" style="background-image: url({{$product->img}})"></div>
                                <div class="card-body">
                                    <h5 class="card-title">{{$product->title}}</h5>
                                </div>
                                <div class="card-footer">
                                    <a href="/products/{{$product->id}}"class="btn btn-primary btn-block">Buy ${{$product->price}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @endif

        @else
            <div class="header-databros pt-md-3 text-center mx-auto">
                <h1>Followed Products</h1>
            </div>
            <p>You currently don't follow any product.</p>
        @endif

        <h3 class="mt-5 mb-3">Suggestions</h3>
            <div class="card-deck mt-4 pb-4">
                @foreach($featuredProducts as $product)
                    <div class="col-sm-4 col-12 py-3">
                        <div class="card " style="width: 18rem;">
                            <div class="img-header" style="background-image: url({{$product->img}})"></div>
                            <div class="card-body">
                                <h5 class="card-title">{{$product->title}}</h5>
                            </div>
                            <div class="card-footer">
                                <a href="products/old/{{$product->epid}}"class="btn btn-primary btn-block">See (${{$product->price}})</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>




@endsection