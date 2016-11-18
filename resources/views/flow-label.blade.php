@foreach($combinations as $combinationKey => $combinationValue)
	<div class="m-b-30 vitamin-item-for-recommendation" data-group="{{ $combinationKey }}">
		<div style="display: inline-block;" class="pull-right text-right">
			<span class="icon pill-{{ \App\Apricot\Libraries\PillLibrary::getPill($combinationKey, $combinationValue) }}"></span>
		</div>

		<strong>
			{{ \App\Apricot\Libraries\PillLibrary::getPillCode(\App\Apricot\Libraries\PillLibrary::getPill($combinationKey, $combinationValue)) }}
			<span data-group="{{ $combinationKey }}" data-subgroup="{{ $combinationValue }}" class="removePillButton pull-right icon icon-cross-16-dark m-r-10"></span>
		</strong>
		<p>
			@if(isset($advises[$combinationKey]))
				{!! $advises[$combinationKey] !!}
			@endif
		</p>
	</div>
@endforeach
{{-- todo fix this nasty shit; getPill and stuff --}}
