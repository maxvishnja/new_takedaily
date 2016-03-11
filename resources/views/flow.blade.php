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

						<p class="substep-explanation">Men and women need different levels of vitamins en minerals. For example
							vitamin D. Vitamin D is an important vitamin for strong bones and muscles.</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title">Hvor gammel er du?</h3>

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
							<button v-on:click="nextStep();" type="button" class="button button--rounded button--medium button--green">Ja, jeg er <strong>@{{ temp_age }}</strong> år gammel</button>
						</template>

						<p class="substep-explanation">Your requirement for vitamins, minerals is agerelated. As we get older
							the
							need for vitamin D, vitamin B12 and calcium changing. Vitamin B12 plays an important role in
							the
							body: it gives energy, is important for our nerve- and immune system and our psychological
							function.</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">Hvilken hudfarve har du?</h3>
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

						<p class="substep-explanation">A white skin can produce more vitamin D during sun exposure. That’s why
							people with a Meditarranean or black skin need extra vitamin D.</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">Er du udenfor mellem 11:00 og 15:00 hver dag?</h3>
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

						<p class="substep-explanation">You have to be outside for 15 minutes till 30 minutes daily to make
							enough
							vitamin D during sun exposure.</p>
					</div>
				</div>

				<div data-step="2" v-bind="{ 'data-first-sub-step': user_data.gender == 2 ? 1 : 2 }" class="step">
					<div data-sub-step="1" class="sub_step sub_step--active" v-bind:class="{ 'sub_step--active': user_data.gender == 2 }">
						<h3 class="substep-title">Er du gravid, eller ønsker at blive det?</h3>
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

						<p class="substep-explanation">If you have a pregnancy whish, the first thing you need a good supply of
							vitamins and minerals. The health authorities reccomend taking extra vitamin B9 (folic acid
							)
							which takes care of the development of the baby. If you take folic acid tablets in early
							pregnancy you reduce the risk of having a baby born with a spinal cord problem such as spina
							bifida.<br/>
							During the whole pregnancy specific vitamins, such as vitamin D is important for the
							development
							of the bones and musles. Other nutrients as fish oil play an important role in development
							of
							the baby.
						</p>
					</div>

					<div data-sub-step="2" class="sub_step" v-bind:class="{ 'sub_step--active': user_data.gender == 1 }">
						<h3 class="substep-title">Er du på en diæt for vægttab?</h3>
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

						<p class="substep-explanation">When you are losing weight it is important to get an extra dose of some
							vitamins and minerals. Because your diet might not be healthy enough in the past you need
							some
							extra vitamins. For example vitamin A. This is a important vitamin for your skin an your
							immune
							system. Together with vitamin C it takes care of a good immune system. You need more vitamin
							C
							when your weight is higher.
							You also need more vitamin K for your blood. B-vitamines are important for your energy
							level.
						</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">Hvor ofte er du fysisk aktiv?</h3>
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

						<p class="substep-explanation">Sports are good for your health, if you are a frequent athlete you need
							some
							extra vitamins and minerals. B-vitamins take care of your energymetabolism and performance.
							Iron
							is also involved in producing energy.</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">Hvordan er dit liv i øjeblikket?</h3>
						<label>
							<input type="radio" name="step[2][4]" value="1" v-model="user_data.stressed" v-on:click="nextStep();"/>
							<span class="icon icon-stress" title="Stressful"></span>
							<br/>Stresset
						</label>
						<label>
							<input type="radio" name="step[2][4]" value="2" v-model="user_data.stressed" v-on:click="nextStep();"/>
							<span class="icon icon-joy" title="Quiet"></span>
							<br/>Roligt
						</label>

						<p class="substep-explanation">In a stressful period extra vitamins and minerals can help you to relax.
							B-vitamins are important for the nervous system and a normal psychological function.</p>
					</div>

					<div data-sub-step="5" class="sub_step">
						<h3 class="substep-title">Føler du dig tit træt, eller mangler energi?</h3>
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

						<p class="substep-explanation">The B vitamins (B1, B2 , B3, B5 , B6 ) play a crucial role in energy
							metabolism. A lack of these vitamins can cause tiredness and a low energy level.</p>
					</div>

					<div data-sub-step="6" class="sub_step">
						<h3 class="substep-title">Ønsker du at forbedre dit immunsystem?</h3>
						<label>
							<input type="radio" name="step[2][6]" value="1" v-model="user_data.immune_system" v-on:click="nextStep();"/>
							<span class="icon icon-immune-boost"></span>
							<br/>Ja
						</label>
						<label>
							<input type="radio" name="step[2][6]" value="2" v-model="user_data.immune_system" v-on:click="nextStep();"/>
							<span class="icon icon-immune-ignore"></span>
							<br/>Nej
						</label>

						<p class="substep-explanation">Special vitamins can help to give your immune system a boost!<br/>
							Vitamin C is an important anti-illness vitamin, because it helps your body to produce white
							bloodcells. But also vitamin A and D are anti-infection vitamins.
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

						<p class="substep-explanation">It has been scientifically established that the need for vitamin C is
							considerably higher for smokers.</p>
					</div>

					<div data-sub-step="8" class="sub_step">
						<h3 class="substep-title">Er du vegetar?</h3>
						<label>
							<input type="radio" name="step[2][8]" value="1" v-model="user_data.vegetarian" v-on:click="nextStep();"/>
							<span class="icon icon-vegetarian-yes"></span>
							<br/>Ja
						</label>
						<label>
							<input type="radio" name="step[2][8]" value="2" v-model="user_data.vegetarian" v-on:click="nextStep();"/>
							<span class="icon icon-meat"></span>
							<br/>Nej
						</label>

						<p class="substep-explanation">Meat is rich in vitamin B1, B12 and iron. You need these vitamins for
							your
							energy metabolism.</p>
					</div>

					<div data-sub-step="9" class="sub_step">
						<h3 class="substep-title">Har du problemer med muskler eller led?</h3>
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

						<p class="substep-explanation">Some nutrients support your joints and muscles. Vitamin D makes you
							musles
							strong and takes care of your balance. Glucosamin/chondoitin also play and important
							role.</p>
					</div>

					<div data-sub-step="10" class="sub_step">
						<h3 class="substep-title">Tager du nogle vitaminer eller mineraler allerede?</h3>
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

						<p class="substep-explanation">The result of this test is based on your diet and your lifestyle. Take
							Daily
							takes care that you get all the vitamins and minerals you need. When using supplements of
							Take
							Daily it is not necessary to take other supplements as well.</p>
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

						<p class="substep-explanation">Vegetables are an important source of vitamin C, folic acid and
							potassium.
							One vegetable serving spoon equals 50 grams.</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title">Hvor meget frugt spiser du / frugt juice drikker du? </h3>
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

						<p class="substep-explanation">Fruit is an important source of vitamin C. Count two small pieces
							(mandarin,
							kiwi) or a bowl with small fruits strawberry, grapes etc. as one.</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">Hvor meget brød spiser du dagligt?</h3>
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

						<p class="substep-explanation">Bread is an important sources of B vitamins, iron and fibre. It is
							important
							to eat a sufficient amount of bread or bread substitutes. B-vitamines and iron give you
							energy.</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">Bruger du smør eller margarine på dit brød eller ved madlavning?</h3>
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
							<br/>Af og til
						</label>

						<p class="substep-explanation">Margarine and halvarine are important sources of vitamin A and vitamin
							D.Both
							vitamins are important for example for your imunesystem.</p>
					</div>

					<div data-sub-step="5" class="sub_step">
						<h3 class="substep-title">Hvor meget pasta, kartofler eller ris spiser du dagligt?</h3>
						<label>
							<input type="radio" name="step[3][5]" value="1" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
							<span class="icon icon-portion-pasta-1"></span>
							<br/>Intet</label>
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

						<p class="substep-explanation">Pasta and rice are an important source of B vitamins and minerals. One
							serving spoon potatoes equals 50 grams.</p>
					</div>

					<div data-sub-step="6" class="sub_step">{{-- consider hide if vegeratian --}}
						<h3 class="substep-title">Hvor meget kød spiser du dagligt?</h3>
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
							<br/>+151 gram</label>

						<p class="substep-explanation">Meat is rich in B-vitamins en iron.</p>
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

						<p class="substep-explanation">Fish is rich in fish-oil (omega-3) and vitamin D.</p>
					</div>

					<div data-sub-step="8" class="sub_step">
						<h3 class="substep-title">Hvor mange portioner mælkeprodukter får du dagligt?</h3>
						<label>
							<input type="radio" name="step[3][8]" value="1" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
							<span class="icon icon-portion-milk-1"></span>
							<br/>Ingen
						</label>
						<label>
							<input type="radio" name="step[3][8]" value="2" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
							<span class="icon icon-portion-milk-2"></span>
							<br/>1-2 portioner
						</label>
						<label>
							<input type="radio" name="step[3][8]" value="3" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
							<span class="icon icon-portion-milk-3"></span>
							<br/>+3 portioner
						</label>

						<p class="substep-explanation">Milk is an important source of vitamine B2, B12 and calcium that makes
							for
							strong bones and joints. The Recommended Daily Allowance (RDA) for calcium varies depending
							on
							your age.</p>
					</div>
				</div>

				<div data-step="4" data-first-sub-step="1" class="step">
					<div class="group" data-group="1">

						<div class="advise" data-advise="1.1" data-group="1" v-if="( (user_data.age < 50 && user_data.gender == 2 && user_data.pregnant == 2)  || (user_data.age < 70 && user_data.gender == 1) )" transition="setAdviseOne">
							Basic
							<p>This basic supplement ensures that you're getting all the vitamins and minerals in
								addition
								to your daily diet.</p>
						</div>

						<div class="advise" data-advise="1.2" data-group="1" v-if="(isAlone(1, 1.2)) && (( ( user_data.age >= 50 && user_data.age <= 70 ) && user_data.gender == 2) || (user_data.skin > 1)))" transition="setAdviseOne">
							Basic +10 D
							<p>Your Take Daily basic supplement ensures that you're getting all the vitamins and
								minerals in
								addition to your daily diet.</p>
							<p>Besides that the supplement contains extra vitamin D. Because of your age and/or your
								skin
								colour you need extra vitamin D.</p>
						</div>

						<div class="advise" data-advise="1.3" data-group="1" v-if="(isAlone(1, 1.3)) && (outside == 2)" transition="setAdviseOne">
							Basic +10 D
						</div>

						<div class="advise" data-advise="1.4" data-group="1" v-if="((user_data.age > 70 && user_data.gender == 1) || (user_data.age > 50 && user_data.gender == 2) ) && isAlone(1, 1.4)" transition="setAdviseOne">
							Basic +20 D
							<p>Your Take Daily basic supplement ensures that you're getting all the vitamins and
								minerals in
								addition to your daily diet.</p>
							<p>Besides that the supplement contains extra vitamin D. Because of your age you need extra
								vitamin D.</p>
						</div>
					</div>

					<div class="group" data-group="2">
						<div class="advise" data-advise="2.1" data-group="A" v-if="(isCombinationPossible(current_advise_one, 'A', null)) && user_data.pregnant == 1" transition="setAdviseTwo">
							A
							<p>
								You have a pregnancy whish. In this special period in your life Take Daily ensures that
								you
								get enough vitamins before or during your pregnancy. This special supplement contains
								the
								extra vitamins, minerals and other nutrients you need right now.
								<br/><br/>
								If you have a pregnancy whish, the first thing you need a good supply of vitamins and
								minerals. The health authorities reccomend taking extra vitamin B9 (folic acid ) which
								takes
								care of the development of the baby. If you take folic acid tablets in early pregnancy
								you
								reduce the risk of having a baby born with a spinal cord problem such as spina bifida.
							</p>

							<p>
								You are pregnant. In this special period in your life Take Daily ensures that you get
								enough
								vitamins before or during your pregnancy. This special supplement contains the extra
								vitamins, minerals and other nutrients you need right now.
								<br/><br/>
								During the whole pregnancy specific vitamins, such as vitamin D is important for the
								development of the bones and musles. Other nutrients as fish oil play an important role
								in
								development of the baby.
							</p>
						</div>

						<div class="advise" data-advise="2.2" data-group="B" v-if="(isCombinationPossible(current_advise_one, 'B', null)) && (isAlone(2, 2.2)) && (user_data.diet == 1)" transition="setAdviseTwo">
							B
							<p>At this moment you are on a slimming diet.
								We give you a special supplement. Besides that is important to avoid stress, sleep and
								exercise. You can do it: good luck!
								<br/><br/>
								When you are losing weight it is important to get an extra dose of some vitamins and
								minerals. Because your diet might not be healthy enough in the past you need some extra
								vitamins. For example vitamin A. This is a important vitamin for your skin an your
								immune
								system. Together with vitamin C it takes care of a good immune system. You need more
								vitamin
								C when your weight is higher.
								You also need more vitamin K for your blood. B-vitamines are important for your energy
								level.
							</p>
						</div>

						<div class="advise" data-advise="2.3" data-group="C" v-if="(isCombinationPossible(current_advise_one, 'C', null)) && (isAlone(2, 2.3)) && (user_data.sports == 4 || user_data.lacks_energy < 3 || user_data.stressed == 1)" transition="setAdviseTwo">
							C
							<p v-show="user_data.sports == 4">
								You are exercising more than 2 times a week. Your body needs extra vitamins and
								minerals.
								That’s why you get this special Take Daily sports supplement.
								<br/><br/>
								Sports are good for your health, if you are a frequent athlete you need some extra
								vitamins
								and minerals. B-vitamins take care of your energymetabolism and performance. Iron is
								also
								involved in producing energy.
							</p>
							<p v-show="user_data.lacks_energy < 3 || user_data.stressed == 1">
								Your energy level is (too) low at this moment and you feel tired.
								<br/><br/>
								The B vitamins (B1, B2 , B3, B5 , B6 ) play a crucial role in energy metabolism. A lack
								of
								these vitamins can cause tiredness and a low energy level.
							</p>
						</div>

						<div class="advise" data-advise="2.4" data-group="D" v-if="(isCombinationPossible(current_advise_one, 'D', null)) && (isAlone(2, 2.4)) && (user_data.immune_system == 1 || user_data.smokes == 1 || user_data.vegetarian == 1)" transition="setAdviseTwo">
							D
							<p v-show="user_data.immune_system == 1">
								You need an immune system boost
								Vitamins and minerals help you to boost your immune system.
								<br/><br/>
								Special vitamins can help to give your immune system a boost!
								Vitamin C is an important anti-illness vitamin, because it helps your body to produce
								white
								bloodcells. But also vitamin A and D are anti-infection vitamins.
							</p>

							<p v-show="user_data.smokes == 1">
								You need an immune system boost
								Vitamins and minerals help you to boost your immune system.
								<br/><br/>
								Special vitamins can help to give your immune system a boost!
								Vitamin C is an important anti-illness vitamin, because it helps your body to produce
								white
								bloodcells. But also vitamin A and D are anti-infection vitamins.
							</p>

							<p v-show="user_data.vegetarian == 1">
								You do not eat meat . That’s why Take Daily gives you some specific vitamins and
								minerals.
								<br/><br/>
								Meat is rich in vitamin B1, B12 and iron. You need these vitamins for your energy
								metabolism.
							</p>
						</div>

						<div class="advise" data-advise="2.5" data-group="E" v-if="(isCombinationPossible(current_advise_one, 'E', null)) && (isAlone(2, 2.5)) && (user_data.joints == 1)" transition="setAdviseTwo">
							E
							<p>
								You need some extra support for your muscles and joints.
								Some nutrients support your joints and muscles. Vitamin D makes you musles strong and
								takes
								care of your balance. Glucosamin/chondoitin also play and important role.
							</p>
						</div>
					</div>

					<div class="group" data-group="3">
						<div class="advise" data-advise="3.1" data-group="a" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'a')) && user_data.foods.fruits == 1 || user_data.foods.vegetables == 1" transition="setAdviseThree">
							a
							<p v-show="user_data.foods.fruits == 1">
								You don’t eat enough fruit. That’s why you can get a lack of some important vitamins,
								like
								vitamin C.
								<br/>
								Vegetables are an important source of vitamin C, folic acid and potassium. One vegetable
								serving spoon equals 50 grams.
							</p>

							<p v-show="user_data.foods.vegetables == 1">
								You don’t eat enough vegetables. That’s why you can get a lack of some important
								vitamins,
								like vitamin B9.
								<br/>
								Fruit is an important source of vitamin C, B9 and potassium.
							</p>
						</div>

						<div class="advise" data-advise="3.2" data-group="b" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'b')) && (isAlone(3, 3.2)) && (user_data.foods.bread == 1 || user_data.foods.wheat == 1)" transition="setAdviseThree">
							b
							<p v-show="user_data.foods.bread == 1">
								The amount of bread you take is not enough to get all the important vitamins and
								minerals
								you need.
								<br/>
								Bread is an important sources of B vitamins, iron and fibre. It is important to eat a
								sufficient amount of bread or bread substitutes. B-vitamines and iron give you energy.
							</p>

							<p v-show="user_data.foods.wheat == 1">
								The amount of rice/pasta you take is not enough to get all the important vitamins and
								minerals you need.
								<br/>
								Pasta and rice are an important source of B vitamins and minerals.
							</p>
						</div>

						<div class="advise" data-advise="3.3" data-group="c" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'c')) && (isAlone(3, 3.3)) && (user_data.foods.dairy == 1)" transition="setAdviseThree">
							c
							<p>
								You don’t eat enough dairy. That’s why you can get a lack of Calcium and vitamin B2.
								<br/>
								Milk and milk products are an important source of vitamin B2, B12 and calcium that makes
								for
								strong bones and joints. The Recommended Daily Allowance (RDA) for calcium varies
								depending
								on your age.
							</p>
						</div>

						<div class="advise" data-advise="3.4" data-group="d" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'd')) && (isAlone(3, 3.4)) && (user_data.foods.meat == 1)" transition="setAdviseThree">
							d
							<p>
								You don’t eat (enough) meat. That’s why you can get a lack of some important vitamins
								and
								minerals like iron.
								<br/>
								Meat is rich in B-vitamins en iron.
							</p>
						</div>

						<div class="advise" data-advise="3.5" data-group="e" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'e')) && (isAlone(3, 3.5)) && (user_data.foods.fish == 1)" transition="setAdviseThree">
							e
							<p>
								The amount of fish you take is not enough to get all the important vitamins, minerals
								and
								fish oil.
								<br/>
								Fish is rich in fish-oil (omega-3) and vitamin D.
							</p>
						</div>

						<div class="advise" data-advise="3.6" data-group="f" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'f')) && (isAlone(3, 3.6)) && (user_data.foods.butter == 2)" transition="setAdviseThree">
							f
							<p>
								You don’t use any butter or margarine. That’s why your intake of vitamin A en D is too
								low.
								<br/>
								Margarine and halvarine are important sources of vitamin A and vitamin D.Both vitamins
								are
								important for example for your immune system.
							</p>
						</div>

						<div class="advise" data-advise="3.7" data-group="" transition="setAdviseThree" v-if="isGroupEmpty(3) && isGroupEmpty(2)">
							Congratulations, your lifestyle is excellent and your diet is perfect. The only advice we
							have
							is: take daily basic. Because there might be days that your lifestyle and diet are not
							healthy
							enough.
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
