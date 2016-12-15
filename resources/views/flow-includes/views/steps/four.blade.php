<div data-step="4" class="step">
	<div id="advises-loader" class="text-center">
		<div class="spinner" style="display: inline-block;">
			<div class="rect1"></div>
			<div class="rect2"></div>
			<div class="rect3"></div>
			<div class="rect4"></div>
			<div class="rect5"></div>
		</div>

		<h2>{{ trans('flow.four.wait') }}</h2>
		<p>{{ trans('flow.four.wait-text') }}</p>
	</div>

	<div id="advises-block" class="text-left" style="display: none;">
		<h2 class="flow-title-with-p">{!! trans('flow.four.your-recommendations') !!}</h2>
		<button type="submit"
				class="button button--green button--large visible-xs button--full-mobile m-t-30 m-b-30">{{ trans('flow.button-order-text') }}</button>

		<div class="row">
			@include('flow-includes.views.steps.recommendation.show')
			@include('flow-includes.views.steps.recommendation.totals')
		</div>

		<div>@include('includes.disclaimer')</div>

		<div class="m-b-20 m-t-20">
			<button type="button" class="link-button" id="send-by-mail-button">{{ trans('flow.four.send-them') }}</button>
		</div>
	</div>

	<textarea name="user_data" id="user_data_field" type="hidden"
			  style="display: none;">@{{ $data.user_data | json }}</textarea>

	<input type="hidden" name="flow-token" v-model="recommendation_token" />
</div>

<style>
	.flow-title-with-p {

	}

	.flow-title-with-p p {
		font-size: 14px;
		line-height: 1.5;
		font-weight: normal;
	}
</style>