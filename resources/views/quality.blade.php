@extends('layouts.app')

@section('pageClass', 'quality-products')

@section('title', trans('quality.title'))

@section('mainClasses', 'm-b-50')

@section('content')
	<div class="header_image">
		<div class="container">
			<h1>{{ trans('quality.page_title') }}</h1>

			<div class="row">
				<div class="col-md-6 col-md-push-3 text-left">
					{{--<h2>{!! trans('quality.subtitle') !!}</h2>--}}
				</div>
			</div>
		</div>
	</div>

	<div class="container m-t-30">
		<p>{!! trans('quality.subtitle') !!}</p>
	</div>

	<section class="quality_section_one">
		<div class="container">
			<div class="row">
				<div class="aligner">
					<div class="col-md-6 text-center">
						<img src="/images/quality/one.jpg" style="max-height: 400px;" alt="TakeDaily">
					</div>
					<div class="col-md-6">
						<h2>{{ trans('quality.section_vitamins.title') }}</h2>
						{!! trans('quality.section_vitamins.body') !!}
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
						<h2>{{ trans('quality.section_plants.title') }}</h2>
						{!! trans('quality.section_plants.body') !!}
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
						<h2>{{ trans('quality.section_foa.title') }}</h2>
						{!! trans('quality.section_foa.body') !!}
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="text-center m-t-50">
		<a href="{{ url()->route('flow') }}"
		   class="button button--rounded button--huge button--landing button--green">
			<strong>{!! trans('home.header.button-click-here') !!}</strong>
		</a>
		<div class="m-t-10"><a href="{{ url()->route('pick-package') }}">{{ trans('home.header.pick') }}</a></div>
	</div>


	<style>
		.header_image {
			padding: 40px 0;
			background-image: -webkit-linear-gradient(top, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/quality/bg.jpg);
			background-image: linear-gradient(-180deg, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/quality/bg.jpg);
		}

		section {
			padding: 60px 0;
			background-color: #fff;
			background-repeat: no-repeat;
			background-size: 50% 100%;
			font-size: 16px;
		}

		section h2 {
			font-size: 28px;
		}

		section.quality_section_two {
			background-image: linear-gradient(-270deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.00) 100%), linear-gradient(-270deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.00) 100%), url(/images/quality/two.jpg);
			background-position: right center;
		}

		section.quality_section_three img {
			width: 202px;
		}

		section .aligner {
			display: flex;
			align-items: center;
		}

		section ul {
			line-height: 2;
			list-style: disc;
			padding-left: 15px;
		}

		@media all and (max-width: 991px) {
			section {
				background-size: cover;
			}

			section .aligner {
				display: block;
			}

			section.quality_section_two {
				background-image: linear-gradient(-90deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.00) 55%), linear-gradient(-90deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.00) 100%), linear-gradient(-270deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.00) 100%), url(/images/quality/two.jpg);
			}
		}
	</style>
@endsection