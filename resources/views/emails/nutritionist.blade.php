<?php App::setLocale($locale);?>
@extends('layouts.mail')

@section('title', str_replace('{n_name}', $name, nl2br(trans('mails.nutritionist.title'))))
@section('content')

    <h3> {!! str_replace('{name}', $name, nl2br(trans('mails.nutritionist.name'))) !!}</h3>

    <p>{{ trans('mails.nutritionist.text') }}</p>
    <p>{{$mess}}</p>

@endsection