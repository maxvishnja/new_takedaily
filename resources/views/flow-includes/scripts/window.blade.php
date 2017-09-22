<script type="text/javascript">
	var firstStep = $(".step.step--active"),
		combinationAjax,
		combinationTimeout;

	var newHeight = 1;
	firstStep.find(".sub_step").each(function () {
		if ($(this).height() > newHeight) {
			newHeight = $(this).height();
		}
	});

	firstStep.css("min-height", newHeight * 1.2);

	$("window").resize(function () {
		var firstStep = $(".step.step--active");

		var newHeight = 1;
		firstStep.find(".sub_step").each(function () {
			if ($(this).height() > newHeight) {
				newHeight = $(this).height();
			}
		});

		firstStep.css("min-height", newHeight * 1.2);
	});
</script>