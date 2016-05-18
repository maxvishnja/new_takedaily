@foreach($combinations as $combinationKey => $combinationValue)
	<div style="display: inline-block;" class="m-t-15 icon pill-{{ \App\Apricot\Libraries\PillLibrary::getPill($combinationKey, $combinationValue) }}"></div>
@endforeach