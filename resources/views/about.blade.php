@extends('layouts.app')

@section('pageClass', 'about-us')

@section('title', trans('about.title'))

@section('mainClasses', 'm-b-50')

@section('content')
	<div class="header_image">
		<div class="container">
			<h1>{{ trans('about.page_title') }}</h1>

			<div class="row">
				<div class="col-md-6 col-md-push-3 text-left">
					<h2>{!! trans('about.subtitle') !!}</h2>
				</div>
			</div>
		</div>
	</div>

	<div class="container m-t-30">
		<div class="row">
			<div class="col-md-6 col-md-push-3">
				<p>Vi er en gruppe dedikerede diætister, farmaceuter og læger, der er gået sammen om radikalt at ændre på den måde vi spiser vitaminer og kosttilskud.</p>
				<p>Det er en kompliceret proces at finde frem til de vitaminer og kosttilskud, der passer netop til dig. Markedet er præget af et overvældende udbud og selvmodsigende budskaber om, hvad vi bør spise, og hvad vi skal holde os lang væk fra. Vi vil med TakeDaily gøre det nemt for dig at få dine daglige vitaminer, mineraler og omega-3 fedtsyrer. I samarbejde med førende eksperter, forfølger vi nu visionen om at blive danskernes førende og foretrukne brand inden for vitaminer og kosttilskud.</p>
			</div>
		</div>

		<div class="row m-t-50">
			@foreach(range(1,8) as $item)
				<div class="col-md-3 col-sm-4 person text-center">
					<img src="//placehold.it/400x400" alt="Personens navn">
					<h3>Navnet Her</h3>
					<strong>Personens stilling</strong>
				</div>
			@endforeach
		</div>
	</div>


	<style>
		.header_image {
			padding: 40px 0 60px;
			background-image: -webkit-linear-gradient(top, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/about/bg.jpg);
			background-image: linear-gradient(-180deg, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/about/bg.jpg);
		}

		p {
			font-size: 16px;
			line-height: 28px;
		}

		.person {
			margin-bottom: 60px;
		}

		.person img {
			width: 100%;
			border-radius: 100%;
		}

		.person h3 {
			font-size: 22px;
			margin: 20px 0 6px;
		}

		.person strong {
			font-size: 16px;
			font-weight: normal;
		}
	</style>
@endsection