<?php App::setLocale( $customer->getLocale() ); ?>

<div style="width: 100%; height: 100%;  padding: 5mm 1mm 1mm 1mm;">

	<div style="height: 8mm; position: relative; padding:2mm 0 0 15pt;">
		<h1 style="margin: 0; font-weight: normal;font-size: 12pt;color: #1A8562;text-align: left;">{{ trans('label-product.produced-for') }}
			<strong>{{ strlen($customer->getName()) > 25 ? \Illuminate\Support\Str::words($customer->getName(), 1, '') : $customer->getName() }}</strong></h1>

		<span style="position: absolute; top: 2mm; right: 0; font-size: 9pt; font-weight: 200; color: #1A8562;">#{{ $order->getPaddedId() }}</span>
	</div>

	<div class="vitamins">
		@if($customer->hasPlan() )
			@foreach($customer->getVitaminModels() as $vitaminModel)
				<?php $vitaminModel->code = strtolower($vitaminModel->code); ?>
				<div class="vitamin" >
					<img src="{{ asset('/images/icons/pills/pill-' . $vitaminModel->code . '@2x.png') }}" alt="Vitamin icon" style="float: right;width:20pt; height: 19pt; margin-right:9pt">
					<h2 style="font-weight: bold; font-size: 8.5pt; margin: 0 0 2pt; color: #1A8562">{{ \App\Apricot\Helpers\PillName::get($vitaminModel->code) }}</h2>
					<div style="margin: 4pt 0; font-size: 5.5pt; line-height: 1.2; color: #1A8562;">
						<div style="margin-bottom: 2pt;">{!! trans('label-product.contains') !!}</div>
						@if(is_array(trans("label-{$vitaminModel->code}.praises")) && count(trans("label-{$vitaminModel->code}.praises")) > 0)
							@foreach(trans("label-{$vitaminModel->code}.praises") as $praise => $praiseText)
								@if($praiseText !== '')
									<div style="margin-bottom: 1.6pt">
										<img src="{{ asset('/images/icons/flow/icon-' . strtolower($praise) . '-flow@2x.png') }}"
											 style="display: inline-block; vertical-align: -4px; height: 17px; width: 17px; "/>
										{{ strip_tags($praiseText) }}
									</div>
								@endif
							@endforeach
						@endif
						@if(trans("label-{$vitaminModel->code}.disclaimer_EPA_en_DHA") != "label-{$vitaminModel->code}.disclaimer_EPA_en_DHA")
							<p style="line-height: 1.1; font-weight: 200; color: #1A8562; font-size: 5.5pt; margin: 4pt 0 0;font-style:italic">{!! trans("label-{$vitaminModel->code}.disclaimer_EPA_en_DHA") !!}</p>
						@endif
						<div style="margin-top:2pt">{!! trans('label-product.recommended-daily-use') !!}</div>
					</div>

					@if(is_array(trans("label-{$vitaminModel->code}.first-vitamins")) && count(trans("label-{$vitaminModel->code}.first-vitamins")) > 0)
						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 5.5pt; color: #1A8562;">
								<th style="text-align: left;width: 50%;">{{ trans('label-product.titles.first-vitamins') }}</th>
								<th style="text-align: center;width: 30%;">{{ trans('label-product.titles.amount') }}</th>
								<th style="text-align: right;">{{ trans('label-product.titles.percent') }}</th>
							</tr>
							</thead>
							<tbody style="font-size: 6pt; color:#1A8562;line-height: 1;">
							@foreach(collect(trans("label-{$vitaminModel->code}.first-vitamins"))->sortBy('name', SORT_NATURAL) as $vitamin)
								<tr>
									<td style="text-align: left; font-size: 5.5pt;">{{ isset($vitamin['name']) ? $vitamin['name'] : '' }}</td>
									<td style="text-align: center; font-size: 5.5pt;">{{ isset($vitamin['amount']) ? $vitamin['amount'] : '' }}</td>
									<td style="text-align: right; font-size: 5.5pt;">{{ isset($vitamin['percent']) ? $vitamin['percent'] : '' }}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					@endif

					@if(is_array(trans("label-{$vitaminModel->code}.vitamins")) && count(trans("label-{$vitaminModel->code}.vitamins")) > 0)
						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 5.5pt; color: #1A8562;">
								<th style="text-align: left;width: 50%; font-size: 5.5pt;">{{ trans('label-product.titles.vitamins') }}</th>
								<th style="text-align: center;width: 30%; font-size: 5.5pt;">{{ trans('label-product.titles.amount') }}</th>
								<th style="text-align: right; font-size: 5.5pt;">{{ trans('label-product.titles.percent') }}</th>
							</tr>
							</thead>
							<tbody style="font-size: 6pt; color:#1A8562;line-height: 1;">
							@foreach(collect(trans("label-{$vitaminModel->code}.vitamins"))->sortBy('name', SORT_NATURAL) as $vitamin)
								<tr>
									<td style="text-align: left; font-size: 5.5pt;">{{ isset($vitamin['name']) ? $vitamin['name'] : '' }}</td>
									<td style="text-align: center; font-size: 5.5pt;">{{ isset($vitamin['amount']) ? $vitamin['amount'] : '' }}</td>
									<td style="text-align: right; font-size: 5.5pt;">{{ isset($vitamin['percent']) ? $vitamin['percent'] : '' }}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					@endif

					@if(is_array(trans("label-{$vitaminModel->code}.minerals")) && count(trans("label-{$vitaminModel->code}.minerals")) > 0)
						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 5.5pt; color: #1A8562;">
								<th style="text-align: left; width: 50%; font-size: 5.5pt;">{{ trans('label-product.titles.minerals') }}</th>
								<th style="text-align: center; width: 30%; font-size: 5.5pt;">{{ trans('label-product.titles.amount') }}</th>
								<th style="text-align: right; font-size: 5.5pt;">{{ trans('label-product.titles.percent') }}</th>
							</tr>
							</thead>
							<tbody style="font-size: 6pt; color:#1A8562;line-height: 1;">
							@foreach(collect(trans("label-{$vitaminModel->code}.minerals"))->sortBy('name', SORT_NATURAL) as $vitamin)
								<tr>
									<td style="text-align: left; font-size: 5.5pt;">{{ isset($vitamin['name']) ? $vitamin['name'] : '' }}</td>
									<td style="text-align: center; font-size: 5.5pt;">{{ isset($vitamin['amount']) ? $vitamin['amount'] : '' }}</td>
									<td style="text-align: right; font-size: 5.5pt;">{{ isset($vitamin['percent']) ? $vitamin['percent'] : '' }}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					@endif

					@if(is_array(trans("label-{$vitaminModel->code}.other-vitamins")) && count(trans("label-{$vitaminModel->code}.other-vitamins")) > 0)
						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 5.5pt; color: #1A8562;">
								<th style="text-align: left;width: 50%;">{{ trans('label-product.titles.other') }}</th>
								<th style="text-align: center;width: 30%;">{{ trans('label-product.titles.amount') }}</th>
								<th style="text-align: right;">{{ trans('label-product.titles.percent') }}</th>
							</tr>
							</thead>
							<tbody style="line-height: 1;font-size: 5.5pt; color:#1A8562;">

							<?php $otherVitamins = (trans("label-{$vitaminModel->code}.other-vitamins")); ?>
							<?php ksort($otherVitamins); ?>
							@foreach($otherVitamins as $vitamin)
								@if(isset($vitamin['name']))
								<tr>
									<td style="text-align: left;">{{ isset($vitamin['name']) ? $vitamin['name'] : '' }}</td>
									<td style="text-align: center;">{{ isset($vitamin['amount']) ? $vitamin['amount'] : '' }}</td>
									<td style="text-align: right;">{{ isset($vitamin['percent']) ? $vitamin['percent'] : '' }}</td>
								</tr>
								@endif
							@endforeach
							</tbody>
						</table>
					@endif
					<p style="line-height: 1.1; font-weight: 200; color: #1A8562; font-size: 5.5pt; margin: 2pt 0 0;">{{ trans('label-product.RI') }}</p>
					<p style="line-height: 1.1; font-weight: 200; color: #1A8562; font-size: 5.5pt; margin: 2pt 0 0;"><strong>{{ trans('label-product.ingredients') }}:</strong> {!! trans("label-{$vitaminModel->code}.ingredients") !!}</p>

					@if(trans("label-{$vitaminModel->code}.Allergener") != '' && trans("label-{$vitaminModel->code}.Allergener") != "label-{$vitaminModel->code}.Allergener")
						<p style="line-height: 1.1; font-weight: 200; color: #1A8562; font-size: 5.5pt; margin: 2pt 0 0;"><strong>{{ trans('label-product.Allergener') }}:</strong> {!! trans("label-{$vitaminModel->code}.Allergener") !!}</p>
					@endif

					@if(trans("label-{$vitaminModel->code}.Disclaimer_warningage") != '' && trans("label-{$vitaminModel->code}.Disclaimer_warningage") != "label-{$vitaminModel->code}.Disclaimer_warningage")
						<p style="line-height: 1.1; font-weight: 200; color: #1A8562; font-size: 5.5pt; margin: 2pt 0 0;">{!! trans("label-{$vitaminModel->code}.Disclaimer_warningage") !!}</p>
					@endif

					@if(trans("label-{$vitaminModel->code}.Disclaimer_warningage") != '' && trans("label-{$vitaminModel->code}.Disclaimer_warningage") != "label-{$vitaminModel->code}.Disclaimer_warningage")
						<p style="line-height: 1.1; font-weight: 200; color: #1A8562; font-size: 5.5pt; margin: 2pt 0 0;">{!! trans("label-{$vitaminModel->code}.Disclaimer_warningage") !!}</p>
					@endif

					@if(trans("label-{$vitaminModel->code}.disclaimer_colorants") != '' && trans("label-{$vitaminModel->code}.disclaimer_colorants") != "label-{$vitaminModel->code}.disclaimer_colorants")
						<p style="line-height: 1.1; font-weight: 200; color: #1A8562; font-size: 5.5pt; margin: 2pt 0 0;">{!! trans("label-{$vitaminModel->code}.disclaimer_colorants") !!}</p>
					@endif
					@if(trans("label-{$vitaminModel->code}.disclaimer") != '')
						@if($vitaminModel->code == '3e')
							<img src="{{ asset('/images/foa_logo.png') }}" style="float: left; height: 8mm; margin-right: 3pt;margin-bottom: 3pt;margin-top: 3pt" alt="Friends of the Sea"/>
						@endif
						<p style="line-height: 1.1; font-weight: 200; color: #1A8562; font-size: 5.5pt; margin: 4pt 0 0;font-style:italic">{!! trans("label-{$vitaminModel->code}.disclaimer") !!}</p>
					@endif

					<div style="font-size: 5.5pt;color: #1A8562; margin-top: 1pt; font-weight: 200; ">
						<strong>{{ trans('label-product.batch') }}</strong> {{ trans("label-{$vitaminModel->code}.batch_number") }} ·
						<strong>{{ trans('label-product.expiration') }}</strong> {{ trans("label-{$vitaminModel->code}.end_date") }}
					</div>
				</div>
			@endforeach

			<div class="vitamin" style="height: 160mm;"></div>
		@endif
	</div>

		<div style="text-align: center;  font-size: 5.5pt;  padding:0 0 0 12pt; color: #1A8562">
			@if($customer->getLocale() == 'da')
			{{ trans('label-product.pill_color_reason') }}
			@endif
		</div>

	<div style="font-weight: 200;font-size: 5.5pt;color: #1A8562;line-height: 1; position: relative; padding:0 0 0 12pt; margin-top:5pt; text-align: center">

		{!! trans('label-product.Use') !!} {!! trans('label-product.Store') !!}<br/>
		<div style="margin-top:3pt;">{{ trans('label-product.address') }}</div>
		<strong>{{ trans('label-product.Questions') }}</strong>
	</div>
</div>