@extends('layouts.mail')

@section('title', trans('mails.rebill-failed.title'))
@section('summary', trans('mails.rebill-failed.summary'))

@section('content')
	<p>
		{{ trans('mails.rebill-failed.text') }}
	</p>

	<p>
		{{ trans('mails.rebill-failed.text2') }}
	</p>
@endsection