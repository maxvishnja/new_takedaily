<div class="clear"></div>

<footer>
	<div class="main">
		<div class="container">
			<div class="row">
				<div class="col-md-4 footer_column footer_column--newsletters text-center">
					<h3 class="footer_title">{{ trans('footer.columns.one.title') }}</h3>
					<form method="post" action="/signup-mailchimp" class="m-t-20 m-b-10">
						<div class="row">
							<div class="col-sm-8">
								<input type="email" name="email" id="input_newsletters_email" placeholder="{{ trans('footer.columns.one.input-placeholder') }}" class="input input--regular input--full input--plain"/>
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
				<div class="col-lg-3 col-md-4">
					<span class="footer_bottom_copy">&copy; {{ date('Y') }} {{ trans('footer.copyright') }}.</span>
					<span class="icon icon-card-mastercard m-r-5 v-a-m" title="Mastercard"></span>
					<span class="icon icon-card-visa m-l-5 v-a-m" title="Visa"></span>
				</div>
				<div class="col-lg-9 col-md-8 text-right">
					<ul class="footer_bottom_links">
						<li class="input input--semibold input--transparent selector selector--up">{{ trans('footer.language') }}
							<span class="icon icon-arrow-up-small v-a-m m-l-5"></span>
							<ul>
								{!! trans('footer.languages') !!}
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
				confirmButtonColor: "#17AA66",
				timer: 4500
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
			confirmButtonColor: "#17AA66",
			timer: 4500
		});
	</script>
@endif

@if( ! isset($_COOKIE['call-me-hidden'])  )

	<script>
		$("#call-me-form-hider").click(function ()
		{
			$(".call-cta").slideUp();
			$("body").css('padding-bottom', 0);
			Cookies.set('call-me-hidden', 1, {expires: 3});
		});

		$("#call-me-form-toggler").click(function ()
		{
			$(".call-cta").toggleClass('call-cta--visible');
		});

		$("#call-me-form").submit(function (e)
		{
			e.preventDefault();

			var form = $(this);

			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				dataType: 'JSON',
				data: form.serialize(),
				success: function (response)
				{
					$(".call-cta").html('<strong>' + response.message + '</strong>');
					setTimeout(function ()
					{
						$(".call-cta").slideUp();
						$("body").css('padding-bottom', 0);
						Cookies.set('call-me-hidden', 1, {expires: 3});
					}, 2500);
				}
			});
		});
	</script>
	@endif

		<!-- begin olark code -->
	<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/
		window.olark || (function (c)
		{
			var f = window, d = document, l = f.location.protocol == "https:" ? "https:" : "http:", z = c.name, r = "load";
			var nt = function ()
			{
				f[z] = function ()
				{
					(a.s = a.s || []).push(arguments)
				};
				var a = f[z]._ = {}, q = c.methods.length;
				while (q--)
				{
					(function (n)
					{
						f[z][n] = function ()
						{
							f[z]("call", n, arguments)
						}
					})(c.methods[q])
				}
				a.l = c.loader;
				a.i = nt;
				a.p = {
					0: +new Date
				};
				a.P = function (u)
				{
					a.p[u] = new Date - a.p[0]
				};
				function s()
				{
					a.P(r);
					f[z](r)
				}

				f.addEventListener ? f.addEventListener(r, s, false) : f.attachEvent("on" + r, s);
				var ld = function ()
				{
					function p(hd)
					{
						hd = "head";
						return ["<", hd, "></", hd, "><", i, ' onl' + 'oad="var d=', g, ";d.getElementsByTagName('head')[0].", j, "(d.", h, "('script')).", k, "='", l, "//", a.l, "'", '"', "></", i, ">"].join("")
					}

					var i = "body", m = d[i];
					if (!m)
					{
						return setTimeout(ld, 100)
					}
					a.P(1);
					var j = "appendChild", h = "createElement", k = "src", n = d[h]("div"), v = n[j](d[h](z)), b = d[h]("iframe"), g = "document", e = "domain", o;
					n.style.display = "none";
					m.insertBefore(n, m.firstChild).id = z;
					b.frameBorder = "0";
					b.id = z + "-loader";
					if (/MSIE[ ]+6/.test(navigator.userAgent))
					{
						b.src = "javascript:false"
					}
					b.allowTransparency = "true";
					v[j](b);
					try
					{
						b.contentWindow[g].open()
					} catch (w)
					{
						c[e] = d[e];
						o = "javascript:var d=" + g + ".open();d.domain='" + d.domain + "';";
						b[k] = o + "void(0);"
					}
					try
					{
						var t = b.contentWindow[g];
						t.write(p());
						t.close()
					} catch (x)
					{
						b[k] = o + 'd.write("' + p().replace(/"/g, String.fromCharCode(92) + '"') + '");d.close();'
					}
					a.P(2)
				};
				ld()
			};
			nt()
		})({
			loader: "static.olark.com/jsclient/loader0.js", name: "olark", methods: ["configure", "extend", "declare", "identify"]
		});
		/* custom configuration goes here (www.olark.com/documentation) */
		olark.identify('2609-447-10-5702');
		/*]]>*/</script>
	<noscript><a href="https://www.olark.com/site/2609-447-10-5702/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by
		<a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
	<!-- end olark code -->
	</body>
	</html>