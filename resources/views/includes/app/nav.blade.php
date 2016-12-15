<nav role="navigation">
	<ul class="navigation" id="mobile-nav">
		<a class="visible-sm visible-xs icon icon-cross-large toggle-mobile-nav" href="#mobile-nav"></a>
		@if(Auth::guest())
			<li class="cta"><a href="/flow">{{ trans('nav.cta') }}</a></li>
		@endif
		@foreach(\App\Apricot\Helpers\NavGenerator::generate(App::getLocale()) as $item)
			<li @if(URL::getRequest()->path() === $item['link']) class="cta" @endif><a href="/{{ $item['link'] }}">{{ $item['text'] }}</a></li>
		@endforeach

		@if(Auth::guest() || Auth::user()->isUser())
			<li><a href="/account"><strong>{{ trans('nav.account.profile') }}</strong></a></li>
		@endif
		@if( Auth::user() && Auth::user()->isAdmin() )
			<li><a href="/dashboard"><strong>Dashboard</strong></a></li>
		@endif
	</ul>

	<div class="visible-sm visible-xs">
		<a href="#mobile-nav" class="toggle-mobile-nav">
			<span class="hamburger hamburger--white">
				<span class="meat"></span>
				<span class="meat"></span>
				<span class="meat meat--last"></span>
			</span>
		</a>
	</div>
</nav>