$(".toggle-mobile-nav").click(function (e)
{
	e.preventDefault();

	$($(this).attr('href')).toggleClass('active');
});

function validateFormInput(form) {
	var errors = [];

	form.find("[data-validate='true']").each(function (i, input) {
		if( $(input).attr('required') === 'required' && $(input).val() === '' )
		{
			errors.push(input);
			$(input).addClass('input--error');
		}
		else
		{
			$(input).removeClass('input--error');
			$(input).addClass('input--success');
		}
	});

	// todo something with the errors.

	if( errors.length > 0 )
	{
		return false;
	}

	return true;
};