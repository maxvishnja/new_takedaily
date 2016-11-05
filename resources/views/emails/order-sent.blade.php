@extends('layouts.mail')

@section('title', trans('mails.order-sent.title'))
@section('summary', trans('mails.order-sent.summary'))

@section('content')
	<p>
		{{ trans('mails.order-sent.text') }}
	</p>
@endsection