@extends('layouts.account')

@section('pageClass', 'account account-transactions')

@section('title', trans('account.transactions.title'))

@section('content')
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
				weekStart: 1,
				daysOfWeekDisabled: [0,6],
				format: "dd-mm-yyyy"
			});
		});



		@if((int) Request::get('already_open', 0) === 1)
			$("#snooze-toggle").click();
		@endif
	</script>
@endsection