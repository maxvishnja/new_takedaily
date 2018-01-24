@extends('layouts.app')

@section('pageClass', 'cms page cms-layout-' . $page->layout)

@section('title', "{$page->title} - TakeDaily")

@section('mainClasses', 'm-b-50')

@section('content')
	<style>
		h3 {
			font-size: 1.5rem;
			line-height: 1.5;
		}
	</style>
	@if( $page->layout == 'header' )
		<div class="header_image" style="margin-top: 6.4rem">
			<div class="container text-center">
				<h1>{{ $page->title }}</h1>
				@if( $page->sub_title != '')
					<h2>{{ $page->sub_title }}</h2>
				@endif
			</div>
		</div>
	@endif

	<div class="container m-t-50">
		<article class="vit--landing">
			@if( $page->layout == 'plain' )
				<h1 class="cms-title">{{ $page->title }}</h1>
				@if( $page->sub_title != '')
					<h2 class="cms-title">{{ $page->sub_title }}</h2>
				@endif
				<div class="cms-title-separator"></div>
			@elseif($page->layout == 'header')
				<h1 class="cms-title" style="height: 0; margin: 0; color: transparent; position: absolute; text-indent: -99999999px; left: -9999999px;">{{ $page->title }}</h1>
				@if( $page->sub_title != '')
					<h2 class="cms-title"
						style="height: 0; margin: 0; color: transparent; position: absolute; text-indent: -99999999px; left: -9999999px;">{{ $page->sub_title }}</h2>
				@endif
			@endif
			{!! $page->body !!}
		</article>
		@if($_SERVER['REQUEST_URI']!="/page/a-zink")
			<div class="text-center m-t-50 page">
				<div class="headervideo-block m-l-15">
					<div class="video_circle" id="video-toggle-two">
						<div class="video_circle_content">
							<span class="icon icon-play"></span>
						</div>
					</div>
					<strong>{{ trans('home.page-what-is') }}</strong>
				</div>
			</div>
		@endif
		<div class="text-center m-t-30">
			<a href="{{ url()->route('flow') }}"
			   class="button button--rounded button--huge button--landing button--green">
				<strong>{!! trans('home2.header.button-flow') !!}</strong>
			</a>
			<div class="text-center m-t-20">

				<a href="{{ url()->route('pick-n-mix') }}"
				   class="button button--rounded button--huge button--landing button--green m-b-10 picks-not-main2">
					<strong>{!! trans('pick.button-main') !!}</strong>
				</a>
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
	@if( $page->layout == 'header' )
		<style>
			.header_image {
				background-image: -webkit-linear-gradient(top, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url({{ asset($page->top_image) }});
				background-image: linear-gradient(-180deg, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url({{ asset($page->top_image) }});
			}
		</style>
	@endif
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