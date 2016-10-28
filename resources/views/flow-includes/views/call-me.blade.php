@if( ! isset($_COOKIE['call-me-hidden'])  )
	<style>
		body {
			padding-bottom: 190px;
		}

		.call-cta {
			z-index: 99999999999 !important; /* eeeeeeeeww */
		}
	</style>
	<div class="call-cta" id="call-me-form-toggler">
		<div class="container">
				<span title="{{ trans('flow.call-me.deny') }}" id="call-me-form-hider"
					  class="icon icon-cross-large pull-right"></span>
			<strong>{{ trans('flow.call-me.title') }}</strong>
			<span>{{ trans('flow.call-me.text') }}</span>
			<form method="post" action="{{ URL::route('ajax-call-me') }}" id="call-me-form">
				<input type="number" pattern="\d." maxlength="14" name="phone"
					   class="input input--regular input--plain input--no-number input--spacing input--full-mobile m-t-10"
					   placeholder="{{ trans('flow.call-me.placeholder') }}" required="required"/>
				<select class="select select--regular select--spacing select--plain select--full-mobile m-t-10"
						name="period">
					@foreach(trans('flow.call-me.options') as $option)
						<option value="{{ $option }}">{{ $option }}</option>
					@endforeach
				</select>
				<div class="m-t-10">
					<button type="submit"
							class="button button--white button--large button--full-mobile">{{ trans('flow.call-me.button-text') }}</button>
				</div>
			</form>
		</div>
	</div>
@endif