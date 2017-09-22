@extends('layouts.mail')

@section('title', str_replace('{name}', $name, nl2br(trans('mails.ambassador.title'))))
@section('summary', trans('mails.control-health.summary'))

@section('content')

    <p>
        {!! str_replace('{count}', $count, nl2br(trans('mails.ambassador.text'))) !!}
    </p>
@endsection