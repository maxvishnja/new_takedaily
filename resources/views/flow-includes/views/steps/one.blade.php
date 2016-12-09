<div data-step="1" class="step step--active">
	<div data-sub-step="1" class="sub_step sub_step--active">
		<h3 class="substep-title">{{ trans('flow.questions.1-1.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[1][1]" value="1" v-model="user_data.gender" data-model="gender"
					   v-on:click="nextStep();"/>
				<span class="icon icon-gender-male"></span>
				<br/>{{ trans('flow.questions.1-1.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[1][1]" value="2" v-model="user_data.gender" data-model="gender"
					   v-on:click="nextStep();"/>
				<span class="icon icon-gender-female"></span>
				<br/>{{ trans('flow.questions.1-1.options.2') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.1-1.text') }}</p>
	</div>

	<div data-sub-step="2" class="sub_step">
		<h3 class="substep-title"
			v-show="user_data.gender == 1">{{ trans('flow.questions.1-2.title') }}</h3>
		<h3 class="substep-title"
			v-show="user_data.gender == 2">{{ trans('flow.questions.1-2.title-alt') }}</h3>

		<div class="datepicker-container-block">
			<label for="birthdate-picker" class="text-center flow_label_noclick" id="openPicker">
								<span class="icon calendar-icon"
									  style="vertical-align: middle; margin-right: 6px;"></span>
				<span>{{ trans('flow.questions.1-2.button-text') }}</span>
			</label>

			<input type="text" name="step[1][2]" v-model="user_data.birthdate" id="birthdate-picker" data-model="birthdate"
				   style="display: none;"/>
		</div>

		<template v-if="temp_age">
			<br/>
			<button v-on:click="nextStep();" type="button"
					class="button button--rounded button--medium button--green">{!! trans('flow.questions.1-2.button-submit-text') !!}</button>
		</template>

		<p class="substep-explanation">{{ trans('flow.questions.1-2.text') }}</p>
	</div>

	<div data-sub-step="3" class="sub_step">
		<h3 class="substep-title">{{ trans('flow.questions.1-3.title') }}</h3>
		<div class="can-scroll visible-xs"><span class="icon icon-canscroll"></span></div>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[1][3]" value="1" v-model="user_data.skin" data-model="skin"
					   v-on:click="nextStep();"/>
				<span class="icon icon-skin-white"></span>
				<br/>{{ trans('flow.questions.1-3.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[1][3]" value="2" v-model="user_data.skin" data-model="skin"
					   v-on:click="nextStep();"/>
				<span class="icon icon-skin-mediterranean"></span>
				<br/>{{ trans('flow.questions.1-3.options.2') }}
			</label>
			<label>
				<input type="radio" name="step[1][3]" value="3" v-model="user_data.skin" data-model="skin"
					   v-on:click="nextStep();"/>
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
				<input type="radio" name="step[1][4]" value="1" v-model="user_data.outside" data-model="outside"
					   v-on:click="nextStep();"/>
				<span class="icon icon-sun-yes"></span>
				<br/>{{ trans('flow.questions.1-4.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[1][4]" value="2" v-model="user_data.outside" data-model="outside"
					   v-on:click="nextStep();"/>
				<span class="icon icon-sun-no"></span>
				<br/>{{ trans('flow.questions.1-4.options.2') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.1-4.text') }}</p>
	</div>
</div>