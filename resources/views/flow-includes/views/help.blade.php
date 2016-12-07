<div class="flow-helper m-t-10" @if(isset($center)) style="text-align: center !important;" @endif>
	<div class="m-b-10 hidden-xs"><strong>{{ trans('help.title') }}</strong></div>

		<div>
			<a href="javascript:void(0);" onclick="Tawk_API.toggle();" class="flow-helper_button hidden-xs hidden-sm">{{ trans('help.chat') }}</a>

			<div class="mobile_info visible-xs">
				<div><strong>{{ trans('help.title') }}</strong></div>
				<div>{{ trans('help.openings') }}</div>
			</div>

			<a href="tel:12345678" class="flow-helper_button flow-helper_button--mobile">
				<span class="visible-xs visible-sm icon icon-phone m-t-5"></span>
				<span class="hidden-xs hidden-sm">{{ trans('help.call') }}</span>
			</a>

			<a href="mailto:{{ trans('general.mail') }}" class="flow-helper_button flow-helper_button--mobile">
				<span class="visible-xs visible-sm icon icon-mail-small m-t-5"></span>
				<span class="hidden-xs hidden-sm">{{ trans('help.email') }}</span>
			</a>
		</div>

		<div class="m-t-10 hidden-xs">{{ trans('help.openings') }}</div>
</div>