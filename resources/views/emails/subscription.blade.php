@extends('layouts.mail')

@section('title', 'Vi har trukket penge') <!-- todo translate -->
@section('summary', 'Du blev faktureret af TakeDaily') <!-- todo translate -->

@section('content')

	<p class="size-16" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 16px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;text-align: center;'>
		Hej, da du har et abonnent hos os, har vi nu oprettet en ny ordre og trukket pengene for den. Du kan se dine ordre under "Mit TakeDaily" på vores hjemmeside.
	</p>

	<p class="size-16" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 16px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;text-align: center;'>
		Mvh.<br/>
		TakeDaily
	</p>
@endsection