<div data-step="4" class="step">
	<div id="advises-loader" class="text-center">
		<div class="spinner" style="display: inline-block;">
			<div class="rect1"></div>
			<div class="rect2"></div>
			<div class="rect3"></div>
			<div class="rect4"></div>
			<div class="rect5"></div>
		</div>

		<h2>Vent venligst..</h2> {{-- todo translate --}}
		<p>Vent et øjeblik mens vi sammensætter den ideelle Takedaily pakke til
			dig</p> {{-- todo translate --}}
	</div>

	<div id="advises-block" class="text-left" style="display: none;">
		<h2>Dine anbefalinger</h2> {{-- todo translate --}}
		<button type="submit"
				class="button button--green button--large visible-xs button--full-mobile m-t-30 m-b-30">{{ trans('flow.button-order-text') }}</button>

		<div class="row">
			@include('flow-includes.views.steps.recommendation.show')
			@include('flow-includes.views.steps.recommendation.totals')
		</div>

		<div class="m-b-20 m-t-20">
			<button type="button" class="link-button" id="send-by-mail-button">Send et link til mine anbefalinger</button>{{-- todo translate --}}
		</div>
	</div>

	<textarea name="user_data" id="user_data_field" type="hidden"
			  style="display: none;">@{{ $data.user_data | json }}</textarea>
</div>