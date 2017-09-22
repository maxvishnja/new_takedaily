@extends('layouts.mail')

@section('title', trans('mails.order-sent.title'))
@section('summary', trans('mails.order-sent.summary'))

@section('content')
	<p>
		{!! str_replace('{name}', $name, nl2br(trans('mails.order-sent.text'))) !!}
	</p>
@endsection