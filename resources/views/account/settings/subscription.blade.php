@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-subscription')

@section('title', trans('account.settings_subscription.title'))

@section('content')
	<h1>{!! trans('account.settings_subscription.header', ['status' => trans('account.settings_subscription.plan.' . ( $plan->isActive() ? 'active' : 'cancelled' ) ) ]) !!}</h1>
	<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true), 'currency' => $plan->currency])]) !!}</h2>

	@if( $plan->isActive() )
		<p>{!! strip_tags(trans('account.settings_subscription.next-date', ['date' => Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y') ]), '<strong>') !!}</p>

		<div class="m-b-30">
			@if($plan->isSnoozeable())
				<a href="#snooze-toggle" id="snooze-toggle"
				   class="button button--regular button--light button--rounded m-r-10">{{ trans('account.settings_subscription.button-snooze-text') }}</a>
			@else
				<span
					class="button button--regular button--light button--disabled button--rounded m-r-10"
					title="{{ trans('account.settings_subscription.cant-snooze') }}">{{ trans('account.settings_subscription.button-snooze-text') }}</span>
			@endif
			@if($plan->isCancelable())
				<a href="{{ URL::action('AccountController@getCancelPage') }}"
				   class="button button--regular button--light button--rounded">{{ trans('account.settings_subscription.button-cancel-text') }}</a>
			@else
				<span
					class="button button--regular button--white button--text-grey button--disabled button--rounded"
					title="{{ trans('account.settings_subscription.cant-cancel') }}">{{ trans('account.settings_subscription.button-cancel-text') }}</span>
			@endif
		</div>
	@else
		<div class="m-t-20 m-b-30">
			<a href="{{ URL::action('AccountController@getSettingsSubscriptionRestart') }}"
			   class="button button--large button--green button--rounded">{{ trans('account.settings_subscription.button-start-text') }}</a>
		</div>
	@endif

	@foreach(Auth::user()->getCustomer()->getVitaminModels() as $vitamin)
		<div class="new_vitamin_item">

			<div class="pill_section">
				<span class="icon pill-{{ strtolower($vitamin->code) }}"></span>
			</div>

			<div class="content_section">
				<strong class="title">
					{{ $vitamin->name }}
				</strong>

				<p>{!! $vitamin->getInfo() !!}</p>

				@if(is_array(trans("flow-praises.{$vitamin->code}")))
					@foreach((array) trans("flow-praises.{$vitamin->code}") as $icon => $text)
						<div class="promise_v_item">
							<span class="icon icon-{{ $icon }}-flow flow-promise-icon"></span>
							<div class="flow-promise-text">{{ $text }}</div>
						</div>
						<div class="clear"></div>
					@endforeach
				@endif

				<div class="extra_content">
					<div class="m-t-30 m-b-10">
						<a href="#" class="readMoreBtn">{{ trans('flow-actions.read-more') }}</a>
						<a href="#" class="readLessBtn" style="display: none">{{ trans('flow-actions.read-less') }}</a>
					</div>

					<div class="description">
						@if(trans('label-' . strtolower($vitamin->code) . '.web_description') != 'label-' . strtolower($vitamin->code) . '.web_description')
							<p>{!! nl2br(trans('label-' . strtolower($vitamin->code) . '.web_description')) !!}</p>
						@endif

						@if(trans('label-' . strtolower($vitamin->code) . '.web_advantage_list') != 'label-' . strtolower($vitamin->code) . '.web_advantage_list')
							<div class="vitamin_advantage_list">
								{!! trans('label-' . strtolower($vitamin->code) . '.web_advantage_list') !!}
							</div>
						@endif

						@if(trans('label-' . strtolower($vitamin->code) . '.foot_note_disclaimer') != 'label-' . strtolower($vitamin->code) . '.foot_note_disclaimer')
							<small class="m-t-15">
								{!! trans('label-' . strtolower($vitamin->code) . '.foot_note_disclaimer') !!}
							</small>
						@endif

						<div class="m-t-20 m-b-10"><a href="#" class="seeIngredientsBtn">{{ trans('flow-actions.see-ingredients') }}</a></div>
						<div class="ingredients">@include('flow-includes.views.vitamin_table', ['label' => strtolower($vitamin->code)])</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach
@endsection

@section('footer_scripts')
	<script>
		$("#snooze-toggle").click(function (e) {
			e.preventDefault();

			swal({
				title: "{{ trans('account.settings_subscription.snooze_popup.title') }}",
				text: "{{ trans('account.settings_subscription.snooze_popup.text') }}" +
				"<form method=\"post\" action=\"{{ URL::action('AccountController@postSettingsSubscriptionSnooze') }}\" id=\"snooze_form\">" +
				{{--"<select class=\"select select--regular m-t-10\" name=\"days\">" +--}}
				{{--@foreach(range(1,28) as $days)--}}
					{{--"<option value=\"{{ $days }}\">{{ trans('account.settings_subscription.snooze_popup.option', ['days' => $days ]) }}</option>" +--}}
				{{--@endforeach--}}
					{{--"</select>" +--}}
				"<input type=\"text\" name=\"days\" class=\"datepicker\" />" +
				"<input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token() }}\" />" +
				"</form>",
				type: "",
				html: true,
				confirmButtonText: "{{ trans('account.settings_subscription.snooze_popup.button-snooze-text') }}",
				cancelButtonText: "{{ trans('account.settings_subscription.snooze_popup.button-close-text') }}",
				confirmButtonColor: "#3AAC87",
				allowOutsideClick: true,
				showCancelButton: true,
				closeOnConfirm: false,
			}, function (inputValue) {
				if (inputValue) {
					return $("#snooze_form").submit();
				}
			});
			$( ".datepicker" ).datepicker({
				startDate: '+1d',
				endDate: '+28d',
				daysOfWeekDisabled: [0,6],
				format: "dd-mm-yyyy"
			});
		});

		$('.readMoreBtn').click(function (e) {
			e.preventDefault();

			$(this).hide();
			$(this).parent().find('.readLessBtn').show();
			$(this).parent().parent().find('.description').stop().slideToggle(200);
		});

		$('.readLessBtn').click(function (e) {
			e.preventDefault();

			$(this).hide();
			$(this).parent().find('.readMoreBtn').show();
			$(this).parent().parent().find('.description').stop().slideToggle(200);
		});

		$('.seeIngredientsBtn').click(function (e) {
			e.preventDefault();

			$(this).parent().parent().find('.ingredients').stop().slideToggle(200);
		});

	</script>
@endsection