@extends('layouts.app')

@section('pageClass', 'index')

@section('content')
    <main>
        <!-- HP Hero -->
        <section class="hp-hero">
            <div class="hp-hero__media">
                {{--<picture>--}}
                    {{--<!-- Desk && Tab img -->--}}
                    {{--<source srcset="/images/home/hero.jpg" media="(min-width: 768px)">--}}
                    {{--<!-- Mob img -->--}}
                    {{--<img srcset="/images/home/hero-mobile.jpg"--}}
                         {{--alt="">--}}
                {{--</picture>--}}
            </div>
            <div class="l">
                <div class="hp-hero__content">
                    <h1 class="hp-hero__title">{!! trans('home.header.title-1') !!}</h1>
                    <p class="hp-hero__intro">{!! trans('home.header.intro') !!}</p>
                    <a href="/flow" class="hp-btn">{!! trans('home.header.button-test') !!}</a>
                    <div class="hp-hero__play">
                        <a href="">
                            <div class="hp-hero__play__btn">
                                <div class="hp-hero__play__btn__icon"></div>
                            </div>
                        </a>
                        <span class="hp-hero__play__txt">{!! trans('home.header.play-text') !!}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Choose -->
        <section class="hp-choose l">
            <h2 class="hp-choose__title">{{ trans('home.choose.title') }}</h2>
            <section class="hp-choose__list">
                <article class="hp-choose__item">
                    <img
                        src="/images/home/oval.png"
                        alt=""
                        class="hp-choose__item__img">
                    <h4 class="hp-choose__item__title">{{ trans('home.choose.block1-title') }}</h4>
                    <p class="hp-choose__item__intro">{{ trans('home.choose.block1-text') }}</p>
                </article>
                <article class="hp-choose__item">
                    <img
                        src="/images/home/oval2.png"
                        alt=""
                        class="hp-choose__item__img">
                    <h4 class="hp-choose__item__title">{{ trans('home.choose.block2-title') }}</h4>
                    <p class="hp-choose__item__intro">{{ trans('home.choose.block2-text')  }}</p>
                </article>
                <article class="hp-choose__item">
                    <img
                        src="/images/home/oval3.png"
                        alt=""
                        class="hp-choose__item__img">
                    <h4 class="hp-choose__item__title">{{ trans('home.choose.block3-title') }}</h4>
                    <p class="hp-choose__item__intro">{{ trans('home.choose.block3-text')  }}</p>
                </article>
            </section>
        </section>

        <!-- Reviews -->
        <section class="hp-members l">
            <div class="hp-members__body">
                <h2 class="hp-members__title">{{ trans('home.reviews.title') }}</h2>
                <section class="hp-members__list">
                    @foreach($reviews as $review)
                        <article class="hp-members__item">
                            <div class="hp-members__item__media">
                                <img src="/images/reviews/smiley.png" alt="">
                            </div>
                            <p class="hp-members__item__intro">{{ $review->review }}</p>
                            <p class="hp-members__item__author">{{ $review->name }} {{ $review->age }}år</p>
                        </article>
                    @endforeach
                </section>
            </div>
        </section>

        <!-- Compromises -->
        <section class="hp-comp l">
            <h3 class="hp-comp__title">{{ trans('home.compromises.title') }}</h3>
            <p class="hp-comp__intro">{{ trans('home.compromises.subtitle') }}</p>
            <section class="hp-comp__list">
                <article class="hp-comp__item">
                    <img src="/images/icons/plantbased.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home.compromises.icons.plantbased') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/ISO.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home.compromises.icons.iso') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/nordic.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home.compromises.icons.nordic') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/fos.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home.compromises.icons.fos') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/glutenfree.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home.compromises.icons.glutenfree') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/lactosefree.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home.compromises.icons.laktosefri') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/allergyfree.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home.compromises.icons.allergifri') !!}</p>
                </article>
                <article class="hp-comp__item">
                    <img src="/images/icons/gmo.png" alt="" class="hp-comp__item__img">
                    <p class="hp-comp__item__title">{!! trans('home.compromises.icons.gmo') !!}</p>
                </article>
            </section>
        </section>

        <!-- Mosaic -->
        <section class="hp-mosaic l">
            <article class="hp-mosaic__item">
                <div class="hp-mosaic__item__media">
                    <picture>
                        <!-- Desk && Tab img -->
                        <source srcset="/images/home/Takedaily1.jpg" media="(min-width: 768px)">
                        <!-- Mob img -->
                        <img srcset="/images/home/Takedaily1.jpg"
                             alt=""
                             class="hp-mosaic__item__img">
                    </picture>
                </div>
                <div class="hp-mosaic__item__content">
                    <h3 class="hp-mosaic__item__title">{{ trans('home.mosaic.block1_h3') }}</h3>
                    <p class="hp-mosaic__item__intro">{!!  trans('home.mosaic.block1_txt') !!}</p>
                </div>
            </article>
            <article class="hp-mosaic__item">
                <div class="hp-mosaic__item__media">
                    <picture>
                        <!-- Desk && Tab img -->
                        <source srcset="/images/home/Takedaily2.jpg" media="(min-width: 768px)">
                        <!-- Mob img -->
                        <img srcset="/images/home/Takedaily2.jpg"
                             alt=""
                             class="hp-mosaic__item__img">
                    </picture>
                </div>
                <div class="hp-mosaic__item__content">
                    <h3 class="hp-mosaic__item__title">{{ trans('home.mosaic.block2_h3') }}</h3>
                    <p class="hp-mosaic__item__intro">{!!  trans('home.mosaic.block2_txt') !!}</p>
                </div>
            </article>
        </section>

        <!-- Enjoy -->
        <section class="hp-enjoy l">
            <div class="hp-enjoy__body">
                <h2 class="hp-enjoy__title">Til glæde for dig</h2>
                <section class="hp-enjoy__list">
                    <article class="hp-enjoy__item">
                        <img src="/images/enjoy/chat.png" alt="" class="hp-enjoy__item__img">
                        <p class="hp-enjoy__item__intro">{!! trans('home.enjoy.p1') !!}</p>
                    </article>
                    <article class="hp-enjoy__item">
                        <img src="/images/enjoy/salad.png" alt="" class="hp-enjoy__item__img">
                        <p class="hp-enjoy__item__intro">{!! trans('home.enjoy.p2') !!}</p>
                    </article>
                    <article class="hp-enjoy__item">
                        <img src="/images/enjoy/factory.png" alt="" class="hp-enjoy__item__img">
                        <p class="hp-enjoy__item__intro">{!! trans('home.enjoy.p3') !!}</p>
                    </article>
                    <article class="hp-enjoy__item">
                        <img src="/images/enjoy/connection-chart.png" alt="" class="hp-enjoy__item__img">
                        <p class="hp-enjoy__item__intro">{!! trans('home.enjoy.p4') !!}</p>
                    </article>
                </section>
            </div>
        </section>

        <!-- Packaging -->
        <section class="hp-packaging">
            <div class="hp-packaging__body l">
                <div class="hp-packaging__content">
                    <h2 class="hp-packaging__title">Kender du dit vitamin behov?</h2>
                    <p class="hp-packaging__intro">- Så kan du nemt og enkelt sammensætte din egen pakke</p>
                    <a href="" class="hp-btn">Vælg selv dine vitaminer</a>
                </div>
                <div class="hp-packaging__media">
                    <img src="/images/home/product.png" alt="">
                </div>
            </div>
        </section>

        <!-- Nutritionists -->
        <section class="hp-nutr l">
            <h2 class="hp-nutr__title">Spørg vores ernæringseksperter</h2>
            <p class="hp-nutr__intro">Dummy text goes here…</p>
            <section class="hp-nutr__list">
                <article class="hp-nutr__item">
                    <img src="http://via.placeholder.com/180x180/ff66cc/fff" alt="" class="hp-nutr__item__img">
                    <div class="hp-nutr__item__content">
                        <h4 class="hp-nutr__item__title">Marie-Louise</h4>
                        <p class="hp-nutr__item__intro">Ernærings, BA i Ernæring & Sundhed, Projektleder</p>
                    </div>
                </article>
                <article class="hp-nutr__item">
                    <img src="http://via.placeholder.com/180x180/ff66cc/fff" alt="" class="hp-nutr__item__img">
                    <div class="hp-nutr__item__content">
                        <h4 class="hp-nutr__item__title">Marie-Louise</h4>
                        <p class="hp-nutr__item__intro">Ernærings, BA i Ernæring & Sundhed, Projektleder</p>
                    </div>
                </article>
                <article class="hp-nutr__item">
                    <img src="http://via.placeholder.com/180x180/ff66cc/fff" alt="" class="hp-nutr__item__img">
                    <div class="hp-nutr__item__content">
                        <h4 class="hp-nutr__item__title">Marie-Louise</h4>
                        <p class="hp-nutr__item__intro">Ernærings, BA i Ernæring & Sundhed, Projektleder</p>
                    </div>
                </article>
            </section>
        </section>

        <!-- Instagram -->
        @if($instaLatestFour)
        <section class="hp-insta l">
            <header class="hp-insta__head">
                <img src="/images/instagram/insta.png" alt="" class="hp-insta__logo">
                <h2 class="hp-insta__title">#Takedaily</h2>
            </header>
            <section class="hp-insta__list">
            @foreach($instaLatestFour as $insta)
                <article class="hp-insta__item">
                    <div class="hp-insta__item__media">
                        <img srcset="{{ $insta->images->standard_resolution->url }}" width="237px" height="237px" alt="">
                    </div>
                    <div class="hp-insta__item__content">
                        <p class="hp-insta__item__intro">{{ $insta->caption->text }}</p>
                        <span class="hp-insta__item__bottom">
                            <img src="/images/instagram/like.png" alt="">
                            <span class="hp-insta__item__bottom__num">{{ $insta->likes->count }}</span>
                        </span>
                        <span class="hp-insta__item__bottom">
                            <img src="/images/instagram/comment.png" alt="">
                            <span class="hp-insta__item__bottom__num">{{ $insta->comments->count }}</span>
                        </span>
                    </div>
                </article>
            @endforeach
            </section>
        </section>
        @endif
    </main>
@endsection

@section('footer_scripts')

@endsection