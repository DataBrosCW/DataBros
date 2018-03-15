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
            <div class="row" style="padding-top: 20px; margin-bottom: 20px;">
                <div class="col-4">
                    <a href="/categories/" class="btn btn-outline-primary singleItemPageBtn mt-2"><i
                                class="fas fa-long-arrow-alt-left"></i> Back to categories </a>

                </div>
                <div class="col-4" style="text-align: center;">
                    <button type="button" class="btn btn-outline-primary" data-toggle="collapse"
                            data-target="#stats" aria-expanded="true" aria-controls="stats" id="hideStats">
                        <i class="fas fa-eye"></i>
                        Hide Statistics
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="collapse"
                            data-target="#stats" aria-expanded="true" aria-controls="stats" id="showStats">
                        <i class="fas fa-eye"></i>
                        Show Statistics
                    </button>

                    @push('scripts')
                        <script type="application/javascript">
                            $('#showStats').hide();

                            $( document ).ready(function() {
                                $('#showStats').click(function () {
                                    $('#showStats').hide();
                                    $('#hideStats').show();
                                })
                                $('#hideStats').click(function () {
                                    $('#hideStats').hide();
                                    $('#showStats').show();
                                })
                            });
                        </script>
                    @endpush
                </div>
                <div class="col-4" style="text-align: right;">
                    @if ($userCategory->followed == 0)
                        <a href="/categories/{{$category->id}}/favourite"
                           class="btn btn-primary singleItemPageBtn mt-2"><i class="fas fa-star"></i> Add to
                            favourite</a>
                    @else
                        <a href="/categories/{{$category->id}}/favourite" class="btn btn-danger singleItemPageBtn mt-2"><i
                                    class="far fa-star"></i> Remove favourite</a>
                    @endif
                </div>
            </div>


            <!-- Modal -->
            <div class="row mt-3">
                @if ($category_stat)
                    <div class="col-12 collapse show" id="stats">
                        <h4 class="text-center">Statistics</h4>

                        <div class="card p-4">
                            <h5 class="text-center">Average price of top items of category</h5>
                            <canvas id="avgChart"></canvas>
                            @push('scripts')
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
                                <script type="application/javascript">
                                    const verticalLinePlugin = {
                                        getLinePosition: function (chart, pointIndex) {
                                            const meta = chart.getDatasetMeta(0); // first dataset is used to discover X coordinate of a point
                                            const data = meta.data;
                                            return data[pointIndex]._model.x;
                                        },
                                        renderVerticalLine: function (chartInstance, pointIndex) {
                                            const lineLeftOffset = this.getLinePosition(chartInstance, pointIndex);
                                            const scale = chartInstance.scales['y-axis-0'];
                                            const context = chartInstance.chart.ctx;

                                            // render vertical line
                                            context.beginPath();
                                            context.strokeStyle = '#ff0000';
                                            context.moveTo(lineLeftOffset, scale.top);
                                            context.lineTo(lineLeftOffset, scale.bottom);
                                            context.stroke();

                                            // write label
                                            context.fillStyle = "#ff0000";
                                            context.textAlign = 'center';
                                            context.fillText('Today', lineLeftOffset - 20, (scale.top - 20) + scale.top);
                                        },

                                        afterDatasetsDraw: function (chart, easing) {
                                            if (chart.config.lineAtIndex) {
                                                chart.config.lineAtIndex.forEach(pointIndex => this.renderVerticalLine(chart, pointIndex));
                                            }
                                        }
                                    };
                                    Chart.plugins.register(verticalLinePlugin);
                                </script>

                                <script type="application/javascript">

                                    var avg_data = {!!$category_stat->content!!};
                                    predicted_val = avg_data['Scored Label Mean'];
                                    delete avg_data.Category;
                                    delete avg_data['Scored Label Mean'];
                                    delete avg_data['Scored Label Standard Deviation'];

                                    var labels = Array.apply(null, {length: avg_data.length}).map(Number.call, Number);

                                    var total = 0;
                                    var dataPoints = []

                                    for (var k in avg_data){
                                        avg_data[k] = avg_data[k] / 100;
                                        dataPoints.push(avg_data[k]);
                                    }
                                    // line
                                    dataPoints.push(null);
                                    dataPoints = dataPoints.slice(20,dataPoints.length);
                                    var prediction = new Array(dataPoints.length - 2);
                                    prediction.fill(null);
                                    prediction.push(dataPoints[dataPoints.length - 2]);
                                    prediction.push(parseFloat(predicted_val/100));

                                    console.log(prediction);

                                    // Avg Line
                                    var total = dataPoints.reduce((a, b) => a + b, 0);
                                    total += parseFloat(predicted_val / 100);
                                    var avg = total / dataPoints.length;
                                    var avg_line = new Array(dataPoints.length);
                                    avg_line.fill(avg);

                                    labels = [];
                                    var i = -(dataPoints.length - 2);
                                    while (i<2){
                                        labels.push(i);
                                        i++;
                                    }

                                    var ctx = document.getElementById('avgChart').getContext('2d');
                                    Chart.defaults.global.elements.point.radius = 0;
                                    var chart = new Chart(ctx, {
                                        // The type of chart we want to create
                                        type: 'line',

                                        // The data for our dataset
                                        data: {
                                            labels: labels,
                                            datasets: [
                                                {
                                                    label: "Comparable item prices",
                                                    backgroundColor: 'rgb(255, 99, 132)',
                                                    borderColor: 'rgb(255, 99, 132)',
                                                    data: dataPoints,
                                                    fill: false,
                                                },
                                                {
                                                    label: "Machine learning prediction",
                                                    backgroundColor: 'rgb(100, 255, 100)',
                                                    borderColor: 'rgb(100, 255, 100)',
                                                    data: prediction,
                                                    fill: false,
                                                },
                                                {
                                                    label: "Average Price",
                                                    backgroundColor: 'rgb(117, 154, 244)',
                                                    borderColor: 'rgb(117, 154, 244)',
                                                    data: avg_line,
                                                    fill: false,
                                                    pointRadius: 0,
                                                    borderDash: [10,5]
                                                }
                                            ]
                                        },

                                        // Configuration options go here
                                        options: {
                                            scales: {
                                                yAxes: [{
                                                    scaleLabel: {
                                                        display: true,
                                                        labelString: 'Price (USD)'
                                                    }
                                                }],
                                                xAxes: [{
                                                    ticks: {
                                                        display: true
                                                    },
                                                    gridLines: {
                                                        display: false
                                                    },
                                                    scaleLabel: {
                                                        display: true,
                                                        labelString: 'Days'
                                                    }
                                                }]
                                            }
                                        },
                                        lineAtIndex: [dataPoints.length-2]
                                    });
                                </script>
                            @endpush
                        </div>
                    </div>

                @endif


                <div class="col-12 mt-5">
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
                                            <i class="fas fa-signal text-primary"
                                               style="position: absolute;right: 5px;bottom: 5px;"></i>
                                        @endif
                                    </div>
                                    <footer class="card-footer">
                                        <a href="/products/old/{{$product->epid}}" class="btn btn-primary btn-block">See
                                            (${{$product->price}})</a>
                                    </footer>
                                </div>
                            </div>
                        @endforeach
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