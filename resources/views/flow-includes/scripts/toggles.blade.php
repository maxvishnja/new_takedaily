<style>
	.datepicker-decades:before {  content: "{!! trans('flow.datepicker.pick-decade') !!}";  }

	.datepicker-years:before {  content: "{!! trans('flow.datepicker.pick-year') !!}";  }

	.datepicker-months:before {  content: "{!! trans('flow.datepicker.pick-month') !!}";  }

	.datepicker-days:before {  content: "{!! trans('flow.datepicker.pick-day') !!}";  }
</style>


<style>
	.datepicker .prev,
	.datepicker .next {
		width: 30px;
		height: 20px;
		font-size: 0;
		color: transparent;
	}

	.datepicker .prev,
	.datepicker .prev:hover,
	.datepicker .prev:focus {
		background-size: 26px 26px;
		background-position: center center;
		background-repeat: no-repeat;
		background-image: url(/images/icons/icon-prev.png) !important;
	}

	.datepicker .next,
	.datepicker .next:hover,
	.datepicker .next:focus {
		background-size: 26px 26px;
		background-position: center center;
		background-repeat: no-repeat;
		background-image: url(/images/icons/icon-next.png) !important;
	}
</style>

<script>
	$('#openPicker').datepicker({
		startDate: "-100y",
		endDate: "-18y",
		startView: 2,
		weekStart: 1,
		autoclose: true,
		language: "{{ App::getLocale() }}"
	}).on("changeDate", function () {
		app.user_data.birthdate = $('#openPicker').datepicker('getDate');
	});

	$("#openPicker").click(function (e) {
		e.preventDefault();
		$('#openPicker').datepicker('show');
	});

	$("#flow-toggler").click(function (e) {
		$(".flow-progress").toggleClass('flow-progress--closed');
		$(this).toggleClass('toggled');
	});

	$(".tab-toggler").click(function () {
		$(this).parent().find('.tab--active').removeClass('tab--active');
		$(this).parent().parent().find('.tab-block--active').removeClass('tab-block--active');
		$(this).addClass('tab--active');
		$($(this).data('tab')).addClass('tab-block--active');
	});
</script>