<?php App::setLocale('da');?>
@extends('layouts.mail')

@section('title', 'Suspicious order')
@section('summary', trans('mails.control-health.summary'))

@section('content')

    <p style="font-size:16px">
        Suspicious order has been made.<br/>
        Coincidence: {{ $reason }}<br/>

        Customer {{ $name }} (ID {{ $customer_id }})
    </p>
@endsection