<nav role="navigation">
	<ul class="navigation" id="mobile-nav">
		<a class="visible-sm visible-xs icon icon-cross-large toggle-mobile-nav" href="#mobile-nav"></a>
		{{--		{!! trans('nav.links') !!}--}}
		@foreach(\App\Apricot\Helpers\NavGenerator::generate(App::getLocale()) as $item)
			<li>
				<a href="/{{ $item['link'] }}">{{ $item['text'] }}</a>

				@if( count($item['subitems']) > 0 )
					<div class="submenu" style="min-width: 55%;">
						<div class="row">
							@foreach($item['subitems'] as $subGroupTitle => $subGroupItems)
								<div class="col-md-6">
									<div><strong>{{ $subGroupTitle }}</strong></div>
									<ul>
										@foreach($subGroupItems as $sublink)
											<li><a href="/{{ $sublink['link'] }}">{{ $sublink['text'] }}</a></li>
										@endforeach
									</ul>
								</div>
							@endforeach
						</div>
					</div>
				@endif
			</li>
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