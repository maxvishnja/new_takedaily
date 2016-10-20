<script>{{-- todo translate --}}
	$("#send-by-mail-button").click(function () {
		swal({
			title: "Send anbefaling",
			text: "Indtast din e-mail adresse:",
			type: "input",
			showCancelButton: true,
			confirmButtonColor: "#3AAC87",
			confirmButtonText: "Send",
			cancelButtonText: "Annuller",
			closeOnConfirm: false,
			inputPlaceholder: "navn@email.dk",
			showLoaderOnConfirm: true
		}, function (inputValue) {
			if (inputValue === false || inputValue === "") {
				swal.showInputError("Du skal indtaste din e-mail!");
				return false;
			}

			setTimeout(function () {
				swal({
					title: "{{ trans('message.success-title') }}",
					text: "Anbefalingen blev sendt!",
					type: "success",
					html: true,
					allowOutsideClick: true,
					confirmButtonText: "{{ trans('popup.button-close') }}",
					confirmButtonColor: "#3AAC87",
					timer: 6000
				});
			}, 2000);
		});
	});
</script>