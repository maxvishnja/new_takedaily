@include('includes.app.header')
<div class="container">
	<aside class="sidebar sidebar--account">
		@include('includes.app.account-sidebar')
	</aside>

	<main>
		@if($errors->has())
			@foreach($errors->all() as $error)
				<div class="alert alert--error">{{ $error }}</div>
			@endforeach
		@endif

		@if (session('success'))
			<div class="alert alert--success">{{ session('success') }}</div>
		@endif

		@yield('content')
	</main>

	<div class="clear"></div>
</div>
@include('includes.app.footer')
