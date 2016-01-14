<nav role="navigation">
	<div class="container">
		<ul>
			@if(Auth::guest())
				<li><a href="{{ url('/login') }}">Login</a></li>
				<li><a href="{{ url('/register') }}">Register</a></li>
			@else
				@if(Auth::user()->isUser())
					<li><span>{{ Auth::user()->name }}</span>
						<ul class="dropdown">
							<li><a href="/account">My account</a></li>
							<li><a href="/account/transactions">Orders</a></li>
							<li><a href="/account/settings/basic">Settings</a></li>
							<li><a href="/account/settings/billing">Billing</a></li>
							<li><a href="{{ url('/logout') }}">Logout</a></li>
						</ul>
					</li>
				@else
					<li>
						<a href="/dashboard">To dashboard</a>
					</li>
				@endif
			@endif
		</ul>
	</div>
</nav>