@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-subscription')

@section('title', trans('account.settings_subscription.title'))

@section('content')
	<h1>{!! trans('account.settings_subscription.header', ['status' => trans('account.settings_subscription.plan.' . ( $plan->isActive() ? 'active' : 'cancelled' ) ) ]) !!}</h1>
	<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true), 'currency' => $plan->currency])]) !!}</h2>

	@if( $plan->isActive() )
		<p>{!! strip_tags(trans('account.settings_subscription.next-date', ['date' => Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y') ]), '<strong>') !!}</p>

		<div class="m-b-30">
			@if($plan->isCancelable())
				<a href="{{ URL::action('AccountController@getCancelPage') }}"
				   class="button button--regular button--white button--text-grey button--rounded">{{ trans('account.settings_subscription.button-cancel-text') }}</a>
			@else
				<span
					class="button button--regular button--white button--text-grey button--disabled button--rounded"
					title="{{ trans('account.settings_subscription.cant-cancel') }}">{{ trans('account.settings_subscription.button-cancel-text') }}</span>
			@endif
		</div>
	@else
		<div class="m-t-20 m-b-30">
			<a href="{{ URL::action('AccountController@getSettingsSubscriptionRestart') }}"
		   	class="button button--large button--green button--rounded">{{ trans('account.settings_subscription.button-start-text') }}</a>
		</div>
	@endif

	@foreach(Auth::user()->getCustomer()->getVitaminModels() as $vitamin)
		<div class="new_vitamin_item">

			<div class="pill_section">
				<span class="icon pill-{{ strtolower($vitamin->code) }}"></span>
			</div>

			<div class="content_section">
				<strong>
					{{ $vitamin->name }}
				</strong>
				<p>{!! trans('label-' . strtolower($vitamin->code) . '.web_description') !!}</p>
			</div>
		</div>
	@endforeach
@endsection