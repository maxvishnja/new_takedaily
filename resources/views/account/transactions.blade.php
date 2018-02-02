@extends('layouts.account')

@section('pageClass', 'account account-transactions')

@section('title', trans('account.transactions.title'))

@section('content')
	<style>
		p {
			font-size: 1.2rem;
			margin: .8rem 0;
			line-height: 1.2;
		}
		.card_content {
			font-size: 1.2rem;
		}
		thead, tbody {
			font-size: 1.2rem;
		}
	</style>
	<h1>{{ trans('account.transactions.header') }}</h1>

	<div class="card m-b-30">
		<div class="card_content">
			@if( $plan->isActive() )
				<div class="row m-b-10">
					<div class="col-md-6 m-b-10">
						<span>{!! trans('account.settings_subscription.next-date', ['date' => Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y') ]) !!}</span>
					</div>
					<div class="col-md-6 m-b-10">
						{{--@if(App::getLocale() == "da")--}}
						{{--<span>{!! trans('account.transactions.next-date', ['date1' => Date::createFromFormat('Y-m-d', $plan->getStartNextDeliveryDk())->format('j. M Y'), 'date' => Date::createFromFormat('Y-m-d', $plan->getEndNextDeliveryDk())->format('j. M Y') ]) !!}</span></div>--}}
						{{--@else--}}
						{{--<span>{!! trans('account.transactions.next-date', ['date1' => Date::createFromFormat('Y-m-d', $plan->getStartNextDeliveryNl())->format('j. M Y'), 'date' => Date::createFromFormat('Y-m-d', $plan->getEndNextDeliveryNl())->format('j. M Y') ]) !!}</span></div>--}}
						{{--@endif--}}
						{{ trans('account.transactions.delivery.text') }}

				</div>

				<div class="">
					@if($plan->isSnoozeable())
						<a href="#snooze-toggle" id="snooze-toggle"
						   class="button button--regular button--light button--rounded">{{ trans('account.settings_subscription.button-snooze-text') }}</a>
					@else
						<span
							class="button button--regular button--light  button--rounded not-snooz"
							title="{{ trans('account.settings_subscription.cant-snooze') }}">{{ trans('account.settings_subscription.button-snooze-text') }}</span>
					@endif
				</div>
			@endif
		</div>
	</div>

	<h1>{{ trans('account.transactions.header_history') }}</h1>
	@if($orders->count() == 0 )
		<h3>{{ trans('account.transactions.no-results') }}</h3>
	@else
		<table class="table table--full table--striped text-left table--responsive">
			<thead>
			<tr>
				<th>#</th>
				<th>{{ trans('account.transactions.table.date') }}</th>
				<th>{{ trans('account.transactions.table.amount') }}</th>
				<th>{{ trans('account.transactions.table.status') }}</th>
				<th>{{ trans('account.transactions.button-receipt') }}</th>
				<th>{{ trans('account.transactions.receipt-donwload') }}</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			@foreach($orders as $order)
				<tr>
					<td data-th="#">#{{ $order->getPaddedId() }}</td>
					<td data-th="{{ trans('account.transactions.table.date') }}">{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
					<td data-th="{{ trans('account.transactions.table.amount') }}">
						<strong>{{ trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true), 'currency' => $order->currency]) }}</strong>
					</td>
					<td data-th="{{ trans('account.transactions.table.status') }}"><span
							class="state-label state-label--{{ $order->state  }}">{{ trans("order.state.{$order->state}") }}</span></td>

					<td data-id="{{$order->id}}"><a
											class="button button--small button--rounded button--green reciept"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></td>

					<td data-th="&nbsp;"><a href='{{ URL::action('RecieptController@downloadReciept', [ 'id' => $order->id ]) }}'
								class="button button--small button--rounded button--blue"><i class="fa fa-download" aria-hidden="true"></i> </a></td>

					<td data-th="&nbsp;"><a href="{{URL::action('AccountController@getTransaction', [ 'id' => $order->id ]) }}"
											class="button button--small button--rounded button--grey">{{ trans('account.transactions.button-show-text') }}</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@endif


@endsection

@section('footer_scripts')
	<script>


		$('.reciept').on('click', function (e) {
			var id = $(this).parent().data('id');
			e.preventDefault();
			swal({
				title: "{{ trans('mails.order.receipt-title')}}",
				text: "{{ trans('account.transaction.receipt-text') }}" +
				"<form method=\"post\" action=\"{{ URL::action('RecieptController@sendReciept') }}\" id='reciept-form'>" +
						"<input type=\"email\" name=\"email\" required class=\"datepicker\" value='{{$plan->customer->getEmail()}}' placeholder=\"E-mail\" />" +
				"<input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token() }}\" />" +
				"<input type=\"hidden\" name=\"id\" class='hid-id' value=\"{{ csrf_token() }}\" />" +
				"</form>",
				type: "",
				html: true,
				confirmButtonText: "{{ trans('account.transaction.receipt-send') }}",
				cancelButtonText: "{{ trans('account.settings_subscription.snooze_popup.button-close-text') }}",
				confirmButtonColor: "#3AAC87",
				allowOutsideClick: true,
				showCancelButton: true,
				closeOnConfirm: false
			}, function (inputValue) {
				if (inputValue) {
					return $("#reciept-form").submit();
				}
			});

			$('.hid-id').val(id);
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
				closeOnConfirm: false,
			});
		});

		$("#snooze-toggle").click(function (e) {
			e.preventDefault();
			@if($plan->getRebillAt()!=null)
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
					closeOnConfirm: false,
				}, function (inputValue) {
					if (inputValue) {
						return $("#snooze_form").submit();
					}
				});
			@endif
			@if($plan->getRebillAt()!=null)
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

		$(".opsig").click(function (e) {
			e.preventDefault();
			$('.modal').modal('show');

		});

		$('.cus-mail').on('click',function(){
			if($(".cus-mail").prop("checked")){
				$('.email-cus').val($('.mailcus').val());
			} else{
				$('.email-cus').val('');
			}
		});

		@if((int) Request::get('already_open', 0) === 1)
			$("#snooze-toggle").click();
		@endif
	</script>
@endsection