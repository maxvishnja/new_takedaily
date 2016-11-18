<div class="col-md-7">
	<div class="tabs m-b-30">
		<div class="options">
			<div data-tab="#advises-label-tab" class="tab tab-toggler tab--active">
				{{ trans('flow.show.supplements') }}
			</div>
			<div data-tab="#advises-content" class="tab tab-toggler">{{ trans('flow.show.description') }}</div>
			<div data-tab="#advises-vitamins" class="tab tab-toggler">{{ trans('flow.show.contents') }}</div>

			<div class="clear"></div>
		</div>

		<div id="advises-label-tab" class="tab-block tab-block--active">
			<div id="advises-label"></div>
		</div>

		<div id="advises-content" class="tab-block"></div>

		<div id="advises-vitamins" class="tab-block"></div>
	</div>

	<p>{{ trans('flow.show.change-vitamins') }} <a href="{{ url()->route('pick-n-mix') }}" id="link-to-change">{{ trans('flow.show.click-me') }}</a></p>
	<p>{{ trans('flow.info_about_supplement')  }}</p>
</div>