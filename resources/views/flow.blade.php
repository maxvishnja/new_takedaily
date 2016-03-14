@extends('layouts.app')

@section('pageClass', 'page-flow')

@section('mainClasses', 'm-b-50')

@section('content')
	<noscript>
		<style>
			#app { display: none !important; }
		</style>

		<h1 class="text-center">Venligst aktiver javascripts!</h1>
	</noscript>

	<div id="app" class="flow-container">
		<div class="flow-progress">
			<div class="flow-step" step="1" v-bind:class="{ 'flow-step--inactive': step !== 1, 'flow-step--completed': step > 1 }">
				<div class="flow-step-progress">
					<span class="flow-step-progress-bar" v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
				<div class="flow-step-check">
					<div class="icon icon-check"></div>
				</div>
				<div class="flow-step-title">PERSONLIGT</div>
			</div>
			<div class="flow-step flow-step--inactive" step="2" v-bind:class="{ 'flow-step--inactive': step !== 2, 'flow-step--completed': step > 2 }">
				<div class="flow-step-progress">
					<span class="flow-step-progress-bar" v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
				<div class="flow-step-check">
					<div class="icon icon-check"></div>
				</div>
				<div class="flow-step-title">HELBRED</div>
			</div>
			<div class="flow-step flow-step--inactive" step="3" v-bind:class="{ 'flow-step--inactive': step !== 3, 'flow-step--completed': step > 3 }">
				<div class="flow-step-progress">
					<span class="flow-step-progress-bar" v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
				<div class="flow-step-check">
					<div class="icon icon-check"></div>
				</div>
				<div class="flow-step-title">KOST OG VANER</div>
			</div>
			<div class="flow-step flow-step--inactive" step="4" v-bind:class="{ 'flow-step--inactive': step !== 4 }">
				<div class="flow-step-title">ANBEFALING</div>
			</div>
		</div>

		<div class="container">

			<div class="flow-step-back" v-bind:class="{ 'clickable': step > 1 || sub_step > 1}">
				<a href="#" v-on:click="previousStep();">&larr; Tilbage til tidligere spørgsmål</a>
			</div>

			<form method="post" action="">
				<div data-step="1" data-first-sub-step="1" class="step step--active">
					<div data-sub-step="1" class="sub_step sub_step--active">
						<h3 class="substep-title">Hvilket køn er du?</h3>
						<label>
							<input type="radio" name="step[1][1]" value="1" v-model="user_data.gender" v-on:click="nextStep();"/>
							<span class="icon icon-gender-male"></span>
							<br/>Mand
						</label>
						<label>
							<input type="radio" name="step[1][1]" value="2" v-model="user_data.gender" v-on:click="nextStep();"/>
							<span class="icon icon-gender-female"></span>
							<br/>Kvinde
						</label>

						<p class="substep-explanation">Mænd og kvinder har ikke brug for den samme mængde vitaminer og mineraler. Fx har store knogler og stærke
							muskler brug for mere D-vitamin.</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title" v-show="user_data.gender == 1">Hvor gammel er du?</h3>
						<h3 class="substep-title" v-show="user_data.gender == 2">Vi ved det godt. Man spørger ikke en kvinde om hendes alder, men vi lover, vi
							ikke siger det til nogen.</h3>

						<div style="display: inline-block;">
							<label for="birthdate-picker" class="text-center">
								<span class="icon calendar-icon" style="vertical-align: middle; margin-right: 6px;"></span>
								<span>Vælg din fødselsdagsdato</span>
							</label>

							<br/>

							<input type="text" name="step[1][1]" v-model="user_data.birthdate" id="birthdate-picker" style="visibility: hidden; height: 0px !important;" placeholder="Din fødselsdagsdato"/>
							<div id="datepicker-container"></div>
						</div>

						<template v-if="temp_age">
							<br/>
							<button v-on:click="nextStep();" type="button" class="button button--rounded button--medium button--green">Ja, jeg er
								<strong>@{{ temp_age }}</strong> år gammel
							</button>
						</template>

						<p class="substep-explanation">Når du bliver ældre, får din krop brug for mere D-vitamin, B12-vitamin og kalk end tidligere. Du har brug
							for B12-vitaminet til at danne røde blodlegemer. Vitaminet er godt mod demens og sikrer, at dit nervesystem fungerer optimalt.</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">Hvilken hudfarve matcher din bedst?</h3>
						<label>
							<input type="radio" name="step[1][3]" value="1" v-model="user_data.skin" v-on:click="nextStep();"/>
							<span class="icon icon-skin-white"></span>
							<br/>Lys
						</label>
						<label>
							<input type="radio" name="step[1][3]" value="2" v-model="user_data.skin" v-on:click="nextStep();"/>
							<span class="icon icon-skin-mediterranean"></span>
							<br/>Mørk
						</label>
						<label>
							<input type="radio" name="step[1][3]" value="3" v-model="user_data.skin" v-on:click="nextStep();"/>
							<span class="icon icon-skin-dark"></span>
							<br/>Sort
						</label>

						<p class="substep-explanation">Er du meget lys i huden, kan du producere mere D-vitamin, når du opholder dig i solen, end hvis din hud
							er mørk. Så har du ikke en helt lys hudfarve, kan du have brug for D-vitamin-tilskud.</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">Er du udenfor hver dag, efter solen er stået op, og før den går ned?</h3>
						<label>
							<input type="radio" name="step[1][4]" value="1" v-model="user_data.outside" v-on:click="nextStep();"/>
							<span class="icon icon-sun-yes"></span>
							<br/>Ja
						</label>
						<label>
							<input type="radio" name="step[1][4]" value="2" v-model="user_data.outside" v-on:click="nextStep();"/>
							<span class="icon icon-sun-no"></span>
							<br/>Nej
						</label>

						<p class="substep-explanation">Du skal være udenfor i 15-30 minutter hver dag, hvis du vil være sikker på, at din krop producerer
							D-vitamin nok. Har du en langærmet trøje og lange bukser på, tæller turen i det fri ikke, hvis målet er at få nok D-vitamin.</p>
					</div>
				</div>

				<div data-step="2" v-bind="{ 'data-first-sub-step': user_data.gender == 2 ? 1 : 2 }" class="step">
					<div data-sub-step="1" class="sub_step sub_step--active" v-bind:class="{ 'sub_step--active': user_data.gender == 2 }">
						<h3 class="substep-title">Er du gravid, eller drømmer du om at blive det?</h3>
						<label>
							<input type="radio" name="step[2][1]" value="1" v-model="user_data.pregnant" v-on:click="nextStep();"/>
							<span class="icon icon-pregnant-yes"></span>
							<br/>Ja
						</label>
						<label>
							<input type="radio" name="step[2][1]" value="2" v-model="user_data.pregnant" v-on:click="nextStep();"/>
							<span class="icon icon-pregnant-no"></span>
							<br/>Nej
						</label>

						<p class="substep-explanation">Nogle vitaminer og mineraler skal du have flere af, når du er gravid eller gerne vil være det.
							Sundhedsstyrelsen anbefaler, at du tager tilskud af folsyre, som er et B-vitamin, allerede fra du tænker på at blive gravid til 12
							uger inde i graviditeten. Folsyre er vigtigt, når barnets centralnervesystem udvikles.
							<br/><br/>
							Gennem hele graviditeten er det en god idé at tage fiskeolie. Det er godt for både barnet og dig.
						</p>
					</div>

					<div data-sub-step="2" class="sub_step" v-bind:class="{ 'sub_step--active': user_data.gender == 1 }">
						<h3 class="substep-title">Er du på slankekur?</h3>
						<label>
							<input type="radio" name="step[2][2]" value="1" v-model="user_data.diet" v-on:click="nextStep();"/>
							<span class="icon icon-diet-pear"></span>
							<br/>Ja
						</label>
						<label>
							<input type="radio" name="step[2][2]" value="2" v-model="user_data.diet" v-on:click="nextStep();"/>
							<span class="icon icon-diet-burger"></span>
							<br/>Nej
						</label>

						<p class="substep-explanation">Når din kost bliver mere fedtfattig, bliver den måske også mere ensidig, end den plejer. Og så er det
							vigtigt, at du stadig får de vitaminer og mineraler, som du måske normalt indtager igennem din kost. A-vitamin er godt for din hud
							og dit immunsystem. Mens C-vitamin øger kroppens evne til at nedbryde fedt. Så ingen af delene skal du have for lidt af, når du
							gerne vil tabe nogle kilo.</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">Hvor meget og hvor ofte motionerer du?</h3>
						<label>
							<input type="radio" name="step[2][3]" value="1" v-model="user_data.sports" v-on:click="nextStep();"/>
							<span class="icon icon-activity-seldom" title="Seldom"></span>
							<br/>Sjældent
						</label>
						<label>
							<input type="radio" name="step[2][3]" value="2" v-model="user_data.sports" v-on:click="nextStep();"/>
							<span class="icon icon-activity-once" title="Once a week"></span>
							<br/>Én gang om ugen
						</label>
						<label>
							<input type="radio" name="step[2][3]" value="3" v-model="user_data.sports" v-on:click="nextStep();"/>
							<span class="icon icon-activity-twice" title="Twice a week"></span>
							<br/>To gange om ugen
						</label>
						<label>
							<input type="radio" name="step[2][3]" value="4" v-model="user_data.sports" v-on:click="nextStep();"/>
							<span class="icon icon-activity-more" title="More often"></span>
							<br/>Oftere
						</label>

						<p class="substep-explanation">Motion er både godt for din sundhed og dit velbefindende. Hvis du dyrker meget motion, har du brug for
							nogle ekstra vitaminer og mineraler. B-vitamin sørger fx for, at du kan præstere mere ved højintensitetstræning og er med til at
							producere og reparere celler. Jern er også vigtigt, når du motionerer meget. Det sørger nemlig for, at ilten transporteres rundt i
							kroppen. </p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">Hvordan har du det, når dagen er slut?</h3>
						<label>
							<input type="radio" name="step[2][4]" value="1" v-model="user_data.stressed" v-on:click="nextStep();"/>
							<span class="icon icon-stress" title="Stressful"></span>
							<br/>Jeg føler mig lidt stresset
						</label>
						<label>
							<input type="radio" name="step[2][4]" value="2" v-model="user_data.stressed" v-on:click="nextStep();"/>
							<span class="icon icon-joy" title="Quiet"></span>
							<br/>Jeg har det fint og er naturligt træt
						</label>

						<p class="substep-explanation">I en stresset periode har du brug for lidt ekstra vitaminer, som kan hjælpe dig med at slappe mere af.
							B-vitamin giver ro på og hjælper dit nervesystem og immunforsvar med at fungere optimalt.</p>
					</div>

					<div data-sub-step="5" class="sub_step">
						<h3 class="substep-title">Føler du dig tit træt, eller mangler du energi?</h3>
						<label>
							<input type="radio" name="step[2][5]" value="1" v-model="user_data.lacks_energy" v-on:click="nextStep();"/>
							<span class="icon icon-tired" title="Every day"></span>
							<br/>Hver dag
						</label>
						<label>
							<input type="radio" name="step[2][5]" value="2" v-model="user_data.lacks_energy" v-on:click="nextStep();"/>
							<span class="icon icon-awake" title="Sometimes"></span>
							<br/>Af og til
						</label>
						<label>
							<input type="radio" name="step[2][5]" value="3" v-model="user_data.lacks_energy" v-on:click="nextStep();"/>
							<span class="icon icon-fresh" title="Never"></span>
							<br/>Aldrig
						</label>

						<p class="substep-explanation">B-vitaminerne (B1, B2 , B3, B5 og B6) spiller en afgørende rolle for dit energiniveau. Mangler du de
							vitaminer, kan du føle dig træt og savne energi.</p>
					</div>

					<div data-sub-step="6" class="sub_step">
						<h3 class="substep-title">Vil du gerne styrke dit immunforsvar?</h3>
						<label>
							<input type="radio" name="step[2][6]" value="1" v-model="user_data.immune_system" v-on:click="nextStep();"/>
							<span class="icon icon-immune-boost"></span>
							<br/>Ja, jeg vil gerne trækkes lidt op
						</label>
						<label>
							<input type="radio" name="step[2][6]" value="2" v-model="user_data.immune_system" v-on:click="nextStep();"/>
							<span class="icon icon-immune-ignore"></span>
							<br/>Nej, det behøver jeg ikke
						</label>

						<p class="substep-explanation">De rigtige vitaminer kan styrke dit immunforsvar. C-vitamin er en antioxidant og vigtigt for dit
							immunforsvar, fordi det hjælper kroppen med at producere hvide blodlegemer. Men også A- og D-vitamin er gavnlige, hvis du gerne vil
							undgå at blive syg.
						</p>
					</div>

					<div data-sub-step="7" class="sub_step">
						<h3 class="substep-title">Ryger du?</h3>
						<label>
							<input type="radio" name="step[2][7]" value="1" v-model="user_data.smokes" v-on:click="nextStep();"/>
							<span class="icon icon-smoke"></span>
							<br/>Ja
						</label>
						<label>
							<input type="radio" name="step[2][7]" value="2" v-model="user_data.smokes" v-on:click="nextStep();"/>
							<span class="icon icon-smoke-no"></span>
							<br/>Nej
						</label>

						<p class="substep-explanation">Det er videnskabeligt bevist, at behovet for C-vitamin er større, hvis du ryger, fordi tobaksrøg ilter og
							ødelægger vitaminet.</p>
					</div>

					<div data-sub-step="8" class="sub_step">
						<h3 class="substep-title">Spiser du som en kanin?</h3>
						<label>
							<input type="radio" name="step[2][8]" value="1" v-model="user_data.vegetarian" v-on:click="nextStep();"/>
							<span class="icon icon-vegetarian-yes"></span>
							<br/>Ja, jeg er vegetar
						</label>
						<label>
							<input type="radio" name="step[2][8]" value="2" v-model="user_data.vegetarian" v-on:click="nextStep();"/>
							<span class="icon icon-meat"></span>
							<br/>Nej, jeg spiser også kød og fisk
						</label>

						<p class="substep-explanation">Kød indeholder masser af jern, B1- og B12-vitamin. Begge vitaminer er vigtige komponenter i dit
							energistofskifte. B1 omsætter fx kulhydrat til druesukker. Når druesukker forbrændes i kroppen skabes energi.</p>
					</div>

					<div data-sub-step="9" class="sub_step">
						<h3 class="substep-title">Har du ømme muskler eller ondt i dine led?</h3>
						<label>
							<input type="radio" name="step[2][9]" value="1" v-model="user_data.joints" v-on:click="nextStep();"/>
							<span class="icon icon-joint-yes"></span>
							<br/>Ja
						</label>
						<label>
							<input type="radio" name="step[2][9]" value="2" v-model="user_data.joints" v-on:click="nextStep();"/>
							<span class="icon icon-joint-no"></span>
							<br/>Nej
						</label>

						<p class="substep-explanation">Nogle næringsstoffer er gode for dine led og muskler. Mangel på D-vitamin kan ligefrem give svage muskler
							og muskelsmerter.</p>
					</div>

					<div data-sub-step="10" class="sub_step">
						<h3 class="substep-title">Tager du allerede vitaminer og/eller mineraler?</h3>
						<label>
							<input type="radio" name="step[2][10]" value="1" v-on:click="nextStep();"/>
							<span class="icon icon-supplement-yes"></span>
							<br/> Ja
						</label>
						<label>
							<input type="radio" name="step[2][10]" value="2" v-on:click="nextStep();"/>
							<span class="icon icon-supplement-no"></span>
							<br/> Nej
						</label>

						<p class="substep-explanation">Testresultatet er baseret på din kost og din livsstil. Take Daily sørger for, at du får alle de vitaminer
							og mineraler, du har brug for. Du skal derfor ikke bekymre dig om at tage andre tilskud. </p>
					</div>
				</div>

				<div data-step="3" data-first-sub-step="1" class="step">
					<div data-sub-step="1" class="sub_step sub_step--active">
						<h3 class="substep-title">Hvor mange grønsager spiser du dagligt?</h3>
						<label>
							<input type="radio" name="step[3][1]" value="1" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
							<span class="icon icon-portion-vegetables-1"></span>
							<br/>Ingen</label>
						<label>
							<input type="radio" name="step[3][1]" value="2" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
							<span class="icon icon-portion-vegetables-2"></span>
							<br/>1 portion (50 gram)</label>
						<label>
							<input type="radio" name="step[3][1]" value="3" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
							<span class="icon icon-portion-vegetables-3"></span>
							<br/>2 portioner (100 gram)</label>
						<label>
							<input type="radio" name="step[3][1]" value="4" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
							<span class="icon icon-portion-vegetables-4"></span>
							<br/>3 portioner (150 gram)</label>
						<label>
							<input type="radio" name="step[3][1]" value="5" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
							<span class="icon icon-portion-vegetables-5"></span>
							<br/>+4 portioner (+200 gram)</label>

						<p class="substep-explanation">Grøntsager er en vigtig kilde til C-vitamin, folsyre og kalium.</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title">Hvor meget frugt spiser/drikker du om dagen? </h3>
						<label>
							<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="1" v-on:click="nextStep();"/>
							<span class="icon icon-portion-fruit-1"></span>
							<br/>Intet</label>
						<label>
							<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="2" v-on:click="nextStep();"/>
							<span class="icon icon-portion-fruit-2"></span>
							<br/>1 stk. / glas</label>
						<label>
							<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="3" v-on:click="nextStep();"/>
							<span class="icon icon-portion-fruit-3"></span>
							<br/>+2 stk. / glas</label>

						<p class="substep-explanation">Frugt er en vigtig kilde til C-vitamin. Frugtjuice kan kun tælle for ét stykke frugt om dagen. Så du kan
							fint nøjes med et enkelt glas.</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">Hvor mange skiver brød spiser du om dagen?</h3>
						<label>
							<input type="radio" name="step[3][3]" value="1" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
							<span class="icon icon-portion-bread-1"></span>
							<br/>Intet</label>
						<label>
							<input type="radio" name="step[3][3]" value="2" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
							<span class="icon icon-portion-bread-2"></span>
							<br/>1-2 stk.</label>
						<label>
							<input type="radio" name="step[3][3]" value="3" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
							<span class="icon icon-portion-bread-3"></span>
							<br/>3-4 stk.</label>
						<label>
							<input type="radio" name="step[3][3]" value="4" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
							<span class="icon icon-portion-bread-4"></span>
							<br/>5-6 stk.</label>
						<label>
							<input type="radio" name="step[3][3]" value="5" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
							<span class="icon icon-portion-bread-5"></span>
							<br/>+7 stk.</label>

						<p class="substep-explanation">Havregrød eller lign. tæller for én skive brød.</p>
						<p class="substep-explanation">Brød er en vigtig kilde til B-vitamin, jern og kostfibre. Vælg fuldkorn. Det mætter rigtig godt. Det får
							dig til at spise mindre og gør det lettere at holde vægten. B-vitamin og jern fra brødet giver dig energi.</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">Kommer du smør på brødet eller bruger du margarine, smør eller olie, når du laver mad?</h3>
						<label>
							<input type="radio" name="step[3][4]" value="1" v-model="user_data.foods.butter" v-on:click="nextStep();"/>
							<span class="icon icon-portion-butter-yes"></span>
							<br/>Ja
						</label>
						<label>
							<input type="radio" name="step[3][4]" value="2" v-model="user_data.foods.butter" v-on:click="nextStep();"/>
							<span class="icon icon-portion-butter-no"></span>
							<br/>Nej
						</label>
						<label>
							<input type="radio" name="step[3][4]" value="3" v-model="user_data.foods.butter" v-on:click="nextStep();"/>
							<span class="icon icon-portion-butter-sometimes"></span>
							<br/>Nogle gange
						</label>

						<p class="substep-explanation">Smør, margarine og olie er vigtige kilder til A-vitamin og D-vitamin. Du har brug for begge vitaminer.
							Blandt immunforsvar.</p>
					</div>

					<div data-sub-step="5" class="sub_step">
						<h3 class="substep-title">Hvor mange portioner pasta, ris, kartofler, couscous, quinoa og lignede spiser du om dagen?</h3>
						<label>
							<input type="radio" name="step[3][5]" value="1" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
							<span class="icon icon-portion-pasta-1"></span>
							<br/>Ingen</label>
						<label>
							<input type="radio" name="step[3][5]" value="2" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
							<span class="icon icon-portion-pasta-2"></span>
							<br/>1-2 portioner (50-100 gram)</label>
						<label>
							<input type="radio" name="step[3][5]" value="3" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
							<span class="icon icon-portion-pasta-3"></span>
							<br/>3-4 portioner (150-200 gram)</label>
						<label>
							<input type="radio" name="step[3][5]" value="4" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
							<span class="icon icon-portion-pasta-4"></span>
							<br/>+5 portioner (+250 gram)</label>

						<p class="substep-explanation">Pasta, ris, kartofler og lignende er fyldt med gode kulhydrater og indeholder næsten ingen fedt. Og så er
							de en vigtig kilde til B-vitamin og mineraler. </p>
					</div>

					<div data-sub-step="6" class="sub_step">{{-- consider hide if vegeratian --}}
						<h3 class="substep-title">Hvor meget kød spiser du om dagen?</h3>
						<label>
							<input type="radio" name="step[3][6]" value="1" v-model="user_data.foods.meat" v-on:click="nextStep();"/>
							<span class="icon icon-portion-meat-1"></span>
							<br/>0-75 gram</label>
						<label>
							<input type="radio" name="step[3][6]" value="2" v-model="user_data.foods.meat" v-on:click="nextStep();"/>
							<span class="icon icon-portion-meat-2"></span>
							<br/>76-150 gram</label>
						<label>
							<input type="radio" name="step[3][6]" value="3" v-model="user_data.foods.meat" v-on:click="nextStep();"/>
							<span class="icon icon-portion-meat-3"></span>
							<br/>+150 gram</label>

						<p class="substep-explanation">Kød er en vigtig kilde til B-vitaminer (fx B6 og B12) og mineralerne zink, selen og jern.</p>
					</div>

					<div data-sub-step="7" class="sub_step">
						<h3 class="substep-title">Hvor ofte spiser du fisk?</h3>
						<label>
							<input type="radio" name="step[3][7]" value="1" v-model="user_data.foods.fish" v-on:click="nextStep();"/>
							<span class="icon icon-portion-fish-1"></span>
							<br/>Aldrig / sjældent
						</label>
						<label>
							<input type="radio" name="step[3][7]" value="2" v-model="user_data.foods.fish" v-on:click="nextStep();"/>
							<span class="icon icon-portion-fish-2"></span>
							<br/>En gang om ugen
						</label>
						<label>
							<input type="radio" name="step[3][7]" value="3" v-model="user_data.foods.fish" v-on:click="nextStep();"/>
							<span class="icon icon-portion-fish-3"></span>
							<br/>To, eller flere, gange om ugen
						</label>

						<p class="substep-explanation">Fisk indeholder sunde fiskeolier som fx omega-3 fedtsyre og vitaminer som D-vitamin, jod og selen.</p>
					</div>

					<div data-sub-step="8" class="sub_step">
						<h3 class="substep-title">Hvor meget mælk drikker du om dagen?</h3>
						<label>
							<input type="radio" name="step[3][8]" value="1" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
							<span class="icon icon-portion-milk-1"></span>
							<br/>Ingen
						</label>
						<label>
							<input type="radio" name="step[3][8]" value="2" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
							<span class="icon icon-portion-milk-2"></span>
							<br/>1-2 glas
						</label>
						<label>
							<input type="radio" name="step[3][8]" value="3" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
							<span class="icon icon-portion-milk-3"></span>
							<br/>+3 glas
						</label>

						<p class="substep-explanation">Mejeriprodukter indeholder vigtige næringsstoffer, blandt andet protein, B2-vitamin, B12-vitamin,
							kalcium, fosfor og jod. Kalcium er godt for knoglerne, men hvor mange mejeriprodukter du har brug for, afhænger af din alder.</p>
					</div>
				</div>

				<div data-step="4" data-first-sub-step="1" class="step">
					<div class="group" data-group="1">

						<div class="advise" data-advise="1.1" data-group="1" v-if="( (user_data.age < 50 && user_data.gender == 2 && user_data.pregnant == 2)  || (user_data.age < 70 && user_data.gender == 1) )" transition="setAdviseOne">
							Basic
							<p>Med Take Daily får du præcis de vitaminer og mineraler, du har brug for – i den helt rette dosis</p>
						</div>

						<div class="advise" data-advise="1.2" data-group="1" v-if="(isAlone(1, 1.2)) && (( ( user_data.age >= 50 && user_data.age <= 70 ) && user_data.gender == 2) || (user_data.skin > 1)))" transition="setAdviseOne">
							Basic +10 D
							<p>Med Take Daily får du præcis de vitaminer og mineraler, du har brug for – i den helt rette dosis.</p>
							<p>Du skal fx have lidt ekstra D-vitamin pga. <span v-show="( user_data.age >= 50 && user_data.age <= 70 )">din alder</span>
								<span v-show="( user_data.age >= 50 && user_data.age <= 70 ) && user_data.skin > 1">og</span> <span v-show="user_data.skin > 1">mørke hudfarve</span>.
								Det sørger vi for.</p>
						</div>

						<div class="advise" data-advise="1.3" data-group="1" v-if="(isAlone(1, 1.3)) && (outside == 2)" transition="setAdviseOne">
							Basic +10 D
							<p>Med Take Daily får du præcis de vitaminer og mineraler, du har brug for – i den helt rette dosis.</p>
							<p>Du skal fx have lidt ekstra D-vitamin, fordi du ikke kommer så meget ud i solen. Det sørger vi for.</p>
						</div>

						<div class="advise" data-advise="1.4" data-group="1" v-if="((user_data.age > 70 && user_data.gender == 1) || (user_data.age > 50 && user_data.gender == 2) ) && isAlone(1, 1.4)" transition="setAdviseOne">
							Basic +20 D
							<p>Med Take Daily får du præcis de vitaminer og mineraler, du har brug for – i den helt rette dosis.</p>
							<p>I din alder, har du fx brug for lidt ekstra D-vitamin. Det sørger vi for.</p>
						</div>
					</div>

					<div class="group" data-group="2">
						<div class="advise" data-advise="2.1" data-group="A" v-if="(isCombinationPossible(current_advise_one, 'A', null)) && user_data.pregnant == 1" transition="setAdviseTwo">
							A
							<p>
								Du er gravid. Tillykke! I den søde ventetid, sørger Take Daily for, at du og din baby får de særlige tilskud, I har brug for.
								<br/><br/>
								Gennem hele graviditeten er det godt for udviklingen af babyens knogler og muskler at tage et tilskud af D-vitamin. Fiskeolie…
							<hr/>
							Vi håber, du snart får dit ønske om en baby opfyldt. Mens du prøver at blive gravid, har din krop brug for særlige vitaminer og
							mineraler. Det sørger Take Daily for.
							<br/><br/>
							Sundhedsstyrelsen anbefaler, at du tager folsyre (B9-vitamin), allerede når du begynder at drømme om en baby. Du skal tage folsyre
							helt fra graviditetens begyndelse, da det har betydning for celledelingen og arvematerialet i kroppens celler. Folsyre nedsætter
							risikoen for alvorlige medfødte misdannelser af hjerne og rygmarv (neuralrørsdefekter).

							</p>
						</div>

						<div class="advise" data-advise="2.2" data-group="B" v-if="(isCombinationPossible(current_advise_one, 'B', null)) && (isAlone(2, 2.2)) && (user_data.diet == 1)" transition="setAdviseTwo">
							B
							<p>Når du er på slankekur, har du brug for lidt ekstra vitaminer og mineraler. Take Daily giver dig det helt rigtige miks. Husk også
								at slappe af, sove og dyrke motion.
								<br/><br/>
								Når du har fokus på at spise fedtfattigt, bliver din kost typisk mere ensidig, end den plejer, og så har du brug for et tilskud
								K-vitamin. Det er i det hele taget vigtigt, at du stadig får de vitaminer og mineraler, som du normalt indtager igennem en
								varieret kost. A-vitamin er godt for din hud og dit immunsystem. Mens C-vitamin øger kroppens evne til at nedbryde fedt. Så
								ingen af delene skal du have for lidt af, når du gerne vil tabe nogle kilo. Lidt ekstra B-vitamin sørger for, at du kan præstere
								mere, hvis du træner hårdt, og er også med til at producere og reparere celler.
							</p>
						</div>

						<div class="advise" data-advise="2.3" data-group="C" v-if="(isCombinationPossible(current_advise_one, 'C', null)) && (isAlone(2, 2.3)) && (user_data.sports == 4 || user_data.lacks_energy < 3 || user_data.stressed == 1)" transition="setAdviseTwo">
							C
							<p v-show="user_data.sports == 4">
								Når du motionerer så meget, som du gør lige nu, har du brug for ekstra vitaminer og mineraler. Vi har sammensat lige det, din
								krop har behov for, så den kan yde sit maksimale, når du træner.
								<br/><br/>
								B-vitamin sørger fx for, at du kan præstere mere ved højintensitetstræning og er med til at producere og reparere celler. Jern
								er også vigtigt, når du motionerer meget. Det sørger nemlig for, at ilten transporteres rundt i kroppen.
							</p>
							<p v-show="user_data.lacks_energy < 3 || user_data.stressed == 1">
								Når du føler dig træt og mangler energi, mangler du også B-vitaminer. Både B1, B2 , B3, B5 og B6 spiller en afgørende rolle for
								dit energiniveau.
							</p>
						</div>

						<div class="advise" data-advise="2.4" data-group="D" v-if="(isCombinationPossible(current_advise_one, 'D', null)) && (isAlone(2, 2.4)) && (user_data.immune_system == 1 || user_data.smokes == 1 || user_data.vegetarian == 1)" transition="setAdviseTwo">
							D
							<p v-show="user_data.immune_system == 1">
								De rigtige vitaminer kan styrke dit immunforsvar. C-vitamin er en antioxidant og vigtigt for dit immunforsvar, fordi det hjælper
								kroppen med at producere hvide blodlegemer. Men også A- og D-vitamin er gavnlige, hvis du gerne vil undgå at blive syg.
							</p>

							<p v-show="user_data.smokes == 1">
								Vi anbefaler selvfølgelig, at du stopper med at ryge. Men så længe du ryger, sørger Take Daily for, at du får lidt ekstra
								C-vitamin. Det er nemlig videnskabeligt bevist, at behovet for C-vitamin er større, når du ryger, fordi tobaksrøg ilter og
								ødelægger vitaminet. Stopper du med at ryge, så husk at ændre din profil på <a href="/account" target="_blank">Mit Take
									Daily</a>.
							</p>

							<p v-show="user_data.vegetarian == 1">
								Kød indeholder masser af jern, B1- og B12-vitamin. Som vegetar kan det være svært at få nok af det hele gennem kosten. Begge
								B-vitaminer er vigtige komponenter i dit energistofskifte. B1 omsætter fx kulhydrat til druesukker, og når druesukker forbrændes
								i kroppen skabes energi.
							</p>
						</div>

						<div class="advise" data-advise="2.5" data-group="E" v-if="(isCombinationPossible(current_advise_one, 'E', null)) && (isAlone(2, 2.5)) && (user_data.joints == 1)" transition="setAdviseTwo">
							E
							<p>
								Når du har ømme muskler og led har du brug for nogle gode næringsstoffer. Mangel på D-vitamin kan ligefrem give svage muskler og
								muskelsmerter. Glukosamin/chonodroitin stimulerer bruskcellerne og er godt, hvis dine led fx er slidte.
							</p>
						</div>
					</div>

					<div class="group" data-group="3">
						<div class="advise" data-advise="3.1" data-group="a" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'a')) && user_data.foods.fruits == 1 || user_data.foods.vegetables == 1" transition="setAdviseThree">
							a
							<p v-show="user_data.foods.fruits == 1">
								Frugt er en vigtig kilde til C-vitamin. Din krop får ikke nok frugt, og derfor heller ikke nok C-vitamin. Take Daily sørger for,
								at du får det, du behøver – og så kan du fortsætte med at spise, som du gør nu.
								<br/><br/>
								Begynder du at spise mere frugt, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit Take Daily</a>. Så
								er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.
							</p>

							<p v-show="user_data.foods.vegetables == 1">
								Grøntsager er en vigtig kilde til B9-vitamin, C-vitamin, folsyre og kalium. Take Daily sørger for, at du får det, du behøver –
								og så kan du fortsætte med at spise, som du gør nu.
								<br/><br/>
								Begynder du at spise flere grøntsager, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit Take
									Daily</a>. Så er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug
								for.
							</p>
						</div>

						<div class="advise" data-advise="3.2" data-group="b" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'b')) && (isAlone(3, 3.2)) && (user_data.foods.bread == 1 || user_data.foods.wheat == 1)" transition="setAdviseThree">
							b
							<p v-show="user_data.foods.bread == 1">
								Brød er en vigtig kilde til B-vitamin, jern og kostfibre. Du spiser ikke nok brød i hverdagen, så du har brug for lidt ekstra
								B-vitamin og jern. Når du ikke får nok jern, vil du ofte føle dig sløv. Take Daily giver dig præcis det, der skal til, for at du
								føler dig frisk hver dag.
								<br/><br/>
								Begynder du at spise mere brød, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit Take Daily</a>. Så
								er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.
							</p>

							<p v-show="user_data.foods.wheat == 1">
								Du spiser ikke nok pasta, ris og kartofler, og derfor går din krop glip af gode kulhydrater, som er en vigtig kilde til
								B-vitamin og mineraler. Take Daily sørger for, at du får det, du behøver – og så kan du fortsætte med at spise, som du gør nu.
								<br/><br/>
								Begynder du at spise mere ris, pasta eller det, der ligner, skal du huske at ændre din profil på
								<a href="/account" target="_blank">Mit Take Daily</a>. Så er du sikker på, at de mineraler og vitaminer vi sender til dig,
								indeholder lige præcis de doser, du har brug for.
							</p>
						</div>

						<div class="advise" data-advise="3.3" data-group="c" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'c')) && (isAlone(3, 3.3)) && (user_data.foods.dairy == 1)" transition="setAdviseThree">
							c
							<p>
								Du får ikke mejerprodukter nok, og derfor heller ikke nok kalcium og B2-vitamin. Begge dele har dine knogler og led brug for. Vi sørger for at afstemme din dosis efter din alder. Den har nemlig indflydelse på, hvor meget kalcium og B2-vitamin din krop har behov for.
								<br/><br/>
								Begynder du at få flere mejeriprodukter i din daglige kost, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit Take Daily</a>. Så er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.
							</p>
						</div>

						<div class="advise" data-advise="3.4" data-group="d" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'd')) && (isAlone(3, 3.4)) && (user_data.foods.meat == 1)" transition="setAdviseThree">
							d
							<p>
								Kød er en vigtig kilde til B-vitaminer (fx B6 og B12) og mineralerne zink, selen og jern. Take Daily sørger for, at du får det, du behøver – og så kan du fortsætte med at spise, som du gør nu.
								<br/><br/>
								Begynder du at spise kød, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit Take Daily</a>. Så er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.
							</p>
						</div>

						<div class="advise" data-advise="3.5" data-group="e" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'e')) && (isAlone(3, 3.5)) && (user_data.foods.fish == 1)" transition="setAdviseThree">
							e
							<p>
								Du spiser ikke nok fisk, og derfor bliver din krop snydt for sunde fiskeolier som fx omega-3 fedtsyre og vitaminer som D-vitamin, jod og selen. Take Daily sørger for, at du får det, du behøver – og så kan du fortsætte med at spise, som du gør nu.
								<br/><br/>
								Begynder du at spise mere fisk, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit Take Daily</a>. Så er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.
							</p>
						</div>

						<div class="advise" data-advise="3.6" data-group="f" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'f')) && (isAlone(3, 3.6)) && (user_data.foods.butter == 2)" transition="setAdviseThree">
							f
							<p>
								Din daglige kost indeholder ikke nok smør, margarine eller olie, som er vigtige kilder til A-vitamin og D-vitamin. Du har brug for begge vitaminer. Blandt andet for at styrke dit immunforsvar. Take Daily sørger for, at du får det, du behøver – og så kan du fortsætte med at spise, som du gør nu.
								<br/><br/>
								Begynder du at spise mere fedtstof, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit Take Daily</a>. Så er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.
							</p>
						</div>

						<div class="advise" data-advise="3.7" data-group="" transition="setAdviseThree" v-if="isGroupEmpty(3) && isGroupEmpty(2)">
							Du har en sund livsstil og passer godt på din krop. Take Daily giver dig det mest basale, så din krop også får, hvad den har brug for de dage, hvor du slapper af og synder lidt.
						</div>

						<textarea name="user_data" type="hidden" style="display: none;">@{{ $data.user_data | json }}</textarea>
						<button type="submit">Continue</button>
					</div>
				</div>

				{{ csrf_field() }}
			</form>
		</div>
	</div>
@endsection

@section('footer_scripts')
	<script type="text/javascript">
		var app = new Vue({
			el: '#app',
			data: {
				step: 1,
				sub_step: 1,
				current_advise_one: null,
				current_advise_two: null,
				current_advise_three: null,
				temp_age: null,
				combinations: {
					"1": {
						"A": {
							"a": false,
							"b": false,
							"c": true,
							"d": true,
							"e": true,
							"f": false
						},
						"B": {
							"a": false,
							"b": false,
							"c": true,
							"d": false,
							"e": true,
							"f": true
						},
						"C": {
							"a": true,
							"b": false,
							"c": false,
							"d": false,
							"e": true,
							"f": true
						},
						"D": {
							"a": false,
							"b": false,
							"c": true,
							"d": false,
							"e": true,
							"f": false
						},
						"E": {
							"a": false,
							"b": true,
							"c": true,
							"d": true,
							"e": true,
							"f": false
						}
					},
					"2": {
						"A": false,
						"B": {
							"a": false,
							"b": false,
							"c": true,
							"d": false,
							"e": true,
							"f": true
						},
						"C": {
							"a": true,
							"b": false,
							"c": false,
							"d": false,
							"e": true,
							"f": true
						},
						"D": {
							"a": false,
							"b": false,
							"c": true,
							"d": false,
							"e": true,
							"f": false
						},
						"E": {
							"a": false,
							"b": true,
							"c": true,
							"d": true,
							"e": true,
							"f": false
						}
					},
					"3": {
						"A": false,
						"B": {
							"a": false,
							"b": false,
							"c": true,
							"d": false,
							"e": true,
							"f": false
						},
						"C": {
							"a": true,
							"b": false,
							"c": false,
							"d": false,
							"e": true,
							"f": false
						},
						"D": {
							"a": false,
							"b": false,
							"c": false,
							"d": false,
							"e": false,
							"f": false
						},
						"E": {
							"a": false,
							"b": false,
							"c": false,
							"d": false,
							"e": false,
							"f": false
						}
					}
				},
				user_data: {
					gender: null,
					birthdate: null,
					age: null,
					skin: null,
					outside: null,
					pregnant: null,
					diet: null,
					sports: null,
					lacks_energy: null,
					smokes: null,
					immune_system: null,
					vegetarian: null,
					joints: null,
					stressed: null,
					foods: {
						fruits: null,
						vegetables: null,
						bread: null,
						wheat: null,
						dairy: null,
						meat: null,
						fish: null,
						butter: null
					}
				}
			},
			computed: {
				temp_age: function ()
				{
					return this.getAge();
				}
			},
			methods: {
				nextStep: function ()
				{
					var currentStep = $(".step[data-step='" + this.step + "']");
					var nextStep = $(".step[data-step='" + (this.step + 1) + "']");
					var currentSubStep = currentStep.find(".sub_step[data-sub-step='" + this.sub_step + "']");
					var nextSubStep = currentStep.find(".sub_step[data-sub-step='" + (this.sub_step + 1) + "']");

					if (nextSubStep[0])
					{
						this.sub_step = nextSubStep.attr("data-sub-step") * 1;
						currentSubStep.removeClass("sub_step--active");
						nextSubStep.addClass("sub_step--active");

						return true;
					}

					this.step++;
					this.sub_step = nextStep.attr("data-first-sub-step") * 1;

					currentStep.removeClass("step--active");
					nextStep.addClass("step--active");

					return true;
				},

				getSubStepsForStep: function ()
				{
					return $(".step[data-step='" + this.step + "']").find(".sub_step").length;
				},

				previousStep: function ()
				{
					if (this.sub_step == 1 && this.step == 1)
					{
						return false;
					}

					var currentStep = $(".step[data-step='" + this.step + "']");
					var previousStep = $(".step[data-step='" + (this.step - 1) + "']");

					if (this.sub_step > ( currentStep.attr('data-first-sub-step') * 1 ))
					{
						var currentSubStep = currentStep.find(".sub_step[data-sub-step='" + this.sub_step + "']");
						var previousSubStep = currentStep.find(".sub_step[data-sub-step='" + (this.sub_step - 1) + "']");

						if (previousSubStep[0])
						{
							this.sub_step = previousSubStep.attr("data-sub-step") * 1;
							currentSubStep.removeClass("sub_step--active");
							previousSubStep.addClass("sub_step--active");

							return true;
						}
					}

					var numberOfSubStepsInPreviousStep = previousStep.find(".sub_step").length;

					this.step--;
					this.sub_step = numberOfSubStepsInPreviousStep;

					currentStep.removeClass("step--active");
					previousStep.addClass("step--active");

					return true;
				},

				getAge: function ()
				{
					if (this.user_data.birthdate === null)
					{
						return null;
					}

					var today = new Date();
					var birthDate = new Date(this.user_data.birthdate);
					var age = today.getFullYear() - birthDate.getFullYear();
					var m = today.getMonth() - birthDate.getMonth();
					if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate()))
					{
						age--;
					}

					if (age !== undefined && age > 0)
					{
						this.user_data.age = age;

						return this.user_data.age;
					}

					return false;
				},

				adviseShown: function (adviseId)
				{
					return $(".advise[data-advise='" + adviseId + "']")[0] !== undefined;
				},

				shouldJumpToNext: function (elementId, length, event)
				{
					if (length === false || event.target.value.length >= length)
					{
						$("#" + elementId).select();
						return true;
					}

					return false;
				},

				isAlone: function (groupNum, currentAdvise)
				{
					return $(".group[data-group='" + groupNum + "']").find(".advise").filter(function (index, element)
						{
							return ( $(element).data("advise") * 1 ) < currentAdvise;
						}).length <= 0;
				},

				isGroupEmpty: function (groupNum)
				{
					var step = this.step;
					return $(".group[data-group='" + groupNum + "']").find(".advise").length === 0;
				},

				isCombinationPossible: function (groupOne, groupTwo, groupThree)
				{
					var firstGroup = this.combinations[groupOne];

					if (!firstGroup)
					{
						return false;
					}

					if (groupTwo !== false)
					{
						var secondGroup = firstGroup[groupTwo];

						if (!secondGroup)
						{
							return false;
						}

						if (groupThree !== false && groupThree !== null)
						{
							var thirdGroup = secondGroup[groupThree];

							if (!thirdGroup)
							{
								return false;
							}
						}
					}

					return true;
				}
			}
		});

		var $birthdayPicker = $("#birthdate-picker").pickadate({
			// Strings and translations
			monthsFull: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			weekdaysFull: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
			weekdaysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			today: false,
			clear: 'Nulstil',
			close: 'Luk',
			labelMonthNext: 'Næste måned',
			labelMonthPrev: 'Tidligere måned',
			labelMonthSelect: 'Vælg måned',
			labelYearSelect: 'Vælg årstal',
			format: 'd mmmm, yyyy',
			selectYears: 100,
			selectMonths: true,
			firstDay: 1,
			min: new Date("{{ date('Y-m-d', strtotime('-100 years 1/1')) }}"),
			max: new Date("{{ date('Y-m-d', strtotime('-13 years 12/31')) }}"),
			closeOnClear: false,
			hiddenName: true,
			formatSubmit: 'yyyy-mm-dd',
			container: '#datepicker-container',
			onSet: function ()
			{
				app.user_data.birthdate = this.get('select', 'yyyy-mm-dd');
			}
		});

		Vue.transition('setAdviseOne', {
			enter: function (el)
			{
				this.current_advise_one = $(el).data('group');
			}
		});

		Vue.transition('setAdviseTwo', {
			enter: function (el)
			{
				this.current_advise_two = $(el).data('group');
			}
		});

		Vue.transition('setAdviseThree', {
			enter: function (el)
			{
				this.current_advise_three = $(el).data('group');
			}
		});

		$("#openPicker").click(function (e)
		{
			e.preventDefault();
			$birthdayPicker.pickadate('picker').open();
		});
	</script>
@endsection
