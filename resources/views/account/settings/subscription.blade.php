@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-subscription')

@section('title', trans('account.settings_subscription.title'))

@section('content')
	<h1>{!! trans('account.settings_subscription.header', ['status' => trans('account.settings_subscription.plan.' . ( $plan->isActive() ? 'active' : 'cancelled' ) ) ]) !!}</h1>
	<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true), 'currency' => $plan->currency])]) !!}</h2>

	@foreach(Auth::user()->getCustomer()->getVitaminModels() as $vitamin)
		<span class="icon pill-{{ $vitamin->code }}"></span>
	@endforeach

	@if( $plan->isActive() )
		<p>{{ trans('account.settings_subscription.next-date', ['date' => Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y H:i') ]) }}</p>

		<div class="m-t-50">
			@if($plan->isSnoozeable())
				<a href="#snooze-toggle" id="snooze-toggle"
				   class="button button--regular button--light button--rounded">{{ trans('account.settings_subscription.button-snooze-text') }}</a>
			@else
				<span
					class="button button--regular button--light button--disabled button--rounded"
					title="{{ trans('account.settings_subscription.cant-snooze') }}">{{ trans('account.settings_subscription.button-snooze-text') }}</span>
			@endif

			@if($plan->isCancelable())
				<a href="{{ URL::action('AccountController@getSettingsSubscriptionCancel') }}"
				   class="button button--regular button--white button--text-grey button--rounded">{{ trans('account.settings_subscription.button-cancel-text') }}</a>
			@else
				<span
					class="button button--regular button--white button--text-grey button--disabled button--rounded"
					title="{{ trans('account.settings_subscription.cant-cancel') }}">{{ trans('account.settings_subscription.button-cancel-text') }}</span>
			@endif
		</div>
	@else
		<div class="m-t-10">
		<a href="{{ URL::action('AccountController@getSettingsSubscriptionRestart') }}"
		   class="button button--large button--green button--rounded">{{ trans('account.settings_subscription.button-start-text') }}</a>
		</div>
	@endif
@endsection

@section('footer_scripts')
	<script>
		$("#snooze-toggle").click(function (e) {
			e.preventDefault();

			swal({
				title: "{{ trans('account.settings_subscription.snooze_popup.title') }}",
				text: "{{ trans('account.settings_subscription.snooze_popup.text') }}" +
				"<form method=\"post\" action=\"{{ URL::action('AccountController@postSettingsSubscriptionSnooze') }}\" id=\"snooze_form\">" +
				"<select class=\"select select--regular m-t-10\" name=\"days\">" +
				@foreach(range(1,28) as $days)
				"<option value=\"{{ $days }}\">{{ trans('account.settings_subscription.snooze_popup.option', ['days' => $days ]) }}</option>" +
				@endforeach
				"</select>" +
				"<input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token() }}\" />" +
				"</form>",
				type: "",
				html: true,
				confirmButtonText: "{{ trans('account.settings_subscription.snooze_popup.button-snooze-text') }}",
				cancelButtonText: "{{ trans('account.settings_subscription.snooze_popup.button-close-text') }}",
				confirmButtonColor: "#777",
				allowOutsideClick: true,
				showCancelButton: true,
				closeOnConfirm: false,
			}, function (inputValue) {
				if (inputValue) {
					return $("#snooze_form").submit();
				}
			});
		});
	</script>
@endsection