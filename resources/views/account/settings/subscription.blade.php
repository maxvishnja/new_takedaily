@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-subscription')

@section('title', trans('account.settings_subscription.title'))

@section('content')
	<style>
		p {
			font-size: 1.2rem;
			margin: .8rem 0;
			line-height: 1.2;
		}
		.flow-promise-text {
			font-size: 1.2rem;
		}
		thead, tbody {
			font-size: 1.2rem;
		}
	</style>
	<h1>{!! trans('account.settings_subscription.header', ['status' => trans('account.settings_subscription.plan.' . ( $plan->isActive() ? 'active' : 'cancelled' ) ) ]) !!}</h1>

	@if($customer->getPlan()->getCouponCount() > 0 and ($customer->getPlan()->getDiscountType() == 'month' or $customer->getPlan()->getDiscountType() == '' ) or ($customer->getPlan()->getDiscountCount() > 0 and  $customer->getPlan()->getPriceDiscount() == 0))

		<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => 0, 'currency' => $plan->currency])]) !!}</h2>

	@elseif($customer->getPlan()->getCouponCount() > 0 and $customer->getPlan()->getDiscountType() == 'percent')

		<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal() - ($plan->getTotal() * ($customer->getPlan()->getCouponCount()/100)), true), 'currency' => $plan->currency])]) !!}</h2>
	@else
		<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true), 'currency' => $plan->currency])]) !!}</h2>
	@endif

	@if( $plan->isActive() )
		<p>{!! strip_tags(trans('account.settings_subscription.next-date', ['date' => Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y') ]), '<strong>') !!}</p>

		<div class="m-b-30">
			@if($plan->isSnoozeable())
				<a href="#snooze-toggle" id="snooze-toggle"
				   class="button button--regular button--light button--rounded m-r-10">{{ trans('account.settings_subscription.button-snooze-text') }}</a>
			@else
				<span
					class="button button--regular button--light not-snooz button--rounded m-r-10"
					title="{{ trans('account.settings_subscription.cant-snooze') }}">{{ trans('account.settings_subscription.button-snooze-text') }}</span>
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
					{{ \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)) }}
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
	@if( $plan->isActive() )
		<div class="text-center">
			@if($plan->isCancelable())
				<a href="{{ URL::action('AccountController@getCancelPage') }}"
				   class="cancel-button">{{ trans('account.settings_subscription.button-cancel-text') }}</a>
			@else
				<span
						class="button button--regular button--white button--text-grey button--disabled button--rounded"
						title="{{ trans('account.settings_subscription.cant-cancel') }}">{{ trans('account.settings_subscription.button-cancel-text') }}</span>
			@endif
		</div>
	@endif
@endsection

@section('footer_scripts')
	<script>
		$("#snooze-toggle").click(function (e) {
			e.preventDefault();
			@if( $plan->isActive() )
				swal({
					title: "{{ trans('account.settings_subscription.snooze_popup.title') }}",
					text: "{{ trans('account.settings_subscription.snooze_popup.text') }}" +
					"<form method=\"post\" action=\"{{ URL::action('AccountController@postSettingsSubscriptionSnooze') }}\" id=\"snooze_form\">" +
					{{--"<select class=\"select select--regular m-t-10\" name=\"days\">" +--}}
					{{--@foreach(range(1,28) as $days)--}}
						{{--"<option value=\"{{ $days }}\">{{ trans('account.settings_subscription.snooze_popup.option', ['days' => $days ]) }}</option>" +--}}
					{{--@endforeach--}}
						{{--"</select>" +--}}

					"<input type=\"text\" name=\"days\" class=\"datepicker\" placeholder='{{ trans('account.settings_subscription.snooze_popup.placeholder') }}' />" +
					"<input type=\"hialreen\" name=\"_token\" value=\"{{ csrf_token() }}\" />" +
					"<div class='m-b-10'>" +
					"<a data-days='{{Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->addDays(1)->format('d-m-Y')}}' class='snooz-month button button--small button--rounded button--green'>{{ trans('account.settings_subscription.snooze1day') }}</a>" +
					"<a data-days='{{Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->addDays(2)->format('d-m-Y')}}' class='snooz-month button button--small button--rounded button--green'>{{ trans('account.settings_subscription.snooze2day') }}</a>" +
					"<a data-days='{{Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->addDays(3)->format('d-m-Y')}}' class='snooz-month button button--small button--rounded button--green'>{{ trans('account.settings_subscription.snooze3day') }}</a>" +
					"</div>" +
					"<div class='m-b-10'>" +
					"<a data-days='{{Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->addDays(7)->format('d-m-Y')}}' class='snooz-month button button--small button--rounded button--green'>{{ trans('account.settings_subscription.snooze1week') }}</a>" +
					"<a data-days='{{Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->addDays(14)->format('d-m-Y')}}' class='snooz-month button button--small button--rounded button--green'>{{ trans('account.settings_subscription.snooze14days') }}</a>" +
					"<a data-days='{{Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->addDays(21)->format('d-m-Y')}}' class='snooz-month button button--small button--rounded button--green'>{{ trans('account.settings_subscription.snooze3week') }}</a>" +
					"</div>" +
					"<div class='m-b-10'>" +
					"<a data-days='{{Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->addMonths(1)->format('d-m-Y')}}'  class='snooz-month button button--small button--rounded button--green'>{{ trans('account.settings_subscription.snooze1month') }}</a>" +
					"<a data-days='{{Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->addMonths(2)->format('d-m-Y')}}'  class='snooz-month button button--small button--rounded button--green'>{{ trans('account.settings_subscription.snooze2month') }}</a>" +
					"<a data-days='{{Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->addMonths(3)->format('d-m-Y')}}'  class='snooz-month button button--small button--rounded button--green'>{{ trans('account.settings_subscription.snooze3month') }}</a>" +
					"</div>" +
					"</form>",
					type: "",
					html: true,
					confirmButtonText: "{{ trans('account.settings_subscription.snooze_popup.button-snooze-text') }}",
					cancelButtonText: "{{ trans('account.settings_subscription.snooze_popup.button-close-text') }}",
					confirmButtonColor: "#3AAC87",
					allowOutsideClick: true,
					showCancelButton: true,
					closeOnConfirm: false
				}, function (inputValue) {
					if (inputValue) {
						return $("#snooze_form").submit();
					}
				});
			$( ".datepicker" ).datepicker({
				startDate: '{{Date::now()->addDay()->format('d-m-Y')}}',
				endDate: '{{Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->addDays(28)->format('d-m-Y')}}',
				daysOfWeekDisabled: [0,6],
				weekStart: 1,
				format: "dd-mm-yyyy"
			});
			$('.snooz-month').on('click',function(){

				$('input.datepicker').val($(this).data('days'));
				$('.confirm').attr('disabled',true);
				$("#snooze_form").submit();
			});
			@endif
		});
		$('.readMoreBtn').click(function (e) {
			e.preventDefault();

			$(this).hide();
			$(this).parent().find('.readLessBtn').show();
			$(this).parent().parent().find('.description').stop().slideToggle(200);
		});


		$('.not-snooz').on('click', function (e) {
			e.preventDefault();
			swal({
				title: "{{ trans('account.settings_subscription.snooze_popup.title-error') }}",
				text: "{{ trans('account.settings_subscription.snooze_popup.text-error') }}",
				type: "error",
				html: true,
				confirmButtonText: "{{ trans('account.settings_subscription.snooze_popup.button-snooze-text') }}",
				confirmButtonColor: "#3AAC87",
				allowOutsideClick: true,
				showCancelButton: false,
				closeOnConfirm: false
			});
		});

		$('.cancel-button').on('click',function(e){
			e.preventDefault();
			var href = $('.cancel-button').attr('href');
			swal({
				title: "",
				text: "<i class='fa fa-times close-but' aria-hidden='true'></i>{{ trans('account.settings_subscription.cancel-agree-text') }}"+
                "<div class='m-t-30 m-center'>" +
                "<a class='button button--light' href='{{ URL::action('AccountController@getCancelPage') }}'>{{ trans('account.settings_subscription.cancel-agree') }}</a>" +
				"<div class='spaced'></div>"+
                "<a class='button button--green confirm-snooz'>"+he.decode("{{ trans('account.settings_subscription.cancel-success') }}")+"</a>" +
                "</div>",
				type: "",
				html: true,
				cancelButtonText: "",
				confirmButtonText: "",
                showConfirmButton:false,
				allowOutsideClick: true,
				showCancelButton: false,
				closeOnConfirm: true
			}, function (isConfirm) {
				if (!isConfirm) {
                    swal.close();
				} else{
                    swal.close();
				}
			});
			$('.close-but').on('click',function(){
				swal.close();
			});
            $('.confirm-snooz').on('click',function(){
                $('#snooze-toggle').click();
            });
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