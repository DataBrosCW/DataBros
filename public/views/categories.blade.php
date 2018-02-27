
@extends('layout.dashboard')

@section('dashboard-content')

    <div class="header-databros pt-md-3 text-center mx-auto">
        <h1>Categories</h1>
    </div>

    <div class="container">

        <div class="row">
                <div class="card mb-4 box-shadow col-4">
                    <img class="card-img-top" src="https://cdn.pocket-lint.com/r/s/1200x/assets/images/120309-phones-buyer-s-guide-best-smartphones-image1-cnxvifjlms.jpg" alt="Electronics [100%x225]" style="height: 225px; width: 100%; display: block;">
                    <div class="card-body">
                        <h3>Electronics</h3>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-sm btn-outline-secondary" href="/categories/example">View</a>
                                <a class="btn btn-sm btn-outline-secondary" href="#">Follow</a>
                            </div>
                            <small class="text-muted pl-3">3451 recently added items</small>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 box-shadow col-4">
                    <img class="card-img-top" src="data:image/jpeg;base64,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" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
                    <div class="card-body">
                        <h3>Fashion</h3>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-sm btn-outline-secondary" href="/categories/example">View</a>
                                <a class="btn btn-sm btn-outline-secondary" href="#">Follow</a>
                            </div>
                            <small class="text-muted pl-3">451 recently added items</small>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 box-shadow col-4">
                    <img class="card-img-top" src="data:image/jpeg;base64,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" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
                    <div class="card-body">
                        <h3>Home</h3>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-sm btn-outline-secondary" href="/categories/example">View</a>
                                <a class="btn btn-sm btn-outline-secondary" href="#">Follow</a>
                            </div>
                            <small class="text-muted pl-3">2456 recently added items</small>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 box-shadow col-4">
                    <img class="card-img-top" src="https://www.edgehill.ac.uk/study/files/2017/03/Sport-and-Leisure-6-1024x683.jpg" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
                    <div class="card-body">
                        <h3>Leisure</h3>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-sm btn-outline-secondary" href="/categories/example">View</a>
                                <a class="btn btn-sm btn-outline-secondary" href="#">Follow</a>
                            </div>
                            <small class="text-muted pl-3">856 recently added items</small>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 box-shadow col-4">
                    <img class="card-img-top" src="https://www.nhs.uk/Livewell/Healthyhearts/PublishingImages/T_0417-heart-health_504450902_A.jpg" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
                    <div class="card-body">
                        <h3>Health</h3>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-sm btn-outline-secondary" href="/categories/example">View</a>
                                <a class="btn btn-sm btn-outline-secondary" href="#">Follow</a>
                            </div>
                            <small class="text-muted pl-3">1693 recently added items</small>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 box-shadow col-4">
                    <img class="card-img-top" src="https://cdn.cnn.com/cnnnext/dam/assets/161212145759-best-cars-2016-bugatti-1-super-169.jpg" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
                    <div class="card-body">
                        <h3>Vehicules</h3>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-sm btn-outline-secondary" href="/categories/example">View</a>
                                <a class="btn btn-sm btn-outline-secondary" href="#">Follow</a>
                            </div>
                            <small class="text-muted pl-3">2352 recently added items</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection