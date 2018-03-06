@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>
                Orders within a month</h3>
        </div>
        <div class="module-body">
            <div class="chart inline-legend grid">
                <div id="placeholder10" class="graph" style="height: 300px">
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')


    <script>

        Highcharts.chart('placeholder10', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [
                        @for($i = 0; $i <= date('t'); $i++)
                    ["{{ \Jenssegers\Date\Date::now()->addDays($i)->format('d M') }}"],
                    @endfor
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Forecast order'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 0,
                floating: false,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [
                {
                    name: 'Failed rebills order',
                    data: [
                            @foreach(range(0,date('t')-1) as $i)
                        [ {{ \App\Apricot\Repositories\CustomerRepository::getFutureOrdersDelay(\Jenssegers\Date\Date::now()->addDays($i+1)->format('Y-m-d') ) }} ],
                        @endforeach
                    ],
                    color: 'red'
                },
                {
                    name: 'First rebills order',
                    data: [
                            @foreach(range(0,date('t')-1) as $i)
                        [ {{ \App\Apricot\Repositories\CustomerRepository::getFutureOrders(\Jenssegers\Date\Date::now()->addDays($i+1)->format('Y-m-d') ) }} ],
                        @endforeach
                    ]
                }


            ]
        });


    </script>


@endsection