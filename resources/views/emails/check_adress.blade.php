@extends('layouts.mail')

@section('title', str_replace('{name}', $name, nl2br(trans('mails.check_adress.welcome'))))
@section('summary', trans('mails.control-health.summary'))

@section('content')
    <h3 style="font-family: 'Open Sans',sans-serif; font-size: 18px;">{{ trans('mails.check_adress.title') }}</h3>
    <p>{{ trans('mails.check_adress.text') }}</p>
    <p>{!! trans('mails.check_adress.link', ['link' => $link ]) !!}</p>
@endsection