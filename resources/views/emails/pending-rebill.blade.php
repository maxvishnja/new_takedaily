@extends('layouts.mail')

@section('title', 'En ny pakke afsendes indenfor 48 timer') <!-- todo translate -->
@section('summary', 'Vi sender din næste pakke om 48 timer!') <!-- todo translate -->

@section('content')
	<p>Din næste forsendelse oprettes d. {{ Date::createFromFormat('Y-m-d H:i:s', $rebillAt)->format('j. M Y H:i') }}</p>

	<h3 style="font-family: 'Open Sans',sans-serif; font-size: 18px;">Ønsker du at udskyde din forsendelse?</h3>
	<p>Vi tillader at du som kunde, kan udskyde din forsendelse - f.eks. hvis du ikke har fået taget alle vitaminerne, eller bare ønsker at vente med at betale og modtage.</p>
	<p>Ønsker du at udskyde? I så fald, så <a href="{{ URL::action('AccountController@getSettingsSubscription') }}">Tryk her</a> og så hjælper vi dig.</p>
@endsection