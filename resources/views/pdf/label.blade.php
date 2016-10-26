<div>
	@foreach($customer->getVitaminModels() as $vitamine)
			{{ $vitamine->code }}
	@endforeach

		<img style="width: 226pt; height: 40pt;" src="{{ asset('/images/pdf-logo.png') }}"/>

		<address>
			<div><strong>{{ $customer->getName() }}</strong></div>
			{{ $customer->getCustomerAttribute('address_line1') }}<br/>
			{{ $customer->getCustomerAttribute('address_postal') }}, {{ $customer->getCustomerAttribute('address_city') }}<br/>
			{{ ucfirst($customer->getCustomerAttribute('address_country')) }}<br/>
		</address>


		@foreach($customer->getVitaminModels() as $vitamine)
			<img style="width: 29pt; height: 30pt;"
				 src="{{ asset('/images/icons/pills/pill-' . $vitamine->code . '@2x.png') }}"/>
		@endforeach
</div>