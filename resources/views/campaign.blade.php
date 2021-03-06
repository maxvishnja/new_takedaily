@extends('layouts.app')

@section('pageClass', 'index')

@section('content')
    <main style="margin-top: -6rem;">
        <!-- HP Hero -->
        <section class="hp-hero">
            <div class="hp-hero__media"></div>
            <div class="l">
                <div class="hp-hero__content @if(App::getLocale() == 'nl') {{ 'm-w-nl' }} @endif">
                    <h1 class="hp-hero__title">{!! trans('home2.header.title-1') !!}</h1>
                    <p class="hp-hero__intro">{!! trans('home2.header.intro') !!}</p>
                    <a href="/flow" class="hp-btn blk-bg">{!! trans('home2.header.button-test') !!}</a>
                    <div class="hp-hero__play">
                        <a href="#">
                            <div class="hp-hero__play__btn" id="video-toggle">
                                <div class="hp-hero__play__btn__icon"></div>
                            </div>
                        </a>
                        <span class="hp-hero__play__txt">{!! trans('home2.header.play-text') !!}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Choose -->
        <section class="hp-choose l">
            <h2 class="hp-choose__title">{{ trans('home2.choose.title') }}</h2>
            <section class="hp-choose__list">
                <article class="hp-choose__item">
                    <img
                            src="/images/home/oval.png"
                            alt=""
                            class="hp-choose__item__img">
                    <h4 class="hp-choose__item__title">{{ trans('home2.choose.block1-title') }}</h4>
                    <p class="hp-choose__item__intro">{{ trans('home2.choose.block1-text') }}</p>
                </article>
                <article class="hp-choose__item">
                    <img
                            src="/images/home/oval2.png"
                            alt=""
                            class="hp-choose__item__img">
                    <h4 class="hp-choose__item__title">{{ trans('home2.choose.block2-title') }}</h4>
                    <p class="hp-choose__item__intro">{{ trans('home2.choose.block2-text')  }}</p>
                </article>
                <article class="hp-choose__item">
                    <img
                            src="/images/home/oval3.png"
                            alt=""
                            class="hp-choose__item__img">
                    <h4 class="hp-choose__item__title">{{ trans('home2.choose.block3-title') }}</h4>
                    <p class="hp-choose__item__intro">{{ trans('home2.choose.block3-text')  }}</p>
                </article>
            </section>
        </section>

        <!-- Reviews -->
        <section class="hp-members l">
            <div class="hp-members__body">
                <h2 class="hp-members__title">{{ trans('home2.reviews.title') }}</h2>
                <section class="hp-members__list">
                    @foreach($reviews as $review)
                        <article class="hp-members__item">
                            <div class="hp-members__item__media">
                                <img src="/images/reviews/smiley.png" alt="">
                            </div>
                            <p class="hp-members__item__intro">{{ $review->review }}</p>
                            <p class="hp-members__item__author">{{ $review->name }} {{ $review->age }}@if(\App::getLocale() == 'da') {{ 'år' }} @else {{ 'jaar' }} @endif</p>
                        </article>
                    @endforeach
                </section>
            </div>
        </section>

        <!-- Compromises -->
        <section class="hp-comp l">
            <h2 class="hp-comp__title">{{ trans('home2.compromises.title') }}</h2>
            <p class="hp-comp__intro">{{ trans('home2.compromises.subtitle') }}</p>
            <section class="hp-comp__list">
                <article class="hp-comp__item">
                    <img src="/images/icons/plantbased.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home2.compromises.icons.plantbased') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/ISO.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home2.compromises.icons.iso') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/nordic.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home2.compromises.icons.nordic') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/fos.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home2.compromises.icons.fos') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/glutenfree.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home2.compromises.icons.glutenfree') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/lactosefree.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home2.compromises.icons.laktosefri') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/allergyfree.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home2.compromises.icons.allergifri') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/gmo.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home2.compromises.icons.gmo') !!}</p>
                </article>
            </section>
        </section>

        <!-- Mosaic -->
        <section class="hp-mosaic l">
            <div class="hp-mosaic__wrapper">
                <article class="hp-mosaic__item">
                    <div class="hp-mosaic__item__media" id="media1"></div>
                    <div class="hp-mosaic__item__content">
                        <h3 class="hp-mosaic__item__title">{{ trans('home2.mosaic.block1_h3') }}</h3>
                        <p class="hp-mosaic__item__intro">{!!  trans('home2.mosaic.block1_txt') !!}</p>
                    </div>
                </article>
                <article class="hp-mosaic__item">
                    <div class="hp-mosaic__item__media" id="media2"></div>
                    <div class="hp-mosaic__item__content">
                        <h3 class="hp-mosaic__item__title">{{ trans('home2.mosaic.block2_h3') }}</h3>
                        <p class="hp-mosaic__item__intro">{!!  trans('home2.mosaic.block2_txt') !!}</p>
                    </div>
                </article>
            </div>
        </section>

        <!-- Enjoy -->
        <section class="hp-enjoy l">
            <div class="hp-enjoy__wrapper">
                <div class="hp-enjoy__body">
                    <h2 class="hp-enjoy__title">{{ trans('home2.enjoy.title') }}</h2>
                    <section class="hp-enjoy__list">
                        <article class="hp-enjoy__item">
                            <img src="/images/enjoy/chat.png" alt="" class="hp-enjoy__item__img">
                            <p class="hp-enjoy__item__intro">{!! trans('home2.enjoy.p1') !!}</p>
                        </article>
                        <article class="hp-enjoy__item">
                            <img src="/images/enjoy/salad.png" alt="" class="hp-enjoy__item__img">
                            <p class="hp-enjoy__item__intro">{!! trans('home2.enjoy.p2') !!}</p>
                        </article>
                        <article class="hp-enjoy__item">
                            <img src="/images/enjoy/factory.png" alt="" class="hp-enjoy__item__img">
                            <p class="hp-enjoy__item__intro">{!! trans('home2.enjoy.p3') !!}</p>
                        </article>
                        <article class="hp-enjoy__item">
                            <img src="/images/enjoy/connection-chart.png" alt="" class="hp-enjoy__item__img">
                            <p class="hp-enjoy__item__intro">{!! trans('home2.enjoy.p4') !!}</p>
                        </article>
                    </section>
                </div>
            </div>
        </section>

        <!-- Packaging -->
        <section class="hp-packaging">
            <div class="hp-packaging__body l">
                <div class="hp-packaging__content">
                    <h2 class="hp-packaging__title">{{ trans('home2.packaging.title') }}</h2>
                    <p class="hp-packaging__intro">{{ trans('home2.packaging.intro') }}</p>
                    <a href="/pick-n-mix" class="hp-btn">{{ trans('home2.packaging.btn') }}</a>
                </div>
                <div class="hp-packaging__media">
                    <img src="/images/home/product.png" alt="">
                </div>
            </div>
        </section>

        <!-- Nutritionists -->
        @if($nutritionists)
            <section class="hp-nutr l">
                <div class="hp-nutr__wrapper">
                    <h2 class="hp-nutr__title">{{ trans('home2.nutritionists.title') }}</h2>
                    <p class="hp-nutr__intro">{{ trans('home2.nutritionists.intro') }}</p>
                    <section class="hp-nutr__list">
                        @foreach($nutritionists as $nutri)
                            <article class="hp-nutr__item">
                                @if($nutri->image !== '')
                                    <img src="/images/nutritionist/thumb_{{$nutri->image}}" alt="" class="hp-nutr__item__img">
                                @else
                                    <img src="http://via.placeholder.com/180x180/ff66cc/fff" alt="" class="hp-nutr__item__img">
                                @endif
                                <div class="hp-nutr__item__content">
                                    <h4 class="hp-nutr__item__title">{{ $nutri->first_name }}</h4>
                                    <p class="hp-nutr__item__intro">{{ $nutri->desc }}</p>
                                </div>
                            </article>
                        @endforeach
                    </section>
                </div>
            </section>
        @endif

    <!-- Instagram -->
        @if($instaLatestFour)
            <section class="hp-insta l">
                <header class="hp-insta__head">
                    <img src="/images/home/insta.png" alt="" class="hp-insta__logo">
                    <h2 class="hp-insta__title">#Takedaily</h2>
                </header>
                <section class="hp-insta__list">
                    @foreach($instaLatestFour as $insta)
                        <article class="hp-insta__item">
                            <div class="hp-insta__item__media">
                                <a href="{{ $insta['link'] }}" target="_blank">
                                    <img srcset="{{ $insta['images']['standard_resolution']['url'] }}"
                                         width="237px"
                                         height="237px"
                                         alt="">
                                </a>
                            </div>
                            <div class="hp-insta__item__content">
                                <p class="hp-insta__item__intro">{{ $insta['caption']['text'] }}</p>
                                <span class="hp-insta__item__bottom">
                            <img src="/images/instagram/like.png" alt="">
                            <span class="hp-insta__item__bottom__num">{{ $insta['likes']['count'] }}</span>
                        </span>
                                <span class="hp-insta__item__bottom">
                            <img src="/images/instagram/comment.png" alt="">
                            <span class="hp-insta__item__bottom__num">{{ $insta['comments']['count'] }}</span>
                        </span>
                            </div>
                        </article>
                    @endforeach
                </section>
            </section>
        @endif

        <div class="video-popup" id="video_popup">
            <div class="video_popup_aligner">
                <div class="video-popup_container">
                    <div class="video-popup-close" id="video_popup_close"><span class="icon icon-cross-large"></span></div>
                    <div id="video_popup-content"></div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('footer_scripts')
    <script>
        var videoPopup = $("#video_popup");
        var videoPopupContent = $("#video_popup-content");
        $("#video-toggle, #video-toggle-two").click(function (e) {
            e.preventDefault();
            videoPopupContent.html('<video preload="none" autoplay controls>' +
                '<source src="/video/{{ App::getLocale() }}/home.mp4" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' />' +
                '<source src="/video/{{ App::getLocale() }}/home.webm" type=\'video/webm; codecs="vp8, vorbis"\' />' +
                '<source src="/video/{{ App::getLocale() }}/home.ogv" type=\'video/ogg; codecs="theora, vorbis"\' />' +
                '<source src="/video/{{ App::getLocale() }}/home.m4v" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' />' +
                '</video>');
            videoPopup.fadeIn(200);
        });

        $("#video_popup_close").click(function () {
            videoPopupContent.html('');
            videoPopup.hide();
        });

        $(".video-popup").click(function () {
            videoPopupContent.html('');
            videoPopup.hide();
        });

        $(".video-popup_container").click(function (e) {
            e.stopPropagation();
        });
    </script>
@endsection