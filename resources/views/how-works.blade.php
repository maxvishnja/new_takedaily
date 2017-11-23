@extends('layouts.app')

@section('pageClass', 'how-works')

@section('title', trans('how-works.title'))

@section('mainClasses', 'm-b-50')

@section('content')
<main>
	<div class="header_image">
		<div class="container hiw_m-h">
			<h1>{{ trans('how-works.page_title') }}</h1>

			<div class="row cont__pos">
				<div class="col-md-6 col-md-push-3 text-left">
					{{--<h2>{!! trans('how-works.subtitle') !!}</h2>--}}
					<div class="headervideo-block text-center">
						<div class="video_circle" id="video-toggle">
							<div class="video_circle_content">
								<span class="icon play-icon"></span>
							</div>
						</div>
						<div class="m-t-10"><strong>{{ trans('home.header.what-is') }}</strong></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section>
		<div class="container">
			<div class="row cont__pos">
				<div class="col-md-4">
					<img src="{{ asset('/images/how-works/icon-heart@2x.png') }}" height="276" alt="Heart">
				</div>
				<div class="col-md-6 desc__txt">
					<h3>{{ trans('how-works.steps.one.title') }}</h3>
					<p>{!! trans('how-works.steps.one.body') !!}</p>
				</div>
			</div>
		</div>
	</section>

	<section class="mid">
		<div class="container">
			<div class="row cont__pos">
				<div class="col-md-4 col-md-push-8">
					<div class="visible-xs">
						<img src="{{ asset('/images/how-works/icon-logo@2x.png') }}" height="276" alt="Logo">
					</div>

					<div class="hidden-xs text-right">
						<img src="{{ asset('/images/how-works/icon-logo@2x.png') }}" height="276" alt="Logo">
					</div>
				</div>
				<div class="col-md-6 col-md-pull-4 desc__txt desc__txt-pl">
					<h3>{{ trans('how-works.steps.two.title') }}</h3>
					<p>{!! trans('how-works.steps.two.body') !!}</p>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container">
			<div class="row cont__pos">
				<div class="col-md-4">
					<img src="{{ asset('/images/how-works/icon-box@2x.png') }}" height="276" alt="Box">
				</div>
				<div class="col-md-6 desc__txt">
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
		<div class="text-center m-t-20">

			<a href="{{ url()->route('pick-n-mix') }}"
			   class="button button--rounded button--huge button--landing button--green m-b-10 picks-not-main">
				<strong>{!! trans('pick.button-main') !!}</strong>
			</a>
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

	<style>
		.header_image {
			padding: 40px 0 51px;
			background-image: -webkit-linear-gradient(top, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/how-works/bg.jpg);
			background-image: linear-gradient(-180deg, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url(/images/how-works/bg.jpg);
			margin: 66px 0 20px;
			text-align: center;
			color: #fff;
		}

		main p {
			font-size: 16px;
			color: #3BA883;
			margin-top: 20px;
		}

		main h3 {
			font-size: 22px;
		}

		section {
			padding: 60px 0;
		}

		section.mid {
			background: #fafafa;
		}

		.video_circle {
			text-align: center;
			display: inline-block;
			border-radius: 4px;
			width: 5.5rem;
			height: 4rem;
			padding-top: 21px;
			position: relative;
			transition: transform .4s ease;
			cursor: pointer;
			border: 2px solid #fff;
		}

		.play-icon {
			width: 0;
			height: 0;
			display: inline-block;
			border: solid 0.8rem transparent;
			border-right: none;
			border-left: solid 0.8rem #fff;
			border-left: solid 1.4rem;
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
		}

		.desc__txt {
			width: 50%;
			height: 50%;
			margin: auto;
			position: absolute;
			top: 0;
			left: 50%;
			bottom: 0;
			right: 0;
		}

		.cont__pos {
			position: relative;
		}

		.desc__txt-pl {
			left: -50% !important;
		}


	</style>
</main>
@endsection

@section('footer_scripts')
	<script>
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
	</script>
@endsection