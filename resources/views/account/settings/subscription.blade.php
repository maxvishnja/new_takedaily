@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-subscription')

@section('title', trans('account.settings_subscription.title'))

@section('content')
	<h1>{{ trans('account.settings_subscription.header', ['status' => trans('account.settings_subscription.plan.' . ( $plan->isActive() ? 'active' : 'cancelled' ) ) ]) }}</h1>
	<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true) ])]) !!}</h2>
	@if( $plan->isActive() )
		<p>{{ trans('account.settings_subscription.next-date', ['date' => Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y H:i') ]) }}</p>
		@if($plan->isSnoozeable())
			<a href="#snooze-toggle" id="snooze-toggle" class="m-t-20 button button--regular button--green button--rounded">{{ trans('account.settings_subscription.button-snooze-text') }}</a>
		@endif

		@if($plan->isCancelable())
			<div class="m-t-50">
				<a href="{{ URL::action('AccountController@getSettingsSubscriptionCancel') }}" class="button button--small button--light button--rounded m-t-50">{{ trans('account.settings_subscription.button-cancel-text') }}</a>
			</div>
		@endif
	@else
		<a href="{{ URL::action('AccountController@getSettingsSubscriptionRestart') }}" class="button button--large button--green button--rounded">{{ trans('account.settings_subscription.button-start-text') }}</a>
	@endif
@endsection

@section('footer_scripts')
	<script>
		$("#snooze-toggle").click(function (e)
		{
			e.preventDefault();

			swal({
				title: "{{ trans('account.settings_subscription.snooze_popup.title') }}",
				text: "{{ trans('account.settings_subscription.snooze_popup.text') }}" +
				"<form method=\"post\" action=\"{{ URL::action('AccountController@postSettingsSubscriptionSnooze') }}\" id=\"snooze_form\">" +
				"<select class=\"select select--regular m-t-10\" name=\"days\">" +
				"<option value=\"1\">{{ trans('account.settings_subscription.snooze_popup.option', ['days' => 1]) }}</option>" +
				"<option value=\"2\">{{ trans('account.settings_subscription.snooze_popup.option', ['days' => 2]) }}</option>" +
				"<option value=\"3\">{{ trans('account.settings_subscription.snooze_popup.option', ['days' => 3]) }}</option>" +
				"<option value=\"4\">{{ trans('account.settings_subscription.snooze_popup.option', ['days' => 4]) }}</option>" +
				"<option value=\"5\">{{ trans('account.settings_subscription.snooze_popup.option', ['days' => 5]) }}</option>" +
				"<option value=\"6\">{{ trans('account.settings_subscription.snooze_popup.option', ['days' => 6]) }}</option>" +
				"<option value=\"7\">{{ trans('account.settings_subscription.snooze_popup.option', ['days' => 7]) }}</option>" +
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
			}, function (inputValue)
			{
				if (inputValue)
				{
					return $("#snooze_form").submit();
				}
			});
		});
	</script>
@endsection