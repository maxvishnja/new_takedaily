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

                    <td>
                        {{ $active_user  }}   <a style="float:right" class="btn btn-success" href="{{ URL::action('Dashboard\StatsController@exportCsv') }}">
                            Download CSV</a>
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
                        <h5>Aktive kunder with time</h5>
                    </td>
                    <td>
                        <input type="text" class="form-control datepicker" name="start_date" id="start_picker"
                               placeholder="Start date" value="{{\Date::now()->subDays(30)->format('Y-m-d')}}"/> -
                        <input type="text" class="form-control datepicker" name="end_date" id="end_picker"
                               placeholder="End date" value="{{\Date::now()->format('Y-m-d')}}"/>
                    </td>

                    <td>
                        <button style="float: right" class="btn btn-success">Download CSV</button>
                    </td>
                </tr>
                </tbody>
            </table>
            </form>
        </div>
    </div><!--/.module-->
@stop

@section('scripts')
    <script>
        $(function () {
            $('.datepicker').datepicker({
                dateFormat: "yy-mm-dd"
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