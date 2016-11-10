<div class="flow-helper">
	<div class="m-b-10 hidden-xs hidden-sm"><strong>{{ trans('help.title') }}</strong></div>

		<div>
			<a href="javascript:void(0);" onclick="Tawk_API.toggle();" class="flow-helper_button hidden-xs hidden-sm">{{ trans('help.chat') }}</a>
			<a href="tel:12345678" class="flow-helper_button flow-helper_button--mobile">
				<span class="visible-xs visible-sm icon icon-phone m-t-5"></span>
				<span class="hidden-xs hidden-sm">{{ trans('help.call') }}</span>
			</a>
		</div>

		<div class="m-t-10 hidden-xs hidden-sm">{{ trans('help.openings') }}</div>
</div>