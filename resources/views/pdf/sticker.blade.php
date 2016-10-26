{{-- todo set locale based on customer --}}
<style>
	.vitamins {
		display: flex;
		flex-direction: column;
		flex-wrap: wrap;
		height: 178mm;
		width: 160mm;
	}

	.vitamins .vitamin {
		width: 50%;
		padding: 5pt;
	}

	.vitamins .vitamin:nth-child(2n+1) {
		/*border-right: 1px solid #CCE9E0;*/
	}

	.vitamins .vitamin:nth-child(1),
	.vitamins .vitamin:nth-child(2) {
		/*border-bottom: 1px solid #CCE9E0;*/
	}

	.vitamins .vitamin:nth-child(2n+2) {
	}

	.vitamin thead th,
	.vitamin tbody td {
		padding-bottom: 1pt;
	}
</style>

<div style="width: 100%; height: 220mm; padding: 0;position: relative;">
	<div style="height: 26mm">
		<h1 style="margin: 0; font-weight: normal;font-size: 16pt;color: #1A8562;text-align: center;">{{ trans('label-product.produced-for') }} <strong>{{ $customer->getName() }}</strong></h1>
		<p style="text-align: center; font-weight: 200;font-size: 10pt;color: #1A8562;margin: 8pt 0 12pt;line-height: 17pt;">{{ trans('label-product.for-me', ['name' => $customer->getFirstname() ]) }}</p>
	</div>

	<div class="vitamins">
		@if($customer->hasPlan())
			@foreach($customer->getVitaminModels() as $vitaminModel)
				<div class="vitamin">
					<img src="{{ asset('/images/icons/pills/pill-' . $vitaminModel->code . '@2x.png') }}" alt="Vitamin icon" style="float: right;width:19pt; height: 20pt;">
					<h2 style="font-weight: bold; font-size: 11pt; margin: 0 0 2pt; color: #1A8562">{{ \App\Apricot\Libraries\PillLibrary::$codes[$vitaminModel->code] }}</h2>
					<p style="margin: 0 0 6pt; line-height: 12pt; font-size: 8pt; color: #1A8562;">Bidrager til den normale funktion af immunforsvaret.</p>

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

					<p style="font-weight: 200; color: #1A8562; font-size: 7pt; margin: 4pt 0;">{{ trans('label-product.ingredients') }}: {{ trans("label-{$vitaminModel->code}.ingredients") }}</p>
				</div>
			@endforeach
		@endif
	</div>

	<p style="font-weight: 200;font-size: 9pt;color: #1A8562;line-height: 14pt;position: absolute; bottom: 0; height: 15mm; width: 70%; left: 15%; text-align: center">{{ trans('label-product.recommended-daily-use') }}<br/>{{ trans('label-product.info') }}</p>
</div>