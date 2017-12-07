// Header Behavior
$(window).on('load', function() {

    var header = $('.b-header');
    var hpHero = $('.hp-hero');

    var headerHeight = header.height();
    var hpHeroHeight = hpHero.height();

    $(document).scroll(function() {
        if ($(this).scrollTop() > (hpHeroHeight - headerHeight / 2)) {
            header.addClass('active');
        } else {
            header.removeClass('active');
        }
    });

    $('.c-nav-header__trigger').click(function() {
        $('.c-nav-header').toggleClass('active');
    });

});

// Sliders
sliderMembers();
if ($(window).width() < 768) {
    sliderInstagram();
    sliderCompromises();
}
function sliderMembers() {
    $('.hp-members__list').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        prevArrow: '<div class="hp-members__arrow hp-members__arrow--left"></div>',
        nextArrow: '<div class="hp-members__arrow hp-members__arrow--right"></div>',
        dots: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    arrows: false
                }
            }
        ]
    });
}
function sliderCompromises() {
    $('.hp-comp__list').slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: false,
        dots: false,
        infinite: false
    });
}
function sliderInstagram() {
    $('.hp-insta__list').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: false
    });
}

// footer flags
$('.b-footer__lang__arrow').on('hover', function () {
    $('.b-footer__lang__dropdown').css('display', 'block');
})

// old code

$(".toggle-mobile-nav").click(function (e)
{
	e.preventDefault();

	$($(this).attr('href')).toggleClass('active');
});

$('.video_circle_content').on('click', function(){
	ga('send', {
		hitType: 'event',
		eventCategory: 'Videos',
		eventAction: 'play',
		eventLabel: 'Video_name'
	});
});

$('.dropdown-toggle').on('click',function(e){
	e.preventDefault();
	$('.center-dropdown').toggle(500);
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

	return (errors.length == 0)

};