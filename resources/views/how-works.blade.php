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
				</div>
			</div>
		</div>
	</div>

	<div class="container m-t-30">
		<div class="col-md-6 col-md-push-3">
			{!! trans('how-works.body') !!}
		</div>

		<div class="clear"></div>

		<div class="row text-center">
			<div class="col-sm-4 block_item">
				<span class="icon icon-heart"></span>
				<h3>{{ trans('home.blocks.one.steps.one.title') }}</h3>
				<p>{{ trans('home.blocks.one.steps.one.text') }}</p>
			</div>

			<div class="col-sm-4 block_item">
				<span class="icon icon-logo"></span>
				<h3>{{ trans('home.blocks.one.steps.two.title') }}</h3>
				<p>{{ trans('home.blocks.one.steps.two.text') }}</p>
			</div>

			<div class="col-sm-4 block_item">
				<span class="icon icon-box"></span>
				<h3>{{ trans('home.blocks.one.steps.three.title') }}</h3>
				<p>{{ trans('home.blocks.one.steps.three.text') }}</p>
			</div>
		</div>
	</div>

	<div class="text-center m-t-50">
		<a href="{{ url()->route('flow') }}"
		   class="button button--rounded button--huge button--landing button--green">
			<strong>{!! trans('home.header.button-click-here') !!}</strong>
		</a>
		<div class="m-t-10"><a href="{{ url()->route('pick-package') }}">{{ trans('home.header.pick') }}</a></div>
	</div>


	<style>
		.header_image {
			padding: 40px 0 60px;
			background-image: -webkit-linear-gradient(top, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/how-works/bg.jpg);
			background-image: linear-gradient(-180deg, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/how-works/bg.jpg);
		}
	</style>
@endsection