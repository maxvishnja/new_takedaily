@extends('layouts.landing')

@section('pageClass', 'index')

@section('content')
	<header class="header--landing header--with-large-bg">
		<div class="header-nav">
			<div class="container-fluid">
				<div class="header_top">
					<div class="row">
						<div class="col-md-3 col-xs-8">
							<a href="/" class="logo logo-color"></a>
						</div>

						<div class="col-md-9 col-xs-4">
							@include('includes.app.nav')
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="header_content">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h1>{!! trans('home.header.title-1') !!}</h1>
						@if( Auth::guest() )
							<a href="/flow" class="button button--rounded button--huge button--green m-t-30">
								<strong>{{ trans('home.header.button-click-here') }}</strong>
							</a>
						@endif
					</div>
					<div class="col-md-6 hidden-sm hidden-xs">
						<div class="splash_circle pull-right">
							<span>{!! trans('home.header.splash.text') !!}</span>
							<small>{{ trans('home.header.splash.only') }}</small>
							<strong>{!! trans('home.header.splash.price') !!}</strong>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{--

		<div class="slider_container" id="slider_one">
			<div class="icon slider-arrow-left icon-arrow-left"></div>
			<div class="icon slider-arrow-right icon-arrow-right"></div>
			<div class="header_content">
				<div class="slider">
					<div class="slide_container">
						<div class="slide">
							<div class="container">
								<div class="row">
									<div class="col-md-6">
										<h1>{!! trans('home.header.title-1') !!}</h1>
										<a href="/flow" class="button button--rounded button--huge button--green m-t-30">
											<strong>{{ trans('home.header.button-click-here') }}</strong>
										</a>
									</div>
									<div class="col-md-6 hidden-sm hidden-xs">
										<img src="/images/product_small.png" alt="TakeDaily box">
									</div>
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="container">
								<div class="row">
									<div class="col-md-8">
										<h1>{!! trans('home.header.title-2') !!}</h1>
										<a href="/flow" class="button button--rounded button--huge button--green m-t-30">
											<strong>{{ trans('home.header.button-click-here') }}</strong>
										</a>
									</div>

									<div class="col-md-4 hidden-sm hidden-xs">
										<div class="splash_circle">
											<span>{!! trans('home.header.splash.text') !!}</span>
											<small>{{ trans('home.header.splash.only') }}</small>
											<strong>{!! trans('home.header.splash.price') !!}</strong>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		--}}

		<div class="header_footer hidden-sm hidden-xs">
			{!! trans('home.header.cta') !!}
		</div>
	</header>

	<main>
		<div class="container">
			<div class="block block--one text-center">
				<h2>{{ trans('home.blocks.one.title') }}</h2>
				<p class="sub_header">{{ trans('home.blocks.one.description') }}</p>

				<div class="row text-center">
					<div class="col-md-4 block_item">
						<span class="icon icon-user-information"></span>
						<h3>{{ trans('home.blocks.one.steps.one.title') }}</h3>
						<p>{{ trans('home.blocks.one.steps.one.text') }}</p>
					</div>

					<div class="col-md-4 block_item">
						<span class="icon icon-box"></span>
						<h3>{{ trans('home.blocks.one.steps.two.title') }}</h3>
						<p>{{ trans('home.blocks.one.steps.two.text') }}</p>
					</div>

					<div class="col-md-4 block_item">
						<span class="icon icon-truck"></span>
						<h3>{{ trans('home.blocks.one.steps.three.title') }}</h3>
						<p>{{ trans('home.blocks.one.steps.three.text') }}</p>
					</div>
				</div>

				<div class="text-center m-t-50">
					{!! trans('home.blocks.one.button') !!}
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

		<div class="container">
			<div class="block block--three text-center">
				<div class="row">
					<div class="col-md-4">
						<img src="/images/dietist.png" class="img--rounded" alt="{{ trans('home.blocks.three.name') }}"/>
						<span class="dietist-name">{{ trans('home.blocks.three.name') }}</span>
					</div>
					<div class="col-md-8">
						<blockquote>{!! trans('home.blocks.three.quote') !!}</blockquote>

						{!! trans('home.blocks.three.button') !!}
					</div>
				</div>
			</div>
		</div>

		<div class="block block--four hidden-xs">
			<div class="container">
				<video src="/video/animation.mp4" autoplay="autoplay" loop="loop" poster="/video/thumbnail.png" oncontextmenu="return false;" muted="muted">
					<source type="video/mp4" src="/video/animation.mp4"/>
					<source type="video/ogv" src="/video/animation.ogv"/>
					<source type="video/webm" src="/video/animation.webm"/>
				</video>
			</div>
		</div>

		<div class="block block--five">
			<img src="//placehold.it/640x420" alt="Image"/>

			<div class="block_content text-center">
				{!! trans('home.blocks.five.body') !!}
				{!! trans('home.blocks.five.button') !!}
			</div>

			<div class="clear"></div>
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
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		@endif

		<div class="block block--seven text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-push-2">
						<h2>{{ trans('home.blocks.seven.title') }}</h2>
						<h3>{{ trans('home.blocks.seven.subtitle') }}</h3>
						<p>{{ trans('home.blocks.seven.text') }}</p>
						{!! trans('home.blocks.seven.button') !!}
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="block block--eight text-center">
				<div class="row">
					<div class="col-md-8 col-md-push-2">
						<img src="/images/product_box_large.png" alt="TakeDaily boks"/>
						<h2>{!! trans('home.blocks.eight.title') !!}</h2>
						<p>{{ trans('home.blocks.eight.text') }}</p>

						{!! trans('home.blocks.eight.button') !!}
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection

@section('footer_scripts')
	<script>
		$("#slider_one").slider();
		$("#slider_two").slider();

		var ctaBlock = $(".header_footer");
		var headerBlock = $("header.header--landing");

		$(window).scroll(function ()
		{
			if ($(this).scrollTop() > (headerBlock.height()))
			{
				ctaBlock.addClass('header_footer--sticky');
			}
			else
			{
				ctaBlock.removeClass('header_footer--sticky');
			}
		});
	</script>
@endsection