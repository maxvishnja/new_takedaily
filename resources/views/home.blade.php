@extends('layouts.landing')

@section('pageClass', 'index')

@section('content')

	<header class="header--landing header--with-large-bg">
		<div class="container-fluid">
			<div class="header_top">
				<div class="row">
					<div class="col-md-3 col-xs-8">
						<a href="/" class="logo logo-white"></a>
					</div>

					<div class="col-md-9 col-xs-4">
						@include('includes.app.nav')
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="header_content">
				<div class="header_slider">
					<div class="header_slide">
						<div class="row">
							<div class="col-md-6">
								<h1>Nu bliver det nemt,<br/>
									at få din krop i balance.</h1>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aperiam distinctio
									eligendi.</p>
								<a href="#" class="button button--double button--rounded button--green">
									<strong>Tryk her for at starte nu</strong>
									<span>Fra 149 kr. Ingen binding</span>
								</a>
							</div>
							<div class="col-md-6">
								<img src="/images/product_small.png" alt="Take Daily box">
							</div>
						</div>
					</div>
					<div class="header_slide"></div>
				</div>
			</div>
		</div>

		<div class="header_footer hidden-sm hidden-xs">
			<a href="#">Start selv</a> i dag eller giv Take Daily <a href="#">i gave</a>
		</div>
	</header>

	<main @if(!isset($mainClasses)) class="m-t-50 m-b-50" @else class="{{ $mainClasses }}" @endif>
		<div class="container">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus magni nulla laborum nam sunt
				laboriosam
				veritatis, minus ullam sit consequatur neque tempore. Dolorum omnis vero facilis sequi nihil delectus
				voluptatibus.</p>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus magni nulla laborum nam sunt
				laboriosam
				veritatis, minus ullam sit consequatur neque tempore. Dolorum omnis vero facilis sequi nihil delectus
				voluptatibus.</p>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus magni nulla laborum nam sunt
				laboriosam
				veritatis, minus ullam sit consequatur neque tempore. Dolorum omnis vero facilis sequi nihil delectus
				voluptatibus.</p>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus magni nulla laborum nam sunt
				laboriosam
				veritatis, minus ullam sit consequatur neque tempore. Dolorum omnis vero facilis sequi nihil delectus
				voluptatibus.</p>
		</div>
	</main>
@endsection
