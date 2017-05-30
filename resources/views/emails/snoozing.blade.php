@extends('layouts.mail')

@section('title', str_replace('{name}', $name, nl2br(trans('mails.cancel.title'))))
@section('summary', trans('mails.control-health.summary'))

@section('content')

    <p>
        {!! str_replace('{days}', $days, nl2br(trans('mails.snoozing.text'))) !!}
    </p>
@endsection