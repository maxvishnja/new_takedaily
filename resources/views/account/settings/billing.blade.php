@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-billing')

@section('content')
	<h1>Betalingsmetode</h1>
	@if( ! $source )
		<h3>Ingen betalingsmetode fundet! <a href="{{ URL::action('AccountController@getSettingsBillingRefresh') }}">Opdater</a></h3>
		<a href="{{ URL::action('AccountController@getSettingsBillingAdd') }}">Tilføj nyt kort</a>
	@else
		<h3>{{ $source->brand }} (···· ···· ···· {{ $source->last4 }})</h3>
		<p>Udløb: {{ str_pad($source->exp_month, 2, 0, STR_PAD_LEFT) }}/{{ $source->exp_year }}</p>
		<a href="{{ URL::action('AccountController@getSettingsBillingRemove') }}">Fjern kort</a>
	@endif
@endsection