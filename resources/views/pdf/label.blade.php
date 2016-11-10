<?php App::setLocale($customer->getLocale()); ?>
<div style="height: 50mm; width: 160mm">
		<img style="width: 112pt; height: 59pt; float: right" src="{{ asset('/images/logo-postnl@2x.png') }}"/>

		<address>
			<div style="margin-bottom: 6pt;"><strong>{{ $customer->getName() }}</strong>@if($customer->getCustomerAttribute('company') != '') - {{ $customer->getCustomerAttribute('company') }}@endif</div>
			{{ $customer->getCustomerAttribute('address_line1') }}<br/>
			@if($customer->getCustomerAttribute('address_line2') != '')
				{{ $customer->getCustomerAttribute('address_line2') }}<br/>
			@endif
			{{ $customer->getCustomerAttribute('address_postal') }}&nbsp;&nbsp;{{ $customer->getCustomerAttribute('address_city') }}<br/>
			{{ ucfirst($customer->getCustomerAttribute('address_country')) }}<br/>
		</address>
</div>