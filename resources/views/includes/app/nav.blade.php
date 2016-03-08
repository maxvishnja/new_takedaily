<nav role="navigation">
	<ul class="navigation" id="mobile-nav">
		<a class="visible-sm visible-xs icon icon-cross-large toggle-mobile-nav" href="#mobile-nav"></a>
		<li><a href="/fra-a-til-zink">Fra A til Zink</a></li>
		<li><a href="/saadan-virker-det">Sådan virker det</a></li>
		<li><a href="/test-og-kvalitet">Test &amp; Kvalitet</a></li>
		@if(Auth::guest() || Auth::user()->isUser())
			<li><a href="/account"><strong>Mit Take Daily</strong></a></li>
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