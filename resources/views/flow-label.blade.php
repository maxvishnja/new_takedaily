@foreach($combinations as $vitamin)
	<div class="new_vitamin_item">

		<div class="pill_section">
			<span class="icon pill-{{ strtolower($vitamin) }}"></span>
		</div>

		<div class="content_section">
			<strong class="title">
				{{ \App\Apricot\Helpers\PillName::get($vitamin) }}
				<div class="removePillButton pull-right" data-vitamin="{{ $vitamin }}">
					{{ trans('flow-actions.remove') }}
				</div>
			</strong>

			@if(isset($descriptions[$vitamin])) <p>{!! nl2br($descriptions[$vitamin]) !!}</p>@endif

			@if(isset($advises[$vitamin]) && $advises[$vitamin] !== '' && $advises[$vitamin] !== '&nbsp;' && $vitamin !== '2a' && $vitamin !== '2A')
				<p>
					{!! $advises[$vitamin] !!}
				</p>
			@endif

			@if(is_array(trans("flow-praises.{$vitamin}")))
				<?php $praises = (array) trans( "flow-praises.{$vitamin}" ); ?>
				<?php uasort( $praises, function ( $a, $b )
				{
					return strlen( $a ) - strlen( $b );
				} ); ?>
				@foreach($praises as $icon => $text)
					<div class="promise_v_item">
						<span class="icon icon-{{ $icon }}-flow flow-promise-icon"></span>
						<div class="flow-promise-text">{{ $text }}</div>
					</div>
					<div class="clear"></div>
				@endforeach
			@endif

			<div class="extra_content">
				<div class="m-t-30 m-b-10">
					<a href="#" class="pull-left button button--small button--white button--text-green readMoreBtn">{{ trans('flow-actions.read-more') }}</a>
					<a href="#" class="pull-left button button--small button--white button--text-green readLessBtn"
					   style="display: none">{{ trans('flow-actions.read-less') }}</a>
					<div class="pull-right">
						@if($vitamin === '3e')
							<a href="javascript:void(0);" class="m-l-10 button button--small button--light customVitaminButton" data-vitamin="3g"
							   data-oldvitamin="3e">{{ trans('flow.switch-to-chia') }}</a>
						@elseif($vitamin === '3g')
							<a href="javascript:void(0);" class="m-l-10 button button--small button--light customVitaminButton" data-vitamin="3e"
							   data-oldvitamin="3g">{{ trans('flow.switch-to-fish') }}</a>
						@endif
					</div>

					<div class="clear"></div>
				</div>

				<div class="description">
					@if(trans('label-' . strtolower($vitamin) . '.web_description') != 'label-' . strtolower($vitamin) . '.web_description' && $vitamin !== '2a' && $vitamin !== '2A')
						<p>{!! nl2br(trans('label-' . strtolower($vitamin) . '.web_description')) !!}</p>
					@endif

					@if(trans('label-' . strtolower($vitamin) . '.web_advantage_list') != 'label-' . strtolower($vitamin) . '.web_advantage_list')
						<div class="vitamin_advantage_list">
							{!! trans('label-' . strtolower($vitamin) . '.web_advantage_list') !!}
						</div>
					@endif

					@if(trans('label-' . strtolower($vitamin) . '.foot_note_disclaimer') != 'label-' . strtolower($vitamin) . '.foot_note_disclaimer')
						<small class="m-t-30">
							{!! trans('label-' . strtolower($vitamin) . '.foot_note_disclaimer') !!}
						</small>
					@endif

					<div class="m-t-20 m-b-10"><a href="#" class="seeIngredientsBtn">{{ trans('flow-actions.see-ingredients') }}</a></div>
					<div class="ingredients">@include('flow-includes.views.vitamin_table', ['label' => strtolower($vitamin)])</div>
				</div>
			</div>
		</div>
	</div>
@endforeach

@if(isset($descriptions['no-lifestyle']))
	<div class="new_vitamin_item">

		<div class="pill_section">
		</div>

		<div class="content_section" style="font-size: 17px">
			{!! $descriptions['no-lifestyle'] !!}
		</div>
	</div>
@endif
@if(isset($descriptions['no-diet']))
	<div class="new_vitamin_item">

		<div class="pill_section">
		</div>

		<div class="content_section" style="font-size: 17px">
			{!! $descriptions['no-diet'] !!}
		</div>
	</div>
@endif