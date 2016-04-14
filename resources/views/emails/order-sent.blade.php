@extends('layouts.mail')

@section('title', 'Din ordre blev afsendt') <!-- todo translate -->
@section('summary', 'Din ordre hos TakeDaily blev afsendt!') <!-- todo translate -->

@section('content')
	<p class="size-16" style='font-style: normal;font-weight: 400;Margin-bottom: 0;font-size: 16px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;text-align: center;'>
		Din ordre på TakeDaily blev markeret som "afsendt".
	</p>

	<p class="size-16" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 16px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;text-align: center;'>
		Mvh.<br/>
		TakeDaily
	</p>
@endsection