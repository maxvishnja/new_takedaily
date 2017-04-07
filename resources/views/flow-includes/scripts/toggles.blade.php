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

	.datepicker .datepicker-decades .datepicker-switch:before {
		content: "-";
		display: block;
		font-weight: normal;
	}

	.datepicker .datepicker-years .datepicker-switch:before {
		content: "-";
		display: block;
		font-weight: normal;
	}

	.datepicker .datepicker-months .datepicker-switch:before {
		content: "{!! trans('flow.datepicker.months.back') !!}";
		display: block;
		font-weight: normal;
	}

	.datepicker .datepicker-days .datepicker-switch:before {
		content: "{!! trans('flow.datepicker.days.back') !!}";
		display: block;
		font-weight: normal;
	}
</style>

<script>
	$('#openPicker').datepicker({
		startDate: "-100y",
		endDate: "-18y",
		startView: 2,
		weekStart: 1,
		autoclose: true,
		defaultViewDate: {year: 1970, month: 1, day: 1},
		language: "{{ App::getLocale() }}"
	}).on("changeDate", function () {
		app.user_data.birthdate = $('#openPicker').datepicker('getUTCDate');
	});

	$("#openPicker").click(function (e) {
		e.preventDefault();
		$('#openPicker').datepicker('show');
	});


	$('.month').on('change',function(){
		$(this).attr('id', $(this).val());
		$('.years').show();
	});

	$('.days').on('change',function(){
		$(this).attr('id', $(this).val());
		$('.month').show();
	});

	$('.years').on('change',function(){
		$(this).attr('id', $(this).val());
		var today = new Date();
		var birthDate = new Date(Date.parse($(this).attr('id')+"-"+$('.month').attr('id')+"-"+$('.days').attr('id')));
		var age = today.getFullYear() - birthDate.getFullYear();
		if(age >= 18 && age < 91){
			app.user_data.birthdate = Date.parse($(this).attr('id')+"-"+$('.month').attr('id')+"-"+$('.days').attr('id'));
		} else{
			app.user_data.birthdate = '';
		}
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