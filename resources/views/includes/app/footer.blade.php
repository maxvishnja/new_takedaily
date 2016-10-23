<div class="clear"></div>

<footer>
	<div class="main">
		<div class="container">
			<div class="row">
				<div class="col-md-4 footer_column footer_column--newsletters text-center">
					<h3 class="footer_title">{{ trans('footer.columns.one.title') }}</h3>
					<form method="post" action="{{ trans('general.newsletter_url') }}" class="m-t-20 m-b-10" target="_blank">
						<div class="row">
							<div class="col-sm-8">
								<input type="email" name="EMAIL" id="input_newsletters_email" placeholder="{{ trans('footer.columns.one.input-placeholder') }}"
									   class="input input--regular input--full input--plain"/>
							</div>
							<div class="col-sm-4">
								<button type="submit" class="button button--regular button--full button--green">{{ trans('footer.columns.one.button-text') }}</button>
							</div>
						</div>
						<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					</form>
				</div>
				<div class="col-md-4 footer_column text-center">
					<h3 class="footer_title">{{ trans('footer.columns.two.title') }}</h3>
					<a href="#fb"><span class="icon icon-facebook v-a-m m-r-10 "></span></a>
					<a href="#ig"><span class="icon icon-instagram v-a-m m-l-10"></span></a>
				</div>
				<div class="col-md-4 footer_column text-center">
					<h3 class="footer_title">{{ trans('footer.columns.three.title') }}</h3>
					<p>{{ trans('footer.columns.three.text') }}</p>
					<div class="m-b-10 m-t-10">
						<p>
							{!! trans('footer.columns.three.info') !!}
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-sm-4">
					<span class="footer_bottom_copy">&copy; {{ date('Y') }} {{ trans('footer.copyright') }}.</span>
					<div class="visible-sm m-t-10"></div>
					@foreach(\App\Apricot\Helpers\PaymentMethods::getIconsForMethods(\App\Apricot\Helpers\PaymentMethods::getAcceptedMethodsForCountry(App::getLocale())) as $method)
						<span class="icon icon-card-{{ $method }} m-r-5 v-a-m" title="{{ ucfirst($method) }}"></span>
					@endforeach
				</div>
				<div class="col-lg-9 col-sm-8 text-right">
					<ul class="footer_bottom_links">
						<li class="input input--semibold input--transparent lang-selector-footer selector selector--up">{{ trans('footer.language') }}
							<span class="icon icon-arrow-up-small v-a-m m-l-5"></span>
							<ul>
								@foreach(config('app.locales') as $locale)
									<li>
										<a rel="alternate" hreflang="{{ $locale['code'] }}" href="{{ \App\Apricot\Helpers\DomainHelper::convertTldTo($locale['tld']) }}">
											{{ $locale['name'] }}
										</a>
									</li>
								@endforeach
							</ul>
						</li>
						{!! trans('footer.links') !!}
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/validator.js') }}"></script>
<!--[if lt IE 9]>
<script src="/js/placeholders.min.js"></script>
<![endif]-->

<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': '{{ csrf_token() }}'
		}
	});
</script>

@yield('footer_scripts')

@if(isset($errors))
	@if($errors->has())
		<script>
			swal({
				title: "{{ trans('message.error-title') }}",
				text: "{!! implode("<br/>", $errors->all()) !!}",
				type: "error",
				html: true,
				allowOutsideClick: true,
				confirmButtonText: "{{ trans('popup.button-close') }}",
				confirmButtonColor: "#3AAC87",
				timer: 6000
			});
		</script>
	@endif
@endif

@if(session('success'))
	<script>
		swal({
			title: "{{ trans('message.success-title') }}",
			text: "{{ session('success') }}",
			type: "success",
			html: true,
			allowOutsideClick: true,
			confirmButtonText: "{{ trans('popup.button-close') }}",
			confirmButtonColor: "#3AAC87",
			timer: 6000
		});
	</script>
@endif

@if(session('warning'))
	<script>
		swal({
			title: "{{ trans('message.warning-title') }}",
			text: "{{ session('warning') }}",
			type: "warning",
			html: true,
			allowOutsideClick: true,
			confirmButtonText: "{{ trans('popup.button-close') }}",
			confirmButtonColor: "#3AAC87",
			timer: 6000
		});
	</script>
@endif

@if( ! isset($_COOKIE['call-me-hidden'])  )

	<script>
		$("#call-me-form-hider").click(function () {
			$(".call-cta").slideUp();
			$("body").css('padding-bottom', 0);
			Cookies.set('call-me-hidden', 1, {expires: 3});
		});

		$("#call-me-form-toggler").click(function () {
			$(".call-cta").toggleClass('call-cta--visible');
		});

		$("#call-me-form").submit(function (e) {
			e.preventDefault();

			var form = $(this);

			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				dataType: 'JSON',
				data: form.serialize(),
				success: function (response) {
					$(".call-cta").html('<strong>' + response.message + '</strong>');
					setTimeout(function () {
						$(".call-cta").slideUp();
						$("body").css('padding-bottom', 0);
						Cookies.set('call-me-hidden', 1, {expires: 3});
					}, 2500);
				}
			});
		});
	</script>
@endif

<!--Start of Tawk.to Script-->
<script type="text/javascript">
	var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
	(function () {
		var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
		s1.async = true;
		s1.src = 'https://embed.tawk.to/573c49314084da3e71efb4e9/{{ trans('general.tawk_id') }}';
		s1.charset = 'UTF-8';
		s1.setAttribute('crossorigin', '*');
		s0.parentNode.insertBefore(s1, s0);
	})();
</script>
<!--End of Tawk.to Script-->


</body>
</html>