{{-- todo set locale based on customer --}}

<div style="width: 100%; height: 230mm; padding: 0;position: relative;">
	<div style="height: 7mm">
		<h1 style="margin: 0; font-weight: normal;font-size: 15pt;color: #1A8562;text-align: left;">{{ trans('label-product.produced-for') }}
			<strong>{{ strlen($customer->getName()) > 25 ? \Illuminate\Support\Str::words($customer->getName(), 1, '') : $customer->getName() }}</strong></h1>
	</div>

	<div class="vitamins">
		@if($customer->hasPlan() )
			@foreach($customer->getVitaminModels() as $vitaminModel)
				<div class="vitamin">
					<img src="{{ asset('/images/icons/pills/pill-' . $vitaminModel->code . '@2x.png') }}" alt="Vitamin icon" style="float: right;width:20pt; height: 19pt;">
					<h2 style="font-weight: bold; font-size: 10.5pt; margin: 0 0 2pt; color: #1A8562">{{ \App\Apricot\Libraries\PillLibrary::$codes[$vitaminModel->code] }}</h2>
					<div style="margin: 4pt; font-size: 7pt; line-height: 1.2; color: #1A8562;">
						@if(is_array(trans("label-{$vitaminModel->code}.praises")) && count(trans("label-{$vitaminModel->code}.praises")) > 0)
							<div>{{ trans('label-product.good-for') }}</div>
							@foreach(trans("label-{$vitaminModel->code}.praises") as $praise => $praiseText)
								<div style="margin-bottom: 1pt;">
									<img src="{{ asset('/images/icons/flow/icon-' . $praise . '-flow@2x.png') }}" style="display: inline-block; vertical-align: -4px; height: 17px; width: 17px; " />
									{{ $praiseText }}
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

					<p style="line-height: 1.1; font-weight: 200; color: #1A8562; font-size: 6.5pt; margin: 2pt 0 0;">{{ trans('label-product.ingredients') }}: {{ trans("label-{$vitaminModel->code}.ingredients") }}</p>
					@if(trans("label-{$vitaminModel->code}.disclaimer") != '')
						<p style="line-height: 1.1; font-weight: 200; color: #1A8562; font-size: 6.5pt; margin: 4pt 0 0;">{!! trans("label-{$vitaminModel->code}.disclaimer") !!}</p>
					@endif
				</div>
			@endforeach
		@endif
	</div>

	<div style="text-align: center">
		@if($customer->hasPlan() && $customer->getPlan()->hasFishoil())
			<img src="{{ asset('/images/foa_logo.png') }}" style="height: 8mm; margin-right: 4pt;" alt="Friends of the Sea">
		@endif
		{{--<img src="{{ asset('/images/kcaps.jpeg') }}" style="height: 8mm" alt="K-Caps">--}}
	</div>

	<div style="font-weight: 200;font-size: 7pt;color: #1A8562;line-height: 1;position: absolute; bottom: 0; text-align: center">
		<strong>{{ trans('label-product.recommended-daily-use') }}</strong> {{ trans('label-product.info') }}<br/>
		<div><strong>{{ trans('label-product.contains') }}</strong> · {{ trans('label-product.address') }}</div>
	</div>
</div>