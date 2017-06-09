@extends('layouts.mail')

@section('title', trans('mails.almost-subject'))
@section('summary', trans('mails.control-health.summary'))

@section('content')

    <p>
        {{ trans('mails.almost-text') }}
    </p>
@endsection