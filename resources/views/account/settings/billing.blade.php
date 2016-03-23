@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-billing')

@section('title', 'Fakturering - Take Daily')

@section('content')
	<h1>Betalingsmetode</h1>
	@if( ! $source )
		<h3>Ingen betalingsmetode fundet! <a href="{{ URL::action('AccountController@getSettingsBillingRefresh') }}">Opdater</a></h3>
		<a href="{{ URL::action('AccountController@getSettingsBillingAdd') }}">Tilføj nyt kort</a>
	@else
		<span class="icon icon-card-{{ strtolower($source->brand) }}"></span>
		<h3>···· ···· ···· {{ $source->last4 }}</h3>
		<p>Udløb: {{ str_pad($source->exp_month, 2, 0, STR_PAD_LEFT) }}/{{ $source->exp_year }}</p>

		<div class="m-t-50">
			<a href="{{ URL::action('AccountController@getSettingsBillingRemove') }}" class="button button--small button--light button--rounded m-t-50">Fjern kort</a>
		</div>
	@endif
@endsection