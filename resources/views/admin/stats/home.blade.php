@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h4>Statistics</h4>

        </div>

        <div class="module-body table">



            <form class="stat-form" method="POST">
                <table cellpadding="0" cellspacing="0" border="0"
                       class="datatable-1 table table-bordered table-striped	display" width="100%">
                    <thead>
                    <tr>
                        <td>Please choose category</td>
                        <td>Please choose date</td>
                        <td>Amount</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <select name="stat_category">
                                <option value="1">New signups</option>
                                <option value="2">Postponed users</option>
                                <option value="3">Billed second time</option>
                                <option value="4">Churned users</option>
                            </select>
                        </td>

                        <td>
                            <input type="text" class="form-control datepicker" name="start-date" id="start-picker"
                                   placeholder="Start date" value="{{\Date::now()->subDays(30)->format('Y-m-d')}}"/> -
                            <input type="text" class="form-control datepicker" name="end-date" id="end-picker"
                                   placeholder="End date" value="{{\Date::now()->format('Y-m-d')}}"/>
                            <button class="btn btn-success stats-ok">Go</button>
                            {{ csrf_field() }}
                        </td>
                        <td>
                    <div class="result"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <br/>
            <table cellpadding="0" cellspacing="0" border="0"
                            class="datatable-1 table table-bordered table-striped	display" width="100%">
                <tbody>
                <tr>
                    <td>
                        <h5>All aktive kunder</h5>
                    </td>

                    <td style="width:50%; text-align: center">
                        {{ $active_user  }}
                    </td>
                    <td>
                        <form style="float: right" class="csv-forms" action="{{ URL::action('Dashboard\StatsController@exportCsv') }}" method="POST">
                            {{ csrf_field() }}
                        <select name="lang" id="input_states" style="width: 100px; margin-right:20px">
                            <option value="nl" selected="selected" >Dutch</option>
                            <option value="da" >Denmark</option>
                        </select>

                            <button style="float: right" class="btn btn-success">Download CSV</button>
                            </form>
                    </td>
                </tr>
                </tbody>
            </table>
                <br/>
            <form class="csv-form" action="{{ URL::action('Dashboard\StatsController@exportCsvDate') }}" method="POST">
            {{ csrf_field() }}
            <table cellpadding="0" cellspacing="0" border="0"
                   class="datatable-1 table table-bordered table-striped	display" width="100%">
                <tbody>
                <tr>
                    <td>
                        <select name="csv-category">
                            <option value="1">Aktive kunder with time</option>
                            <option value="2">All unsubscribe with time</option>
                            <option value="3">Unsubscribe with other reason</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control datepicker" style="width:120px" name="start_date" id="start_picker"
                               placeholder="Start date" value="{{\Date::now()->subDays(30)->format('Y-m-d')}}"/> -
                        <input type="text" style="width:120px" class="form-control datepicker" name="end_date" id="end_picker"
                               placeholder="End date" value="{{\Date::now()->format('Y-m-d')}}"/>
                    </td>
                    <td>
                        <select name="lang" id="input_state" style="width:100px">
                            <option value="nl" selected="selected" >Dutch</option>
                            <option value="da" >Denmark</option>
                        </select>
                    </td>

                    <td>
                        <button style="float: right" class="btn btn-success">Download CSV</button>
                    </td>
                </tr>
                </tbody>
            </table>
            </form>

            <br/>
            <form class="reason-form" action="" method="POST">
                {{ csrf_field() }}
                <table cellpadding="0" cellspacing="0" border="0"
                       class="datatable-1 table table-bordered table-striped	display" width="100%">
                    <tbody>
                    <tr>
                        <td>
                            <h5>Unsubscribe reason with time</h5>
                        </td>
                        <td>
                            <input type="text" class="form-control datepicker" style="width:150px" name="start_dates" id="start_pickers"
                                   placeholder="Start date" value="{{\Date::now()->subDays(30)->format('Y-m-d')}}"/> -
                            <input type="text" style="width:150px" class="form-control datepicker" name="end_dates" id="end_pickers"
                                   placeholder="End date" value="{{\Date::now()->format('Y-m-d')}}"/>
                        </td>
                        <td>
                            <select name="lang" id="input_state" style="width:100px">
                                <option value="EUR" selected="selected" >Dutch</option>
                                <option value="DKK" >Denmark</option>
                            </select>
                        </td>

                        <td>
                            <button style="float: right" class="btn btn-success pie-reason">Show me</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>

            <div class="pie-chart" id="piechart" style="height:400px">

            </div>
        </div>
    </div><!--/.module-->
@stop

@section('scripts')
    <script>
        $('.pie-chart').hide();
        function Charts(reason){
            Highcharts.chart('piechart', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Unsubscribe reason'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Percent',
                    colorByPoint: true,
                    data: reason
                }]
            });
        }


        $(function () {
            $('.datepicker').datepicker({
                dateFormat: "yy-mm-dd"
            });

            $('.pie-reason').on('click', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    data: $('form.reason-form').serialize(),
                    url: '{{ route("reason") }}',
                    success: function (data) {
                        console.log(data);
                        $('.pie-chart').show();
                        Charts(data);

                    }

                });
            });

            $('.stats-ok').on('click', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    data: $('form.stat-form').serialize(),
                    url: '{{ route("stats-post") }}',
                    success: function (data) {
                        $('.result').html(data);
                    }

                });
            });


        });


    </script>
@endsection