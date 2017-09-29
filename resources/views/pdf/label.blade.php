<?php App::setLocale($customer->getLocale()); ?>
<div style="position:relative;  width: 170mm;">
		<img style="width: 112pt; height: 59pt; position: absolute; top: 0; right: 25pt;" src="{{ asset('/images/logo-postnl@2x.png') }}"/>
	<span style="position: absolute; top: 23mm; right: 25pt; font-size: 9pt; font-weight: 200; color: #1A8562;">#{{ $order->getPaddedId() }}</span>

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