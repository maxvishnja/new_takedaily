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
        <td>{{ \App\Plan::getSignupsCountry(sprintf('%02d', $key), 2017, $country) }}</td>
        <td>{{ \App\Plan::getSignupsCountry(sprintf('%02d', $key), 2017, $country) }} (100%)</td>
        @foreach(range($key,\Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01' ))) as $y)
            <td class="text-center">
                @if($y >= $key)
                    {{ \App\Plan::getCohortsCountry(sprintf('%02d', $key),sprintf('%02d', $y), 2017, $country)}}
                @endif
            </td>
        @endforeach
    </tr>

@endforeach
@foreach(trans('flow.datepicker.months_long') as $key2=>$month2)

    <tr>
        <td>{{$month2}} {{\Date::now()->format('Y')}}</td>
        <td>{{ \App\Plan::getSignupsCountry(sprintf('%02d', $key2), 2018, $country) }}</td>
        <td>{{ \App\Plan::getSignupsCountry(sprintf('%02d', $key2), 2018, $country) }} (100%)</td>
        @foreach(range($key2,\Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01' ))) as $y2)
            <td class="text-center">
                @if($y2 >= $key2 and $y2 <= (int)date('m') )
                    {{ \App\Plan::getCohortsCountry(sprintf('%02d', $key2),sprintf('%02d', $y2), 2018, $country)}}
                @endif
            </td>
        @endforeach
    </tr>

@endforeach