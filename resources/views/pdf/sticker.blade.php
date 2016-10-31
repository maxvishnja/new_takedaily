{{-- todo set locale based on customer --}}

<div style="width: 100%; height: 220mm; padding: 0;position: relative;">
	<div style="height: 15mm">
		<h1 style="margin: 0; font-weight: normal;font-size: 15pt;color: #1A8562;text-align: center;">{{ trans('label-product.produced-for') }}
			<strong>{{ $customer->getName() }}</strong></h1>
		<p style="text-align: center; font-weight: 200;font-size: 9pt;color: #1A8562;margin: 6pt 0 0;line-height: 11pt;">{{ trans('label-product.for-me', ['name' => $customer->getFirstname() ]) }}</p>
	</div>

	<div class="vitamins">
		@if($customer->hasPlan() )
			@foreach($customer->getVitaminModels() as $vitaminModel)
				<div class="vitamin">
					<img src="{{ asset('/images/icons/pills/pill-' . $vitaminModel->code . '@2x.png') }}" alt="Vitamin icon" style="float: right;width:20pt; height: 19pt;">
					<h2 style="font-weight: bold; font-size: 10.5pt; margin: 0 0 2pt; color: #1A8562">{{ \App\Apricot\Libraries\PillLibrary::$codes[$vitaminModel->code] }}</h2>
					<div style="margin: 4pt; font-size: 7pt; line-height: 1.2; color: #1A8562;">
						@if(is_array(trans("label-{$vitaminModel->code}.praises")))
							@foreach(trans("label-{$vitaminModel->code}.praises") as $praiseIcon => $praise)
								<div style="margin-bottom: 1.5pt">
									@if(!in_array($praiseIcon, ['one', 'two','three','four']))
										<span
											style="display: inline-block; vertical-align: -4px; height: 17px; width: 17px; background: url({{ asset('/images/icons/flow/icon-' . $praiseIcon . '-flow@2x.png') }}) no-repeat center center; background-size: cover;"></span>
									@endif
									{!! $praise !!}
								</div>
							@endforeach
						@endif
					</div>

					@if(is_array(trans("label-{$vitaminModel->code}.vitamins")) && count(trans("label-{$vitaminModel->code}.vitamins")) > 0)
						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 7pt; color: #1A8562;">
								<th style="text-align: left;width: 40%;">{{ trans('label-product.titles.vitamins') }}</th>
								<th style="text-align: center;width: 40%;">{{ trans('label-product.titles.amount') }}</th>
								<th style="text-align: right;">{{ trans('label-product.titles.percent') }}</th>
							</tr>
							</thead>
							<tbody style="font-size: 7pt; color:#1A8562;">
							@foreach(collect(trans("label-{$vitaminModel->code}.vitamins"))->sortBy('name') as $vitamin)
								<tr>
									<td style="text-align: left;">{{ $vitamin['name'] }}</td>
									<td style="text-align: center;">{{ $vitamin['amount'] }}</td>
									<td style="text-align: right;">{{ $vitamin['percent'] }}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					@endif

					@if(is_array(trans("label-{$vitaminModel->code}.minerals")) && count(trans("label-{$vitaminModel->code}.minerals")) > 0)
						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 7pt; color: #1A8562;">
								<th style="text-align: left;width: 40%;">{{ trans('label-product.titles.minerals') }}</th>
								<th style="text-align: center;width: 40%;">{{ trans('label-product.titles.amount') }}</th>
								<th style="text-align: right;">{{ trans('label-product.titles.percent') }}</th>
							</tr>
							</thead>
							<tbody style="font-size: 7pt; color:#1A8562;">
							@foreach(collect(trans("label-{$vitaminModel->code}.minerals"))->sortBy('name') as $vitamin)
								<tr>
									<td style="text-align: left;">{{ $vitamin['name'] }}</td>
									<td style="text-align: center;">{{ $vitamin['amount'] }}</td>
									<td style="text-align: right;">{{ $vitamin['percent'] }}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					@endif

					@if(is_array(trans("label-{$vitaminModel->code}.other-vitamins")) && count(trans("label-{$vitaminModel->code}.other-vitamins")) > 0)
						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 7pt; color: #1A8562;">
								<th style="text-align: left;width: 40%;"></th>
								<th style="text-align: center;width: 40%;">{{ trans('label-product.titles.amount') }}</th>
								<th style="text-align: right;">{{ trans('label-product.titles.percent') }}</th>
							</tr>
							</thead>
							<tbody style="font-size: 7pt; color:#1A8562;">
							@foreach(collect(trans("label-{$vitaminModel->code}.other-vitamins"))->sortBy('name') as $vitamin)
								<tr>
									<td style="text-align: left;">{{ $vitamin['name'] }}</td>
									<td style="text-align: center;">{{ $vitamin['amount'] }}</td>
									<td style="text-align: right;">{{ $vitamin['percent'] }}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					@endif

					<p style="line-height: 1.2; font-weight: 200; color: #1A8562; font-size: 7pt; margin: 2pt 0 4pt;">
						{{ trans('label-product.ingredients') }}: {{ trans("label-{$vitaminModel->code}.ingredients") }}</p>
					@if(trans("label-{$vitaminModel->code}.disclaimer") != '')
						<p style="line-height: 1.2; font-weight: 200; color: #1A8562; font-size: 7pt; margin: 4pt 0 0;">{{ trans("label-{$vitaminModel->code}.disclaimer") }}</p>
					@endif
				</div>
			@endforeach
		@endif
	</div>

	<div style="text-align: center">
		@if($customer->hasPlan() && $customer->getPlan()->hasFishoil())
			<img src="{{ asset('/images/foa_logo.png') }}" style="height: 8mm; margin-right: 4pt;" alt="Friends of the Sea">
		@endif
		<img src="{{ asset('/images/kcaps.jpeg') }}" style="height: 8mm" alt="K-Caps">
	</div>

	<p style="font-weight: 200;font-size: 7.5pt;color: #1A8562;line-height: 8pt;position: absolute; bottom: 0; height: 11mm; width: 70%; left: 15%; text-align: center">
		{{ trans('label-product.recommended-daily-use') }}<br/>
		{{ trans('label-product.info') }}
	</p>
</div>