@extends('layouts.mail')

@section('title', trans('mails.order.title'))
@section('summary', trans('mails.order.summary'))

@section('content')
	@if( isset($giftcard) && !is_null($giftcard) )
		<h3 style="font-family: 'Open Sans',sans-serif; font-size: 18px;">{{ trans('mails.order.giftcard.title') }}</h3>
		<p class="size-14" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 14px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;'>
			{{ trans('mails.order.giftcard.code-is') }} <strong>{{ $giftcard }}</strong>
			<br/>
			{{ trans('mails.order.giftcard.to-use') }}
			<a href="{{ URL::to('gc', [ 'token' => $giftcard ]) }}" target="_blank">{{ URL::to('gc', [ 'token' => $giftcard ]) }}</a> {{ trans('mails.order.giftcard.order') }}
		</p>
	@endif

	<h3 style="font-family: 'Open Sans',sans-serif; font-size: 18px;">{{ trans('mails.order.overview.title') }}</h3>
		<p class="size-14" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 14px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;'>
			{!! str_replace('{name}', $name, nl2br(trans('mails.order.text'))) !!}
		</p>
	<table class="size-14" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;font-style: normal;font-weight: 400;font-size: 14px;line-height: 24px;font-family: 'Open Sans',sans-serif;color: #60666d;">
		<tbody>
		<tr>
			<td style="border: 1px solid #ddd; padding: 7px;"><strong>{{ trans('mails.order.overview.description') }}</strong></td>
			<td style="border: 1px solid #ddd; padding: 7px;">{{ $description }}</td>
		</tr>
		<tr>
			<td style="border: 1px solid #ddd; padding: 7px;"><strong>{{ trans('mails.order.overview.subtotal') }}</strong></td>
			<td style="border: 1px solid #ddd; padding: 7px;">{{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat((new \App\Apricot\Helpers\Money($priceSubtotal))->toCurrency(trans('general.currency')), true)]) }}</td>
		</tr>
		<tr>
			<td style="border: 1px solid #ddd; padding: 7px;"><strong>{{ trans('mails.order.overview.taxes') }}</strong></td>
			<td style="border: 1px solid #ddd; padding: 7px;">{{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat((new \App\Apricot\Helpers\Money($priceTaxes))->toCurrency(trans('general.currency')), true)]) }}</td>
		</tr>
		<tr>
			<td style="border: 1px solid #ddd; padding: 7px;"><strong>{{ trans('mails.order.overview.total') }}</strong></td>
			<td style="border: 1px solid #ddd; padding: 7px;">{{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat((new \App\Apricot\Helpers\Money($priceTotal))->toCurrency(trans('general.currency')), true)]) }}</td>
		</tr>
		</tbody>
	</table>
@endsection