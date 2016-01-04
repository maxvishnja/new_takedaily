<nav role="navigation">
	<div class="container">
		<span>{{ Auth::user()->name }}</span>
		<ul>
			@if(Auth::guest())
				<li><a href="{{ url('/login') }}">Login</a></li>
				<li><a href="{{ url('/register') }}">Register</a></li>
			@else
				<li><a href="{{ url('/logout') }}">Logout</a></li>
			@endif
		</ul>
	</div>
</nav>