@extends('layouts.mail')

@section('title', str_replace('{name}', $name, nl2br(trans('mails.pending.welcome'))))
@section('summary', trans('mails.pending.summary'))

@section('content')
	<h3 style="font-family: 'Open Sans',sans-serif; font-size: 18px;">{{ trans('mails.pending.snooze-title') }}</h3>
	<p>{{ trans('mails.pending.snooze-text') }}</p>
	<p>{!! trans('mails.pending.snooze-link', ['link' => $link ]) !!}</p>
@endsection