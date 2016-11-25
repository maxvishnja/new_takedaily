@foreach($combinations as $vitamin)
	<div class="new_vitamin_item">

		<div class="pill_section">
			<span class="icon pill-{{ strtolower($vitamin) }}"></span>
		</div>

		<div class="content_section">
			<strong>
				{{ \App\Apricot\Libraries\PillLibrary::getPillCode(strtolower($vitamin)) }}
				<div class="removePillButton pull-right" data-vitamin="{{ $vitamin }}">
					{{ trans('flow-actions.remove') }}
				</div>
			</strong>

			<p>
				@if(isset($advises[$vitamin]))
					{!! $advises[$vitamin] !!}
				@endif
			</p>
			@if($vitamin == '3e')
				<div style="font-size: 13px; margin: 15px 0">{!! trans('label-3e.disclaimer_web') !!}</div>
				<a href="javascript:void(0);" class="button button--small button--light customVitaminButton" data-vitamin="3g"
				   data-oldvitamin="3e">{{ trans('flow.switch-to-chia') }}</a>
			@elseif($vitamin == '3g')
				<div style="font-size: 13px; margin: 15px 0">{!! trans('label-3g.disclaimer_web') !!}</div>
				<a href="javascript:void(0);" class="button button--small button--light customVitaminButton" data-vitamin="3e"
				   data-oldvitamin="3g">{{ trans('flow.switch-to-fish') }}</a>
			@endif

			<div class="extra_content">
				<div class="m-t-30 m-b-10"><a href="#" class="readMoreBtn">{{ trans('flow-actions.read-more') }}</a></div>
				<div class="description">
					@if(isset($descriptions[$vitamin])) <p>{!! $descriptions[$vitamin] !!}</p> @endif

					<div class="m-t-20 m-b-10"><a href="#" class="seeIngredientsBtn">{{ trans('flow-actions.see-ingredients') }}</a></div>
					<div class="ingredients">@include('flow-includes.views.vitamin_table', ['label' => strtolower($vitamin)])</div>
				</div>
			</div>
		</div>
	</div>
@endforeach
