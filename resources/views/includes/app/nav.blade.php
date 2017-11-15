<!-- Navigation -->
<nav class="c-nav-header">
	<ul class="c-nav-header__list">
		@foreach(\App\Apricot\Helpers\NavGenerator::generate(App::getLocale()) as $item)
			<li
					@if(URL::getRequest()->path() === $item['link']) class="cta" @endif>
				<a href="/{{ $item['link'] }}">{{ $item['text'] }}</a>
			</li>
		@endforeach
		@if(App::getLocale() == 'da')
			<li><a href="https://takedaily.dk/blog">Blog</a></li>
		@endif
		@if(Auth::guest() || Auth::user()->isUser())
			<li><a href="/account">{{ trans('nav.account.profile') }}</a></li>
		@endif
		@if( Auth::user() && Auth::user()->isAdmin() )
			<li><a href="/dashboard"><strong>Dashboard</strong></a></li>
		@endif
	</ul>

	<!-- Close -->
	<div class="c-nav-header__close c-nav-header__trigger"></div>
</nav>