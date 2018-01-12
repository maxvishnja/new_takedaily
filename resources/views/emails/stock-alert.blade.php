@extends('layouts.mail')

@section('content')
    <p class="size-16" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 16px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;text-align: center;'>
        Hello. Stock item {{ $item->name }} is getting low. <br>
        Please check stock dashboard.
    </p>
@endsection