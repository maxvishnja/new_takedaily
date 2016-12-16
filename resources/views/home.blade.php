@extends('layouts.landing')

@section('pageClass', 'index')

@section('content')
	<header class="header--landing header--front-slide-1">
		<div class="header-nav">
			<div class="container-fluid">
				<div class="header_top">
					<div class="row">
						<div class="col-md-3 col-xs-9">
							<a href="/" class="logo logo-color"></a>
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
					<div class="header_slide" data-slide="2">
						<div class="container">
							<div class="row">
								<div class="col-md-9">
									<h1>{!! trans('home.header.title-1') !!}</h1>
									<p style="font-size: 18px;"><strong>{{ trans('home.header.subtitle') }}</strong></p>

									<div class="m-t-20 pricing_item_header m-t-20 m-b-50">
										<strong>{!! trans('home.header.splash.price') !!}</strong>
										<small class="info">{!! trans('home.header.splash.info') !!}</small>
									</div>

									<div class="m-t-10">
										<div class="pull-left">
											<a href="{{ url()->route('flow') }}"
											   class="button button--rounded button--huge button--landing button--green m-b-10">
												<strong>{!! trans('home.header.button-click-here') !!}</strong>
											</a>
											<div class="or-pick-mix-link-container"><a href="{{ url()->route('pick-n-mix') }}">{{ trans('pick.cta_for_other_pages') }}</a></div>
										</div>

										<div class="clear visible-xs"></div>

										<div class="pull-left pull-left-n-mobile">
											<div class="headervideo-block m-l-35">
												<div class="video_circle" id="video-toggle-two">
													<div class="video_circle_content">
														<span class="icon icon-play"></span>
													</div>
												</div>
												<strong>{{ trans('home.header.what-is') }}</strong>
											</div>
										</div>
										<div class="clear"></div>
									</div>

									<div class="clear"></div>
								</div>
							</div>

							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="landing_advantages_placeholder"></div>

	<div class="landing_advantages">
		<div class="container-fluid">

			<div class="col-md-3 col-sm-6">
				<div class="home-promo-item-with-icon">
					<span class="icon icon-front-scissor"></span>
					{{ trans('home.promos.two') }}
				</div>
			</div>

			<div class="col-md-3 col-sm-6">
				<div class="home-promo-item-with-icon">
					<span class="icon icon-front-delivery"></span>
					{{ trans('home.promos.four') }}
				</div>
			</div>

			<div class="col-md-3 col-sm-6">
				<div class="home-promo-item-with-icon">
					<span class="icon icon-front-post"></span>
					{{ trans('home.promos.one') }}
				</div>
			</div>

			<div class="col-md-3 col-sm-6">
				<div class="home-promo-item-with-icon">
					<span class="icon icon-front-support"></span>
					{{ trans('home.promos.three') }}
				</div>
			</div>
		</div>
	</div>

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
						<p>{{ trans('home.blocks.promises.promise-2') }}</p>
					</div>

					<div class="promise-item">
						<p>{{ trans('home.blocks.promises.promise-3') }}</p>
					</div>

					<div class="promise-item">
						<img src="/images/promises/promise_3.png" alt=""/>
					</div>

					<div class="promise-item">
						<p>{{ trans('home.blocks.promises.promise-4') }}</p>
					</div>

					<div class="promise-item">
						<img src="/images/promises/promise_4.png" alt=""/>
					</div>
				</div>
			</div>
		</div>

		<div class="new_block">
			<div class="container">
				<div class="row">
					<div class="flex-desktop">
						<div class="col-md-6 col-md-push-6 text-center">
							<img src="/images/marie-louise-home.jpg" alt="Marie-Louise" style="border-radius: 10px" width="330"/>
							<div class="m-t-20">{!! trans('home.new_blocks.one.below_image') !!}</div>
						</div>
						<div class="col-md-6 col-md-pull-6">
							<h3 style="font-size: 20px;">{{ trans('home.new_blocks.one.title') }}</h3>
							{!! trans('home.new_blocks.one.body') !!}
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="new_block">
			<div class="container">
				<div class="row">
					<div class="flex-desktop">
						<div class="col-md-6 text-center">
							<img src="/images/new_blocks_two.jpg" width="400" alt="{{ trans('home.new_blocks.two.title') }}" style="border-radius: 10px"/>
							<div class="m-t-20">{!! trans('home.new_blocks.two.below_image') !!}</div>
						</div>
						<div class="col-md-6">
							<h3 style="font-size: 20px;">{{ trans('home.new_blocks.two.title') }}</h3>
							{!! trans('home.new_blocks.two.body') !!}
						</div>
					</div>
				</div>
			</div>
		</div>

		@if( is_array( trans('home.blocks.six.slides') ) )
			<div class="block block--six" style="position: relative">
				<div class="slider_container" id="slider_two">
					<div class="icon slider-arrow-left icon-arrow-left"></div>
					<div class="icon slider-arrow-right icon-arrow-right"></div>

					<div class="slider">
						<div class="slide_container">
							@foreach(trans('home.blocks.six.slides') as $key => $slide)
								<div class="slide slide--{{$key}}">
									<div class="container">
										<h2 class="text-center">{{ $slide['title'] }}</h2>
										<p class="text-center">{{ $slide['text'] }}</p>
										<div class="text-center">
											{!! $slide['button'] !!}
											{{--<div class="m-t-20"><a href="{{ url()->route('pick-package') }}">{{ trans('home.header.pick') }}</a></div>--}}
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>

					<div class="slider_two_progress"
						 style="position: absolute; left: 50%; margin-left: -50px; bottom: 20px; height: 4px; background: rgba(0,0,0,.25); width: 100px">
						<div class="bar" style="height: 4px; background: rgba(0,0,0,.25); width: 0"></div>
					</div>
				</div>
			</div>
		@endif

		<div class="block--faq m-t-30 m-b-30">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-push-2">
						<h3 style="font-size: 32px" class="text-center">{{ trans('faq.title') }}</h3>
						<div class="faqs">
							@foreach($faqs as $faq)
								<div class="faq">
									<div class="faq_header">
										<strong>{{ $faq->question }}</strong>
										<span class="icon icon-arrow-down"></span>

										<div class="clear"></div>
									</div>

									<div class="faq_answer">
										{!! $faq->answer !!}
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="video-popup" id="video_popup">
			<div class="video_popup_aligner">
				<div class="video-popup_container">
					<div class="video-popup-close" id="video_popup_close"><span class="icon icon-cross-large"></span></div>
					<div id="video_popup-content"></div>
				</div>
			</div>
		</div>
	</main>
@endsection

@section('footer_scripts')
	<script>
		$("#slider_two").slider();

		var auto_slide_progress = $(".slider_two_progress");
		var auto_slide_progress_bar = auto_slide_progress.find('.bar');
		var auto_slide_state = 0;
		var auto_slide_interval = 800;

		setInterval(function () {
			auto_slide_state++;
			auto_slide_progress_bar.width((auto_slide_state / 800 * 100) + '%');

			if (auto_slide_state >= auto_slide_interval) {
				auto_slide_state = 0;
				$("#slider_two .slider-arrow-right").click();
			}
		}, 10);

		$("#slider_two .slider-arrow-left, #slider_two .slider-arrow-right").click(function () {
			auto_slide_state = 0;
		});


		var videoPopup = $("#video_popup");
		var videoPopupContent = $("#video_popup-content");
		$("#video-toggle, #video-toggle-two").click(function (e) {
			videoPopupContent.html('<video width="960" preload="none" autoplay controls>' +
				'<source src="/video/{{ App::getLocale() }}/home.mp4" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' />' +
				'<source src="/video/{{ App::getLocale() }}/home.webm" type=\'video/webm; codecs="vp8, vorbis"\' />' +
				'<source src="/video/{{ App::getLocale() }}/home.ogv" type=\'video/ogg; codecs="theora, vorbis"\' />' +
				'<source src="/video/{{ App::getLocale() }}/home.m4v" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' />' +
				'</video>');
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

		$(".faq").click(function () {
			var currentFaq = $(".faq.open");
			var thisFaq = $(this);

			if (currentFaq !== undefined) {
				currentFaq.find('.faq_answer').stop().slideUp(250); // Sadly, height is dynamic so CSS animations is no option.
				currentFaq.removeClass('open');
			}

			if (!thisFaq.is(currentFaq)) {
				thisFaq.addClass('open');
				thisFaq.find('.faq_answer').stop().slideDown(250); // Sadly, height is dynamic so CSS animations is no option.
			}
		});
	</script>

	<style>
		.home-promo-item-with-icon {
			height: 31px;
			line-height: 31px;
		}
	</style>
@endsection