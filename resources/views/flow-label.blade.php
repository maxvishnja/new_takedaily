@foreach($combinations as $combinationKey => $combinationValue)
	<div class="m-b-30">
		<div style="display: inline-block;" class="pull-right icon pill-{{ \App\Apricot\Libraries\PillLibrary::getPill($combinationKey, $combinationValue) }}"></div>
		<strong>{{ \App\Apricot\Libraries\PillLibrary::getPillCode(\App\Apricot\Libraries\PillLibrary::getPill($combinationKey, $combinationValue)) }}</strong>
		<p>
			@if(isset($advises[$combinationKey]))
				{!! $advises[$combinationKey] !!}
			@endif
		</p>
	</div>
@endforeach

