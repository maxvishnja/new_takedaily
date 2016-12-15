@extends('layouts.app')

@section('pageClass', 'how-works')

@section('title', trans('how-works.title'))

@section('mainClasses', 'm-b-50')

@section('content')
	<div class="header_image">
		<div class="container">
			<h1>{{ trans('how-works.page_title') }}</h1>

			<div class="row">
				<div class="col-md-6 col-md-push-3 text-left">
					{{--<h2>{!! trans('how-works.subtitle') !!}</h2>--}}
					<div class="headervideo-block">
						<div class="video_circle" id="video-toggle-two">
							<div class="video_circle_content">
								<span class="icon icon-play"></span>
								<strong>{{ trans('home.play_video') }}</strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<img src="{{ asset('/images/how-works/icon-heart@2x.png') }}" height="276" alt="Heart">
				</div>
				<div class="col-md-6">
					<h3>{{ trans('how-works.steps.one.title') }}</h3>
					<p>{!! trans('how-works.steps.one.body') !!}</p>
				</div>
			</div>
		</div>
	</section>

	<section class="mid">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-push-8">
					<div class="visible-xs">
						<img src="{{ asset('/images/how-works/icon-logo@2x.png') }}" height="276" alt="Logo">
					</div>

					<div class="hidden-xs text-right">
						<img src="{{ asset('/images/how-works/icon-logo@2x.png') }}" height="276" alt="Logo">
					</div>
				</div>
				<div class="col-md-6 col-md-pull-4">
					<h3>{{ trans('how-works.steps.two.title') }}</h3>
					<p>{!! trans('how-works.steps.two.body') !!}</p>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<img src="{{ asset('/images/how-works/icon-box@2x.png') }}" height="276" alt="Box">
				</div>
				<div class="col-md-6">
					<h3>{{ trans('how-works.steps.three.title') }}</h3>
					<p>{!! trans('how-works.steps.three.body') !!}</p>
				</div>
			</div>
		</div>
	</section>

	<div class="text-center m-t-50">
		<a href="{{ url()->route('flow') }}"
		   class="button button--rounded button--huge button--landing button--green">
			<strong>{!! trans('home.header.button-click-here') !!}</strong>
		</a>
		<div class="or-pick-mix-link-container m-t-10"><a href="{{ url()->route('pick-n-mix') }}">{{ trans('pick.cta_for_other_pages') }}</a></div>
	</div>


	<style>
		.header_image {
			padding: 40px 0 60px;
			background-image: -webkit-linear-gradient(top, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/how-works/bg.jpg);
			background-image: linear-gradient(-180deg, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/how-works/bg.jpg);
		}
		main p {
			font-size: 16px;
		}
		main h3 {
			font-size: 22px;
		}

		section {
			padding: 80px 0;
		}

		section.mid {
			background: #fafafa;
		}
	</style>
@endsection