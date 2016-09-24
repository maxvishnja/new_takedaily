@extends('layouts.mail')

@section('title', 'Din nye adgangskode på TakeDaily') <!-- todo translate -->
@section('summary', 'Nulstil din adgangskode her') <!-- todo translate -->

@section('content')
	<p>
		Du har bedt om at nulstille din adgangskode på TakeDaily. For at gøre dette, skal du trykke her: <a href="{{ url('password/reset/'.$token) }}">Nulstil min adgangskode</a>, eller her: <br/><br/>	<a href="{{ url('password/reset/'.$token) }}">{{ url('password/reset/'.$token) }}</a>
	</p>

	<p>Har du ikke bedt om at nulstille din adgangskode, så ignorer venligst denne mail.</p>
@endsection