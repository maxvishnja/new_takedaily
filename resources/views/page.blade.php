@extends('layouts.app')

@section('pageClass', 'cms page cms-layout-' . $page->layout)

@section('title', "{$page->title} - TakeDaily")

@section('mainClasses', 'm-b-50')

@section('content')
	@if( $page->layout == 'header' )
		<div class="header_image">
			<div class="container text-center">
				<h1>{{ $page->title }}</h1>
				@if( $page->sub_title != '')
					<h2>{{ $page->sub_title }}</h2>
				@endif

				@if( !Auth::user() || !Auth::user()->isUser() || ! Auth::user()->getCustomer() )
					<div class="cta hidden-xs">
						{!! trans('cms.sticky-cta') !!}
					</div>
				@endif
			</div>
		</div>
	@endif

	<div class="container m-t-50">
		<article>
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

		<div class="text-center m-t-50">
			<a href="{{ url()->route('flow') }}"
			   class="button button--rounded button--huge button--landing button--green">
				<strong>{!! trans('home.header.button-click-here') !!}</strong>
			</a>
			<div class="m-t-10"><a href="{{ url()->route('pick-package') }}">{{ trans('home.header.pick') }}</a></div>
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
	@if( !Auth::user() || !Auth::user()->isUser() || ! Auth::user()->getCustomer() )
		<script>
			var ctaBlock = $(".cta");
			var headerBlock = $(".header_image");

			$(window).scroll(function () {
				if ($(this).scrollTop() > headerBlock.outerHeight()) {
					ctaBlock.addClass('cta--sticky');
				}
				else {
					ctaBlock.removeClass('cta--sticky');
				}
			});
		</script>
	@endif
@endsection