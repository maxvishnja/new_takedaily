@extends('layouts.landing')

@section('pageClass', 'index')

@section('content')
	<header class="header--landing header--with-large-bg">
		<div class="container-fluid">
			<div class="header_top">
				<div class="row">
					<div class="col-md-3 col-xs-8">
						<a href="/" class="logo logo-white"></a>
					</div>

					<div class="col-md-9 col-xs-4">
						@include('includes.app.nav')
					</div>
				</div>
			</div>
		</div>

		<div class="slider_container" id="slider_one">
			<div class="icon slider-arrow-left icon-arrow-left"></div>
			<div class="icon slider-arrow-right icon-arrow-right"></div>
			<div class="header_content">
				<div class="slider">
					<div class="slide_container">
						<div class="slide">
							<div class="container">
								<div class="row">
									<div class="col-md-6">
										<h1>Nu bliver det nemt,<br/>
											at få din krop i balance.</h1>
										<a href="#" class="button button--rounded button--huge button--green m-t-30">
											<strong>Tryk her for at starte nu</strong>
										</a>
									</div>
									<div class="col-md-6 hidden-sm hidden-xs">
										<img src="/images/product_small.png" alt="Take Daily box">
									</div>
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="container">
								<div class="row">
									<div class="col-md-8">
										<h1>Take Daily udvælger vitaminer og mineraler i præcis den koncentration, du har brug for. </h1>
										<a href="#" class="button button--rounded button--huge button--green m-t-30">
											<strong>Tryk her for at starte nu</strong>
										</a>
									</div>

									<div class="col-md-4 hidden-sm hidden-xs">
										<div class="splash_circle">
											<span>En måneds forbrug<br/>
											skræddersyet til dig</span>
											<small>Kun</small>
											<strong>149
												<small> kr.</small>
											</strong>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="header_footer hidden-sm hidden-xs">
			<a href="/flow">Start selv</a> i dag eller giv Take Daily <a href="/gifting">i gave</a>
		</div>
	</header>

	<main>
		<div class="container">
			<div class="block block--one text-center">
				<h2>Sådan virker det</h2>
				<p class="sub_header">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dicta ea,
					earum enim est ex hic iure iusto, lorem ipsum.</p>

				<div class="row text-center">
					<div class="col-md-4 block_item">
						<span class="icon icon-user-information"></span>
						<h3>Konsultationen begynder</h3>
						<p>Fortæl os lidt om din krop, kost og livsstil. Det tager ikke mere end 2 minutter at svare på
							spørgsmålene.</p>
					</div>

					<div class="col-md-4 block_item">
						<span class="icon icon-box"></span>
						<h3>Vi skræddersyr dit Take Daily</h3>
						<p>Vi udvælger dine vitaminer og mineraler i koncentrationer, der passer nøjagtigt til dig.</p>
					</div>

					<div class="col-md-4 block_item">
						<span class="icon icon-truck"></span>
						<h3>Du modtager din æske</h3>
						<p>Du får leveret din æske gratis derhjemme eller på kontoret, hvis det passer dig bedre</p>
					</div>
				</div>

				<div class="text-center m-t-50">
					<a href="/flow" class="button button--green button--rounded button--large">Få flere detaljer</a>
				</div>
			</div>
		</div>

		<div class="block block--two">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h2>Lev lidt sundere.<br/>
							Start indefra med Take Daily.</h2>

						<p>
							At finde de helt rigtige vitaminer og mineraler, som din krop har brug for, kan i sig selv
							være en
							udfordring. Hylderne bugner af multivitaminpiller og komplette kosttilskudspakker. Take
							Daily er
							diamentrale modsætninger.
						</p>
						<p>Vi udvælger og sammensætter omhyggeligt de vitaminer og mineraler, som lige præcis din krop
							har brug
							for. Koncentrationerne er individuelle og kommer i din helt egen æske.
						</p>

						<a href="/flow" class="button button--white button--rounded button--large button--text-grey">Start
							i
							dag</a>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="block block--three text-center">
				<div class="row">
					<div class="col-md-4">
						<img src="/images/dietist.png" class="img--rounded" alt="Suzan"/>
						<span class="dietist-name">Suzan, diætist</span>
					</div>
					<div class="col-md-8">
						<blockquote>“Prevention is better than cure. Well said and well understood! But there are
							certain types of headaches, which are part and parcel of you; gifted to you by birth! Sinus
							headache is one of them, unfortunately.”
						</blockquote>

						<a href="/om" class="anchor anchor--underline">Om vitaminer og sundhed</a>
					</div>
				</div>
			</div>
		</div>

		<div class="block block--four hidden-xs">
			<div class="container">
				<video autoplay="autoplay" poster="/video/animation.jpg" style="width:100%" title="animation" loop="loop" onended="var v=this;setTimeout(function(){v.play()},300)">
					<source src="/video/animation.m4v" type="video/mp4"/>
					<source src="/video/animation.webm" type="video/webm"/>
					<source src="/video/animation.ogv" type="video/ogg"/>
				</video>
			</div>
		</div>

		<div class="block block--five">
			<img src="//placehold.it/640x420" alt="Image"/>

			<div class="block_content text-center">
				<p>Take Daily er høj kvalitet og rene, naturlige, aktive ingredienser. Vi har samlet de bedste
					ernæringseksperter og anvender den nyeste, farmaceutiske forskning for at finde frem til den
					ultimative måde at genopbygge din krop indefra.  </p>

				<p>Videnskaben bag er kompleks, men for dig er det hele enkelt og ligetil.</p>

				<a href="/om" class="anchor anchor--underline anchor--inline m-t-20">Få mere baggrundsviden</a>
			</div>

			<div class="clear"></div>
		</div>

		<div class="block block--six">
			<div class="slider_container" id="slider_two">
				<div class="icon slider-arrow-left icon-arrow-left"></div>
				<div class="icon slider-arrow-right icon-arrow-right"></div>

				<div class="slider">
					<div class="slide_container">
						<div class="slide">
							<div class="container">
								<h2 class="text-center">Spiser du sundt, men tillader dig selv en cigaret i ny og
									næ?</h2>
								<p class="text-center">
									Ryger du engang imellem, nedbryder røgen mange af de C-vitaminer, du indtager.
								</p>


								<div class="text-center">
									<a href="/flow" class="button button--white button--rounded button--large button--text-grey m-t-20">Start på Take Daily
										i dag</a>
								</div>
							</div>
						</div>

						<div class="slide">
							<div class="container">
								<h2 class="text-center">Er du vegetar, men ikke fan af bælgfrugter, soyabønner og tofu?</h2>
								<p class="text-center">
									Som vegetar er det svært at få jern og B-vitaminer nok.
								</p>


								<div class="text-center">
									<a href="/flow" class="button button--white button--rounded button--large button--text-grey m-t-20">Start på Take Daily
										i dag</a>
								</div>
							</div>
						</div>

						<div class="slide">
							<div class="container">
								<h2 class="text-center">Har du lidt for meget om ørene for tiden?</h2>
								<p class="text-center">
									I en stresset periode har du brug for lidt ekstra B-vitamin.
								</p>


								<div class="text-center">
									<a href="/flow" class="button button--white button--rounded button--large button--text-grey m-t-20">Start på Take Daily
										i dag</a>
								</div>
							</div>
						</div>

						<div class="slide">
							<div class="container">
								<h2 class="text-center">Tager du en multivitaminpille med lidt af det hele?</h2>
								<p class="text-center">
									Din krop, kost og livsstil kan give et billede af, hvad du i virkeligheden har brug for.
								</p>


								<div class="text-center">
									<a href="/flow" class="button button--white button--rounded button--large button--text-grey m-t-20">Start på Take Daily
										i dag</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="block block--seven text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-push-2">
						<h2>Online konsultation</h2>
						<h3>Hvilke vitaminer og mineraler mangler du?</h3>
						<p>Vores dygtige diætister står bag spørgsmålene, som giver svar på, hvilke vitaminer og mineraler, du
							skal
							tage for at få din krop i balance. Der er 39 spørgsmål, og efter 2 minutter har du dit resultat.</p>

						<a href="/flow" class="button button--green button--rounded button--large">Start på Take Daily i dag</a>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="block block--eight text-center">
				<div class="row">
					<div class="col-md-8 col-md-push-2">
						<img src="/images/product_box_large.png" alt="Take Daily boks"/>
						<h2>Modtag vitaminer hver måned,<br/>
							det koster kun 149 kr.</h2>
						<p>Banjo tote bag bicycle rights, High Life sartorial cray craft beer whatever street art fap. Hashtag
							typewriter banh mi, squid keffiyeh High.</p>

						<a href="/flow" class="button button--green button--rounded button--large m-t-30">Start på Take Daily i dag</a>
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
	</script>
@endsection