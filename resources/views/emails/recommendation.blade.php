@extends('layouts.mail')

@section('title', 'Din anbefaling') <!-- todo translate -->
@section('summary', 'Her er din TakeDaily anbefaling') <!-- todo translate -->

@section('content')
	<p>
		Hej, du har modtaget en TakeDaily anbefaling. Du kan fortsætte handlen på linket herunder.
	</p>

	<a href="{{ url('/flow/?token=' . $token) }}">Fortsæt handlen her</a> {{-- todo button --}}
@endsection