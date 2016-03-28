@extends('layouts.app')

@section('pageClass', 'cms page cms-layout-' . $page->layout)

@section('header_top_additional')
	@if( $page->layout == 'header' )
		<h1 class="cms-title">{{ $page->title }}</h1>
		@if( $page->sub_title != '')
			<h2 class="cms-title">{{ $page->sub_title }}</h2>
		@endif
	@endif

	{{-- todo add sticky cta --}}
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
			@else
				<h1 class="cms-title" style="height: 0; margin: 0; color: transparent; position: absolute; text-indent: -99999999px; left: -9999999px;">{{ $page->title }}</h1>
				@if( $page->sub_title != '')
					<h2 class="cms-title" style="height: 0; margin: 0; color: transparent; position: absolute; text-indent: -99999999px; left: -9999999px;">{{ $page->sub_title }}</h2>
				@endif
				<div class="cms-title-separator"></div>
			@endif
			{!! $page->body !!}
		</article>
	</div>

	@if( $page->layout == 'header' )
		<style>
			header.header--with-bg
			{
				background-color: #fff;
				background-repeat: no-repeat;
				background-size: cover;
				background-position: center center;
				background-image: -webkit-linear-gradient(top, rgba(97,97,97,0.64) 0%, rgba(51,51,51,0.00) 100%), url({{ asset($page->top_image) }});
				background-image: linear-gradient(-180deg, rgba(97,97,97,0.64) 0%, rgba(51,51,51,0.00) 100%), url({{ asset($page->top_image) }});
			}
		</style>
	@endif
@endsection
