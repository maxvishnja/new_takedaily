@extends('layouts.landing')

@section('pageClass', 'index')

@section('content')
	<header class="header--landing header--front-slide-1">
		<div class="header-nav">
			<div class="container-fluid">
				<div class="header_top">
					<div class="row">
						<div class="col-md-3 col-xs-9">
							<a href="/" class="logo logo-white"></a>
						</div>

						<div class="col-md-9 col-xs-3">
							@include('includes.app.nav')
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="header_content">
			<div class="header_slides_container">
				<div class="header_slides">
					<div class="header_slide header_slide--active" data-slide="1">
						<div class="container">
							<h1>{!! trans('home.header.title-1') !!}</h1>
							<a href="{{ url()->route('flow') }}"
							   class="button button--rounded button--huge button--landing button--white m-t-30">
								<strong>{!! trans('home.header.button-click-here') !!}</strong>
							</a>
							<div class="or-pick-mix-link-container"><a href="{{ url()->route('pick-n-mix') }}">{{ trans('home.header.pick') }}</a></div>
							<div class="headervideo-block">
								<strong>{{ trans('home.header.what-is') }}</strong>
								<span id="video-toggle" class="icon icon-play"></span>
							</div>
						</div>
					</div>

					<div class="header_slide" data-slide="2">
						<div class="container">
							<div class="row">
								<div class="col-md-8">
									<h1>{!! trans('home.header.title-1') !!}</h1>
									<a href="{{ url()->route('flow') }}"
									   class="button button--rounded button--huge button--landing button--green m-t-30">
										<strong>{!! trans('home.header.button-click-here') !!}</strong>
									</a>
									<div class="or-pick-mix-link-container"><a href="{{ url()->route('pick-n-mix') }}">{{ trans('home.header.pick') }}</a></div>
									<div class="headervideo-block">
										<strong>{{ trans('home.header.what-is') }}</strong>
										<span id="video-toggle-two" class="icon icon-play"></span>
									</div>
								</div>
								<div class="col-md-4 hidden-sm hidden-xs">
									<div class="splash_circle pull-right hidden-xs">
										<span>{!! trans('home.header.splash.text') !!}</span>
										<strong>{!! trans('home.header.splash.price') !!}</strong>
										<small class="info">{!! trans('home.header.splash.info') !!}</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="header_slide_nav hidden-xs">
				<div class="header_slide_nav_item header_slide_nav_item--active" data-slide="1"></div>
				<div class="header_slide_nav_item" data-slide="2"></div>
			</div>
		</div>

		<div class="header_bg_slides_container">
			<div class="header_bg_slides">
				<div class="header_bg_item header_bg_item--1" data-slide="1"></div>
				<div class="header_bg_item header_bg_item--2" data-slide="2"></div>
			</div>
		</div>
	</header>

	<main>
		<div class="container">
			<div class="block block--one text-center">
				<h2>{{ trans('home.blocks.one.title') }}</h2>
				<p class="sub_header">{{ trans('home.blocks.one.description') }}</p>

				<div class="row text-center">
					<div class="col-sm-4 block_item">
						<div class="arrow"></div>
						<span class="icon icon-heart"></span>
						<h3>{{ trans('home.blocks.one.steps.one.title') }}</h3>
						<p>{{ trans('home.blocks.one.steps.one.text') }}</p>
					</div>

					<div class="col-sm-4 block_item">
						<div class="arrow"></div>
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

				<div class="text-center m-t-50">
					{!! trans('home.blocks.one.button') !!}

					<div class="m-t-20"><a href="{{ url()->route('pick-n-mix') }}">{{ trans('home.header.pick') }}</a></div>
				</div>
			</div>
		</div>

		<div class="block block--promises">
			<div class="container">
				<h2 class="text-center">{{ trans('home.blocks.promises.title') }}</h2>
				<div class="promise-container">
					<div class="promise-item">
						<img src="/images/promises/promise_1.png" alt=""/>
					</div>

					<div class="promise-item">
						<p>{{ trans('home.blocks.promises.promise-1') }}</p>
					</div>

					<div class="promise-item">
						<img src="/images/promises/promise_2.png" alt=""/>
					</div>

					<div class="promise-item">
						<p>{{ trans('home.blocks.promises.promise-2') }}
							<a href="/page/how-it-works">{{ trans('home.blocks.promises.read-more') }}</a></p>
					</div>

					<div class="promise-item">
						<p>{{ trans('home.blocks.promises.promise-3') }}</p>
					</div>

					<div class="promise-item">
						<img src="/images/promises/promise_3.png" alt=""/>
					</div>

					<div class="promise-item">
						<p>{{ trans('home.blocks.promises.promise-4') }} <a href="{{ url()->route('flow') }}">{{ trans('home.blocks.promises.get-started') }}</a></p>
					</div>

					<div class="promise-item">
						<img src="/images/promises/promise_4.png" alt=""/>
					</div>
				</div>
			</div>
		</div>

		<div class="block block--reviews">
			<div class="container">
				<h2 class="text-center">{{ trans('home.blocks.reviews.title') }}</h2>

				<div class="row">
					@foreach(trans('home.blocks.reviews.items') as $review)
						<div class="col-sm-4 review-item text-center">
							<img src="{{ $review['image'] }}" alt="{{ $review['name'] }}">
							<blockquote>”{{ $review['text'] }}”</blockquote>
						</div>
					@endforeach
				</div>
			</div>
		</div>

		<div class="block block--two">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h2>{!! trans('home.blocks.two.title') !!}</h2>
						{!! trans('home.blocks.two.body') !!}
						{!! trans('home.blocks.two.button') !!}
					</div>
				</div>
			</div>
		</div>

		@if( is_array( trans('home.blocks.six.slides') ) )
			<div class="block block--six">
				<div class="slider_container" id="slider_two">
					<div class="icon slider-arrow-left icon-arrow-left"></div>
					<div class="icon slider-arrow-right icon-arrow-right"></div>

					<div class="slider">
						<div class="slide_container">
							@foreach(trans('home.blocks.six.slides') as $slide)
								<div class="slide">
									<div class="container">
										<h2 class="text-center">{{ $slide['title'] }}</h2>
										<p class="text-center">{{ $slide['text'] }}</p>
										<div class="text-center">
											{!! $slide['button'] !!}
											<div class="m-t-20"><a href="{{ url()->route('pick-n-mix') }}">{{ trans('home.header.pick') }}</a></div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		@endif

		<div class="video-popup" id="video_popup">
			<div class="video-popup_container">
				<div class="video-popup-close" id="video_popup_close"><span class="icon icon-cross-large"></span></div>
				<div id="video_popup-content"></div>
			</div>
		</div>
	</main>
@endsection

@section('footer_scripts')
	<script>
		$("#slider_one").slider();
		$("#slider_two").slider();

		var videoPopup = $("#video_popup");
		var videoPopupContent = $("#video_popup-content");
		$("#video-toggle, #video-toggle-two").click(function (e) {
			videoPopupContent.html('<iframe width="960" height="540" src="https://www.youtube.com/embed/r0iLfAV0pIg" frameborder="0" allowfullscreen></iframe>');
			videoPopup.fadeIn(200);
		});

		$("#video_popup_close").click(function () {
			videoPopupContent.html('');
			videoPopup.hide();
		});

		$(".video-popup").click(function () {
			videoPopupContent.html('');
			videoPopup.hide();
		});

		$(".video-popup_container").click(function (e) {
			e.stopPropagation();
		});

		var header_slider = $(".header_slides");
		var header_bg_slider = $(".header_bg_slides");
		var header = $("header.header--landing");
		var logo = $(".logo");

		$(".header_slide_nav_item").click(function () {
			var currentSlide = $(this).data('slide');
			var activeSlide = $(".header_slide_nav_item--active");

			header.removeClass('header--front-slide-' + activeSlide.data('slide'));
			header.addClass('header--front-slide-' + currentSlide);
			activeSlide.removeClass("header_slide_nav_item--active");
			$(this).addClass("header_slide_nav_item--active");

			if (currentSlide == 1) {
				logo.addClass('logo-white');
				logo.removeClass('logo-color');
			}
			else {
				logo.addClass('logo-color');
				logo.removeClass('logo-white');
			}

			header_slider.css("transform", "translateX(-" + (currentSlide - 1) / 2 * 100 + "%)");
			header_slider.css("transform", "-webkit-translateX(-" + (currentSlide - 1) / 2 * 100 + "%)");

			header_bg_slider.css("transform", "translateX(-" + (currentSlide - 1) / 2 * 100 + "%)");
			header_bg_slider.css("transform", "-webkit-translateX(-" + (currentSlide - 1) / 2 * 100 + "%)");
		});

		setTimeout(function () {
			$(".header_slide_nav_item[data-slide='2']").click();
		}, 3000);
	</script>
@endsection