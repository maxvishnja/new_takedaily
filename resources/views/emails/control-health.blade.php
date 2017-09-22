@extends('layouts.mail')

@section('title', trans('mails.control-health.title'))
@section('summary', trans('mails.control-health.summary'))

@section('content')
    <p>
        {!! str_replace('{name}', $name, nl2br(trans('mails.control-health.text'))) !!}
    </p>

    <p>
        {!! str_replace('{id}', $id, nl2br(trans('mails.control-health.text2'))) !!}
    </p>
@endsection