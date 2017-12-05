<nav role="navigation">
	<ul class="navigation" id="mobile-nav">
		<a class="visible-sm visible-xs icon icon-cross-large toggle-mobile-nav" href="#mobile-nav"></a>
		@if(Auth::guest())
			<li class="cta"><a href="/flow">{{ trans('nav.cta') }}</a></li>
		@endif
		@foreach(\App\Apricot\Helpers\NavGenerator::generate(App::getLocale()) as $item)
			@if($item['link']==='gifting')
			<li @if(URL::getRequest()->path() === $item['link']) class="cta" @endif><a class="dropdown-toggle" id="dropdownMenu1"
		   data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">{{ $item['text'] }}<span class="caret"></span></a>
				<ul class="dropdown-menu center-dropdown" aria-labelledby="dropdownMenu1">
					<li><a href="/gifting">{{ trans('nav.submenu.gifting-buy') }}</a></li>
					<li><a href="/use-giftcard">{{ trans('nav.submenu.gifting-use') }}</a></li>
				</ul>
			</li>

			@else
			<li @if(URL::getRequest()->path() === $item['link']) class="cta" @endif><a href="/{{ $item['link'] }}">{{ $item['text'] }}</a></li>
			@endif
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