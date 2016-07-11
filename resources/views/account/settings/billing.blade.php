@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-billing')

@section('title', trans('account.settings_billing.title'))

@section('content')
	<h1>{{ trans('account.settings_billing.header') }}</h1>
	@if( ! $source )
		<h3>{{ trans('account.settings_billing.no-method') }}</h3>
		<a href="{{ URL::action('AccountController@getSettingsBillingAdd') }}" class="button button--green button--medium button--rounded button--full-mobile m-sm-b-10">{{ trans('account.settings_billing.button-add-method-text') }}</a>
		<a href="{{ URL::action('AccountController@getSettingsBillingRefresh') }}" class="button button--light button--medium m-r-10 button--rounded button--full-mobile">{{ trans('account.settings_billing.button-update-text') }}</a>
	@else
		<span class="icon icon-card-{{ strtolower($source->brand) }}"></span>
		<h3>···· ···· ···· {{ $source->last4 }}</h3>
		<p>{{ trans('account.settings_billing.card-exp') }} {{ str_pad($source->exp_month, 2, 0, STR_PAD_LEFT) }}/{{ $source->exp_year }}</p>

		<div class="m-t-50">
			<a href="{{ URL::action('AccountController@getSettingsBillingRemove') }}" class="button button--small button--light button--rounded m-t-50">{{ trans('account.settings_billing.button-remove-text') }}</a>
		</div>
	@endif
@endsection