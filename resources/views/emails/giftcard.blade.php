@extends('layouts.mail')

@section('title', trans('mails.giftcard.title'))
@section('summary', trans('mails.giftcard.summary'))

@section('content')
	<p class="size-16" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 16px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;text-align: center;'>
		{!! trans('mails.giftcard.text') !!}
	</p>
@endsection