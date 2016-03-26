$(".toggle-mobile-nav").click(function (e)
{
	e.preventDefault();

	$($(this).attr('href')).toggleClass('active');
});

function validateFormInput(form, addClasses)
{
	var errors = [];

	if (addClasses === undefined)
	{
		addClasses = true;
	}

	form.find("[data-validate='true']").each(function (i, input)
	{
		if ($(input).attr('required') === 'required' && $(input).val() === '')
		{
			errors.push(input);

			if (addClasses)
			{
				$(input).addClass('input--error');
			}
		}
		else
		{
			if (addClasses)
			{
				$(input).removeClass('input--error');
				$(input).addClass('input--success');
			}
		}
	});

	// todo something with the errors.

	if (errors.length > 0)
	{
		return false;
	}

	return true;
};