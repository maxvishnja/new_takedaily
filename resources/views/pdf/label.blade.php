<?php App::setLocale($customer->getLocale()); ?>
<div style="position: relative; height: 50mm; width: 160mm;">
		<img style="width: 112pt; height: 59pt; position: absolute; top: 0; right: 20pt;" src="{{ asset('/images/logo-postnl@2x.png') }}"/>

		<address>
			<img style="width: 100pt; height: 19pt; margin-bottom: 1pt; " src="{{ asset('/images/pdf-logo.png') }}"/>
			<div style="margin-bottom: 4pt; font-size:14pt"><strong>{{ $customer->getName() }}</strong>@if($customer->getCustomerAttribute('company') != '') - {{ $customer->getCustomerAttribute('company') }}@endif</div>
			<p style="font-size:12pt">{{ $customer->getCustomerAttribute('address_line1') }}<br/>
			@if($customer->getCustomerAttribute('address_line2') != '')
				{{ $customer->getCustomerAttribute('address_line2') }}<br/>
			@endif
			{{ $customer->getCustomerAttribute('address_postal') }}&nbsp;&nbsp;{{ $customer->getCustomerAttribute('address_city') }}<br/>
			{{ ucfirst($customer->getCustomerAttribute('address_country')) }}</p>
		</address>

		<div style="font-size: 10pt; position: absolute; bottom: 4mm; font-weight: 200;"><small>{{ trans('label-product.return') }}</small></div>
</div>