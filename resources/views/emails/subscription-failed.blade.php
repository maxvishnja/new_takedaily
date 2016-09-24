@extends('layouts.mail')

@section('title', 'Vi kan ikke trække penge for dit abonnement') <!-- todo translate -->
@section('summary', 'TakeDaily har forgæves forsøgt at fakturere dig for dit abonnement') <!-- todo translate -->

@section('content')
	<p>
		Hej, vi har netop forsøgt at trække penge for dit aktive abonnement, men fejlede. Dette kan skyldes flere ting, bl.a. at betalingsmetoden er udløbet, eller at der ikke er dækning på kontoen.
	</p>

	<p>
		Ønsker du at modtage din TakeDaily pakke beder vi dig derfor gennemgå dine konti, og betalignsmetoden du anvender. Vi forsøger automatisk igen indenfor 24 timer.
	</p>
@endsection