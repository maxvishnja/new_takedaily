<nav class="c-nav-header">
	<ul class="c-nav-header__list">
		<li class="c-nav-header__item">
			<a href="/how-it-works" class="c-nav-header__link">{{ trans('nav2.how-it-works') }}</a>
		</li>
		<li class="c-nav-header__item">
			<a href="/gifting" class="c-nav-header__link">{{ trans('nav2.gifting') }}</a>
		</li>
		<li class="c-nav-header__item">
			<a href="/pick-n-mix" class="c-nav-header__link">{{ trans('nav2.vitamins') }}</a>
		</li>
		@if(App::getLocale() == 'da')
			<li class="c-nav-header__item">
				<a href="https://takedaily.dk/blog" class="c-nav-header__link">Blog</a>
			</li>
		@endif
		<li class="c-nav-header__item c-nav-header__item--log">
			@if(Auth::user() && Auth::user()->isAdmin())
				<a href="/dashboard" class="c-nav-header__link">Dashboard </a>
			@elseif(Auth::user() && Auth::user()->isUser())
				<a href="/account" class="c-nav-header__link">{{ trans('nav2.my-takedaily') }}</a>
			@else
				<a href="/account" class="c-nav-header__link">{{ trans('nav2.account') }}</a>
			@endif
		</li>
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