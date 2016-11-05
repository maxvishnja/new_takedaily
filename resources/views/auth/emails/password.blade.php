@extends('layouts.mail')

@section('title', trans('mails.password.title'))
@section('summary', trans('mails.password.summary'))

@section('content')
	<p>
		{!! trans('mails.password.text', ['link' => url("password/reset/{$token}")]) !!}
	</p>

	<p>{{ trans('mails.password.ignore') }}</p>
@endsection