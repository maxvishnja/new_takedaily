<div class="description">
	@if(trans('label-' . strtolower($vitamin) . '.web_description') != 'label-' . strtolower($vitamin) . '.web_description')
		<p>{!! nl2br(trans('label-' . strtolower($vitamin) . '.web_description')) !!}</p>
	@endif

	@if(isset($descriptions[$vitamin])) <p>{!! $descriptions[$vitamin] !!}</p> @endif
	<div class="vitamin_advantage_list">
		{!! trans('label-' . strtolower($vitamin) . '.web_advantage_list') !!}
	</div>

	@if(trans('label-' . strtolower($vitamin) . '.foot_note_disclaimer') != 'label-' . strtolower($vitamin) . '.foot_note_disclaimer')
		<small class="m-t-15">
			{!! trans('label-' . strtolower($vitamin) . '.foot_note_disclaimer') !!}
		</small>
	@endif

		@if(trans('label-' . strtolower($vitamin) . '.fish_note') != 'label-' . strtolower($vitamin) . '.fish_note')
			<br/>
			<small class="m-t-15 grey-text">
				{!! trans('label-' . strtolower($vitamin) . '.fish_note') !!}
			</small>
		@endif

	<div class="m-t-20 m-b-10"><a href="#" class="seeIngredientsBtn">{{ trans('flow-actions.see-ingredients') }}</a></div>
	<div class="ingredients">@include('flow-includes.views.vitamin_table', ['label' => strtolower($vitamin)])</div>
</div>