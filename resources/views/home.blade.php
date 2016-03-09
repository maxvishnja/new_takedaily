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

		<div class="container">
			<div class="header_content">
				<div class="header_slider">
					<div class="header_slide">
						<div class="row">
							<div class="col-md-6">
								<h1>Nu bliver det nemt,<br/>
									at få din krop i balance.</h1>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aperiam distinctio
									eligendi.</p>
								<a href="#" class="button button--rounded button--huge button--green">
									<strong>Tryk her for at starte nu</strong>
								</a>
							</div>
							<div class="col-md-6">
								<img src="/images/product_small.png" alt="Take Daily box">
							</div>
						</div>
					</div>
					<div class="header_slide"></div>
				</div>
			</div>
		</div>

		<div class="header_footer hidden-sm hidden-xs">
			<a href="/flow">Start selv</a> i dag eller giv Take Daily <a href="/gifting">i gave</a>
		</div>
	</header>

	<main @if(!isset($mainClasses)) class="m-t-50 m-b-50" @else class="{{ $mainClasses }}" @endif>
		<div class="container">
			<div class="block block--one text-center">
				<h2>Sådan virker det</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dicta ea, earum enim est ex hic
					iure iusto maxime minus nam pariatur praesentium repellat repellendus sunt temporibus ullam.</p>

				<div class="row text-center">
					<div class="col-md-4">
						<span class="icon icon-user-information"></span>
						<h3>Konsultationen begynder</h3>
						<p>Fortæl os lidt om din krop, kost og livsstil. Det tager ikke mere end 2 minutter at svare på
							spørgsmålene.</p>
					</div>

					<div class="col-md-4">
						<span class="icon icon-box"></span>
						<h3>Vi skræddersyr dit Take Daily</h3>
						<p>Vi udvælger dine vitaminer og mineraler i koncentrationer, der passer nøjagtigt til dig.</p>
					</div>

					<div class="col-md-4">
						<span class="icon icon-truck"></span>
						<h3>Du modtager din æske</h3>
						<p>Du får leveret din æske gratis derhjemme eller på kontoret, hvis det passer dig bedre</p>
					</div>
				</div>

				<div class="text-center">
					<a href="/flow" class="button button--green button--rounded button--large">Få flere detaljer</a>
				</div>
			</div>
		</div>

		<div class="block block--two">
			<div class="container">
				<h2>Lev lidt sundere.<br/>
					Start indefra med Take Daily.</h2>

				<p>
					At finde de helt rigtige vitaminer og mineraler, som din krop har brug for, kan i sig selv være en
					udfordring. Hylderne bugner af multivitaminpiller og komplette kosttilskudspakker. Take Daily er
					diamentrale modsætninger.
				</p>
				<p>Vi udvælger og sammensætter omhyggeligt de vitaminer og mineraler, som lige præcis din krop har brug
					for. Koncentrationerne er individuelle og kommer i din helt egen æske.
				</p>

				<a href="/flow" class="button button--white button--rounded button--large button--text-grey">Start i
					dag</a>
			</div>
		</div>

		<div class="container">
			<div class="block block--three text-center">
				<div class="row">
					<div class="col-md-4">
						<img src="/images/dietist.png" class="img--rounded" alt="Suzan"/>
						<span>Suzan, diætist</span>
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

		<div class="block block--four">
			*Animation*
		</div>

		<div class="block block--five">
			<img src="//placehold.it/640x420" alt="Image"/>

			<div class="block_content text-center">
				<p>Take Daily er høj kvalitet og rene, naturlige, aktive ingredienser. Vi har samlet de bedste
					ernæringseksperter og anvender den nyeste, farmaceutiske forskning for at finde frem til den
					ultimative måde at genopbygge din krop indefra.  </p>

				<p>Videnskaben bag er kompleks, men for dig er det hele enkelt og ligetil.</p>

				<a href="/om" class="anchor anchor--underline">Få mere baggrundsviden</a>
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

								<div class="row">
									<div class="col-md-6">
										<img src="//placehold.it/560x280" alt="Image"/>
									</div>
									<div class="col-md-6">
										<p>
											At finde de helt rigtige vitaminer og mineraler, som din krop har brug for,
											kan
											i
											sig
											selv
											være en
											udfordring. Hylderne bugner af multivitaminpiller og komplette
											kosttilskudspakker.
											Take
											Daily er
											diamentrale modsætninger.  
										</p>
										<p>Vi udvælger og sammensætter omhyggeligt de vitaminer og mineraler, som lige
											præcis
											din
											krop
											har brug
											for. Koncentrationerne er individuelle og kommer i din helt egen æske.
										</p>

										<a href="/flow" class="button button--white button--rounded button--large button--text-grey">Start
											på
											Take Daily i dag</a>
									</div>
								</div>
							</div>
						</div>

						<div class="slide">
							<div class="container">
								<h2 class="text-center">Spiser du sundt, men tillader dig selv en cigaret i ny og
									næ?</h2>

								<div class="row">
									<div class="col-md-6">
										<img src="//placehold.it/560x280" alt="Image"/>
									</div>
									<div class="col-md-6">
										<p>
											At finde de helt rigtige vitaminer og mineraler, som din krop har brug for,
											kan
											i
											sig
											selv
											være en
											udfordring. Hylderne bugner af multivitaminpiller og komplette
											kosttilskudspakker.
											Take
											Daily er
											diamentrale modsætninger.  
										</p>
										<p>Vi udvælger og sammensætter omhyggeligt de vitaminer og mineraler, som lige
											præcis
											din
											krop
											har brug
											for. Koncentrationerne er individuelle og kommer i din helt egen æske.
										</p>

										<a href="/flow" class="button button--white button--rounded button--large button--text-grey">Start
											på
											Take Daily i dag</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="block block--seven text-center">
			<div class="container">
				<h2>Online konsultation</h2>
				<h3>Hvilke vitaminer og mineraler mangler du?</h3>
				<p>Vores dygtige diætister står bag spørgsmålene, som giver svar på, hvilke vitaminer og mineraler, du
					skal
					tage for at få din krop i balance. Der er 39 spørgsmål, og efter 2 minutter har du dit resultat.</p>

				<a href="/flow" class="button button--green button--rounded button--large">Start på Take Daily i dag</a>
			</div>
		</div>

		<div class="container">
			<div class="block block--eight">
				<img src="/images/product_box_large.png" alt="Take Daily boks"/>
				<h2>Modtag vitaminer hver måned,<br/>
					det koster kun 149 kr.</h2>
				<p>Banjo tote bag bicycle rights, High Life sartorial cray craft beer whatever street art fap. Hashtag
					typewriter banh mi, squid keffiyeh High.</p>
			</div>
		</div>
	</main>
@endsection

@section('footer_scripts')
	<script>
		$("#slider_two").slider();
	</script>
@endsection