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
        <td>{{ $signup17 = \App\Plan::getSignupsCountry(sprintf('%02d', $key), 2017, $country) }}</td>
        <td class="text-center">{{ $signup17 }}  <br/>(100%)<br/>
            <b>Rev. </b>  <br/>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsCountryRevenue(sprintf('%02d', $key), 2017, $country),2) }}
            <br/>

            <b>ARPU</b>
            <br/>
            @if($signup17 != 0)
                {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsCountryRevenue(sprintf('%02d', $key), 2017, $country) / $signup17, 2)  }}
            @else
                0
            @endif
        </td>
        @foreach(range($key,\Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01' ))) as $y)
            <td class="text-center">
                @if($y >= $key)
                    {{ $cohorts17 = \App\Plan::getCohortsCountry(sprintf('%02d', $key),sprintf('%02d', $y), 2017, $country)->customers}}<br/>
                    ({{\App\Plan::getCohortsCountry(sprintf('%02d', $key),sprintf('%02d', $y), 2017, $country)->cohorts}}%)
                    <br/>
                    <b>Rev.</b>
                    <br/>
                    {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getCohortsCountryRevenue(sprintf('%02d', $key),sprintf('%02d', $y), 2017, $country), 2)}}
                    <br/>
                    <b>ARPU</b>
                    <br/>
                    @if($cohorts17 == 0)
                        0
                    @else
                        {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getCohortsCountryRevenue(sprintf('%02d', $key),sprintf('%02d', $y), 2017,$country) / $cohorts17, 2)  }}
                    @endif

                @endif
            </td>
        @endforeach
    </tr>

@endforeach
@foreach(trans('flow.datepicker.months_long') as $key2=>$month2)

    <tr>
        <td>{{$month2}} {{\Date::now()->format('Y')}}</td>
        <td>{{ $signup18 = \App\Plan::getSignupsCountry(sprintf('%02d', $key2), 2018, $country) }}</td>
        <td class="text-center">{{ $signup18 }}  <br/>(100%)
            <br/>
            <b>Rev. </b> <br/> {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsCountryRevenue(sprintf('%02d', $key), 2018, $country),2) }}
            <br/>
            <b>ARPU</b>
            <br/>
            @if($signup18 != 0)

                {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsCountryRevenue(sprintf('%02d', $key), 2018, $country) / $signup18, 2)  }}
            @else
                0
            @endif
        </td>
        @foreach(range($key2,\Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01' ))) as $y2)
            <td class="text-center">
                @if($y2 >= $key2 and $y2 <= (int)date('m') )
                    {{ $cohorts18 = \App\Plan::getCohortsCountry(sprintf('%02d', $key2),sprintf('%02d', $y2), 2018, $country)->customers}}
                    ({{\App\Plan::getCohortsCountry(sprintf('%02d', $key),sprintf('%02d', $y), 2018, $country)->cohorts}}%)
                    <br/>
                    <b>Rev.</b>
                    <br/>
                    {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getCohortsCountryRevenue(sprintf('%02d', $key),sprintf('%02d', $y), 2018, $country),2)}}
                    <b>ARPU</b>
                    <br/>
                    @if($cohorts18 == 0)
                        0
                    @else
                        {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getCohortsCountryRevenue(sprintf('%02d', $key),sprintf('%02d', $y), 2018,$country) / $cohorts18, 2)  }}
                    @endif

                @endif
            </td>
        @endforeach
    </tr>

@endforeach