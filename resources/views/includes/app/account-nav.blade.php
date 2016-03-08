<nav class="account_nav m-b-30">
	<div class="container">
		<ul class="navigation" id="profile-nav">
			<a class="visible-sm visible-xs icon icon-cross-large toggle-mobile-nav" href="#profile-nav"></a>
			<li @if(Request::getPathInfo() == '/account') class="active" @endif><a href="/account">My account</a></li>
			<li @if(Request::getPathInfo() == '/account/info') class="active" @endif><a href="/account/info">Information</a></li>
			<li @if(Request::getPathInfo() == '/account/transactions') class="active" @endif><a href="/account/transactions">Orders</a></li>
			<li @if(Request::getPathInfo() == '/account/settings/basic') class="active" @endif><a href="/account/settings/basic">Account</a></li>
			<li @if(Request::getPathInfo() == '/account/settings/subscription') class="active" @endif><a href="/account/settings/subscription">Subscription</a></li>
			<li @if(Request::getPathInfo() == '/account/settings/billing') class="active" @endif><a href="/account/settings/billing">Billing</a></li>
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