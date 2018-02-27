
@extends('layout.dashboard')

@section('dashboard-content')


    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1>Category</h1>
    </div>

    <div class="row category-show">

        <div class="col-8">

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent lacinia odio a nisi imperdiet viverra. Donec volutpat dui sit amet porttitor scelerisque. Mauris et magna euismod velit ultricies commodo in aliquam lorem. Aliquam eu iaculis diam. In pharetra fringilla ultricies. Vivamus posuere, quam eget imperdiet facilisis, ante sem imperdiet nisi, quis ultrices quam mauris non massa. Proin sit amet luctus lorem. Ut commodo nisl et urna vehicula accumsan. Suspendisse porta at mauris eget vestibulum. Morbi pellentesque ex nec posuere vulputate. Sed suscipit at tortor a pretium.</p>

            <h1 class="text-center">Top Items</h1>
            <div class="card-deck mb-4">

                <div class="card">
                    <img class="card-img-top" src="https://staticshop.o2.co.uk/product/images/oneplus-5t-sku-header.png?cb=4939cdd3741b5731c0045aff76793d48" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">iPad</h5>
                        <p class="card-text">Some quick example text to build on the card title</p>
                        <p class="price">£500</p>
                        <a class="btn btn-primary btn-block" href="/products/example">Buy</a>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="https://staticshop.o2.co.uk/product/images/oneplus-5t-sku-header.png?cb=4939cdd3741b5731c0045aff76793d48" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">iPad</h5>
                        <p class="card-text">Some quick example text to build on the card title</p>
                        <p class="price">£500</p>
                        <a class="btn btn-primary btn-block" href="/products/example">Buy</a>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="https://staticshop.o2.co.uk/product/images/oneplus-5t-sku-header.png?cb=4939cdd3741b5731c0045aff76793d48" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">iPad</h5>
                        <p class="card-text">Some quick example text to build on the card title</p>
                        <p class="price">£500</p>
                        <a class="btn btn-primary btn-block" href="/products/example">Buy</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <h1>Statistics</h1>
            <img class="graph" src="http://www.msdeer.net/photos/albums/userpics/10002/deertodbynew.png">
            <img class="graph" src="http://www.msdeer.net/photos/albums/userpics/10002/deerbytime.png">
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