@extends('layouts.mail')

@section('title', 'Tak for din ordre hos TakeDaily') <!-- todo translate -->
@section('summary', 'Din ordrebekræftelse fra TakeDaily') <!-- todo translate -->

@section('content')
	@if( isset($giftcard) && !is_null($giftcard) )
		<h3 style="font-family: 'Open Sans',sans-serif; font-size: 18px;">Gavekort</h3>
		<p class="size-14" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 14px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;'>
			Gavekortets kode er: <strong>{{ $giftcard }}</strong>
			<br/>
			For at indløse det, skal indløseren besøge denne side:
			<a href="{{ URL::to('gc', [ 'token' => $giftcard ]) }}" targe="_blank">{{ URL::to('gc', [ 'token' => $giftcard ]) }}</a> og gennemføre ordren som
			normalt.
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
		<h3 style="font-family: 'Open Sans',sans-serif; font-size: 18px;">TakeDaily kodeord</h3>
		<p class="size-14" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 14px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;'>
			Dit kodeord til TakeDaily er: <strong>{{ $password }}</strong>
		</p>
	@endif

	<p class="size-16" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 16px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;text-align: center;'>
		Mvh.<br/>
		TakeDaily
	</p>
@endsection