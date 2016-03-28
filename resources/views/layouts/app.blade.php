@include('includes.app.header')

<header class="header--with-bg">
	<div class="container">
		<div class="header_top_tb">
			<div class="row">
				<div class="col-md-3 col-xs-8">
					<a href="/" class="logo logo-white"></a>
				</div>

				<div class="col-md-9 col-xs-4">
					@include('includes.app.nav')
				</div>
			</div>
		</div>

		@yield('header_top_additional')
	</div>
</header>

<main @if(!isset($mainClasses)) class="@yield('mainClasses', 'm-t-50 m-b-50')" @else class="{{ $mainClasses }}" @endif>
	@yield('content')

	@if( ! isset($_COOKIE['call-me-hidden'])  )
		<style>
			body { padding-bottom: 190px;}
		</style>
		<div class="call-cta" id="call-me-form-toggler">
			<div class="container">
				<span title="Ellers tak" id="call-me-form-hider" class="icon icon-cross-large pull-right"></span>
				<strong>Har du ikke tid til at udfylde formularen?</strong>
				<span>Bliv ringet op, indtast dit tlf. nummer og vælg tidspunkt.</span>
				<form method="post" action="/call-me" id="call-me-form">
					<input type="number" pattern="\d." maxlength="14" name="phone" class="input input--regular input--plain input--no-number input--spacing input--full-mobile m-t-10" placeholder="12 34 56 78" required="required"/>
					<select class="select select--regular select--spacing select--plain select--full-mobile m-t-10" name="period">
						<option value="09:00 - 11:00">09:00 - 11:00</option>
						<option value="11:00 - 13:00">11:00 - 13:00</option>
						<option value="13:00 - 15:00">13:00 - 15:00</option>
						<option value="15:00 - 17:00">15:00 - 17:00</option>
					</select>
					<div class="m-t-10">
						<button type="submit" class="button button--white button--large button--full-mobile">Ring mig op</button>
					</div>
				</form>
			</div>
		</div>
	@endif
</main>

@include('includes.app.footer')
