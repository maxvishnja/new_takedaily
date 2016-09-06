@extends('layouts.mail')

@section('title', 'En ny pakke afsendes indenfor 48 timer') <!-- todo translate -->
@section('summary', 'Vi sender din næste pakke om 48 timer!') <!-- todo translate -->

@section('content')
	<p>Din næste forsendelse oprettes d. {{ Date::createFromFormat('Y-m-d H:i:s', $rebillAt)->format('j. M Y H:i') }}</p>

	<h3 style="font-family: 'Open Sans',sans-serif; font-size: 18px;">Ønsker du at udskyde din forsendelse?</h3>
	<p>Vi tillader at du som kunde, kan udskyde din forsendelse - f.eks. hvis du ikke har fået taget alle vitaminerne, eller bare ønsker at vente med at betale og modtage.</p>
	<p>Ønsker du at udskyde? I så fald, så <a href="{{ URL::action('AccountController@getSettingsSubscription') }}">Tryk her</a> og så hjælper vi dig.</p>

	<p class="size-16" style='font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 16px;font-size: 16px;line-height: 24px;font-family: "Open Sans",sans-serif;color: #60666d;text-align: center;'>
		Mvh.<br/>
		TakeDaily
	</p>
@endsection