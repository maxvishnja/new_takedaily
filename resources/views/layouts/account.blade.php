@include('includes.app.header')
<div class="container">
	<aside>
		@include('includes.app.account-sidebar')
	</aside>

	<main>
		@yield('content')
	</main>
</div>
@include('includes.app.footer')
