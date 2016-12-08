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
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<aside>
					@include('includes.app.account-nav')
				</aside>
			</div>

			<div class="col-md-9">
				@yield('content')
			</div>
		</div>
	</div>
</main>

@include('includes.app.footer')
