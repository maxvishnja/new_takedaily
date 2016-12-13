<div class="payment_method_card">
	<h3>{{ $source->method }}</h3>{{-- todo translate this (directdebit = card, or something) --}}
	@foreach($source->details as $detail)
		<p>{{ $detail }}</p>
	@endforeach
</div>