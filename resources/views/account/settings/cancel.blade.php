@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-cancel')

@section('title', trans('account.settings_cancel.title'))

@section('content')
	<h1>{!! trans('account.settings_cancel.header') !!}</h1>

	<form action="{{ url()->action('AccountController@getSettingsSubscriptionCancel') }}" id="form" method="post">
		<select name="reason">
			<option value="{{ trans('account.settings_cancel.reasons.0') }}">{{ trans('account.settings_cancel.reasons.0') }}</option>
			<option value="{{ trans('account.settings_cancel.reasons.1') }}">{{ trans('account.settings_cancel.reasons.1') }}</option>
			<option value="{{ trans('account.settings_cancel.reasons.2') }}">{{ trans('account.settings_cancel.reasons.2') }}</option>
			<option value="{{ trans('account.settings_cancel.reasons.3') }}">{{ trans('account.settings_cancel.reasons.3') }}</option>
			<option value="{{ trans('account.settings_cancel.reasons.4') }}">{{ trans('account.settings_cancel.reasons.4') }}</option>
			<option value="{{ trans('account.settings_cancel.reasons.5') }}">{{ trans('account.settings_cancel.reasons.5') }}</option>
		</select>
		<button type="submit" class="button button--green button--large">{{ trans('account.settings_cancel.cancel') }}</button>
		<button type="submit" class="button button--white button--text-green button--large">{{ trans('account.settings_cancel.submit') }}</button>
	</form>
@endsection

@section('footer_scripts')
	<script>
		$("#form").submit(function (e) {
			return confirm('{{ trans('account.settings_cancel.are_you_sure') }}');
		});
	</script>
@endsection