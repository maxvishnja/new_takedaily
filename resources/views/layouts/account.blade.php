@include('includes.app.header')

<header class="header--with-bg">
	<div class="header-nav">
		<div class="container-fluid">
			<div class="header_top_tb">
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
</header>

<main class="m-b-50">
	@include('includes.app.account-nav')
	<div class="container">
		@yield('content')
	</div>
</main>

@include('includes.app.footer')
