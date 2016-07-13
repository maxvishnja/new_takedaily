@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-billing')

@section('title', trans('account.settings_billing.title'))

@section('content')
	<h1>{{ trans('account.settings_billing.header') }}</h1>
	@if(count($sources) > 0)
		@foreach($sources as $source)
			@include("account.settings.payment_methods.{$method}", [$source])
		@endforeach
	@else
		<h3>{{ trans('account.settings_billing.no-method') }}</h3>
		<a href="{{ URL::action('AccountController@getSettingsBillingAdd') }}"
		   class="button button--green button--medium button--rounded button--full-mobile m-sm-b-10">{{ trans('account.settings_billing.button-add-method-text') }}</a>
		<a href="{{ URL::action('AccountController@getSettingsBillingRefresh') }}"
		   class="button button--light button--medium m-r-10 button--rounded button--full-mobile">{{ trans('account.settings_billing.button-update-text') }}</a>
	@endif
@endsection