@extends('layouts.mail')

@section('title', trans('mails.order-print.title'))
@section('summary', trans('mails.order-sent.summary'))

@section('content')
    <p>
        {!! str_replace('{name}', $name, nl2br(trans('mails.order-print.text'))) !!}
    </p>
@endsection