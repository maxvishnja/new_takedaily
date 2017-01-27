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
				<div class="col-sm-4 person text-center">
					<img src="{{ asset('/images/about/people/kirsten.jpg') }}" alt="{{ trans('about.people.kirsten.name') }}">
					<h3>{{ trans('about.people.kirsten.name') }}</h3>
					<strong>{{ trans('about.people.kirsten.job') }}</strong>
				</div>

				<div class="col-sm-4 person text-center">
					<img src="{{ asset('/images/about/people/louise.jpg') }}" alt="{{ trans('about.people.louise.name') }}">
					<h3>{{ trans('about.people.louise.name') }}</h3>
					<strong>{{ trans('about.people.louise.job') }}</strong>
				</div>

				<div class="col-sm-4 person text-center">
					<img src="{{ asset('/images/about/people/marie-louise.jpg') }}" alt="{{ trans('about.people.marie-louise.name') }}">
					<h3>{{ trans('about.people.marie-louise.name') }}</h3>
					<strong>{{ trans('about.people.marie-louise.job') }}</strong>
				</div>

				<div class="col-sm-4 person text-center">
					<img src="{{ asset('/images/about/people/marc.jpg') }}" alt="{{ trans('about.people.marc.name') }}">
					<h3>{{ trans('about.people.marc.name') }}</h3>
					<strong>{{ trans('about.people.marc.job') }}</strong>
				</div>

				<div class="col-sm-4 person text-center">
					<img src="{{ asset('/images/about/people/erik.jpg') }}" alt="{{ trans('about.people.erik.name') }}">
					<h3>{{ trans('about.people.erik.name') }}</h3>
					<strong>{{ trans('about.people.erik.job') }}</strong>
				</div>

				<div class="col-sm-4 person text-center">
					<img src="{{ asset('/images/about/people/lasse.jpg') }}" alt="{{ trans('about.people.lasse.name') }}">
					<h3>{{ trans('about.people.lasse.name') }}</h3>
					<strong>{{ trans('about.people.lasse.job') }}</strong>
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
			<div class="or-pick-mix-link-container m-t-10">
				@if(App::getLocale() != 'nl')
				<a href="{{ url()->route('pick-n-mix') }}">{{ trans('pick.cta_for_other_pages') }}</a>
				@endif
			</div>
		</div>
	</div>


	<style>
		.header_image {
			background-image: -webkit-linear-gradient(top, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/about/bg.jpg);
			background-image: linear-gradient(-180deg, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/about/bg.jpg);
		}

		main p {
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