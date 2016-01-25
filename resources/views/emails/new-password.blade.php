@extends('layouts.mail')

@section('title', 'Dit nye kodeord er:') <!-- todo translate -->
@section('summary', 'Du får her dit nyt kodeord til TakeDaily') <!-- todo translate -->

@section('content')
	<p class="size-16" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 16px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;text-align: center;'>
		<strong>{{ $password }}</strong>
	</p>

	<p class="size-16" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 16px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;text-align: center;'>
		Mvh.<br/>
		TakeDaily
	</p>
@endsection