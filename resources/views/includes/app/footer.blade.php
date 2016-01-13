<footer>
	© TakeDaily {{ date('Y') }}
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
			confirmButtonColor: "#777",
			timer: 3000
		});
	</script>
@endif

@if (session('success'))
	<script>
		swal({
			title: "Handlingen lykkedes",
			text: "{{ session('success') }}",
			type: "success",
			html: true,
			allowOutsideClick: true,
			confirmButtonText: "Luk popup",
			confirmButtonColor: "#777",
			timer: 3000
		});
	</script>
	@endif
	</body>
	</html>
