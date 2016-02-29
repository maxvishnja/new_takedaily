<footer>
	<div class="main">
		<div class="container">
			<div class="row">
				<div class="col-md-4 text-center">
					<h3 class="footer_title">Nyhedsbreve</h3>
					<p>Vil du gerne være med, men har ikke tid til en konsultation lige nu, så indtast din e-mail
						herunder.</p>
					<form method="post" action="/signup-mailchimp" class="m-t-20 m-b-10">
						<input type="email" name="email" id="input_newsletters_email" placeholder="Indtast din e-mail adresse" class="input input--regular input--plain"/>
						<button type="submit" class="button button--regular button--green">Send</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					</form>
					<p class="text-left">Så er du allerede lidt i gang...</p>
				</div>
				<div class="col-md-4 text-center">
					<h3 class="footer_title">Følg Take Daily</h3>
					<a href="#fb"><span class="icon icon-facebook v-a-m "></span></a>
					<a href="#ig"><span class="icon icon-instagram v-a-m m-l-20 m-r-20"></span></a>
					<a href="#tw"><span class="icon icon-twitter v-a-m "></span></a>

					<div class="m-t-30"><span class="logo logo-color"></span></div>
				</div>
				<div class="col-md-4 text-center">
					<h3 class="footer_title">Kontakt os</h3>
					<p>Send en mail og få svar inden 24 timer. Du kan ringe til os alle hverdage 09-16</p>
					<div class="m-b-10 m-t-10">
						<p>
							+45 1234 5678<br/>
							<a href="mailto:support@takedaily.dk">support@takedaily.dk</a>
						</p>
					</div>
					<address>
						TakeDaily · DK 1234 5678<br/>
						Vimmelskaftet 43 · København 1111
					</address>
				</div>
			</div>
		</div>
	</div>

	<div class="bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-4">
					<span class="footer_bottom_copy">&copy; 2016 Take Daily.</span>
					<span class="icon icon-card-mastercard m-r-5 v-a-m" title="Mastercard"></span>
					<span class="icon icon-card-visa m-l-5 v-a-m" title="Visa"></span>
				</div>
				<div class="col-lg-9 col-md-8 text-right">
					<ul class="footer_bottom_links">
						<li class="input input--semibold selector selector--up">Danmark
							<span class="icon icon-arrow-up-small v-a-m m-l-5"></span>
							<ul>
								<li><a href="#dk">Danmark</a></li>
								<li><a href="#no">Norge</a></li>
								<li><a href="#sv">Sverige</a></li>
							</ul>
						</li>
						<li><a href="/om-take-daily">Om Take Daily</a></li>
						<li><a href="/privacy">Fortrolighed & cookies</a></li>
						<li><a href="/terms">Vilkår og betingelser</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
<!--[if lt IE 9]>
<script src="/js/placeholders.min.js"></script>
<![endif]-->
@yield('footer_scripts')

@if($errors->has())
	<script>
		swal({
			title: "Der skete en fejl",
			text: "{!! implode("<br/>", $errors->all()) !!}",
			type: "error",
			html: true,
			allowOutsideClick: true,
			confirmButtonText: "Luk popup",
			confirmButtonColor: "#17AA66",
			timer: 3000
		});
	</script>
@endif

@if(session('success'))
	<script>
		swal({
			title: "Handlingen lykkedes",
			text: "{{ session('success') }}",
			type: "success",
			html: true,
			allowOutsideClick: true,
			confirmButtonText: "Luk popup",
			confirmButtonColor: "#17AA66",
			timer: 3000
		});
	</script>
	@endif
	</body>
	</html>