<div class="m-t-20">
	<div class="table_container">
		<div><strong>{!! trans("label-{$label}.Vit and Min") !!}</strong></div>
		<div>{!! strip_tags(trans('label-product.recommended-daily-use')) !!}</div>

		@if(is_array(trans("label-{$label}.first-vitamins")) && count(trans("label-{$label}.first-vitamins")) > 0)
			<table style="width: 100%;">
				<thead>
				<tr style="font-weight: bold;">
					<th style="text-align: left;width: 50%;">{{ trans('label-product.titles.first-vitamins') }}</th>
					<th style="text-align: center;width: 30%;">{{ trans('label-product.titles.amount') }}</th>
					<th style="text-align: right;">{{ trans('label-product.titles.percent') }}</th>
				</tr>
				</thead>
				<tbody style="line-height: 1;">
				@foreach(collect(trans("label-{$label}.first-vitamins"))->sortBy('name', SORT_NATURAL) as $vitamin)
					<tr>
						<td style="text-align: left;">{{ isset($vitamin['name']) ? $vitamin['name'] : '' }}</td>
						<td style="text-align: center;">{{ isset($vitamin['amount']) ? $vitamin['amount'] : '' }}</td>
						<td style="text-align: right;">{{ isset($vitamin['percent']) ? $vitamin['percent'] : '' }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endif

		@if(is_array(trans("label-{$label}.vitamins")) && count(trans("label-{$label}.vitamins")) > 0)
			<table style="width: 100%;">
				<thead>
				<tr style="font-weight: bold;">
					<th style="text-align: left;width: 50%;">{{ trans('label-product.titles.vitamins') }}</th>
					<th style="text-align: center;width: 30%;">{{ trans('label-product.titles.amount') }}</th>
					<th style="text-align: right;">{{ trans('label-product.titles.percent') }}</th>
				</tr>
				</thead>
				<tbody style="line-height: 1;">
				@foreach(collect(trans("label-{$label}.vitamins"))->sortBy('name', SORT_NATURAL) as $vitamin)
					<tr>
						<td style="text-align: left;">{{ isset($vitamin['name']) ? $vitamin['name'] : '' }}</td>
						<td style="text-align: center;">{{ isset($vitamin['amount']) ? $vitamin['amount'] : '' }}</td>
						<td style="text-align: right;">{{ isset($vitamin['percent']) ? $vitamin['percent'] : '' }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endif

		@if(is_array(trans("label-{$label}.minerals")) && count(trans("label-{$label}.minerals")) > 0)
			<table style="width: 100%;">
				<thead>
				<tr style="font-weight: bold;">
					<th style="text-align: left;width: 50%;">{{ trans('label-product.titles.minerals') }}</th>
					<th style="text-align: center;width: 30%;">{{ trans('label-product.titles.amount') }}</th>
					<th style="text-align: right;">{{ trans('label-product.titles.percent') }}</th>
				</tr>
				</thead>
				<tbody style="line-height: 1;">
				@foreach(collect(trans("label-{$label}.minerals"))->sortBy('name', SORT_NATURAL) as $vitamin)
					<tr>
						<td style="text-align: left;">{{ isset($vitamin['name']) ? $vitamin['name'] : '' }}</td>
						<td style="text-align: center;">{{ isset($vitamin['amount']) ? $vitamin['amount'] : '' }}</td>
						<td style="text-align: right;">{{ isset($vitamin['percent']) ? $vitamin['percent'] : '' }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endif

		@if(is_array(trans("label-{$label}.other-vitamins")) && count(trans("label-{$label}.other-vitamins")) > 0)
			<table style="width: 100%;">
				<thead>
				<tr style="font-weight: bold;">
					<th style="text-align: left;width: 50%;">{{ trans('label-product.titles.other') }}</th>
					<th style="text-align: center;width: 30%;">{{ trans('label-product.titles.amount') }}</th>
					<th style="text-align: right;">{{ trans('label-product.titles.percent') }}</th>
				</tr>
				</thead>
				<tbody style="line-height: 1;">
				<?php $otherVitamins = ( trans( "label-{$label}.other-vitamins" ) ); ?>
				<?php ksort( $otherVitamins ); ?>
				@foreach($otherVitamins as $vitamin)
					<tr>
						<td style="text-align: left;">{{ isset($vitamin['name']) ? $vitamin['name'] : '' }}</td>
						<td style="text-align: center;">{{ isset($vitamin['amount']) ? $vitamin['amount'] : '' }}</td>
						<td style="text-align: right;">{{ isset($vitamin['percent']) ? $vitamin['percent'] : '' }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endif

		<p style="line-height: 1.1; font-weight: 200; margin: 10px 0;"><strong>{{ trans('label-product.ingredients') }}
				:</strong> {{ trans("label-{$label}.ingredients") }}</p>

		@if(trans("label-{$label}.Allergener") != '' && trans("label-{$label}.Allergener") != "label-{$label}.Allergener")
			<p style="line-height: 1.1; font-weight: 200; margin: 10px 0;"><strong>{{ trans('label-product.Allergener') }}
					:</strong> {{ trans("label-{$label}.Allergener") }}</p>
		@endif
		@if(trans("label-{$label}.disclaimer") != '')
			<p style="line-height: 1.1; font-weight: 200; margin: 10px 0;font-style:italic">{!! trans("label-{$label}.disclaimer") !!}</p>
		@endif

		<div>
			{!! trans( 'label-product.Store_website' ) !!}
		</div>

		<div class="m-t-10">
			{!! trans( 'label-product.Use_website' ) !!}
		</div>
	</div>

</div>