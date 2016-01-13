@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-subscription')

@section('content')
	<h1>Dit abonnent</h1>
	<p>Pris pr. md.: {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true) }} kr.</p>
	<p>- Heraf fragt: {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getShippingPrice(), true) }} kr</p>
	<p>Startet.: {{ $plan->getSubscriptionStartedAt() }}</p>
	@if( $plan->isActive() )
		<p>Næste trækning.: {{ $plan->getRebillAt() }}
			({{ Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->diffForHumans() }})</p>
	@endif
	<p>
		Status: {{ $plan->isActive() ? 'Aktiv' : ($plan->isPaused() ? 'På pause' : ($plan->isCancelled() ? 'Afsluttet' : ''))  }} @if($plan->isActive())
			<a href="{{ URL::action('AccountController@getSettingsSubscriptionPause') }}">Sæt på
				pause</a> @endif @if($plan->isPaused())
			<a href="{{ URL::action('AccountController@getSettingsSubscriptionStart') }}">Start igen</a> @endif</p>

	<h2>Produkter</h2>
	<table>
		<thead>
		<tr>
			<th>Navn</th>
			<th>Pris</th>
		</tr>
		</thead>
		<tbody>
		@foreach($planProducts as $productitem )
			<tr>
				<td>{{ $productitem->product->name }}</td>
				<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($productitem->product->price_special, true) }}
					kr
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@endsection