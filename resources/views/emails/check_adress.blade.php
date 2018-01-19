@extends('layouts.mail')

@section('title', str_replace('{name}', $name, nl2br(trans('mails.check_adress.welcome'))))
@section('summary', trans('mails.control-health.summary'))

@section('content')
    <p>{{ trans('mails.check_adress.text') }}</p>
    <h3>{!! trans('mails.check_adress.link', ['link' => $link ]) !!}</h3>
@endsection