<style>
	.datepicker-decades:before {  content: "{!! trans('flow.datepicker.pick-decade') !!}";  }

	.datepicker-years:before {  content: "{!! trans('flow.datepicker.pick-year') !!}";  }

	.datepicker-months:before {  content: "{!! trans('flow.datepicker.pick-month') !!}";  }

	.datepicker-days:before {  content: "{!! trans('flow.datepicker.pick-day') !!}";  }
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