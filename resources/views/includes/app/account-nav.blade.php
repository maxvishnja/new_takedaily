<nav class="account_nav m-b-30">
	<div class="container">
		<ul class="navigation" id="profile-nav">
			<a class="visible-sm visible-xs icon icon-cross-large toggle-mobile-nav" href="#profile-nav"></a>
			<li @if(Request::getPathInfo() == '/account') class="active" @endif><a href="/account">{{ trans('nav.account.profile') }}</a></li>
			<li @if(Request::getPathInfo() == '/account/transactions') class="active" @endif><a href="/account/transactions">{{ trans('nav.account.deliveries') }}</a></li>
			<li @if(Request::getPathInfo() == '/account/settings/basic') class="active" @endif><a href="/account/settings/basic">{{ trans('nav.account.settings') }}</a></li>
			<li @if(Request::getPathInfo() == '/account/settings/subscription') class="active" @endif><a href="/account/settings/subscription">{{ trans('nav.account.subscription') }}</a></li>
			<li @if(Request::getPathInfo() == '/account/settings/billing') class="active" @endif><a href="/account/settings/billing">{{ trans('nav.account.billing') }}</a></li>
		</ul>

		<div class="visible-sm visible-xs text-center">
			<a href="#profile-nav" class="toggle-mobile-nav">
			<span class="hamburger">
				<span class="meat"></span>
				<span class="meat"></span>
				<span class="meat meat--last"></span>
			</span>
			</a>
		</div>

		<div class="clear"></div>
	</div>
</nav>