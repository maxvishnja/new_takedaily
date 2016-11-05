@extends('layouts.mail')

@section('title', trans('mails.recommendation.title'))
@section('summary', trans('mails.recommendation.summary'))

@section('content')
	<p>
		{{ trans('mails.recommendation.text') }}
	</p>

	<a href="{{ url('/flow/?token=' . $token) }}">{{ trans('mails.recommendation.button') }}</a> {{-- todo button --}}
@endsection