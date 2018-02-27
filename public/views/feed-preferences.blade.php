
@extends('layout.dashboard')

@section('dashboard-content')

    <div class="container">
        <div class="header-databros pt-md-3 text-center mx-auto">
            <h1>Feed Preferences</h1>
        </div>

        <a class="mt-4" href="/feed">
            <i class="fas fa-long-arrow-alt-left"></i>
            Back to the feed
        </a>

        <div class="row mt-2">
            <div class="col-5">
                <div class="card">
                    <div class="card-header">
                        Categories
                    </div>
                    <div class="card-body">
                        <p class="card-text">Select the categories of products you wish to see in your feed.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                <label class="form-check-label" for="inlineCheckbox1">Category 1</label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option1">
                                <label class="form-check-label" for="inlineCheckbox2">Category 2</label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option1" checked>
                                <label class="form-check-label" for="inlineCheckbox3">Category 3</label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="option1">
                                <label class="form-check-label" for="inlineCheckbox4">Category 4</label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="option1">
                                <label class="form-check-label" for="inlineCheckbox5">Category 5</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-7">
                <div class="card">
                    <div class="card-header">
                        Pricing
                    </div>
                    <div class="card-body">
                        <p class="card-text">Select desired price range.</p>
                        <form>
                            <div class="form-row">
                                <div class="col form-group">
                                    <label for="inputEmail4">Min. Price</label>
                                    <input type="text" class="form-control" placeholder="Min. Price">
                                </div>
                                <div class="col form-group">
                                    <label for="inputEmail4">Max. Price</label>
                                    <input type="text" class="form-control" placeholder="Max. Price">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection