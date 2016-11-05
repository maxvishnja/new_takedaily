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

	<h3 style="font-family: 'Open Sans',sans-serif; font-size: 18px;">Ordreoversigt</h3>
	<table class="size-14" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;font-style: normal;font-weight: 400;font-size: 14px;line-height: 24px;font-family: 'Open Sans',sans-serif;color: #60666d;">
		<tbody>
		<tr>
			<td style="border: 1px solid #ddd; padding: 7px;"><strong>Bestilling</strong></td>
			<td style="border: 1px solid #ddd; padding: 7px;">{{ $description }}</td>
		</tr>
		<tr>
			<td style="border: 1px solid #ddd; padding: 7px;"><strong>Subtotal</strong></td>
			<td style="border: 1px solid #ddd; padding: 7px;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($priceSubtotal, true) }} DKK</td>
		</tr>
		<tr>
			<td style="border: 1px solid #ddd; padding: 7px;"><strong>Moms</strong></td>
			<td style="border: 1px solid #ddd; padding: 7px;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($priceTaxes, true) }} DKK</td>
		</tr>
		<tr>
			<td style="border: 1px solid #ddd; padding: 7px;"><strong>Beløb i alt</strong></td>
			<td style="border: 1px solid #ddd; padding: 7px;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($priceTotal, true) }} DKK</td>
		</tr>
		</tbody>
	</table>

	@if( isset($password) && !is_null($password) )
		<h3 style="margin-top: 20px;font-family: 'Open Sans',sans-serif; font-size: 18px;">TakeDaily kodeord</h3>
		<p class="size-14" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 14px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;'>
			Dit kodeord til TakeDaily er: <strong>{{ $password }}</strong>
		</p>
	@endif
@endsection