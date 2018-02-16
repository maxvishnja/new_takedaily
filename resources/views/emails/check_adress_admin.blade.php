@extends('layouts.mail')

@section('title', 'Customer address incorrect')
@section('summary', trans('mails.control-health.summary'))

@section('content')
    <p>This email was sent because the address information of this order is incorrect:</p>
    <h3><a href="{{$link}}" target="_blank">{{$link}}</a></h3>
@endsection