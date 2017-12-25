@include('includes.app.header2')

<main class="m-b-50">
	<div class="container m-t-50">
		<div class="row">
			<div class="col-md-3">
				<aside>
					@include('includes.app.account-nav')
				</aside>
			</div>

			<div class="col-md-9">
				<div class="m-t-30">
					@yield('content')
				</div>
			</div>
		</div>
	</div>
</main>

@include('includes.app.footer2')
