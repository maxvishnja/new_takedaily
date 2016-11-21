@foreach($combinations as $combinationKey => $combinationValue)
	<?php $pill = \App\Apricot\Libraries\PillLibrary::getPill($combinationKey, $combinationValue); ?>
	<div class="m-b-30 vitamin-item-for-recommendation" data-group="{{ $combinationKey }}">
		<div style="display: inline-block;" class="pull-right text-right">
			<span class="icon pill-{{ $pill }}"></span>
		</div>

		<strong>
			{{ \App\Apricot\Libraries\PillLibrary::getPillCode($pill) }}
			<span data-group="{{ $combinationKey }}" data-subgroup="{{ $combinationValue }}" class="removePillButton pull-right icon icon-cross-16-dark m-r-10"></span>
		</strong>
		<p>
			@if(isset($advises[$combinationKey]))
				{!! $advises[$combinationKey] !!}
			@endif
		</p>
		@if($pill == '3e')
			<a href="javascript:void(0);" class="button button--small button--light customVitaminButton" data-group="three" data-pill="g">{{ trans('flow.switch-to-chia') }}</a>
			<div style="font-size: 13px; margin-top: 20px;">{!! trans('label-3e.disclaimer_web') !!}</div>
		@elseif($pill == '3g')
			<a href="javascript:void(0);" class="button button--small button--light customVitaminButton" data-group="three" data-pill="e">{{ trans('flow.switch-to-fish') }}</a>
		@endif
	</div>
@endforeach
