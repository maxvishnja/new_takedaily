<div class="flow-helper" @if(isset($center)) style="text-align: center !important;" @endif>
	<div class="m-b-10 hidden-xs" style="font-size: 1.5rem;">
		@if( \App::getLocale() == "nl" and $_SERVER['REQUEST_URI']!="/pick-n-mix")
			<strong>{{ trans('help.extra-text') }}</strong><br/>
		@endif
		<strong class="hidden-xs hidden-sm">{{ trans('help.title') }}</strong>
	</div>

		<div>
			<a href="javascript:void(0);" onclick="Tawk_API.toggle();" class="flow-helper_button hidden-xs hidden-sm">{{ trans('help.chat') }}</a>

			{{--<div class="mobile_info hidden-xs">
				<div><strong>{{ trans('help.title') }}</strong></div>
				<div>{{ trans('help.openings') }}</div>
			</div>--}}

			<a href="tel:{{ trans('help.call-mobile') }}" class="flow-helper_button flow-helper_button--mobile">
				<span class="visible-xs visible-sm icon icon-phone m-t-5"></span>
				<span class="hidden-xs hidden-sm">{{ trans('help.call') }}</span>
			</a>

			<a href="mailto:{{ trans('general.mail') }}" class="flow-helper_button flow-helper_button--mobile">
				<span class="visible-xs visible-sm icon icon-mail-small m-t-5"></span>
				<span class="hidden-xs hidden-sm">{{ trans('help.email') }}</span>
			</a>
		</div>

		<div class="m-t-10 hidden-xs hidden-sm" style="font-size: 1.5rem">{{ trans('help.openings') }}</div>

	<style>
		.flow-helper {
			margin-bottom: 0.3rem !important;
		}
		.flow-helper .icon {
			margin-left: -0.8rem;
		}
	</style>
</div>