@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-subscription')

@section('title', 'Abonnement - Take Daily')

@section('content')
	<h1>Dit abonnement er <span style="text-decoration: underline">{{ $plan->isActive() ? 'aktivt' : ($plan->isCancelled() ? 'afsluttet' : '')  }}</span></h1>
	<h2><span class="color--brand">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true) }} kr.</span><small> / måned</small></h2>
	@if( $plan->isActive() )
		<p>Næste trækningsdato: {{ Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y H:i') }}</p>
		@if($plan->isSnoozeable())
			<a href="#snooze-toggle" id="snooze-toggle" class="m-t-20 button button--regular button--green button--rounded">Udskyd næste forsendelse</a>
		@endif

		<div class="m-t-50">
			<a href="{{ URL::action('AccountController@getSettingsSubscriptionCancel') }}" class="button button--small button--light button--rounded m-t-50">Opsig
				abonnementet</a>
		</div>
	@endif
@endsection

@section('footer_scripts')
	<script>
		$("#snooze-toggle").click(function (e)
		{
			e.preventDefault();

			swal({
				title: "Snooze abonnent",
				text: "Hvor langt tid?" +
				"<form method=\"post\" action=\"{{ URL::action('AccountController@postSettingsSubscriptionSnooze') }}\" id=\"snooze_form\">" +
				"<select class=\"select select--regular m-t-10\" name=\"days\">" +
				"<option value=\"1\">1 dag</option>" +
				"<option value=\"2\">2 dage</option>" +
				"<option value=\"3\">3 dage</option>" +
				"<option value=\"4\">4 dage</option>" +
				"<option value=\"5\">5 dage</option>" +
				"<option value=\"6\">6 dage</option>" +
				"<option value=\"7\">7 dage</option>" +
				"</select>" +
				"<input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token() }}\" />" +
				"</form>",
				type: "",
				html: true,
				confirmButtonText: "Snooze",
				cancelButtonText: "Annuller",
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