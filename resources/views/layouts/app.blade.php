@include('includes.app.header')

<header class="header--with-bg">
	<div class="container">
		<div class="header_top_tb">
			<div class="row">
				<div class="col-md-3 col-xs-8">
					<a href="/" class="logo logo-white"></a>
				</div>

				<div class="col-md-9 col-xs-4">
					@include('includes.app.nav')
				</div>
			</div>
		</div>

		@yield('header_top_additional')
	</div>
</header>

<main @if(!isset($mainClasses)) class="@yield('mainClasses', 'm-t-50 m-b-50')" @else class="{{ $mainClasses }}" @endif>
	@yield('content')
</main>

@include('includes.app.footer')
