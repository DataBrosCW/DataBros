@extends('layout.dashboard')

@section('dashboard-content')

    {{-- TODO: back button to come back to search --}}

    <div class="container">
        <div class="text-center">
            <h3>
                {{$product->title}}
            </h3>
        </div>
        <div class="row" style="padding-top: 20px;">
            <div class="col-12 col-sm-6 col-md-4 singleItemPageContainer pt-3">
                <div class="content-block">
                    <img class="singleItemPageImg" src="{{$product->img}}">

                    <h4 class="text-center">Price: {{$product->price}}</h4>

                    <a href="{{$product->link}}" target="_blank" class="btn btn-success singleItemPageBtn mt-3">Take Me
                        There</a>

                    @if ($userProduct->followed == 0)
                        <a href="/products/{{$product->id}}/favourite" class="btn btn-primary singleItemPageBtn mt-2">Add
                            to favourite</a>
                    @else
                        <a href="/products/{{$product->id}}/favourite" class="btn btn-danger singleItemPageBtn mt-2">Remove
                            favourite</a>
                    @endif
                </div>

            </div>
            <div class="col-12 col-sm-6 col-md-8 singleItemPageContainer pt-3">
                <div class="content-block">
                    <h4>Statistics</h4>
                    <div class="row justify-content-center">
                        @if($productStatAvg)
                            <div class="col-12 p-4">
                                <h5>Average price of similar products ({{count(json_decode($productStatAvg->content))}})</h5>
                                <canvas id="avgChart"></canvas>
                            </div>
                        @endif
                        @if($productStatGeo)
                            <div class="col-12 p-4">
                                <h5>Distribution areas</h5>
                                <!-- Styles -->
                                <style>
                                    #chartdiv {
                                        width: 100%;
                                        height: 300px;
                                    }
                                </style>

                                <!-- HTML -->
                                <div id="chartdiv"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@if($productStatAvg)
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type="application/javascript">

            console.log('sup');

            var avg_data = {!!$productStatAvg->content!!};
            avg_data = avg_data.sort();
            var labels = Array.apply(null, {length: avg_data.length}).map(Number.call, Number);

            var total = 0;
            for (var i = 0; i < avg_data.length; i++) {
                total += parseFloat(avg_data[i]);
            }
            var avg = total / avg_data.length;
            var price = {!! $product->price !!};
            var avg_line = new Array(avg_data.length);
            var price_line = new Array(avg_data.length);
            avg_line.fill(avg);
            price_line.fill(price);
            var diff = avg - price;


            var ctx = document.getElementById('avgChart').getContext('2d');

            Chart.defaults.global.elements.point.radius = 0;

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
                        },
                        {
                            label: "Item Price",
                            backgroundColor: 'rgb(0, 221, 0)',
                            borderColor: 'rgb(0, 221, 0)',
                            data: price_line,
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
                            },
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                }
            });

            console.log(Math.min.apply(Math, avg_data));
    </script>
    @endpush
@endif
@if($productStatGeo)
    @push('scripts')
    <script src="https://www.amcharts.com/lib/3/ammap.js"></script>
    <script src="https://www.amcharts.com/lib/3/maps/js/continentsLow.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css"
          media="all"/>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

    <script type="application/javascript">
        <!-- Chart code -->
        <!-- Resources -->

            var countriesByContinent = [
                {"country": "Aruba", "continent": "North America"},
                {"country": "Afghanistan", "continent": "Asia"},
                {"country": "Angola", "continent": "Africa"},
                {"country": "Anguilla", "continent": "North America"},
                {"country": "Albania", "continent": "Europe"},
                {"country": "Andorra", "continent": "Europe"},
                {"country": "Netherlands Antilles", "continent": "North America"},
                {"country": "United Arab Emirates", "continent": "Asia"},
                {"country": "Argentina", "continent": "South America"},
                {"country": "Armenia", "continent": "Asia"},
                {"country": "American Samoa", "continent": "Oceania"},
                {"country": "Antarctica", "continent": "Antarctica"},
                {"country": "French Southern territories", "continent": "Antarctica"},
                {"country": "Antigua and Barbuda", "continent": "North America"},
                {"country": "Australia", "continent": "Oceania"},
                {"country": "Austria", "continent": "Europe"},
                {"country": "Azerbaijan", "continent": "Asia"},
                {"country": "Burundi", "continent": "Africa"},
                {"country": "Belgium", "continent": "Europe"},
                {"country": "Benin", "continent": "Africa"},
                {"country": "Burkina Faso", "continent": "Africa"},
                {"country": "Bangladesh", "continent": "Asia"},
                {"country": "Bulgaria", "continent": "Europe"},
                {"country": "Bahrain", "continent": "Asia"},
                {"country": "Bahamas", "continent": "North America"},
                {"country": "Bosnia and Herzegovina", "continent": "Europe"},
                {"country": "Belarus", "continent": "Europe"},
                {"country": "Belize", "continent": "North America"},
                {"country": "Bermuda", "continent": "North America"},
                {"country": "Bolivia", "continent": "South America"},
                {"country": "Brazil", "continent": "South America"},
                {"country": "Barbados", "continent": "North America"},
                {"country": "Brunei", "continent": "Asia"},
                {"country": "Bhutan", "continent": "Asia"},
                {"country": "Bouvet Island", "continent": "Antarctica"},
                {"country": "Botswana", "continent": "Africa"},
                {"country": "Central African Republic", "continent": "Africa"},
                {"country": "Canada", "continent": "North America"},
                {"country": "Cocos (Keeling) Islands", "continent": "Oceania"},
                {"country": "Switzerland", "continent": "Europe"},
                {"country": "Chile", "continent": "South America"},
                {"country": "China", "continent": "Asia"},
                {"country": "Ivory Coast", "continent": "Africa"},
                {"country": "Cameroon", "continent": "Africa"},
                {"country": "Congo, The Democratic Republic of the", "continent": "Africa"},
                {"country": "Congo", "continent": "Africa"},
                {"country": "Cook Islands", "continent": "Oceania"},
                {"country": "Colombia", "continent": "South America"},
                {"country": "Comoros", "continent": "Africa"},
                {"country": "Cape Verde", "continent": "Africa"},
                {"country": "Costa Rica", "continent": "North America"},
                {"country": "Cuba", "continent": "North America"},
                {"country": "Christmas Island", "continent": "Oceania"},
                {"country": "Cayman Islands", "continent": "North America"},
                {"country": "Cyprus", "continent": "Asia"},
                {"country": "Czech Republic", "continent": "Europe"},
                {"country": "Germany", "continent": "Europe"},
                {"country": "Djibouti", "continent": "Africa"},
                {"country": "Dominica", "continent": "North America"},
                {"country": "Denmark", "continent": "Europe"},
                {"country": "Dominican Republic", "continent": "North America"},
                {"country": "Algeria", "continent": "Africa"},
                {"country": "Ecuador", "continent": "South America"},
                {"country": "Egypt", "continent": "Africa"},
                {"country": "Western Sahara", "continent": "Africa"},
                {"country": "Spain", "continent": "Europe"},
                {"country": "Eritrea", "continent": "Africa"},
                {"country": "Estonia", "continent": "Europe"},
                {"country": "Ethiopia", "continent": "Africa"},
                {"country": "Finland", "continent": "Europe"},
                {"country": "Fiji Islands", "continent": "Oceania"},
                {"country": "Falkland Islands", "continent": "South America"},
                {"country": "France", "continent": "Europe"},
                {"country": "Faroe Islands", "continent": "Europe"},
                {"country": "Federated States of Micronesia", "continent": "Oceania"},
                {"country": "Gabon", "continent": "Africa"},
                {"country": "United Kingdom", "continent": "Europe"},
                {"country": "Georgia", "continent": "Asia"},
                {"country": "Ghana", "continent": "Africa"},
                {"country": "Gibraltar", "continent": "Europe"},
                {"country": "Guinea", "continent": "Africa"},
                {"country": "Guadeloupe", "continent": "North America"},
                {"country": "Gambia", "continent": "Africa"},
                {"country": "Guinea-Bissau", "continent": "Africa"},
                {"country": "Equatorial Guinea", "continent": "Africa"},
                {"country": "Greece", "continent": "Europe"},
                {"country": "Grenada", "continent": "North America"},
                {"country": "Greenland", "continent": "North America"},
                {"country": "Guatemala", "continent": "North America"},
                {"country": "French Guiana", "continent": "South America"},
                {"country": "Guam", "continent": "Oceania"},
                {"country": "Guyana", "continent": "South America"},
                {"country": "Hong Kong", "continent": "Asia"},
                {"country": "Heard Island and McDonald Islands", "continent": "Antarctica"},
                {"country": "Honduras", "continent": "North America"},
                {"country": "Croatia", "continent": "Europe"},
                {"country": "Haiti", "continent": "North America"},
                {"country": "Hungary", "continent": "Europe"},
                {"country": "Indonesia", "continent": "Asia"},
                {"country": "India", "continent": "Asia"},
                {"country": "British Indian Ocean Territory", "continent": "Africa"},
                {"country": "Ireland", "continent": "Europe"},
                {"country": "Iran", "continent": "Asia"},
                {"country": "Iraq", "continent": "Asia"},
                {"country": "Iceland", "continent": "Europe"},
                {"country": "Israel", "continent": "Asia"},
                {"country": "Italy", "continent": "Europe"},
                {"country": "Jamaica", "continent": "North America"},
                {"country": "Jordan", "continent": "Asia"},
                {"country": "Japan", "continent": "Asia"},
                {"country": "Kazakstan", "continent": "Asia"},
                {"country": "Kenya", "continent": "Africa"},
                {"country": "Kyrgyzstan", "continent": "Asia"},
                {"country": "Cambodia", "continent": "Asia"},
                {"country": "Kiribati", "continent": "Oceania"},
                {"country": "Saint Kitts and Nevis", "continent": "North America"},
                {"country": "South Korea", "continent": "Asia"},
                {"country": "Kuwait", "continent": "Asia"},
                {"country": "Laos", "continent": "Asia"},
                {"country": "Lebanon", "continent": "Asia"},
                {"country": "Liberia", "continent": "Africa"},
                {"country": "Libyan Arab Jamahiriya", "continent": "Africa"},
                {"country": "Saint Lucia", "continent": "North America"},
                {"country": "Liechtenstein", "continent": "Europe"},
                {"country": "Sri Lanka", "continent": "Asia"},
                {"country": "Lesotho", "continent": "Africa"},
                {"country": "Lithuania", "continent": "Europe"},
                {"country": "Luxembourg", "continent": "Europe"},
                {"country": "Latvia", "continent": "Europe"},
                {"country": "Macao", "continent": "Asia"},
                {"country": "Morocco", "continent": "Africa"},
                {"country": "Monaco", "continent": "Europe"},
                {"country": "Moldova", "continent": "Europe"},
                {"country": "Madagascar", "continent": "Africa"},
                {"country": "Maldives", "continent": "Asia"},
                {"country": "Mexico", "continent": "North America"},
                {"country": "Marshall Islands", "continent": "Oceania"},
                {"country": "Macedonia", "continent": "Europe"},
                {"country": "Mali", "continent": "Africa"},
                {"country": "Malta", "continent": "Europe"},
                {"country": "Myanmar", "continent": "Asia"},
                {"country": "Mongolia", "continent": "Asia"},
                {"country": "Northern Mariana Islands", "continent": "Oceania"},
                {"country": "Mozambique", "continent": "Africa"},
                {"country": "Mauritania", "continent": "Africa"},
                {"country": "Montserrat", "continent": "North America"},
                {"country": "Martinique", "continent": "North America"},
                {"country": "Mauritius", "continent": "Africa"},
                {"country": "Malawi", "continent": "Africa"},
                {"country": "Malaysia", "continent": "Asia"},
                {"country": "Mayotte", "continent": "Africa"},
                {"country": "Namibia", "continent": "Africa"},
                {"country": "New Caledonia", "continent": "Oceania"},
                {"country": "Niger", "continent": "Africa"},
                {"country": "Norfolk Island", "continent": "Oceania"},
                {"country": "Nigeria", "continent": "Africa"},
                {"country": "Nicaragua", "continent": "North America"},
                {"country": "Niue", "continent": "Oceania"},
                {"country": "Netherlands", "continent": "Europe"},
                {"country": "Norway", "continent": "Europe"},
                {"country": "Nepal", "continent": "Asia"},
                {"country": "Nauru", "continent": "Oceania"},
                {"country": "New Zealand", "continent": "Oceania"},
                {"country": "Oman", "continent": "Asia"},
                {"country": "Pakistan", "continent": "Asia"},
                {"country": "Panama", "continent": "North America"},
                {"country": "Pitcairn", "continent": "Oceania"},
                {"country": "Peru", "continent": "South America"},
                {"country": "Philippines", "continent": "Asia"},
                {"country": "Palau", "continent": "Oceania"},
                {"country": "Papua New Guinea", "continent": "Oceania"},
                {"country": "Poland", "continent": "Europe"},
                {"country": "Puerto Rico", "continent": "North America"},
                {"country": "North Korea", "continent": "Asia"},
                {"country": "Portugal", "continent": "Europe"},
                {"country": "Paraguay", "continent": "South America"},
                {"country": "Palestine", "continent": "Asia"},
                {"country": "French Polynesia", "continent": "Oceania"},
                {"country": "Qatar", "continent": "Asia"},
                {"country": "Reunion", "continent": "Africa"},
                {"country": "Romania", "continent": "Europe"},
                {"country": "Russian Federation", "continent": "Europe"},
                {"country": "Rwanda", "continent": "Africa"},
                {"country": "Saudi Arabia", "continent": "Asia"},
                {"country": "Sudan", "continent": "Africa"},
                {"country": "South Sudan", "continent": "Africa"},
                {"country": "Senegal", "continent": "Africa"},
                {"country": "Singapore", "continent": "Asia"},
                {"country": "South Georgia and the South Sandwich Islands", "continent": "Antarctica"},
                {"country": "Saint Helena", "continent": "Africa"},
                {"country": "Svalbard and Jan Mayen", "continent": "Europe"},
                {"country": "Solomon Islands", "continent": "Oceania"},
                {"country": "Sierra Leone", "continent": "Africa"},
                {"country": "El Salvador", "continent": "North America"},
                {"country": "San Marino", "continent": "Europe"},
                {"country": "Somalia", "continent": "Africa"},
                {"country": "Saint Pierre and Miquelon", "continent": "North America"},
                {"country": "Sao Tome and Principe", "continent": "Africa"},
                {"country": "Suriname", "continent": "South America"},
                {"country": "Slovakia", "continent": "Europe"},
                {"country": "Slovenia", "continent": "Europe"},
                {"country": "Sweden", "continent": "Europe"},
                {"country": "Swaziland", "continent": "Africa"},
                {"country": "Seychelles", "continent": "Africa"},
                {"country": "Syria", "continent": "Asia"},
                {"country": "Turks and Caicos Islands", "continent": "North America"},
                {"country": "Chad", "continent": "Africa"},
                {"country": "Togo", "continent": "Africa"},
                {"country": "Thailand", "continent": "Asia"},
                {"country": "Tajikistan", "continent": "Asia"},
                {"country": "Tokelau", "continent": "Oceania"},
                {"country": "Turkmenistan", "continent": "Asia"},
                {"country": "East Timor", "continent": "Asia"},
                {"country": "Tonga", "continent": "Oceania"},
                {"country": "Trinidad and Tobago", "continent": "North America"},
                {"country": "Tunisia", "continent": "Africa"},
                {"country": "Turkey", "continent": "Asia"},
                {"country": "Tuvalu", "continent": "Oceania"},
                {"country": "Taiwan", "continent": "Asia"},
                {"country": "Tanzania", "continent": "Africa"},
                {"country": "Uganda", "continent": "Africa"},
                {"country": "Ukraine", "continent": "Europe"},
                {"country": "United States Minor Outlying Islands", "continent": "Oceania"},
                {"country": "Uruguay", "continent": "South America"},
                {"country": "United States", "continent": "North America"},
                {"country": "Uzbekistan", "continent": "Asia"},
                {"country": "Holy See (Vatican City State)", "continent": "Europe"},
                {"country": "Saint Vincent and the Grenadines", "continent": "North America"},
                {"country": "Venezuela", "continent": "South America"},
                {"country": "British Virgin Islands", "continent": "North America"},
                {"country": "United States Virgin Islands", "continent": "North America"},
                {"country": "Vietnam", "continent": "Asia"},
                {"country": "Vanuatu", "continent": "Oceania"},
                {"country": "Wallis and Futuna", "continent": "Oceania"},
                {"country": "Samoa", "continent": "Oceania"},
                {"country": "Yemen", "continent": "Asia"},
                {"country": "Yugoslavia", "continent": "Europe"},
                {"country": "South Africa", "continent": "Africa"},
                {"country": "Zambia", "continent": "Africa"},
                {"country": "Zimbabwe", "continent": "Africa"}
            ];

            //initial values
            var areaData = [{
                "id": "africa",
                "title": "Africa",
                "color": "#c1baba"
            }, {
                "id": "asia",
                "title": "Asia",
                "color": "#c1baba"
            }, {
                "id": "australia",
                "title": "Australia",
                "color": "#c1baba"
            }, {
                "id": "europe",
                "title": "Europe",
                "color": "#c1baba"
            }, {
                "id": "north_america",
                "title": "North America",
                "color": "#c1baba"
            }, {
                "id": "south_america",
                "title": "South America",
                "color": "#c1baba"
            }];

            var graphData = {!! $productStatGeo->content !!};

            if (graphData.includes('Worldwide')) {
                areaData.forEach(function (item) {
                    item.color = "#ff664a";
                });
            } else {
                graphData.forEach(function (item) {

                    //search by continents
                    areaData.forEach(function (point) {
                        if (item == point.title)
                            point.color = "#ff664a";
                    });

                    //search by countries
                    countriesByContinent.some(function (entry) {
                        if (entry.country == item) {

                            areaData.forEach(function (item) {
                                if (item.title == entry.continent)
                                    item.color = "#ff664a";
                            });
                        }
                    });
                });


            }


            var map = AmCharts.makeChart("chartdiv", {

                "type": "map",
                "theme": "light",

                "dragMap": false,
                "projection": "eckert3",

                "areasSettings": {
                    "autoZoom": false,
                    "rollOverColor": undefined,
                    "rollOverOutlineColor": "#db6c53",
                    "outlineAlpha": 1,
                    "outlineColor": "#FFFFFF",
                    "outlineThickness": 1,
                    "color": "#000000"
                },

                "dataProvider": {
                    "map": "continentsLow",

                    "areas": areaData
                },
                "zoomControl": {
                    "panControlEnabled": false,
                    "zoomControlEnabled": false,
                    "homeButtonEnabled": false
                },
                "export": {
                    "enabled": false
                }

            });
    </script>
    @endpush
@endif