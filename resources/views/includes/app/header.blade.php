<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
	<title>@yield('title', 'TakeDaily')</title>

	<meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, user-scalable=no, maximum-scale=1.0"/>

	<link href="{{ elixir('css/app.css') }}" rel="stylesheet"/>

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
	<![endif]-->

    <script src="/js/modernizr-custom.min.js"></script>

</head>

<body class="@yield('pageClass', 'index')">