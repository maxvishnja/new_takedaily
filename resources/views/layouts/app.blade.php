<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <title>@yield('title', 'TakeDaily')</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, user-scalable=no, maximum-scale=1.0"/>

    <link href="{{ elixir('css/app.css') }}" rel="stylesheet"/>

    <meta property="og:image" content="{{ asset('/images/meta.png') }}" />
    <meta property="og:title" content="@yield('title', 'TakeDaily')" />

    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <link rel="icon" type="image/png" href="/favicon.png"/>

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ['Montserrat:400,600,700']
            }
        });
    </script>

    <script>
        (function(d) {
            var tkTimeout=3000;
            if(window.sessionStorage){if(sessionStorage.getItem('useTypekit')==='false'){tkTimeout=0;}}
            var config = {
                    kitId: 'feb1teb',
                    scriptTimeout: tkTimeout
                },
                h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+"wf-inactive";if(window.sessionStorage){sessionStorage.setItem("useTypekit","false")}},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+="wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
        })(document);
    </script>

    <!--[if lt IE 9]>
    <script src="/js/respond.min.js"></script>
    <script src="/js/html5shiv.min.js"></script>
    <script src="/js/modernizr-custom.min.js"></script>
    <![endif]-->
    <script src="https://use.fontawesome.com/a0fbf8c496.js"></script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-T6BSGJG');</script>
    <!-- End Google Tag Manager -->

</head>

<body class="@yield('pageClass', 'index')">
<header class="b-header @if(!Request::is('/')){{ 'active' }}@endif">

    <div class="b-header__body">

        <!-- Logo -->
        <div class="b-header__logo">
            <a href="/">
                <img
                    src="/images/header/takedaily-logo--main.svg"
                    alt=""
                    class="b-header__logo__main">
                <img src="/images/header/takedaily-logo--sec.svg"
                     alt=""
                     class="b-header__logo__sec">
            </a>
        </div>

        <!-- Navigation -->
        @include('includes.app.nav')

        <!-- Button -->
        <a href="/flow" class="hp-btn">{{ trans('home2.take-test') }}</a>

        <!-- Hamb -->
        <div id="nav-icon4" class="b-header__hamb c-nav-header__trigger">
            <span class="b-header__hamb__span"></span>
            <span class="b-header__hamb__span"></span>
            <span class="b-header__hamb__span"></span>
        </div>

    </div>

</header>

@yield('content')

@include('includes.app.footer2')
