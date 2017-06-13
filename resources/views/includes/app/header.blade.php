<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
	<title>@yield('title', 'TakeDaily')</title>

	<meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, user-scalable=no, maximum-scale=1.0"/>

	<link href="{{ elixir('css/app.css') }}" rel="stylesheet"/>

	<meta property="og:image" content="{{ asset('/images/meta.png') }}" />
	<meta property="og:title" content="@yield('title', 'TakeDaily')" />

	<link rel="shortcut icon" type="image/png" href="/favicon.png"/>
	<link rel="icon" type="image/png" href="/favicon.png"/>

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
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', '{{ trans('general.google_analytics_property') }}', 'auto');
		ga('send', 'pageview');

	</script>

</head>

<body class="@yield('pageClass', 'index')">