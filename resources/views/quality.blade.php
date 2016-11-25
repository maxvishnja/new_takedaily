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
			<div class="col-md-push-6">hej</div>
		</div>
	</section>

	<section class="quality_section_two">

	</section>

	<section class="quality_section_three">

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
			background-image: linear-gradient(-90deg, rgba(255,255,255, 1) 0%, rgba(255,255,255, 0.00) 100%), linear-gradient(-90deg, rgba(255,255,255, 1) 0%, rgba(255,255,255, 0.00) 100%), url(/images/quality/one.jpg);
			background-position: left center;
		}

		section.quality_section_two {
			background-image: linear-gradient(-270deg, rgba(255,255,255, 1) 0%, rgba(255,255,255, 0.00) 100%), linear-gradient(-270deg, rgba(255,255,255, 1) 0%, rgba(255,255,255, 0.00) 100%), url(/images/quality/two.jpg);
			background-position: right center;
		}

		section.quality_section_three {
		}
	</style>
@endsection