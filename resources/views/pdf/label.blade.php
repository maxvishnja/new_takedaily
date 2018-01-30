<?php App::setLocale($customer->getLocale()); ?>

@if($customer->getLocale() == 'nl')
<div style="position:relative;  width: 170mm;">


		<img style="width: 112pt; height: 59pt; position: absolute; top: 0; right: 25pt;" src="{{ asset('/images/logo-postnl@2x.png') }}"/>
		<span style="position: absolute; top: 26mm; right: 25pt; font-size: 9pt; font-weight: 200; color: #1A8562;">#{{ $order->getPaddedId() }}</span>


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
	@else

	<div style="position:relative;  width: 170mm;">

		@if($order->barcode != ' ')

			{{--<p style="font-size: 10px; margin-bottom: 10px; text-align: right;">CODE: {{ $order->labelTekst3 }}</p>--}}
			{{--<div style="width: 145px; position: absolute; top: 0pt; right: 25pt;">--}}
			<div style="position: absolute; top: 20pt; right: -10pt; transform: rotate(270deg);">

				<img style="margin: 0px; padding: 0px; width:140px" src="data:image/png;base64, {{ \Milon\Barcode\DNS1D::getBarcodePNG("$order->barcode", "C128",1,33)}}" alt="barcode"   />
				{{--<img style="margin: 0px; padding: 0px;" src="data:image/png;base64, {{ \Milon\Barcode\DNS1D::getBarcodePNG("$order->barcode", "C128",1,33)}}" alt="barcode"   />--}}
				{{--<p style="font-size: 11px; text-align: center">{{ $order->barcode }}</p>--}}
				<p style="font-size: 12px; text-align: center">{{ $order->barcode }}</p>
			</div>
			{{--<span style="position: absolute; top: 20mm; right: 25pt; font-size: 9pt; font-weight: 200; color: #1A8562;">#{{ $order->getPaddedId() }}</span>--}}
			{{--<span style="position: absolute; top: 20mm; right: 50pt; font-size: 9pt; font-weight: 200; color: #1A8562;">#{{ $order->getPaddedId() }}</span>--}}
			{{--<span style="position: absolute; top: 26mm; right: 25pt; font-size: 10px">{{ $order->udsortering }} | {{ $order->labelTekst1 }} | {{ $order->labelTekst2 }}</span>--}}

		@else
			<img style="width: 112pt; height: 59pt; position: absolute; top: 0; right: 25pt;" src="{{ asset('/images/logo-postnl@2x.png') }}"/>
			<span style="position: absolute; top: 26mm; right: 25pt; font-size: 9pt; font-weight: 200; color: #1A8562;">#{{ $order->getPaddedId() }}</span>
		@endif
			<span style="font-size: 8pt; position: absolute; top: -7mm; left: -5pt; font-weight: 200; ">#{{ $order->getPaddedId() }}</span>
			<br/>
		<address>

			<p style="font-size: 8pt; margin-bottom: 1pt;  ">CODE: {{ $order->labelTekst3 }}</p>
			<div style="margin-bottom: 1pt; font-size:8pt"><strong>{{ $customer->getName() }}</strong>@if($customer->getCustomerAttribute('company') != '') @if($customer->getLocale() == 'da'), C/o @else - @endif {{ $customer->getCustomerAttribute('company') }}@endif</div>
			<p style="font-size:8pt">{{ $customer->getCustomerAttribute('address_line1') }}, {{ $customer->getCustomerAttribute('address_number') }}<br/>
				@if($customer->getCustomerAttribute('address_line2') != '')
					{{ $customer->getCustomerAttribute('address_line2') }}<br/>
				@endif
				{{ $customer->getCustomerAttribute('address_postal') }}&nbsp;&nbsp;{{ $customer->getCustomerAttribute('address_city') }},
				{{ ucfirst($customer->getCustomerAttribute('address_country')) }}<br/>

			</p>
			<img style="width: 20px; margin:1pt 0 0 1pt" src="{{ asset('/images/dao.png') }}"/>
			<p style="font-size: 8pt">{{ $order->udsortering }} | {{ $order->labelTekst1 }} | {{ $order->labelTekst2 }}</p>
		</address>

	</div>



	@endif