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
					{{--<h2>{!! trans('about.subtitle') !!}</h2>--}}
				</div>
			</div>
		</div>
	</div>

	<div class="container m-t-30">
		<div class="row">
			<div class="col-md-8 col-md-push-2">
				{!! trans('about.body') !!}
			</div>
		</div>

		<div class="m-t-50">
			<h2 class="text-center">{{ trans('about.behind') }}</h2>

			<div class="row m-t-20">
				<div class="col-md-3 col-sm-4 person text-center">
					<img src="{{ asset('/images/about/people/marc.jpg') }}" alt="Personens navn">
					<h3>Navnet Her</h3>
					<strong>Personens stilling</strong>
				</div>
				<div class="col-md-3 col-sm-4 person text-center">
					<img src="{{ asset('/images/about/people/louise.jpg') }}" alt="Personens navn">
					<h3>Navnet Her</h3>
					<strong>Personens stilling</strong>
				</div>
				<div class="col-md-3 col-sm-4 person text-center">
					<img src="{{ asset('/images/about/people/lasse.jpg') }}" alt="Personens navn">
					<h3>Navnet Her</h3>
					<strong>Personens stilling</strong>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-push-2">
				<div class="m-t-50">
					<h2>{{ trans('about.story.title') }}</h2>
					{!! trans('about.story.text') !!}
				</div>
			</div>
		</div>

		<div class="text-center m-t-50">
			<a href="{{ url()->route('flow') }}"
			   class="button button--rounded button--huge button--landing button--green">
				<strong>{!! trans('home.header.button-click-here') !!}</strong>
			</a>
			{{--			<div class="m-t-10"><a href="{{ url()->route('pick-package') }}">{{ trans('home.header.pick') }}</a></div>--}}
		</div>
	</div>


	<style>
		.header_image {
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
			max-width: 180px;
			max-height: 180px;
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