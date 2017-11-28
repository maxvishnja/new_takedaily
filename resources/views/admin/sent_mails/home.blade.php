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
        text: 'Sent mails'
    },
    xAxis: {
        categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
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
        y: 25,
        floating: true,
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
        name: 'John',
        data: [5, 3, 4, 7, 2]
    }, {
        name: 'Jane',
        data: [2, 2, 3, 2, 1]
    }, {
        name: 'Joe',
        data: [3, 4, 4, 2, 5]
    }]
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