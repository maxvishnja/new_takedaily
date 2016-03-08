$(".toggle-mobile-nav").click(function (e)
{
	e.preventDefault();

	$($(this).attr('href')).toggleClass('active');
});