@extends('layouts.app')

@section('pageClass', 'cms page cms-layout-' . $page->layout)

@section('title', "{$page->title} - TakeDaily")

@section('mainClasses', 'm-b-50')

@section('header_top_additional')
	@if( $page->layout == 'header' )
		<h1 class="cms-title">{{ $page->title }}</h1>
		@if( $page->sub_title != '')
			<h2 class="cms-title">{{ $page->sub_title }}</h2>
		@endif

		@if( !Auth::user() || !Auth::user()->isUser() || ! Auth::user()->getCustomer() )
			<div class="cta hidden-xs">
				{!! trans('cms.sticky-cta') !!}
			</div>
		@endif
	@endif
@endsection

@section('content')
	<div class="container">
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
					<h2 class="cms-title" style="height: 0; margin: 0; color: transparent; position: absolute; text-indent: -99999999px; left: -9999999px;">{{ $page->sub_title }}</h2>
				@endif
			@endif
			{!! $page->body !!}
		</article>
	</div>

	@if( $page->layout == 'header' )
		<style>
			header.header--with-bg {
				background-color:    #fff;
				background-repeat:   no-repeat;
				background-size:     cover;
				background-position: center center;
				background-image:    -webkit-linear-gradient(top, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url({{ asset($page->top_image) }});
				background-image:    linear-gradient(-180deg, rgba(97, 97, 97, 0.64) 0%, rgba(51, 51, 51, 0.00) 100%), url({{ asset($page->top_image) }});
			}
		</style>
	@endif
@endsection

@section('footer_scripts')
	@if( !Auth::user() || !Auth::user()->isUser() || ! Auth::user()->getCustomer() )
		<script>
			var ctaBlock = $(".cta");
			var headerBlock = $("header.header--with-bg");

			$(window).scroll(function ()
			{
				if ($(this).scrollTop() > (headerBlock.height() - ctaBlock.outerHeight()))
				{
					ctaBlock.addClass('cta--sticky');
				}
				else
				{
					ctaBlock.removeClass('cta--sticky');
				}
			});
		</script>
	@endif
@endsection