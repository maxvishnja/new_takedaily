@foreach($combinations as $combinationKey => $combinationValue)
	<?php $pill = \App\Apricot\Libraries\PillLibrary::getPill( $combinationKey, $combinationValue ); ?>
	<div class="m-b-30 vitamin-item-for-recommendation" data-group="{{ $combinationKey }}">
		<div style="display: inline-block;" class="pull-right text-right">
			<span class="icon pill-{{ $pill }}"></span>
		</div>

		<strong>
			{{ \App\Apricot\Libraries\PillLibrary::getPillCode($pill) }}
			<span class="removePillButton pull-right">
				Fjern
				<span data-group="{{ $combinationKey }}" data-subgroup="{{ $combinationValue }}" class="icon icon-cross-16-dark m-r-10"></span>
			</span>
		</strong>
		<p>
			@if(isset($advises[$combinationKey]))
				{!! $advises[$combinationKey] !!}
			@endif
		</p>
		@if($pill == '3e')
			<div style="font-size: 13px; margin: 15px 0">{!! trans('label-3e.disclaimer_web') !!}</div>
			<a href="javascript:void(0);" class="button button--small button--light customVitaminButton" data-group="three" data-pill="g">{{ trans('flow.switch-to-chia') }}</a>
		@elseif($pill == '3g')
			<div style="font-size: 13px; margin: 15px 0">{!! trans('label-3g.disclaimer_web') !!}</div>
			<a href="javascript:void(0);" class="button button--small button--light customVitaminButton" data-group="three" data-pill="e">{{ trans('flow.switch-to-fish') }}</a>
		@endif
	</div>
@endforeach
