@extends($layout)

@section('title', trans('mails.order.receipt-title'))
@section('summary', trans('mails.order.summary'))

@section('content')

    <table class="size-14" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;font-style: normal;font-weight: 400;color: #60666d;">
        <tbody>
        <tr>
            <td style="width:50%; text-align: left"><b>
                    {!! trans('account.transaction.header', ['id' => $order->getPaddedId()]) !!}
                </b></td>
            <td style="width:50%; text-align: right" ><b>{{ trans('account.transactions.table.date') }}:</b>
                {{\Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y')}}</td>
        </tr>
        <tr>
            <td colspan="2" style="height:20px;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 7px;"><strong>{{ trans('mails.order.overview.description') }}</strong></td>
            <td style="border: 1px solid #ddd; padding: 7px;"><strong>{{ trans('account.transaction.table.headers.amount') }}</strong></td>

        @foreach($order->lines as $line)
            <tr>
                <td style="border: 1px solid #ddd; padding: 7px;"><b>{{ trans("products.{$line->description}") }}</b><br/>
                    @if($order->getVitamins())
                        @foreach($order->getVitamins() as $vitamin)
                            {{ \App\Apricot\Helpers\PillName::get(strtolower(\App\Vitamin::remember(60)->find($vitamin)->code)) }}
                            <br/>
                        @endforeach
                    @else
                        Not found vitamins
                    @endif</td>
                {{--<td>{{ $coupon }}</td>--}}
                <td style="border: 1px solid #ddd; padding: 7px;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($line->total_amount, true) }} {{ $order->currency }}</td>
            </tr>
        @endforeach
        <tr>
            <td style="border: 1px solid #ddd; padding: 7px;">{{ trans('account.transaction.table.totals.subtotal') }}</td>
            <td style="border: 1px solid #ddd; padding: 7px;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->sub_total, true) }}
                {{ $order->currency }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 7px;">{{ trans('account.transaction.table.totals.shipping') }}</td>
            <td style="border: 1px solid #ddd; padding: 7px;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->total_shipping, true) }}
                {{ $order->currency }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 7px;">{{ trans('account.transaction.table.totals.taxes') }}</td>
            <td style="border: 1px solid #ddd; padding: 7px;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->total_taxes, true) }}
                {{ $order->currency }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 7px;"><b>{{ trans('account.transaction.table.headers.total') }}</b></td>
            <td style="border: 1px solid #ddd; padding: 7px;"><b>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->total, true) }}
                    {{ $order->currency }}</b>
            </td>
        </tr>
        </tbody>
    </table>
    <br/>
    <h3>{{ trans('account.transactions.header') }}</h3>
    <table class="size-14" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;font-style: normal;font-weight: 400;font-family: 'Open Sans',sans-serif;color: #60666d;">
        <thead>
        <tr>
            <th style="border: 1px solid #ddd; padding: 7px;">#</th>
            <th style="border: 1px solid #ddd; padding: 7px;">{{ trans('account.transactions.table.date') }}</th>
            <th style="border: 1px solid #ddd; padding: 7px;">{{ trans('account.transactions.table.amount') }}</th>

        </tr>
        </thead>
        <tbody>

        <tr>
            <td style="border: 1px solid #ddd; padding: 7px;" data-th="#">#{{ $order->getPaddedId() }}</td>
            <td style="border: 1px solid #ddd; padding: 7px;" data-th="{{ trans('account.transactions.table.date') }}">{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
            <td style="border: 1px solid #ddd; padding: 7px;" data-th="{{ trans('account.transactions.table.amount') }}">
                <strong>{{ trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true), 'currency' => $order->currency]) }}</strong>
            </td>
        </tr>
        </tbody>
    </table>
    <br/>
    <h3>{{ trans('account.settings_basic.header') }}</h3>

    <p style="text-align:left;color:#000; margin: 0"><b>{{ trans('checkout.index.order.info.email') }}:</b> {{$order->customer->getEmail()}}</p>
    <p style="text-align:left;color:#000; margin: 0"><b>{{ trans('checkout.index.order.info.phone-text') }}:</b> {{$order->customer->getPhone()}}</p>

    <br/>
    <p style="text-align:left;color:#000; margin: 0"><b>{{ trans('account.transaction.title-shipping') }}</b></p>
    <p style="text-align:left;color:#000; margin: 0">@if($order->shipping_company != '')
            {{ $order->shipping_company }}<br/>
            c/o: {{ $order->shipping_name }}<br/>
        @else
            {{ $order->shipping_name }}<br/>
        @endif
        {{ $order->customer->getCustomerAttribute('address_line1') }}
        @if($order->customer->getCustomerAttribute('address_number') !=='')
            {{$order->customer->getCustomerAttribute('address_number')}}
        @endif
        <br/>
        {{ $order->shipping_city }}, {{ $order->shipping_zipcode }}<br/>
        {{ trans('countries.' . $order->shipping_country) }}<br/></p>
@endsection