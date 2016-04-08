@extends('layouts.app')

@section('pageClass', 'page-flow')

@section('mainClasses', 'm-b-50')

@section('title', trans('flow.title'))

@section('content')
	<noscript>
		<style>
			#app { display: none !important; }
		</style>

		<h1 class="text-center">{{ trans('flow.scripts') }}</h1>
	</noscript>

	<div id="app" class="flow-container">
		<div class="flow-progress flow-progress--closed">
			<span class="hamburger" id="flow-toggler">
				<span class="meat"></span>
				<span class="meat"></span>
				<span class="meat meat--last"></span>
			</span>

			<div class="flow-step" step="1" v-bind:class="{ 'flow-step--inactive': step !== 1, 'flow-step--completed': step > 1 }">
				<div class="flow-step-progress">
					<span class="flow-step-progress-bar" v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
				<div class="flow-step-check">
					<div class="icon icon-check"></div>
				</div>
				<div class="flow-step-title">{{ trans('flow.steps.one') }}</div>
			</div>
			<div class="flow-step flow-step--inactive" step="2" v-bind:class="{ 'flow-step--inactive': step !== 2, 'flow-step--completed': step > 2 }">
				<div class="flow-step-progress">
					<span class="flow-step-progress-bar" v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
				<div class="flow-step-check">
					<div class="icon icon-check"></div>
				</div>
				<div class="flow-step-title">{{ trans('flow.steps.two') }}</div>
			</div>
			<div class="flow-step flow-step--inactive" step="3" v-bind:class="{ 'flow-step--inactive': step !== 3, 'flow-step--completed': step > 3 }">
				<div class="flow-step-progress">
					<span class="flow-step-progress-bar" v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
				<div class="flow-step-check">
					<div class="icon icon-check"></div>
				</div>
				<div class="flow-step-title">{{ trans('flow.steps.three') }}</div>
			</div>
			<div class="flow-step flow-step--inactive" step="4" v-bind:class="{ 'flow-step--inactive': step !== 4 }">
				<div class="flow-step-title">{{ trans('flow.steps.four') }}</div>
			</div>
		</div>

		<div class="container">

			<div class="flow-step-back" v-bind:class="{ 'clickable': step > 1 || sub_step > 1}">
				<a href="#" v-on:click="previousStep();">{{ trans('flow.back') }}</a>
			</div>

			<form method="post" action="">
				<div data-step="1" data-first-sub-step="1" class="step step--active">
					<div data-sub-step="1" class="sub_step sub_step--active">
						<h3 class="substep-title">{{ trans('flow.questions.1-1.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[1][1]" value="1" v-model="user_data.gender" v-on:click="nextStep();"/>
								<span class="icon icon-gender-male"></span>
								<br/>{{ trans('flow.questions.1-1.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[1][1]" value="2" v-model="user_data.gender" v-on:click="nextStep();"/>
								<span class="icon icon-gender-female"></span>
								<br/>{{ trans('flow.questions.1-1.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.1-1.text') }}</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title" v-show="user_data.gender == 1">{{ trans('flow.questions.1-2.title') }}</h3>
						<h3 class="substep-title" v-show="user_data.gender == 2">{{ trans('flow.questions.1-2.title-alt') }}</h3>

						<div class="datepicker-container-block">
							<label for="birthdate-picker" class="text-center flow_label_noclick">
								<span class="icon calendar-icon" style="vertical-align: middle; margin-right: 6px;"></span>
								<span>{{ trans('flow.questions.1-2.button-text') }}</span>
							</label>

							<br/>

							<input type="text" name="step[1][1]" v-model="user_data.birthdate" id="birthdate-picker" style="visibility: hidden; height: 0px !important;"/>
							<div id="datepicker-container"></div>
						</div>

						<template v-if="temp_age">
							<br/>
							<button v-on:click="nextStep();" type="button" class="button button--rounded button--medium button--green">{!! trans('flow.questions.1-2.button-submit-text') !!}</button>
						</template>

						<p class="substep-explanation">{{ trans('flow.questions.1-2.text') }}</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.1-3.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[1][3]" value="1" v-model="user_data.skin" v-on:click="nextStep();"/>
								<span class="icon icon-skin-white"></span>
								<br/>{{ trans('flow.questions.1-3.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[1][3]" value="2" v-model="user_data.skin" v-on:click="nextStep();"/>
								<span class="icon icon-skin-mediterranean"></span>
								<br/>{{ trans('flow.questions.1-3.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[1][3]" value="3" v-model="user_data.skin" v-on:click="nextStep();"/>
								<span class="icon icon-skin-dark"></span>
								<br/>{{ trans('flow.questions.1-3.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.1-3.text') }}</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.1-4.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[1][4]" value="1" v-model="user_data.outside" v-on:click="nextStep();"/>
								<span class="icon icon-sun-yes"></span>
								<br/>{{ trans('flow.questions.1-4.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[1][4]" value="2" v-model="user_data.outside" v-on:click="nextStep();"/>
								<span class="icon icon-sun-no"></span>
								<br/>{{ trans('flow.questions.1-4.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.1-4.text') }}</p>
					</div>
				</div>

				<div data-step="2" v-bind="{ 'data-first-sub-step': user_data.gender == 2 ? 1 : 2 }" class="step">
					<div data-sub-step="1" class="sub_step sub_step--active" v-bind:class="{ 'sub_step--active': user_data.gender == 2 }">
						<h3 class="substep-title">{{ trans('flow.questions.2-1.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][1]" value="1" v-model="user_data.pregnant" v-on:click="nextStep();"/>
								<span class="icon icon-pregnant-yes"></span>
								<br/>{{ trans('flow.questions.2-1.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][1]" value="2" v-model="user_data.pregnant" v-on:click="nextStep();"/>
								<span class="icon icon-pregnant-no"></span>
								<br/>{{ trans('flow.questions.2-1.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{!! trans('flow.questions.2-1.text') !!}</p>
					</div>

					<div data-sub-step="2" class="sub_step" v-bind:class="{ 'sub_step--active': user_data.gender == 1 }">
						<h3 class="substep-title">{{ trans('flow.questions.2-2.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][2]" value="1" v-model="user_data.diet" v-on:click="nextStep();"/>
								<span class="icon icon-diet-pear"></span>
								<br/>{{ trans('flow.questions.2-2.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][2]" value="2" v-model="user_data.diet" v-on:click="nextStep();"/>
								<span class="icon icon-diet-burger"></span>
								<br/>{{ trans('flow.questions.2-2.options.2') }}
							</label>
						</div>
						<p class="substep-explanation">{{ trans('flow.questions.2-2.text') }}</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-3.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][3]" value="1" v-model="user_data.sports" v-on:click="nextStep();"/>
								<span class="icon icon-activity-seldom"></span>
								<br/>{{ trans('flow.questions.2-3.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][3]" value="2" v-model="user_data.sports" v-on:click="nextStep();"/>
								<span class="icon icon-activity-once"></span>
								<br/>{{ trans('flow.questions.2-3.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[2][3]" value="3" v-model="user_data.sports" v-on:click="nextStep();"/>
								<span class="icon icon-activity-twice"></span>
								<br/>{{ trans('flow.questions.2-3.options.3') }}
							</label>
							<label>
								<input type="radio" name="step[2][3]" value="4" v-model="user_data.sports" v-on:click="nextStep();"/>
								<span class="icon icon-activity-more"></span>
								<br/>{{ trans('flow.questions.2-3.options.4') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-3.text') }}</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-4.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][4]" value="1" v-model="user_data.stressed" v-on:click="nextStep();"/>
								<span class="icon icon-stress"></span>
								<br/>{{ trans('flow.questions.2-4.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][4]" value="2" v-model="user_data.stressed" v-on:click="nextStep();"/>
								<span class="icon icon-joy"></span>
								<br/>{{ trans('flow.questions.2-4.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-4.text') }}</p>
					</div>

					<div data-sub-step="5" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-5.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][5]" value="1" v-model="user_data.lacks_energy" v-on:click="nextStep();"/>
								<span class="icon icon-tired"></span>
								<br/>{{ trans('flow.questions.2-5.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][5]" value="2" v-model="user_data.lacks_energy" v-on:click="nextStep();"/>
								<span class="icon icon-awake"></span>
								<br/>{{ trans('flow.questions.2-5.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[2][5]" value="3" v-model="user_data.lacks_energy" v-on:click="nextStep();"/>
								<span class="icon icon-fresh"></span>
								<br/>{{ trans('flow.questions.2-5.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-5.text') }}</p>
					</div>

					<div data-sub-step="6" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-6.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][6]" value="1" v-model="user_data.immune_system" v-on:click="nextStep();"/>
								<span class="icon icon-immune-boost"></span>
								<br/>{{ trans('flow.questions.2-6.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][6]" value="2" v-model="user_data.immune_system" v-on:click="nextStep();"/>
								<span class="icon icon-immune-ignore"></span>
								<br/>{{ trans('flow.questions.2-6.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-6.text') }}
						</p>
					</div>

					<div data-sub-step="7" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-7.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][7]" value="1" v-model="user_data.smokes" v-on:click="nextStep();"/>
								<span class="icon icon-smoke"></span>
								<br/>{{ trans('flow.questions.2-7.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][7]" value="2" v-model="user_data.smokes" v-on:click="nextStep();"/>
								<span class="icon icon-smoke-no"></span>
								<br/>{{ trans('flow.questions.2-7.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-7.text') }}</p>
					</div>

					<div data-sub-step="8" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-8.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][8]" value="1" v-model="user_data.vegetarian" v-on:click="nextStep();"/>
								<span class="icon icon-vegetarian-yes"></span>
								<br/>{{ trans('flow.questions.2-8.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][8]" value="2" v-model="user_data.vegetarian" v-on:click="nextStep();"/>
								<span class="icon icon-meat"></span>
								<br/>{{ trans('flow.questions.2-8.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-8.text') }}</p>
					</div>

					<div data-sub-step="9" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-9.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][9]" value="1" v-model="user_data.joints" v-on:click="nextStep();"/>
								<span class="icon icon-joint-yes"></span>
								<br/>{{ trans('flow.questions.2-9.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][9]" value="2" v-model="user_data.joints" v-on:click="nextStep();"/>
								<span class="icon icon-joint-no"></span>
								<br/>{{ trans('flow.questions.2-9.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-9.text') }}</p>
					</div>

					<div data-sub-step="10" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-10.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][10]" value="1" v-on:click="nextStep();" v-model="user_data.supplements"/>
								<span class="icon icon-supplement-yes"></span>
								<br/>{{ trans('flow.questions.2-10.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][10]" value="2" v-on:click="nextStep();" v-model="user_data.supplements"/>
								<span class="icon icon-supplement-no"></span>
								<br/>{{ trans('flow.questions.2-10.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-10.text') }}</p>
					</div>
				</div>

				<div data-step="3" data-first-sub-step="1" class="step">
					<div data-sub-step="1" class="sub_step sub_step--active">
						<h3 class="substep-title">{{ trans('flow.questions.3-1.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][1]" value="1" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-1"></span>
								<br/>{{ trans('flow.questions.3-1.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="2" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-2"></span>
								<br/>{{ trans('flow.questions.3-1.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="3" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-3"></span>
								<br/>{{ trans('flow.questions.3-1.options.3') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="4" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-4"></span>
								<br/>{{ trans('flow.questions.3-1.options.4') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="5" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-5"></span>
								<br/>{{ trans('flow.questions.3-1.options.5') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-1.text') }}</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-2.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="1" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fruit-1"></span>
								<br/>{{ trans('flow.questions.3-2.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="2" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fruit-2"></span>
								<br/>{{ trans('flow.questions.3-2.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="3" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fruit-3"></span>
								<br/>{{ trans('flow.questions.3-2.options.3') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-2.text') }}</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-3.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][3]" value="1" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-1"></span>
								<br/>{{ trans('flow.questions.3-3.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="2" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-2"></span>
								<br/>{{ trans('flow.questions.3-3.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="3" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-3"></span>
								<br/>{{ trans('flow.questions.3-3.options.3') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="4" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-4"></span>
								<br/>{{ trans('flow.questions.3-3.options.4') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="5" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-5"></span>
								<br/>{{ trans('flow.questions.3-3.options.5') }}</label>
						</div>

						<p class="substep-explanation">{!! trans('flow.questions.3-3.text') !!}</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-4.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][4]" value="1" v-model="user_data.foods.butter" v-on:click="nextStep();"/>
								<span class="icon icon-portion-butter-yes"></span>
								<br/>{{ trans('flow.questions.3-4.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[3][4]" value="2" v-model="user_data.foods.butter" v-on:click="nextStep();"/>
								<span class="icon icon-portion-butter-no"></span>
								<br/>{{ trans('flow.questions.3-4.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[3][4]" value="3" v-model="user_data.foods.butter" v-on:click="nextStep();"/>
								<span class="icon icon-portion-butter-sometimes"></span>
								<br/>{{ trans('flow.questions.3-4.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-4.text') }}</p>
					</div>

					<div data-sub-step="5" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-5.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][5]" value="1" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-1"></span>
								<br/>{{ trans('flow.questions.3-5.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][5]" value="2" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-2"></span>
								<br/>{{ trans('flow.questions.3-5.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][5]" value="3" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-3"></span>
								<br/>{{ trans('flow.questions.3-5.options.3') }}</label>
							<label>
								<input type="radio" name="step[3][5]" value="4" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-4"></span>
								<br/>{{ trans('flow.questions.3-5.options.4') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-5.text') }}</p>
					</div>

					<div data-sub-step="6" class="sub_step">{{-- consider hide if vegeratian --}}
						<h3 class="substep-title">{{ trans('flow.questions.3-6.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][6]" value="1" v-model="user_data.foods.meat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-meat-1"></span>
								<br/>{{ trans('flow.questions.3-6.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][6]" value="2" v-model="user_data.foods.meat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-meat-2"></span>
								<br/>{{ trans('flow.questions.3-6.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][6]" value="3" v-model="user_data.foods.meat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-meat-3"></span>
								<br/>{{ trans('flow.questions.3-6.options.3') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-6.text') }}</p>
					</div>

					<div data-sub-step="7" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-7.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][7]" value="1" v-model="user_data.foods.fish" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fish-1"></span>
								<br/>{{ trans('flow.questions.3-7.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[3][7]" value="2" v-model="user_data.foods.fish" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fish-2"></span>
								<br/>{{ trans('flow.questions.3-7.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[3][7]" value="3" v-model="user_data.foods.fish" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fish-3"></span>
								<br/>{{ trans('flow.questions.3-7.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-7.text') }}</p>
					</div>

					<div data-sub-step="8" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-8.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][8]" value="1" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
								<span class="icon icon-portion-milk-1"></span>
								<br/>{{ trans('flow.questions.3-8.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[3][8]" value="2" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
								<span class="icon icon-portion-milk-2"></span>
								<br/>{{ trans('flow.questions.3-8.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[3][8]" value="3" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
								<span class="icon icon-portion-milk-3"></span>
								<br/>{{ trans('flow.questions.3-8.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-8.text') }}</p>
					</div>
				</div>

				<div data-step="4" data-first-sub-step="1" class="step">
					<div class="group" data-group="1">

						<div class="advise" data-advise="1.1" data-group="1" v-if="( (user_data.age < '50 '&& user_data.gender == '2 '&& user_data.pregnant == '2') || (user_data.age < '70 '&& user_data.gender == '1') )" transition="setAdviseOne">
							{!! trans('flow.combinations.1.basic') !!}
						</div>

						<div class="advise" data-advise="1.2" data-group="1" v-if="(isAlone(1, 1.2)) && (( ( user_data.age >= '50' && user_data.age <= '70' ) && user_data.gender == '2)' || (user_data.skin > '1')))" transition="setAdviseOne">
							{!! trans('flow.combinations.1.basic-10-d') !!}
						</div>

						<div class="advise" data-advise="1.3" data-group="1" v-if="(isAlone(1, 1.3)) && (outside == '2')" transition="setAdviseOne">
							{!! trans('flow.combinations.1.basic-10-d-alt') !!}
						</div>

						<div class="advise" data-advise="1.4" data-group="1" v-if="((user_data.age >= '70 '&& user_data.gender == '1') || (user_data.age >= '50' && user_data.gender == '2') ) && isAlone(1, 1.4)" transition="setAdviseOne">
							{!! trans('flow.combinations.1.basic-20-d') !!}
						</div>
					</div>

					<div class="group" data-group="2">
						<div class="advise" data-advise="2.1" data-group="A" v-if="(isCombinationPossible(current_advise_one, 'A', null)) && user_data.pregnant == '1'" transition="setAdviseTwo">
							{!! trans('flow.combinations.2.A') !!}
						</div>

						<div class="advise" data-advise="2.2" data-group="B" v-if="(isCombinationPossible(current_advise_one, 'B', null)) && (isAlone(2, 2.2)) && (user_data.diet == '1')" transition="setAdviseTwo">
							{!! trans('flow.combinations.2.B') !!}
						</div>

						<div class="advise" data-advise="2.3" data-group="C" v-if="(isCombinationPossible(current_advise_one, 'C', null)) && (isAlone(2, 2.3)) && (user_data.sports == '4' || user_data.lacks_energy < '3' || user_data.stressed == '1')" transition="setAdviseTwo">
							{!! trans('flow.combinations.2.C') !!}
						</div>

						<div class="advise" data-advise="2.4" data-group="D" v-if="(isCombinationPossible(current_advise_one, 'D', null)) && (isAlone(2, 2.4)) && (user_data.immune_system == '1' || user_data.smokes == '1' || user_data.vegetarian == '1')" transition="setAdviseTwo">
							{!! trans('flow.combinations.2.D') !!}
						</div>

						<div class="advise" data-advise="2.5" data-group="E" v-if="(isCombinationPossible(current_advise_one, 'E', null)) && (isAlone(2, 2.5)) && (user_data.joints == '1')" transition="setAdviseTwo">
							{!! trans('flow.combinations.2.E') !!}
						</div>
					</div>

					<div class="group" data-group="3">
						<div class="advise" data-advise="3.1" data-group="a" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'a')) && user_data.foods.fruits == '1' || user_data.foods.vegetables == '1'" transition="setAdviseThree">
							{!! trans('flow.combinations.3.a') !!}
						</div>

						<div class="advise" data-advise="3.2" data-group="b" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'b')) && (isAlone(3, 3.2)) && (user_data.foods.bread == '1' || user_data.foods.wheat == '1')" transition="setAdviseThree">
							{!! trans('flow.combinations.3.b') !!}
						</div>

						<div class="advise" data-advise="3.3" data-group="c" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'c')) && (isAlone(3, 3.3)) && (user_data.foods.dairy == '1')" transition="setAdviseThree">
							{!! trans('flow.combinations.3.c') !!}
						</div>

						<div class="advise" data-advise="3.4" data-group="d" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'd')) && (isAlone(3, 3.4)) && (user_data.foods.meat == '1')" transition="setAdviseThree">
							{!! trans('flow.combinations.3.d') !!}
						</div>

						<div class="advise" data-advise="3.5" data-group="e" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'e')) && (isAlone(3, 3.5)) && (user_data.foods.fish == '1')" transition="setAdviseThree">
							{!! trans('flow.combinations.3.e') !!}
						</div>

						<div class="advise" data-advise="3.6" data-group="f" v-if="(isCombinationPossible(current_advise_one, current_advise_two, 'f')) && (isAlone(3, 3.6)) && (user_data.foods.butter == '2')" transition="setAdviseThree">
							{!! trans('flow.combinations.3.f') !!}
						</div>

						<div class="advise" data-advise="3.7" data-group="" transition="setAdviseThree" v-if="isGroupEmpty(3) && isGroupEmpty(2)">
							{!! trans('flow.combinations.none') !!}
						</div>

						<textarea name="user_data" type="hidden" style="display: none;">@{{ $data.user_data | json }}</textarea>
						<button type="submit" class="button button--green button--medium button--full-mobile">{{ trans('flow.button-order-text') }}</button>
					</div>
				</div>

				{{ csrf_field() }}
				<input type="hidden" name="product_name" value="{{ Session::get('force_product_name', false) ? ( Session::get('product_name', 'subscription')) : 'subscription' }}"/>
			</form>
		</div>
	</div>

	@if( ! isset($_COOKIE['call-me-hidden'])  )
		<style>
			body { padding-bottom: 190px; }
		</style>
		<div class="call-cta" id="call-me-form-toggler">
			<div class="container">
				<span title="{{ trans('flow.call-me.deny') }}" id="call-me-form-hider" class="icon icon-cross-large pull-right"></span>
				<strong>{{ trans('flow.call-me.title') }}</strong>
				<span>{{ trans('flow.call-me.text') }}</span>
				<form method="post" action="/call-me" id="call-me-form">
					<input type="number" pattern="\d." maxlength="14" name="phone" class="input input--regular input--plain input--no-number input--spacing input--full-mobile m-t-10" placeholder="12 34 56 78" required="required"/>
					<select class="select select--regular select--spacing select--plain select--full-mobile m-t-10" name="period">
						@foreach(trans('flow.call-me.options') as $option)
							<option value="{{ $option }}">{{ $option }}</option>
						@endforeach
					</select>
					<div class="m-t-10">
						<button type="submit" class="button button--white button--large button--full-mobile">{{ trans('flow.call-me.button-text') }}</button>
					</div>
				</form>
			</div>
		</div>
	@endif
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
							"a": true,
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
							"a": true,
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
						"D": false,
						"E": false
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
					supplements: null,
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
			monthsFull: [
				@foreach(trans('flow.datepicker.months_long') as $month)
					'{{ $month }}',
				@endforeach
			],
			monthsShort: [
				@foreach(trans('flow.datepicker.months_short') as $month)
					'{{ $month }}',
				@endforeach
			],
			weekdaysFull: [
				@foreach(trans('flow.datepicker.days_long') as $day)
					'{{ $day }}',
				@endforeach
			],
			weekdaysShort: [
				@foreach(trans('flow.datepicker.days_short') as $day)
					'{{ $day }}',
				@endforeach
			],
			today: false,
			clear: '{{ trans('flow.datepicker.buttons.clear') }}',
			close: '{{ trans('flow.datepicker.buttons.close') }}',
			labelMonthNext: '{{ trans('flow.datepicker.buttons.next-month') }}',
			labelMonthPrev: '{{ trans('flow.datepicker.buttons.prev-month') }}',
			labelMonthSelect: '{{ trans('flow.datepicker.buttons.select-month') }}',
			labelYearSelect: '{{ trans('flow.datepicker.buttons.select-year') }}',
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

		$("#flow-toggler").click(function (e)
		{
			$(".flow-progress").toggleClass('flow-progress--closed');
		});
	</script>
@endsection
