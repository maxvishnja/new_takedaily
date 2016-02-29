@extends('layouts.app')

@section('pageClass', 'index')

@section('content')

	<header class="header--with-bg">
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
