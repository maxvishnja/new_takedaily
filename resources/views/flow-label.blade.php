@foreach($combinations as $vitamin)
	<div class="new_vitamin_item">

		<div class="pill_section">
			<span class="icon pill-{{ strtolower($vitamin) }}"></span>
		</div>

		<div class="content_section">
			<strong>
				{{ \App\Apricot\Helpers\PillName::get($vitamin) }}
				<div class="removePillButton pull-right" data-vitamin="{{ $vitamin }}">
					{{ trans('flow-actions.remove') }}
				</div>
			</strong>

			@if(isset($descriptions[$vitamin])) <p>{!! $descriptions[$vitamin] !!}</p>@endif

			@if(isset($advises[$vitamin]))
				<p>
					{!! $advises[$vitamin] !!}
				</p>
			@endif

			@if(is_array(trans("flow-praises.{$vitamin}")))
				@foreach((array) trans("flow-praises.{$vitamin}") as $icon => $text)
					<div>
						<span class="icon icon-{{ $icon }}-flow flow-promise-icon"></span>
						<div class="flow-promise-text">{{ $text }}</div>
					</div>
				<div class="clear"></div>
				@endforeach
			@endif

			<div class="extra_content">
				<div class="m-t-30 m-b-10">
					<a href="#" class="readMoreBtn">{{ trans('flow-actions.read-more') }}</a>

					@if($vitamin === '3e')
						<a href="javascript:void(0);" class="m-l-10 button button--small button--light customVitaminButton" data-vitamin="3g"
						   data-oldvitamin="3e">{{ trans('flow.switch-to-chia') }}</a>
					@elseif($vitamin === '3g')
						<a href="javascript:void(0);" class="m-l-10 button button--small button--light customVitaminButton" data-vitamin="3e"
						   data-oldvitamin="3g">{{ trans('flow.switch-to-fish') }}</a>
					@endif
				</div>

				<div class="description">
					@if(trans('label-' . strtolower($vitamin) . '.web_description') != 'label-' . strtolower($vitamin) . '.web_description')
						<p>{!! nl2br(trans('label-' . strtolower($vitamin) . '.web_description')) !!}</p>
					@endif

					@if(trans('label-' . strtolower($vitamin) . '.web_advantage_list') != 'label-' . strtolower($vitamin) . '.web_advantage_list')
						<div class="vitamin_advantage_list">
							{!! trans('label-' . strtolower($vitamin) . '.web_advantage_list') !!}
						</div>
					@endif

					<div class="m-t-20 m-b-10"><a href="#" class="seeIngredientsBtn">{{ trans('flow-actions.see-ingredients') }}</a></div>
					<div class="ingredients">@include('flow-includes.views.vitamin_table', ['label' => strtolower($vitamin)])</div>
				</div>
			</div>
		</div>
	</div>
@endforeach
