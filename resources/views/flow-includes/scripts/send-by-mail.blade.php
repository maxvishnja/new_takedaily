<script>{{-- todo translate --}}
	var sendByMailBtn = $("#send-by-mail-button");

	sendByMailBtn.click(function (e) {
		e.preventDefault();

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

			$.post('/flow/send-recommendation', { token: app.recommendation_token, email: inputValue }).done(function () {
				sendByMailBtn.hide();

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
			});
		});
	});
</script>