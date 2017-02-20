@extends('layouts.mail')

@section('title', trans('mails.feedback.subject'))
@section('summary', trans('mails.control-health.summary'))

@section('content')

    <p>
        {!! str_replace('{name}', $name, nl2br(trans('mails.feedback.text'))) !!}
    </p>
@endsection