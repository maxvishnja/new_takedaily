@extends('layouts.mail')

@section('title', 'Payments Error')
@section('summary', trans('mails.control-health.summary'))

@section('content')
    <h3>Payment error with {{ $payment }}</h3>
@endsection