@extends('layouts.app')

@section('pageClass', 'vitamin__page')

@section('title', "{$page->title} - TakeDaily")

@section('mainClasses', 'ex')

@section('content')

    <!-- Main Content -->
    <main>

        <!-- Page: HomePage -->
        <div class="p-home">

            <!-- Block 1 -->
            <section class="b-hero">

                <!-- Block 1 Img -->
                <figure class="b-hero__media">
                    <img src="http://via.placeholder.com/1905x556/8c8cd9/fff?text=Block 1" alt="">
                </figure>

                <!-- Block 1 Text -->
                <div class="b-hero__txt">
                    <h1 class="b-hero__title">{{ $page->title }}</h1>
                    <p class="b-hero__intro">
                        <span>Hvordan får du D-Vitaminer?</span>
                        D-vitamin findes naturligt i fede fisk, æg og mælkeprodukter og huden absorberer D-Vitamin fra
                    </p>
                    <button class="c-btn">MANGLER DU D-VITAMIN - TAG VORES TEST</button>
                </div>

            </section>

            <!-- Block 2 -->
            <section class="b-2">
                <div class="l">

                    <section class="b-2__articles">
                        <article class="b-2__article">
                            <div class="b-2__article__ico"></div>
                            <h4 class="b-2__article__title">Stærkere knogler</h4>
                            <p class="b-2__article__desc">Øger kroppens evne til at optage calcium og stimulerer dermed nydannelsen af knoglevæv</p>
                        </article>
                        <article class="b-2__article">
                            <div class="b-2__article__ico"></div>
                            <h4 class="b-2__article__title">Stærkere knogler</h4>
                            <p class="b-2__article__desc">Øger kroppens evne til at optage calcium og stimulerer dermed nydannelsen af knoglevæv</p>
                        </article>
                        <article class="b-2__article">
                            <div class="b-2__article__ico"></div>
                            <h4 class="b-2__article__title">Stærkere knogler</h4>
                            <p class="b-2__article__desc">Øger kroppens evne til at optage calcium og stimulerer dermed nydannelsen af knoglevæv</p>
                        </article>
                        <article class="b-2__article">
                            <div class="b-2__article__ico"></div>
                            <h4 class="b-2__article__title">Stærkere knogler</h4>
                            <p class="b-2__article__desc">Øger kroppens evne til at optage calcium og stimulerer dermed nydannelsen af knoglevæv</p>
                        </article>
                    </section>

                </div>
            </section>

            <!-- Block 3 -->
            <section class="b-3">

                <!-- Block 3 Text -->
                <div class="b-3__txt">
                    <h2 class="b-3__title">HVOR MEGET ANBEFALES DET DU TAGER PER DAG?</h2>
                    <p class="b-3__intro">
                        <strong>Anbefalet daglig tilførsel:</strong>
                        <br>
                        Kvinder og mænd: 10 µg
                        <br>
                        Kvinder og mænd over 70 år: 20 µg
                    </p>
                </div>

            </section>

            <!-- Block 4 -->
            <section class="b-4">
                <div class="l">

                    <h2 class="b-4__title">GOde Gilder</h2>

                    <section class="b-4__articles">
                        <article class="b-4__article">
                            <div class="b-4__article__ico"></div>
                            <h4 class="b-4__article__title">Fed fisk </h4>
                            <p class="b-4__article__desc">Spis fede fisk som Makrel, laks og ikke mindst torskelever er fulde af D-vitamin, og det anbefales at spise 200-300 gram om ugen.</p>
                        </article>
                        <article class="b-4__article">
                            <div class="b-4__article__ico"></div>
                            <h4 class="b-4__article__title">Fed fisk </h4>
                            <p class="b-4__article__desc">Spis fede fisk som Makrel, laks og ikke mindst torskelever er fulde af D-vitamin, og det anbefales at spise 200-300 gram om ugen.</p>
                        </article>
                    </section>

                </div>
            </section>

            <!-- Block 5 -->
            <section class="b-5">
                <!-- Block 5 Img -->
                <figure class="b-7__media">
                    <img src="http://via.placeholder.com/1905x409/bfbfbf/fff?text=Block 5" alt="">
                </figure>

                <!-- Block 5 Text -->
                <div class="b-5__txt">
                    <h2 class="b-5__title">VITAMINER KAN BRUGES SOM SUPPLEMENT</h2>
                    <p class="b-5__intro">Tag vores test og se om du mangler vitaminer</p>
                    <button class="c-btn">TAG TESTEN - KLIK HER</button>
                </div>
            </section>

            <!-- Block 6 -->
            <section class="b-6">
                <div class="l">

                    <h2 class="b-6__title">HVAD SIGER VORES KUNDER?</h2>

                    <section class="b-6__articles">
                        <article class="b-6__article">
                            <h4 class="b-6__article__desc">“Jeg får D-Vitamin som en del af mit abonnement og kan mærke forskellen”</h4>
                            <p class="b-6__article__author">JYTTE, 43</p>
                        </article>
                        <article class="b-6__article">
                            <h4 class="b-6__article__desc">“Jeg får D-Vitamin som en del af mit abonnement og kan mærke forskellen”</h4>
                            <p class="b-6__article__author">JYTTE, 43</p>
                        </article>
                        <article class="b-6__article">
                            <h4 class="b-6__article__desc">“Jeg får D-Vitamin som en del af mit abonnement og kan mærke forskellen”</h4>
                            <p class="b-6__article__author">JYTTE, 43</p>
                        </article>
                    </section>

                </div>
            </section>

            <!-- Block 7 -->
            <section class="b-7">
                <!-- Block 7 Img -->
                <figure class="b-7__media">
                    <img src="http://via.placeholder.com/1905x398/a6a6a6/fff?text=Block 7" alt="">
                </figure>

                <!-- Block 7 Text -->
                <div class="b-7__txt">
                    <div class="l">
                        <h2 class="b-7__title">Daglige vitaminer. Tilpasset dig. Sendt til din dør.</h2>
                        <button class="c-btn">TAG VORES GRATIS TEST - KLIK HER</button>
                    </div>
                </div>
            </section>

        </div>

    </main>

@endsection

