<script>
	var sendByMailBtn = $("#send-by-mail-button");

	sendByMailBtn.click(function (e) {
		e.preventDefault();

		swal({
			title: "{{ trans('flow.four.send.title') }}",
			text: "{{ trans('flow.four.send.email') }}",
			type: "input",
			showCancelButton: true,
			confirmButtonColor: "#3AAC87",
			confirmButtonText: "{{ trans('flow.four.send.send') }}",
			cancelButtonText: "{{ trans('flow.four.send.cancel') }}",
			closeOnConfirm: false,
			inputPlaceholder: "{{ trans('flow.four.send.placeholder') }}",
			showLoaderOnConfirm: true
		}, function (inputValue) {
			if (inputValue === false || inputValue === "") {
				swal.showInputError("{{ trans('flow.four.send.error') }}");
				return false;
			}

			$.post('{{ url()->route('flow-recommendations') }}', { token: app.recommendation_token, email: inputValue }).done(function () {
				sendByMailBtn.hide();

				swal({
					title: "{{ trans('message.success-title') }}",
					text: "{{ trans('flow.four.send.success') }}",
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