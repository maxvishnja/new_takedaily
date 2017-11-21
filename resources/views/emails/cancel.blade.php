<?php App::setLocale($locale);?>
@extends('layouts.mail')

@section('title', str_replace('{name}', $name, nl2br(trans('mails.cancel.title'))))
@section('summary', trans('mails.control-health.summary'))

@section('content')

    <p>
        {!! trans('mails.cancel.text') !!}
    </p>
@endsection