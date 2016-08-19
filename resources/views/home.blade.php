@extends('layouts.landing')

@section('pageClass', 'index')

@section('content')
    <header class="header--landing header--front-slide-1">
        <div class="header-nav">
            <div class="container-fluid">
                <div class="header_top">
                    <div class="row">
                        <div class="col-md-3 col-xs-9">
                            <a href="/" class="logo logo-white"></a>
                        </div>

                        <div class="col-md-9 col-xs-3">
                            @include('includes.app.nav')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header_content">
            <div class="header_slides_container">
                <div class="header_slides">
                    <div class="header_slide header_slide--active" data-slide="1">
                        <div class="container">
                            <h1>{!! trans('home.header.title-1') !!}</h1>
                            @if( Auth::guest() )
                                <a href="/flow"
                                   class="button button--rounded button--huge button--white button--circular m-t-30">
                                    <strong>{{ trans('home.header.button-click-here') }}</strong>
                                </a>
                                <a href="/gifting"
                                   class="button button--rounded gifting-button button--circular m-t-30">
                                    <strong>{{ trans('home.header.button-gift-text') }}</strong>
                                </a>
                            @endif
                            <div class="headervideo-block">
                                <strong>Hvad er TakeDaily?</strong>{{-- todo translate --}}
                                <span id="video-toggle" class="icon icon-play"></span>
                            </div>
                        </div>
                    </div>

                    <div class="header_slide" data-slide="2">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <h1>{!! trans('home.header.title-1') !!}</h1>
                                    @if( Auth::guest() )
                                        <a href="/flow"
                                           class="button button--rounded button--huge button--green button--circular m-t-30">
                                            <strong>{{ trans('home.header.button-click-here') }}</strong>
                                        </a>
                                        <a href="/gifting"
                                           class="button button--rounded gifting-button button--circular m-t-30">
                                            <strong>{{ trans('home.header.button-gift-text') }}</strong>
                                        </a>
                                    @endif
                                    <div class="headervideo-block">
                                        <strong>Hvad er TakeDaily?</strong>{{-- todo translate --}}
                                        <span id="video-toggle-two" class="icon icon-play"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="splash_circle pull-right hidden-xs">
                                        <span>{!! trans('home.header.splash.text') !!}</span>
                                        <strong>{!! trans('home.header.splash.price') !!}</strong>
                                        <small class="info">{!! trans('home.header.splash.info') !!}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="header_slide_nav hidden-xs">
                <div class="header_slide_nav_item header_slide_nav_item--active" data-slide="1"></div>
                <div class="header_slide_nav_item" data-slide="2"></div>
            </div>
        </div>

        <div class="header_bg_slides_container">
            <div class="header_bg_slides">
                <div class="header_bg_item header_bg_item--1" data-slide="1"></div>
                <div class="header_bg_item header_bg_item--2" data-slide="2"></div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="block block--one text-center">
                <h2>{{ trans('home.blocks.one.title') }}</h2>
                <p class="sub_header">{{ trans('home.blocks.one.description') }}</p>

                <div class="row text-center">
                    <div class="col-sm-4 block_item">
                        <div class="arrow"></div>
                        <span class="icon icon-heart"></span>
                        <h3>{{ trans('home.blocks.one.steps.one.title') }}</h3>
                        <p>{{ trans('home.blocks.one.steps.one.text') }}</p>
                    </div>

                    <div class="col-sm-4 block_item">
                        <div class="arrow"></div>
                        <span class="icon icon-logo"></span>
                        <h3>{{ trans('home.blocks.one.steps.two.title') }}</h3>
                        <p>{{ trans('home.blocks.one.steps.two.text') }}</p>
                    </div>

                    <div class="col-sm-4 block_item">
                        <span class="icon icon-box"></span>
                        <h3>{{ trans('home.blocks.one.steps.three.title') }}</h3>
                        <p>{{ trans('home.blocks.one.steps.three.text') }}</p>
                    </div>
                </div>

                <div class="text-center m-t-50">
                    {!! trans('home.blocks.one.button') !!}
                </div>
            </div>
        </div>

        <div class="block block--promises">{{-- todo translate block --}}
            <div class="container">
                <h2 class="text-center">Hvad vi lover dig</h2>
                <div class="promise-container">
                    <div class="promise-item">
                        <img src="/images/promises/promise_1.png" class="top-left" alt=""/>
                    </div>

                    <div class="promise-item">
                        <p>Gratis rådgivning af TakeDailys egne professionelle diætister ernæringseksperter</p>
                    </div>

                    <div class="promise-item">
                        <img src="/images/promises/promise_2.png" class="top-right" alt=""/>
                    </div>

                    <div class="promise-item">
                        <p>Vi bruger organiske kapsler til hurtigere optagelse og de bedste vitaminer, mineraler og
                            omega fedtsyrer på markedet.
                            <a href="/how-it-works">Læs mere her</a></p>
                    </div>

                    <div class="promise-item">
                        <p>Vi springer alle fordyrende mellemled over og leverer direkte fra fabrik til din dør, på den
                            måde er vi langt billigere end de fleste andre på markedet</p>
                    </div>

                    <div class="promise-item">
                        <img src="/images/promises/promise_3.png" class="bottom-left" alt=""/>
                    </div>

                    <div class="promise-item">
                        <p>Med vores specialudviklede algoritme, skræddersyer vi den optimale kombination af lige netop
                            det du har brug for.
                            <a href="/flow">Kom i gang her</a></p>
                    </div>

                    <div class="promise-item">
                        <img src="/images/promises/promise_4.png" class="bottom-right" alt=""/>
                    </div>
                </div>
            </div>
        </div>

        <div class="block block--reviews">{{-- todo translate block --}}
            <div class="container">
                <h2 class="text-center">Hvad vores kunder siger</h2>

                <div class="row">
                    <div class="col-sm-4 review-item text-center">
                        <img src="https://s3.amazonaws.com/uifaces/faces/twitter/dgclegg/128.jpg" alt="">
                        <blockquote>”Som vegetar er jeg SUPER glad for min månedlige Takedaily pakke!”</blockquote>
                    </div>
                    <div class="col-sm-4 review-item text-center">
                        <img src="https://s3.amazonaws.com/uifaces/faces/twitter/gergelyjanko/128.jpg" alt="">
                        <blockquote>”Som vegetar er jeg SUPER glad for min månedlige Takedaily pakke!”</blockquote>
                    </div>
                    <div class="col-sm-4 review-item text-center">
                        <img src="https://s3.amazonaws.com/uifaces/faces/twitter/jimmuirhead/128.jpg" alt="">
                        <blockquote>”Som vegetar er jeg SUPER glad for min månedlige Takedaily pakke!”</blockquote>
                    </div>
                </div>
            </div>
        </div>

        <div class="block block--two">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2>{!! trans('home.blocks.two.title') !!}</h2>
                        {!! trans('home.blocks.two.body') !!}
                        {!! trans('home.blocks.two.button') !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="block block--three text-center">
                <div class="row">
                    <div class="col-md-4">
                        <img src="/images/dietist.png" class="img--rounded"
                             alt="{{ trans('home.blocks.three.name') }}"/>
                        <span class="dietist-name">{{ trans('home.blocks.three.name') }}</span>
                    </div>
                    <div class="col-md-8">
                        <blockquote>{!! trans('home.blocks.three.quote') !!}</blockquote>

                        {!! trans('home.blocks.three.button') !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="block block--four hidden-xs">
            <div class="container">
                <video src="/video/animation.mp4" autoplay="autoplay" loop="loop" poster="/video/thumbnail.png"
                       oncontextmenu="return false;" muted="muted">
                    <source type="video/mp4" src="/video/animation.mp4"/>
                    <source type="video/ogv" src="/video/animation.ogv"/>
                    <source type="video/webm" src="/video/animation.webm"/>
                </video>
            </div>
        </div>

        <div class="block block--five">
            <img src="//placehold.it/640x420" alt="Image"/>

            <div class="block_content text-center">
                {!! trans('home.blocks.five.body') !!}
                {!! trans('home.blocks.five.button') !!}
            </div>

            <div class="clear"></div>
        </div>

        @if( is_array( trans('home.blocks.six.slides') ) )
            <div class="block block--six">
                <div class="slider_container" id="slider_two">
                    <div class="icon slider-arrow-left icon-arrow-left"></div>
                    <div class="icon slider-arrow-right icon-arrow-right"></div>

                    <div class="slider">
                        <div class="slide_container">
                            @foreach(trans('home.blocks.six.slides') as $slide)
                                <div class="slide">
                                    <div class="container">
                                        <h2 class="text-center">{{ $slide['title'] }}</h2>
                                        <p class="text-center">{{ $slide['text'] }}</p>
                                        <div class="text-center">
                                            {!! $slide['button'] !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="block block--seven text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-push-2">
                        <h2>{{ trans('home.blocks.seven.title') }}</h2>
                        <h3>{{ trans('home.blocks.seven.subtitle') }}</h3>
                        <p>{{ trans('home.blocks.seven.text') }}</p>
                        {!! trans('home.blocks.seven.button') !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="block block--eight text-center">
                <div class="row">
                    <div class="col-md-8 col-md-push-2">
                        <img src="/images/product_box_large.png" alt="TakeDaily boks"/>
                        <h2>{!! trans('home.blocks.eight.title') !!}</h2>
                        <p>{{ trans('home.blocks.eight.text') }}</p>

                        {!! trans('home.blocks.eight.button') !!}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('footer_scripts')
    <script>
        $("#slider_one").slider();
        $("#slider_two").slider();
        {{--
                var ctaBlock = $(".header_footer");
                var headerBlock = $("header.header--landing");

                $(window).scroll(function ()
                {
                    if ($(this).scrollTop() > (headerBlock.height()))
                    {
                        ctaBlock.addClass('header_footer--sticky');
                    }
                    else
                    {
                        ctaBlock.removeClass('header_footer--sticky');
                    }
                });
                --}}

        $("#video-toggle, #video-toggle-two").click(function (e) {
            alert('START VIDEO!'); // todo
        });

        var header_slider = $(".header_slides");
        var header_bg_slider = $(".header_bg_slides");
        var header = $("header.header--landing");
        var logo = $(".logo");

        $(".header_slide_nav_item").click(function () {
            var currentSlide = $(this).data('slide');
            var activeSlide = $(".header_slide_nav_item--active");

            header.removeClass('header--front-slide-' + activeSlide.data('slide'));
            header.addClass('header--front-slide-' + currentSlide);
            activeSlide.removeClass("header_slide_nav_item--active");
            $(this).addClass("header_slide_nav_item--active");

            if (currentSlide == 1) {
                logo.addClass('logo-white');
                logo.removeClass('logo-color');
            }
            else {
                logo.addClass('logo-color');
                logo.removeClass('logo-white');
            }

            header_slider.css("transform", "translateX(-" + (currentSlide - 1) / 2 * 100 + "%)");
            header_slider.css("transform", "-webkit-translateX(-" + (currentSlide - 1) / 2 * 100 + "%)");

            header_bg_slider.css("transform", "translateX(-" + (currentSlide - 1) / 2 * 100 + "%)");
            header_bg_slider.css("transform", "-webkit-translateX(-" + (currentSlide - 1) / 2 * 100 + "%)");
        });
    </script>
@endsection