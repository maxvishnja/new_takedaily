@foreach($combinations as $vitamin)
	<div class="m-b-30 vitamin-item-for-recommendation" data-vitamin="{{ $vitamin }}">
		<div style="display: inline-block;" class="pull-right text-right">
			<span class="icon pill-{{ strtolower($vitamin) }}"></span>
		</div>

		<strong>
			{{ \App\Apricot\Libraries\PillLibrary::getPillCode(strtolower($vitamin)) }}
			<span class="removePillButton pull-right">
				Fjern
				<span data-vitamin="{{ $vitamin }}" class="icon icon-cross-16-dark m-r-10" style="vertical-align: middle"></span>
			</span>
		</strong>
		<p>
			@if(isset($advises[$vitamin]))
				{!! $advises[$vitamin] !!}
			@endif
		</p>
		@if($vitamin == '3e')
			<div style="font-size: 13px; margin: 15px 0">{!! trans('label-3e.disclaimer_web') !!}</div>
			<a href="javascript:void(0);" class="button button--small button--light customVitaminButton" data-vitamin="3g" data-oldvitamin="3e">{{ trans('flow.switch-to-chia') }}</a>
		@elseif($vitamin == '3g')
			<div style="font-size: 13px; margin: 15px 0">{!! trans('label-3g.disclaimer_web') !!}</div>
			<a href="javascript:void(0);" class="button button--small button--light customVitaminButton" data-vitamin="3e" data-oldvitamin="3g">{{ trans('flow.switch-to-fish') }}</a>
		@endif
	</div>
@endforeach
