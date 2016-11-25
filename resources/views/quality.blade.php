@extends('layouts.app')

@section('pageClass', 'quality-products')

@section('title', trans('quality.title'))

@section('mainClasses', 'm-b-50')

@section('content')
	<div class="header_image">
		<div class="container">
			<h1>Vores produkter</h1>
			<p>Hos TakeDaily arbejder vi med både de bedste råvarer og leverandører på markedet, og vi er registreret hos Fødevarestyrelsen.</p>
		</div>
	</div>

	<section class="quality_section_one">
		<div class="container">
			<div class="row">
				<div class="aligner">
					<div class="col-md-6 col-md-push-6">
						<h2>Vores vitaminer og kosttilskud</h2>
						<p>Alle vores vitaminer og kosttilskud er af bedste kvalitet. Alle anvendte grundstoffer og underleverandører er godkendt ned til mindste detalje i EU, og
							vores
							egne formulaer er i overensstemmelse med reglerne for kosttilskud udstukket af EFSA (European Food Safety Authority).</p>

						<p>Uagtet hvilken sammensætning vi anbefaler dig, holder vi os altid under de daglige anbefalede værdier.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="quality_section_two">
		<div class="container">
			<div class="row">
				<div class="aligner">
					<div class="col-md-6">
						<h2>Vores kapsler er 100% plantebaseret</h2>
						<p>Som en af de eneste i Danmark, tilbyder vi ikke-gelatinebaserede kapsler i vores vitaminer og kosttilskud. Vores kapsler er lavet af det organiske stof
							cellulose
							(hydroxypropyl methylcellulose), som kommer fra træer. Det er en omstændig proces at producere, men det har flere gode egenskaber, blandt andet gør det
							kroppens
							optagelse af vitaminer, mineraler og omega-3 fedtsyrer væsentligt hurtigere. Desuden er kapslerne egnet til folk, som ikke ønsker gelatinebaserede
							produkter
							pga. livsstil eller religion.</p>

						<strong>I øvrigt er vores vitaminer, mineraler og omega-kapsler:</strong>

						<ul>
							<li>Certificeret i henhold til ISO 9001:2008 og GMP (Good Manufactoring Practice)</li>
							<li>100% uden konserveringsmidler.</li>
							<li>Godkendt til Kosher/Halal samt vegetarer/veganere</li>
							<li>Ikke-allergifremmende</li>
							<li>GMO-fri (ikke gen-modificeret organisme)</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="quality_section_three">
		<div class="container">
			<div class="row">
				<div class="aligner">
					<div class="col-md-6 text-center">
						<img src="/images/foa_logo.png" alt="Friends of the Sea"/>
					</div>

					<div class="col-md-6">
						<h2>Vores OMEGA-3</h2>
						<p>Vores omega-3 fiskeolie er baseret på den reneste olie fra anjoser og sardiner og indeholder over 55% EPA & DHA fedtsyrer.</p>

						<p>Vores fiskeolie er underlagt de strengeste kvalitetskrav, og er certificeret gennem hele processen fra produktion til forsendelse. Alle vores
							produktioner
							kan spores tilbage til hver enkelt fangst af fisk, som er certificeret af ”Friends of the Sea”. Dette sikrer at miljø og bæredygtighed er i højsæde.</p>
					</div>
				</div>
			</div>
		</div>
	</section>


	<style>
		.header_image {
			max-height: 800px;
			margin: 0;
			position: relative;
			text-align: center;
			padding: 100px 0;
			color: #fff;

			background-color: #fff;
			background-repeat: no-repeat;
			background-size: cover;
			background-position: center center;
			background-image: -webkit-linear-gradient(top, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(http://takedaily.dk.dev/uploads/cms/top/PmilHRBsD2b9tj6OJB2jhYbGqxFLfOqNDG8kaCjy.jpg);
			background-image: linear-gradient(-180deg, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(http://takedaily.dk.dev/uploads/cms/top/PmilHRBsD2b9tj6OJB2jhYbGqxFLfOqNDG8kaCjy.jpg);
		}

		section {
			padding: 100px 0;
			background-color: #fff;
			background-repeat: no-repeat;
			background-size: 50% 100%;
		}

		section.quality_section_one {
			background-image: linear-gradient(-90deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.00) 100%), linear-gradient(-90deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.00) 100%), url(/images/quality/one.jpg);
			background-position: left center;
		}

		section.quality_section_two {
			background-image: linear-gradient(-270deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.00) 100%), linear-gradient(-270deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.00) 100%), url(/images/quality/two.jpg);
			background-position: right center;
		}

		section .aligner {
			display: flex;
			align-items: center;
		}

		@media all and (max-width: 991px)
		{
			section {
				background-size: cover;
			}

			section .aligner {
				display: block;
			}
		}
	</style>
@endsection