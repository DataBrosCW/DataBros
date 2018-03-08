
@extends('layout.dashboard')

@section('dashboard-content')

    {{-- TODO: back button to come back to search --}}

    <div class="container">
        <div class="row" style="padding-top: 20px;">
            <div class="col-md-4 singleItemPageContainer" >
                <img class="singleItemPageImg" src="{{$product->img}}">
                <br>
                <button type="button" class="btn btn-success singleItemPageBtn">Take Me There</button>
                @if ($userProduct->followed)
                <a href="/products/{{$product->id}}/favourite" class="btn btn-primary singleItemPageBtn mt-2">Add to favourite</a>
                @else
                    <a href="/products/{{$product->id}}/favourite" class="btn btn-danger singleItemPageBtn mt-2">Remove favourite</a>
                @endif

            </div>
            <div class="col-md-8 singleItemPageContainer" style="padding-top: 70px;">
                <h3>
                    {{$product->title}}
                </h3>
                <h5>Price: {{$product->price}}</h5>
            </div>
        </div>
        <div class="singleItemPageContainer" style="padding-top: 40px;">
            <h3>Statistics</h3>
            <div class="row justify-content-center pt-4" >
                @if($productStat)
                    <div class="col-md-8 col-sm-12 p-4">
                        <h5>Average price of similar products ({{count(json_decode($productStat->content))}})</h5>
                        <canvas id="avgChart"></canvas>
                    </div>
                @else
                {{--@if($productStatGeo)--}}
                    {{--<div class="col-md-8 col-sm-12 p-4">--}}
                        {{--<h5>Sup</h5>--}}
                    {{--</div>--}}
                {{--@else--}}
                <div class="col-md-6">
                    <img src="data:image/jpeg;base64,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" class="singleItemPageGraph">
                </div>
                <div class="col-md-6">
                    <img src="data:image/png;base64,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" class="singleItemPageGraph">
                </div>
                @endif
            </div>
        </div>

    </div>

@endsection

@if($productStat)

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <script type="application/javascript">

            var avg_data = {!!$productStat->content!!};
            avg_data = avg_data.sort();
            var labels = Array.apply(null, {length: avg_data.length}).map(Number.call, Number);

            var total = 0;
            for(var i = 0; i < avg_data.length; i++) {
                total += parseFloat(avg_data[i]);
            }
            var avg = total / avg_data.length;
            var avg_line = new Array(avg_data.length);
            avg_line.fill(avg);


            var ctx = document.getElementById('avgChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Comparable item prices",
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: avg_data,
                        fill: false,
                    },
                    {
                        label: "Average Price",
                        backgroundColor: 'rgb(22, 99, 255)',
                        borderColor: 'rgb(22, 99, 255)',
                        data: avg_line,
                        fill: false,
                        pointRadius: 0
                    }]

                },

                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                suggestedMin: Math.min.apply(Math, avg_data) - 0.05 * Math.min.apply(Math, avg_data),
                                suggestedMax: Math.max.apply(Math, avg_data) + 0.05 * Math.max.apply(Math, avg_data)
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                display: false
                            }
                        }]
                    }
                }
            });

            console.log(Math.min.apply(Math, avg_data)  );
        </script>
    @endpush

@endif