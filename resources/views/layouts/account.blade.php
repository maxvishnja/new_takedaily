@include('includes.app.header')
<div class="container">
	<aside class="sidebar sidebar--account">
		@include('includes.app.account-sidebar')
	</aside>

	<main>
		@yield('content')
	</main>

	<div class="clear"></div>
</div>
@include('includes.app.footer')