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
            <b>Rev. </b>  <br/>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsCountryRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017, $country),2) }}
            <br/>
            <b>Users billed</b>
            <br/>
            {{$signup17}}
            <br/>

            <b>ARPU</b>
            <br/>
            @if($signup17 != 0)
                {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsCountryRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017, $country) / $signup17, 2)  }}
            @else
                0
            @endif
        </td>
        @foreach(range($key,\Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01' ))) as $y)
            <td class="text-center">
                @if($y >= $key)
                    <?php
                    $cohorts17 = \App\Plan::getCohortsCountry(sprintf('%02d', $key),sprintf('%02d', $y), 2017, $country, $signup17);
                    ?>
                    {{ $cohorts17->customers}}<br/>
                    ({{$cohorts17->cohorts}}%)
                    <br/>
                    <b>Rev.</b>
                    <br/>
                    <?php
                    $revc2017 = \App\Plan::getCohortsCountryRevenue(sprintf('%02d', $key),sprintf('%02d', $y), 2017, $country);
                    ?>
                    {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($revc2017, 2)}}
                    <br/>
                    <b>Users billed</b>
                    <br/>
                    <?php
                    $arpu = \App\Plan::getCohortsCountryArpu(sprintf('%02d', $key),sprintf('%02d', $y), 2017,$country, $revc2017);
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
        <td>{{ $signup18 = \App\Plan::getSignupsCountry(sprintf('%02d', $key2), 2018, $country) }}</td>
        <td class="text-center">{{ $signup18 }}  <br/>(100%)
        <br/>
            <b>Rev. </b> <br/> {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsCountryRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018, $country),2) }}
            <br/>
            <b>Users billed</b>
            <br/>
            {{$signup18}}
            <br/>
            <b>ARPU</b>
            <br/>
            @if($signup18 != 0)

                {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Plan::getSignupsCountryRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018, $country) / $signup18, 2)  }}
            @else
                0
            @endif
        </td>
        @foreach(range($key2,\Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01' ))) as $y2)
            <td class="text-center">
                @if($y2 >= $key2 and $y2 <= (int)date('m') )
                    <?php
                    $cohorts18 = \App\Plan::getCohortsCountry(sprintf('%02d', $key2),sprintf('%02d', $y2), 2018, $country, $signup18);
                    ?>
                    {{ $cohorts18->customers}}
                    ({{$cohorts18->cohorts}}%)
                    <br/>
                    <b>Rev.</b>
                    <br/>
                        <?php
                        $revc2018 = \App\Plan::getCohortsCountryRevenue(sprintf('%02d', $key2),sprintf('%02d', $y2), 2018, $country);
                        ?>
                    <b>Users billed</b>
                    <br/>
                    <?php
                    $arpu2018 = \App\Plan::getCohortsCountryArpu(sprintf('%02d', $key2),sprintf('%02d', $y2), 2018,$country,$revc2018);
                    ?>
                    {{$arpu2018->count}}
                    <br/>
                    {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($revc2018,2)}}
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