@extends('layouts.mail')

@section('title', trans('mails.almost-subject'))
@section('summary', trans('mails.control-health.summary'))

@section('content')

    <p>
        {!! str_replace('{name}', $name, nl2br(trans('mails.almost-text'))) !!}
</p>
@endsection