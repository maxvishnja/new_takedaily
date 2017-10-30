<?php App::setLocale($customer->getLocale()); ?>
<div style="position:relative;  width: 170mm;">

	@if($order->barcode != ' ')
		<p style="position: absolute; top: 1mm; right: 50pt; font-size: 10px">CODE: {{ $order->labelTekst3 }}</p>
		{{--<p style="font-size: 10px; margin-bottom: 10px; text-align: right;">CODE: {{ $order->labelTekst3 }}</p>--}}
		{{--<div style="width: 145px; position: absolute; top: 0pt; right: 25pt;">--}}
		<div style="position: absolute; top: 28pt; right: -10pt; transform: rotate(270deg);">

			<img style="margin: 0px; padding: 0px; width:100px" src="data:image/png;base64, {{ \Milon\Barcode\DNS1D::getBarcodePNG("$order->barcode", "C128",1,33)}}" alt="barcode"   />
			{{--<img style="margin: 0px; padding: 0px;" src="data:image/png;base64, {{ \Milon\Barcode\DNS1D::getBarcodePNG("$order->barcode", "C128",1,33)}}" alt="barcode"   />--}}
			{{--<p style="font-size: 11px; text-align: center">{{ $order->barcode }}</p>--}}
			<p style="font-size: 8px; text-align: center">{{ $order->barcode }}</p>
		</div>
		{{--<span style="position: absolute; top: 20mm; right: 25pt; font-size: 9pt; font-weight: 200; color: #1A8562;">#{{ $order->getPaddedId() }}</span>--}}
		<span style="position: absolute; top: 20mm; right: 50pt; font-size: 9pt; font-weight: 200; color: #1A8562;">#{{ $order->getPaddedId() }}</span>
		{{--<span style="position: absolute; top: 26mm; right: 25pt; font-size: 10px">{{ $order->udsortering }} | {{ $order->labelTekst1 }} | {{ $order->labelTekst2 }}</span>--}}
		<span style="position: absolute; top: 25mm; right: 50pt; font-size: 10px">{{ $order->udsortering }} | {{ $order->labelTekst1 }} | {{ $order->labelTekst2 }}</span>
	@else
		<img style="width: 112pt; height: 59pt; position: absolute; top: 0; right: 25pt;" src="{{ asset('/images/logo-postnl@2x.png') }}"/>
		<span style="position: absolute; top: 26mm; right: 25pt; font-size: 9pt; font-weight: 200; color: #1A8562;">#{{ $order->getPaddedId() }}</span>
	@endif

	<address>
		<img style="width: 100pt; height: 19pt; margin-bottom: 1pt; " src="{{ asset('/images/pdf-logo.png') }}"/>
		<div style="margin-bottom: 4pt; font-size:9pt"><strong>{{ $customer->getName() }}</strong>@if($customer->getCustomerAttribute('company') != '') @if($customer->getLocale() == 'da'), C/o @else - @endif {{ $customer->getCustomerAttribute('company') }}@endif</div>
		<p style="font-size:10pt">{{ $customer->getCustomerAttribute('address_line1') }}, {{ $customer->getCustomerAttribute('address_number') }}<br/>
			@if($customer->getCustomerAttribute('address_line2') != '')
				{{ $customer->getCustomerAttribute('address_line2') }}<br/>
			@endif
			{{ $customer->getCustomerAttribute('address_postal') }}&nbsp;&nbsp;{{ $customer->getCustomerAttribute('address_city') }}<br/>
			{{ ucfirst($customer->getCustomerAttribute('address_country')) }}</p>
	</address>

	<div style="font-size: 8pt; font-weight: 200; margin-left:5pt"><small>{{ trans('label-product.return') }}</small></div>
</div>