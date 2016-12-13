@extends('layouts.mail')

@section('title', trans('mails.pending.title'))
@section('summary', trans('mails.pending.summary'))

@section('content')
	<p>{{ trans('mails.pending.next-order', ['date' => Date::createFromFormat('Y-m-d H:i:s', $rebillAt)->format('j. M Y H:i')]) }}</p>

	<h3 style="font-family: 'Open Sans',sans-serif; font-size: 18px;">{{ trans('mails.pending.snooze-title') }}</h3>
	<p>{{ trans('mails.pending.snooze-text') }}</p>
	<p>{!! trans('mails.pending.snooze-link', ['link' => URL::action('AccountController@getTransactions') ]) !!}</p>
@endsection