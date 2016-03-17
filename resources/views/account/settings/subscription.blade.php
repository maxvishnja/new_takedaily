@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-subscription')

@section('content')
	<h1>Dit abonnent</h1>
	<p>Pris pr. md.: {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true) }} kr.</p>
	{{--<p>- Heraf fragt: {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getShippingPrice(), true) }} kr</p>--}}
	<p>Startet.: {{ $plan->getSubscriptionStartedAt() }}</p>
	@if( $plan->isActive() )
		<p>Næste trækning.: {{ $plan->getRebillAt() }}
			({{ Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->diffForHumans() }})</p>
		@if($plan->isSnoozeable())
			<a href="#snooze-toggle" id="snooze-toggle">Snooze</a>
		@endif
	@endif
	<p>
		Status: {{ $plan->isActive() ? 'Aktiv' : ($plan->isCancelled() ? 'Afsluttet' : '')  }}
	</p>
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
				"<select name=\"days\">" +
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