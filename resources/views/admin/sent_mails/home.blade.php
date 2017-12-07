@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Sent mails</h3>
        </div>

        <div class="module-option clearfix">
            <div class="pull-right">

            </div>
        </div>

        <div class="module-body table">
            <div id="pie-chart">

            </div>
        </div>
    </div><!--/.module-->
@stop

@section('scripts')
    <script>

//        Charts(data);
//
//        function Charts(reason) {
//            Highcharts.chart('piechart', {
//                chart: {
//                    plotBackgroundColor: null,
//                    plotBorderWidth: null,
//                    plotShadow: false,
//                    type: 'pie'
//                },
//                title: {
//                    text: 'Unsubscribe reason'
//                },
//                tooltip: {
//                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
//                },
//                plotOptions: {
//                    pie: {
//                        allowPointSelect: true,
//                        cursor: 'pointer',
//                        dataLabels: {
//                            enabled: true,
//                            format: '<b>{point.percentage:.1f} %</b>',
//                            style: {
//                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
//                            }
//                        },
//                        showInLegend: true
//                    }
//                },
//                series: [{
//                    name: 'Percent',
//                    colorByPoint: true,
//                    data: reason
//                }]
//            });
//        }

Highcharts.chart('pie-chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: [
            @foreach(range(6,0) as $i)
             '{{\App\Apricot\Helpers\SentMailHelper::getDate($i)}}',
            @endforeach
        ]
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total sent mails'
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
    series: [{
        name: 'Registration',
        data: [
            @foreach(range(6,0) as $i)
            {{\App\Apricot\Helpers\SentMailHelper::getCountMail($i,1)}},
            @endforeach
        ]
    }, {
        name: 'Email with giftcard',
        data: [
            @foreach(range(6,0) as $i)
            {{\App\Apricot\Helpers\SentMailHelper::getCountMail($i,2)}},
            @endforeach
        ]
    }, {
        name: 'Unsuccessful payment',
        data: [
            @foreach(range(6,0) as $i)
            {{\App\Apricot\Helpers\SentMailHelper::getCountMail($i,3)}},
            @endforeach
        ]
    }, {
        name: 'Postpone mail',
        data: [
            @foreach(range(6,0) as $i)
            {{\App\Apricot\Helpers\SentMailHelper::getCountMail($i,4)}},
            @endforeach
        ]
    }, {
        name: 'Cancel mail',
        data: [
            @foreach(range(6,0) as $i)
            {{\App\Apricot\Helpers\SentMailHelper::getCountMail($i,5)}},
            @endforeach
        ]
    }

    ]
});


        if ($('.datatable-1').length > 0)
        {
            $('.datatable-1').dataTable({
                "columnDefs": [
                    {
                        "targets": [2,3,4],
                        "searchable": false
                    }
                ]
            });
            $('.dataTables_paginate').addClass('btn-group datatable-pagination');
            $('.dataTables_paginate > a').wrapInner('<span />');
            $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
            $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
        }
    </script>
@endsection