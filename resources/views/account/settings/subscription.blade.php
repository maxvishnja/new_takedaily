@extends('layouts.account')
{{-- todo translate view --}}
@section('pageClass', 'account account-settings account-settings-subscription')

@section('title', trans('account.settings_subscription.title'))

@section('content')
	@if(Auth::user()->getCustomer()->hasNewRecommendations()) {{-- todo translate --}}
	<div class="card m-b-50">
		<div class="card-body">
			<h2 class="card_title">Vi har nye anbefalinger til dig.</h2>
			<hr>
			<p>Ud fra din profil kan vi se at nogle andre vitaminer måske er bedre for dig.</p>
			<a href="{{ URL::action('AccountController@updateVitamins') }}" class="button button--green button--large">Opdater mine vitaminer</a>
		</div>
	</div>
	@endif


	<h1>{!! trans('account.settings_subscription.header', ['status' => trans('account.settings_subscription.plan.' . ( $plan->isActive() ? 'active' : 'cancelled' ) ) ]) !!}</h1>
	<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true) ])]) !!}</h2>
	@if( $plan->isActive() )
		<p>{{ trans('account.settings_subscription.next-date', ['date' => Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y H:i') ]) }}</p>

		<div class="m-t-50">
			@if($plan->isSnoozeable())
				<a href="#snooze-toggle" id="snooze-toggle"
				   class="button button--regular button--light button--rounded">{{ trans('account.settings_subscription.button-snooze-text') }}</a>
			@else
				<span
					class="button button--regular button--light button--disabled button--rounded"
					title="Din næste trækning er indenfor 24 timer, du kan derfor ikke udskyde.">{{ trans('account.settings_subscription.button-snooze-text') }}</span>
			@endif

			@if($plan->isCancelable())
				<a href="{{ URL::action('AccountController@getSettingsSubscriptionCancel') }}"
				   class="button button--regular button--white button--text-grey button--rounded">{{ trans('account.settings_subscription.button-cancel-text') }}</a>
			@else
				<span
					class="button button--regular button--white button--text-grey button--disabled button--rounded"
					title="Din næste trækning er indenfor 48 timer, du kan derfor ikke annullere">{{ trans('account.settings_subscription.button-cancel-text') }}</span>
			@endif
		</div>
	@else
		<a href="{{ URL::action('AccountController@getSettingsSubscriptionRestart') }}"
		   class="button button--large button--green button--rounded">{{ trans('account.settings_subscription.button-start-text') }}</a>
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