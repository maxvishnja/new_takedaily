<div class="col-md-7">
	<div id="advises-label"></div>
	<p>{{ trans('flow.show.change-vitamins') }} <a href="{{ url()->route('pick-n-mix') }}" id="link-to-change">{{ trans('flow.show.click-me') }}</a></p>
{{--	<p><strong>{{ trans('flow.info_about_supplement')  }}</strong></p>--}}

	@include('flow-includes.views.help')
</div>