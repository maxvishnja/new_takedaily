@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h4>Statistics</h4>

        </div>
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#stats" data-toggle="tab">Other stat</a></li>
            <li class=""><a href="#cohorts" data-toggle="tab">Cohorts</a></li>
            <li class=""><a href="#cohorts-coupon" style="display:none" data-toggle="tab">Cohorts Coupon</a></li>

        </ul>


        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active " id="stats">
                <div class="module-body table">
                    {{--<form class="stat-form" method="POST">--}}
                    {{--<table cellpadding="0" cellspacing="0" border="0"--}}
                    {{--class="datatable-1 table table-bordered table-striped display" width="100%">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                    {{--<td>Please choose category</td>--}}
                    {{--<td>Please choose date</td>--}}
                    {{--<td>Amount</td>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--<tr>--}}
                    {{--<td>--}}
                    {{--<select name="stat_category">--}}
                    {{--<option value="1">New signups</option>--}}
                    {{--<option value="2">Postponed users</option>--}}
                    {{--<option value="3">Billed second time</option>--}}
                    {{--<option value="4">Churned users</option>--}}
                    {{--<option value="5">Free TD</option>--}}
                    {{--</select>--}}
                    {{--</td>--}}

                    {{--<td>--}}
                    {{--<input type="text" class="form-control datepicker" name="start-date"--}}
                    {{--id="start-picker"--}}
                    {{--placeholder="Start date"--}}
                    {{--value="{{\Date::now()->subDays(30)->format('Y-m-d')}}"/> ---}}
                    {{--<input type="text" class="form-control datepicker" name="end-date" id="end-picker"--}}
                    {{--placeholder="End date" value="{{\Date::now()->addDay()->format('Y-m-d')}}"/>--}}
                    {{--<button class="btn btn-success stats-ok">Go</button>--}}
                    {{--{{ csrf_field() }}--}}
                    {{--</td>--}}
                    {{--<td>--}}
                    {{--<div class="result"></div>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                    {{--</table>--}}
                    {{--</form>--}}
                    {{--<br/>--}}

                    <form class="csv-form stat-form" action="{{ URL::action('Dashboard\StatsController@exportCsvDate') }}"
                          method="POST">
                        {{ csrf_field() }}
                        <table cellpadding="0" cellspacing="0" border="0"
                               class="datatable-1 table table-bordered table-striped	display" width="100%">
                            <thead>
                            <tr>
                                <td>Choose category</td>
                                <td>Choose date</td>
                                <td>Choose language</td>
                                <td>Amount</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">
                                    <select name="csv-category" class="csv-category">
                                        <option value="1">Active cusomers with time</option>
                                        <option value="6">New customers with time</option>
                                        {{--<option value="2">All unsubscribe with time</option>--}}
                                        <option value="3">Unsubscribe with other reason</option>
                                        {{--<option value="5">Unsubscribe from dashboard</option>--}}
                                        {{--<option value="4">Client for X amount of weeks</option>--}}
                                    </select>
                                </td>
                                <td class="visib text-center">
                                    <input type="text" class="form-control datepicker" style="width:120px"
                                           name="start_date" id="start_picker"
                                           placeholder="Start date"
                                           value="{{\Date::now()->subDays(30)->format('Y-m-d')}}"/>
                                    <br/>
                                    <input type="text" style="width:120px" class="form-control datepicker"
                                           name="end_date" id="end_picker"
                                           placeholder="End date" value="{{\Date::now()->format('Y-m-d')}}"/>

                                    <input type="text" value="10" name="weeks" class="form-control weeks"
                                           style="display: none" placeholder="Enter X weeks, ex. 10 or 12">
                                </td>
                                <td class="text-center">
                                    <select name="lang" id="input_state" style="width:100px">
                                        <option value="nl" selected="selected">Dutch</option>
                                        <option value="da">Denmark</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-success stats-ok">Get amount</button>
                                    <br/>
                                    <div class="result" style="margin-top:20px"></div>
                                </td>
                                <td class="text-center">
                                    <button  class="btn btn-success">Download CSV</button>
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
                            <td rowspan="2" style="width:10%;">
                                <h5>All customers</h5>
                            </td>

                            <td rowspan="2"  style="width:10%; text-align: center">
                                {{ $active_user  }}
                            </td>
                            <td style="width:25%;">
                                <div class="text-center">
                                    <form style="float: right" class="csv-forms"
                                          action="{{ URL::action('Dashboard\StatsController@downloadCsv') }}" method="POST">
                                        {{ csrf_field() }}

                                        <input type="text" class="form-control datepicker" style="width:120px"
                                               name="start_date_all_customers" id="start_picker_all_customers"
                                               placeholder="Start date"
                                               value="{{\Date::now()->subDays(30)->format('Y-m-d')}}"/>

                                        <input type="text" style="width:120px" class="form-control datepicker"
                                               name="end_date_all_customers" id="end_picker_all_customers"
                                               placeholder="End date" value="{{\Date::now()->format('Y-m-d')}}"/>

                                        <input type="text" value="10" name="weeks" class="form-control weeks"
                                               style="display: none" placeholder="Enter X weeks, ex. 10 or 12">

                                        <select name="lang" id="input_states" style="width: 100px; margin-right:20px">
                                            <option value="nl" selected="selected">Dutch</option>
                                            <option value="da">Denmark</option>
                                        </select>

                                        <button  class="btn btn-info" id="createCsv">Create CSV</button>
                                        <button  class="btn btn-success" id="downloadCsv">Download CSV</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%;">
                                <div class="text-center">
                                    <form class="csv-forms-all"
                                          action="{{ URL::action('Dashboard\StatsController@downloadCsvAllCustomers') }}" method="POST">
                                        {{ csrf_field() }}

                                        <select name="lang" id="input_states2" style="width: 100px; margin-right:20px">
                                            <option value="nl" selected="selected">Dutch</option>
                                            <option value="da">Denmark</option>
                                        </select><br/>

                                        <button  class="btn btn-info" id="createCsv2">Create CSV</button>
                                        <button  class="btn btn-success" id="downloadCsv2">Download CSV</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <br/>

                    <form class="csv-form" action="{{ URL::action('Dashboard\StatsController@exportDateCoupon') }}"
                          method="POST">
                        {{ csrf_field() }}
                        <table cellpadding="0" cellspacing="0" border="0"
                               class="datatable-1 table table-bordered table-striped	display" width="100%">
                            <tbody>
                            <tr>
                                <td>
                                    <h5>Please choose title of coupon</h5>
                                </td>
                                <td class="visib">

                                    <select name="coupon" id="input_state" >
                                        <option value="" ><b>---Active coupon---</b></option>
                                        <option value="1">Free order</option>
                                        @foreach ($active_coupon as $coupon)
                                            <option value="{{$coupon->code}}">{{$coupon->code}}</option>
                                        @endforeach
                                        <option value="" ><b>---Inactive coupon---</b></option>
                                        @foreach ($inactive_coupon as $incoupon)
                                            <option value="{{$incoupon->code}}">{{$incoupon->code}}</option>
                                        @endforeach
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
                                    <input type="text" class="form-control datepicker" style="width:150px"
                                           name="start_dates" id="start_pickers"
                                           placeholder="Start date"
                                           value="{{\Date::now()->subDays(30)->format('Y-m-d')}}"/> -
                                    <input type="text" style="width:150px" class="form-control datepicker"
                                           name="end_dates" id="end_pickers"
                                           placeholder="End date" value="{{\Date::now()->format('Y-m-d')}}"/>
                                </td>
                                <td>
                                    <select name="lang" id="input_state" style="width:100px">
                                        <option value="EUR" selected="selected">Dutch</option>
                                        <option value="DKK">Denmark</option>
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
            </div>
            <div role="tabpanel" class="tab-pane" id="cohorts">
                <div class="module-body table">
                    <table cellpadding="0" cellspacing="0" border="0"
                           class="datatable-1 table table-bordered table-striped display" width="100%">
                        <thead>
                        <form action="{{ URL::action('Dashboard\StatsController@cohortsToCsv') }}" method="post">
                        <tr>
                            <td>Week/Month</td>
                            <td>Sign.</td>
                            <td colspan="11">
                                <select name="rate" class="change-cohorts">
                                    <option value="4" >Month</option>
                                    <option value="5">Week</option>
                                </select>
                            </td>
                            <td>
                                {{ csrf_field() }}
                                <button type="submit" style="float:right" class="btn btn-success">CSV</button>
                            </td>
                        </tr>

                        </form>

                        </thead>
                        <tbody id="4" class="cohorts">
                        <tr>
                            <td></td>
                            <td></td>

                            <td>0</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12</td>
                        </tr>
                        @foreach(trans('flow.datepicker.months_long') as $key=>$month)

                                <tr>
                                    <td>{{$month}} 2017</td>
                                    <td>{{ \App\Plan::getSignups(sprintf('%02d', $key)) }}</td>
                                    <td>{{ \App\Plan::getSignups(sprintf('%02d', $key)) }} (100%)</td>
                                    @foreach(range($key,12) as $y)
                                        <td class="text-center">
                                            @if($y >= $key and $y <= (int)date('m') )
                                            {{ \App\Plan::getCohorts(sprintf('%02d', $key),sprintf('%02d', $y))}}

                                            @endif
                                        </td>
                                    @endforeach
                                </tr>

                            @endforeach
                        </tbody>

                        <tbody id="5" class="cohorts hidden">
                        <tr>
                            <td></td>
                            <td></td>
                            @foreach(range(0,date('W')) as $val)
                            <td>{{$val}}</td>
                           @endforeach
                        </tr>

                        @foreach(range(0,date('W')-1) as $week)
                            <tr>
                                <td>Week {{$week+1}}</td>
                                <td>{{ \App\Plan::getSignupsWeek(sprintf('%02d', $week)) }}</td>
                                <td>{{ \App\Plan::getSignupsWeek(sprintf('%02d', $week)) }} (100%)</td>
                                @foreach(range(01,date('W')) as $y)
                                    <td class="text-center">

                                        @if(date('W')-$week >= $y)
                                          {{\App\Plan::getCohortsWeek(sprintf('%02d', $week),$week+$y)}}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>

                        </table>

                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="cohorts-coupon">
                <div class="module-body table">
                    <table cellpadding="0" cellspacing="0" border="0"
                           class="datatable-1 table table-bordered table-striped display" width="100%">
                        <thead>
                        <form class="csv-form coupon-form" action="{{ URL::route('coupon-post') }}">
                            {{ csrf_field() }}
                        <input  name="coupon_name" type="text" value="">
                        <button class="btn btn-success stats-coupon" style="float:right">Create Table</button>
                        </form>

                        </thead>
                        <tbody id="4" class="cohorts">
                        <tr>
                            <td></td>
                            <td></td>

                            <td>0</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12</td>
                        </tr>
                        @foreach(trans('flow.datepicker.months_long') as $key=>$month)

                            <tr>
                                <td>{{$month}} 2017</td>
                                <td>{{ \App\Plan::getSignups(sprintf('%02d', $key)) }}</td>
                                <td>{{ \App\Plan::getSignups(sprintf('%02d', $key)) }} (100%)</td>
                                @foreach(range($key,12) as $y)
                                    <td class="text-center">
                                        @if($y >= $key and $y <= (int)date('m') )
                                            {{ \App\Plan::getCohorts(sprintf('%02d', $key),sprintf('%02d', $y))}}

                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                        @endforeach
                        </tbody>

                        {{--<tbody id="5" class="cohorts hidden">--}}
                        {{--<tr>--}}
                            {{--<td></td>--}}
                            {{--<td></td>--}}
                            {{--@foreach(range(0,date('W')) as $val)--}}
                                {{--<td>{{$val}}</td>--}}
                            {{--@endforeach--}}
                        {{--</tr>--}}

                        {{--@foreach(range(0,date('W')-1) as $week)--}}
                            {{--<tr>--}}
                                {{--<td>Week {{$week+1}}</td>--}}
                                {{--<td>{{ \App\Plan::getSignupsWeek(sprintf('%02d', $week)) }}</td>--}}
                                {{--<td>{{ \App\Plan::getSignupsWeek(sprintf('%02d', $week)) }} (100%)</td>--}}
                                {{--@foreach(range(01,date('W')) as $y)--}}
                                    {{--<td class="text-center">--}}

                                        {{--@if(date('W')-$week >= $y)--}}
                                            {{--{{\App\Plan::getCohortsWeek(sprintf('%02d', $week),$week+$y)}}--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                {{--@endforeach--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                        {{--</tbody>--}}

                    </table>

                </div>
            </div>

        </div>


    </div><!--/.module-->
@stop

@section('scripts')
    <script>


        {{--$('.stats-ok').on('click', function (e) {--}}
            {{--e.preventDefault();--}}
            {{--$.ajax({--}}
                {{--type: 'POST',--}}
                {{--data: $('form.stat-form').serialize(),--}}
                {{--url: '{{ route("stats-post") }}',--}}
                {{--success: function (data) {--}}
                    {{--$('.result').html(data);--}}
                {{--}--}}

            {{--});--}}
        {{--});--}}

        $('.stats-coupon').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                data: $('form.coupon-form').serialize(),
                url: '{{ route("coupon-post") }}',
                success: function (data) {
                    $('.result').html(data);
                }

            });
        });


        {{--$('#post-coupon').on('click', function(){--}}
            {{--var coupon = ($('#data-coupon').val());--}}
            {{--console.log(coupon);--}}

            {{--$.ajax({--}}
                {{--url: '{{  URL::action('Dashboard\StatsController@getStatsCustomersFromCoupon')}}',--}}
                {{--type: 'POST',--}}
                {{--data: {coupon: coupon},--}}
                {{--headers: {--}}
                    {{--'X-CSRF-TOKEN': $('form.form-coupon').find('[name="_token"]').val()--}}
                {{--},--}}
                {{--success: function (response) {--}}
                    {{--console.log(response);--}}

                {{--},--}}
                {{--error: function (response) {--}}

                {{--}--}}

            {{--});--}}


        {{--});--}}

        $('.change-cohorts').on('change', function(){

            $('.cohorts').addClass('hidden');
           $('#'+$(this).val()).removeClass('hidden');
        });

        $('.pie-chart').hide();
        function Charts(reason) {
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
                            enabled: true,
                            format: '<b>{point.percentage:.1f} %</b>',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
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

            $('.pie-reason').on('click', function (e) {
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

            $('.stats-ok').on('click', function (e) {
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


            $('#createCsv').on('click', function(e){
               e.preventDefault();
                $.ajax({
                    type: 'POST',
                    data: $('form.csv-forms').serialize(),
                    url: '{{  URL::action('Dashboard\StatsController@exportCsv')}}',
                    success: function (data) {

                    }

                });

                $(this).prop('disabled', true);

            });

            $('#createCsv2').on('click', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    data: $('form.csv-forms-all').serialize(),
                    url: '{{  URL::action('Dashboard\StatsController@exportCsvAllCustomers')}}',
                    success: function (data) {

                    }

                });

                $(this).prop('disabled', true);

            });


            $('.csv-category').on('change', function () {
                if ($('.csv-category').val() == 4) {

                    $('.visib .datepicker').hide();
                    $('.visib .weeks').show();

                } else {

                    $('.visib .datepicker').show();
                    $('.visib .weeks').hide();
                }
            });

            checkCsv2($('#input_states2').val());
            checkCsv($('#input_states').val());

            setInterval(function() {
                checkCsv2($('#input_states2').val());
                checkCsv($('#input_states').val());
            }, 20000);

            $('#input_states').on('change', function(){
                checkCsv($(this).val());
            });

            function checkCsv(lang) {

                $.ajax({
                    url: '{{  URL::action('Dashboard\StatsController@checkCsv')}}',
                    type: 'POST',
                    data: {lang: lang},
                    headers: {
                        'X-CSRF-TOKEN': $('form.csv-forms').find('[name="_token"]').val()
                    },
                    success: function (response) {
                        $('#createCsv').prop('disabled', true);
                        $('#downloadCsv').prop('disabled', false);
                    },
                    error: function (response) {
                        $('#createCsv').prop('disabled', false);
                        $('#downloadCsv').prop('disabled', true);
                    }

                });

            }

            $('#input_states2').on('change', function(){
                checkCsv2($(this).val());
            });

            function checkCsv2(lang) {

                $.ajax({
                    url: '{{  URL::action('Dashboard\StatsController@checkCsvAllCustomers')}}',
                    type: 'POST',
                    data: {lang: lang},
                    headers: {
                        'X-CSRF-TOKEN': $('form.csv-forms-all').find('[name="_token"]').val()
                    },
                    success: function (response) {
                        $('#createCsv2').prop('disabled', true);
                        $('#downloadCsv2').prop('disabled', false);
                    },
                    error: function (response) {
                        $('#createCsv2').prop('disabled', false);
                        $('#downloadCsv2').prop('disabled', true);
                    }

                });

            }

        });


    </script>
@endsection