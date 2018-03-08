@extends('layouts.admin')

@section('content')

    <div class="module">
        <div class="module-head">
            <h4>Cohorts</h4>

        </div>


        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active">
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
                                        <option value="4">All</option>
                                        <option value="DKK">Denmark</option>
                                        <option value="EUR">Netherlands</option>
                                    </select>
                                </td>
                                <td>
                                    {{ csrf_field() }}
                                    <button type="submit" style="float:right" class="btn btn-success">CSV</button>
                                </td>
                            </tr>

                        </form>

                        </thead>
                    </table>
                    <table cellpadding="0" cellspacing="0" border="0"
                           class="datatable-1 table table-bordered table-striped display" width="100%">
                        <tbody id="4" class="cohorts">
                        <tr>
                            <td></td>
                            <td></td>

                            @foreach(range(0,\Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01' ))) as $number)
                                <td>{{$number}}</td>
                            @endforeach

                        </tr>

                        @foreach(trans('flow.datepicker.months_long') as $key=>$month)

                            <tr>
                                <td>{{$month}} {{\Date::now()->subYear()->format('Y')}}</td>
                                <td>{{ $signup17 = \App\Plan::getSignups(sprintf('%02d', $key), 2017) }}

                                </td>
                                <td class="text-center">{{ $signup17 }} <br/>(100%)
                                    <br/>
                                    <b>Rev. </b>
                                    <br/>{{ $rev17 = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsRevenue(sprintf('%02d', $key),sprintf('%02d', $key), 2017),2) }}
                                    <br/>
                                    <b>Users billed</b>
                                    <br/>
                                    {{$signup17}}
                                    <br/>
                                    <b>ARPU</b>
                                    <br/>
                                    @if($signup17 != 0)
                                        {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017) / $signup17, 2)  }}
                                    @else
                                        0
                                    @endif
                                </td>
                                @foreach(range($key,\Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01' ))) as $y)
                                    <td class="text-center">
                                        @if($y >= $key)
                                           <?php
                                            $cohorts17 = \App\Plan::getCohorts(sprintf('%02d', $key),sprintf('%02d', $y), 2017, $signup17);
                                            ?>
                                            {{ $cohorts17->customers}}
                                            <br/>
                                            ({{$cohorts17->cohorts}}
                                            %)
                                            <br/>
                                            <b>Rev.</b>
                                            <br/>
                                            <?php
                                               $revc17 = \App\Plan::getCohortsRevenue(sprintf('%02d', $key),sprintf('%02d', $y), 2017);
                                            ?>
                                            {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($revc17, 2)}}
                                            <br/>
                                            <b>Users billed</b>
                                            <br/>
                                               <?php
                                               $arpu = \App\Plan::getCohortsArpu(sprintf('%02d', $key),sprintf('%02d', $y), 2017, $revc17);
                                               ?>
                                            {{$arpu->count}}
                                            <br/>
                                            <b>ARPU</b>
                                            <br/>
                                            @if($cohorts17->customers == 0)
                                                0
                                            @else
                                                {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($arpu->rev, 2)  }}
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                        @endforeach
                        @foreach(trans('flow.datepicker.months_long') as $key2=>$month2)

                            <tr>
                                <td>{{$month2}} {{\Date::now()->format('Y')}}</td>
                                <td>{{ $signup18 = \App\Plan::getSignups(sprintf('%02d', $key2), 2018) }}</td>
                                <td class="text-center">{{ $signup18 }}<br/> (100%) <br/>
                                    <b>Rev. </b>
                                    <br/>{{ $rev18 = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018),2) }}
                                    <br/>
                                    <b>Users billed</b>
                                    <br/>
                                    {{$signup18}}
                                    <br/>
                                    <b>ARPU</b>
                                    <br/>
                                    @if($signup18 != 0)
                                        {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018) / $signup18, 2)  }}
                                    @else
                                        0
                                    @endif
                                </td>
                                @foreach(range($key2,\Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01' ))) as $y2)
                                    <td class="text-center">
                                        @if($y2 >= $key2 and $y2 <= (int)date('m') )
                                            <?php
                                            $cohorts18 = \App\Plan::getCohorts(sprintf('%02d', $key2),sprintf('%02d', $y2), 2018, $signup18);
                                            ?>
                                            {{ $cohorts18->customers}}
                                            <br/>
                                            ({{ $cohorts18->cohorts}}
                                            %)
                                            <br/>
                                            <b>Rev.</b>
                                            <br/>
                                            <?php
                                                $revc18=\App\Plan::getCohortsRevenue(sprintf('%02d', $key2),sprintf('%02d', $y2), 2018)
                                            ?>
                                            {{  \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($revc18, 2)}}
                                            <br/>
                                            <b>Users billed</b>
                                            <br/>
                                            <?php
                                            $arpu2018 = \App\Plan::getCohortsArpu(sprintf('%02d', $key2),sprintf('%02d', $y2), 2018,$revc18);
                                            ?>
                                            {{$arpu2018->count}}
                                            <br/>
                                            <b>ARPU</b>
                                            <br/>
                                            @if($cohorts18->customers == 0)
                                                0
                                            @else
                                                {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($arpu2018->rev, 2)  }}
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                        @endforeach
                        </tbody>


                        <tbody id="6" class="cohorts hidden">

                        </tbody>


                    </table>

                </div>
            </div>
        </div>
    </div>
    {{ csrf_field() }}
@stop

@section('scripts')
    <script>

        $('.change-cohorts').on('change', function () {
            $('.cohorts').addClass('hidden');
            if ($(this).val() != 4) {
                $('#6').html('<div class="text-center"><img src="/images/loading.gif"</div>');
                $.ajax({
                    url: '{{  URL::action('Dashboard\StatsController@getCohortsCountry')}}',
                    type: 'POST',
                    data: {country: $(this).val()},
                    headers: {
                        'X-CSRF-TOKEN': $('body').find('[name="_token"]').val()
                    },
                    success: function (response) {
                        $('#6').html(response);
                    }
                });
                $('#6').removeClass('hidden');
            } else {
                $('#' + $(this).val()).removeClass('hidden');
            }
        });


    </script>
@endsection