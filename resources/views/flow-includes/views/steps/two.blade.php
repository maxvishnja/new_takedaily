<div data-step="2" class="step">
	<div data-sub-step="1" class="sub_step sub_step--active" v-bind:class="{ 'sub_step--skip': temp_age > 50 || user_data.gender == 1 }">
		<h3 class="substep-title">{{ trans('flow.questions.2-1.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[2][1]" value="1" v-model="user_data.pregnant" data-model="pregnant"
					   v-on:click="nextStep();"/>
				<span class="icon icon-pregnant-yes"></span>
				<br/>{{ trans('flow.questions.2-1.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[2][1]" value="2" v-model="user_data.pregnant" data-model="pregnant"
					   v-on:click="nextStep();"/>
				<span class="icon icon-pregnant-no"></span>
				<br/>{{ trans('flow.questions.2-1.options.2') }}
			</label>
		</div>

		<p class="substep-explanation">{!! trans('flow.questions.2-1.text') !!}</p>
	</div>

	<div data-sub-step="2" class="sub_step" v-bind:class="{'sub_step--skip': user_data.pregnant == 1}">
		<h3 class="substep-title">{{ trans('flow.questions.2-2.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[2][2]" value="1" v-model="user_data.diet" data-model="diet"
					   v-on:click="nextStep();"/>
				<span class="icon icon-diet-pear"></span>
				<br/>{{ trans('flow.questions.2-2.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[2][2]" value="2" v-model="user_data.diet" data-model="diet"
					   v-on:click="nextStep();"/>
				<span class="icon icon-diet-burger"></span>
				<br/>{{ trans('flow.questions.2-2.options.2') }}
			</label>
		</div>
		<p class="substep-explanation">{{ trans('flow.questions.2-2.text') }}</p>
	</div>

	<div data-sub-step="3" class="sub_step" v-bind:class="{'sub_step--skip': user_data.pregnant == 1}">
		<h3 class="substep-title">{{ trans('flow.questions.2-3.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[2][3]" value="1" v-model="user_data.sports" data-model="sports"
					   v-on:click="nextStep();"/>
				<span class="icon icon-activity-seldom"></span>
				<br/>{{ trans('flow.questions.2-3.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[2][3]" value="2" v-model="user_data.sports" data-model="sports"
					   v-on:click="nextStep();"/>
				<span class="icon icon-activity-once"></span>
				<br/>{{ trans('flow.questions.2-3.options.2') }}
			</label>
			<label>
				<input type="radio" name="step[2][3]" value="3" v-model="user_data.sports" data-model="sports"
					   v-on:click="nextStep();"/>
				<span class="icon icon-activity-twice"></span>
				<br/>{{ trans('flow.questions.2-3.options.3') }}
			</label>
			<label>
				<input type="radio" name="step[2][3]" value="4" v-model="user_data.sports" data-model="sports"
					   v-on:click="nextStep();"/>
				<span class="icon icon-activity-more"></span>
				<br/>{{ trans('flow.questions.2-3.options.4') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.2-3.text') }}</p>
	</div>

	<div data-sub-step="4" class="sub_step" v-bind:class="{'sub_step--skip': user_data.pregnant == 1}">
		<h3 class="substep-title">{{ trans('flow.questions.2-4.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[2][4]" value="1" v-model="user_data.stressed" data-model="stressed"
					   v-on:click="nextStep();"/>
				<span class="icon icon-stress"></span>
				<br/>{{ trans('flow.questions.2-4.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[2][4]" value="2" v-model="user_data.stressed" data-model="stressed"
					   v-on:click="nextStep();"/>
				<span class="icon icon-joy"></span>
				<br/>{{ trans('flow.questions.2-4.options.2') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.2-4.text') }}</p>
	</div>

	<div data-sub-step="5" class="sub_step" v-bind:class="{'sub_step--skip': user_data.pregnant == 1}">
		<h3 class="substep-title">{{ trans('flow.questions.2-5.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[2][5]" value="1" v-model="user_data.lacks_energy" data-model="lacks_energy"
					   v-on:click="nextStep();"/>
				<span class="icon icon-tired"></span>
				<br/>{{ trans('flow.questions.2-5.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[2][5]" value="2" v-model="user_data.lacks_energy" data-model="lacks_energy"
					   v-on:click="nextStep();"/>
				<span class="icon icon-awake"></span>
				<br/>{{ trans('flow.questions.2-5.options.2') }}
			</label>
			@if(Lang::has('flow.questions.2-5.options.3', App::getLocale(), false) && trans('flow.questions.2-5.options.3') !== 'flow.questions.2-5.options.3' && trans('flow.questions.2-5.options.3') !== '')
				<label>
					<input type="radio" name="step[2][5]" value="3" v-model="user_data.lacks_energy" data-model="lacks_energy"
						   v-on:click="nextStep();"/>
					<span class="icon icon-fresh"></span>
					<br/>{{ trans('flow.questions.2-5.options.3') }}
				</label>
			@endif
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.2-5.text') }}</p>
	</div>

	<div data-sub-step="6" class="sub_step" v-bind:class="{'sub_step--skip': user_data.pregnant == 1}">
		<h3 class="substep-title">{{ trans('flow.questions.2-6.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[2][6]" value="1" v-model="user_data.immune_system" data-model="immune_system"
					   v-on:click="nextStep();"/>
				<span class="icon icon-immune-boost"></span>
				<br/>{{ trans('flow.questions.2-6.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[2][6]" value="2" v-model="user_data.immune_system" data-model="immune_system"
					   v-on:click="nextStep();"/>
				<span class="icon icon-immune-moderate"></span>
				<br/>{{ trans('flow.questions.2-6.options.2') }}
			</label>
			@if(Lang::has('flow.questions.2-6.options.3', App::getLocale(), false) && trans('flow.questions.2-6.options.3') !== 'flow.questions.2-6.options.3' && trans('flow.questions.2-6.options.3') !== '')
				<label>
					<input type="radio" name="step[2][6]" value="3" v-model="user_data.immune_system" data-model="immune_system"
						   v-on:click="nextStep();"/>
					<span class="icon icon-immune-ignore"></span>
					<br/>{{ trans('flow.questions.2-6.options.3') }}
				</label>
			@endif
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.2-6.text') }}
		</p>
	</div>

	<div data-sub-step="7" class="sub_step" v-bind:class="{'sub_step--skip': user_data.pregnant == 1}">
		<h3 class="substep-title">{{ trans('flow.questions.2-7.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[2][7]" value="1" v-model="user_data.smokes" data-model="smokes"
					   v-on:click="nextStep();"/>
				<span class="icon icon-smoke"></span>
				<br/>{{ trans('flow.questions.2-7.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[2][7]" value="2" v-model="user_data.smokes" data-model="smokes"
					   v-on:click="nextStep();"/>
				<span class="icon icon-smoke-no"></span>
				<br/>{{ trans('flow.questions.2-7.options.2') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.2-7.text') }}</p>
	</div>

	<div data-sub-step="8" class="sub_step sub_step--active" v-bind:class="{ 'sub_step--skip': user_data.pregnant != 1 }">
		<h3 class="substep-title">{{ trans('flow.questions.2-8.title') }}</h3>
		<div class="sub_step_answers">
			<label class="text-center flow_label_noclick">
				<span>{{ trans('flow.questions.2-8.button-text') }}</span><br/>
				<select name="step[2][8]" data-model="pregnancy.week" data-default="0" v-on:change="nextStep();" v-model="user_data.pregnancy.week"
						class="select select--full m-t-10">
					<option value="0">{{ trans('flow.questions.2-8.pick-one') }}</option>
					@foreach(range(1,40) as $week)
						<option value="{{ $week }}">{{ trans('flow.questions.2-8.select') }} {{ $week }}</option>
					@endforeach
				</select>
			</label>
			<label>
				<input type="radio" name="step[2][8]" value="1" v-model="user_data.pregnancy.wish" data-model="pregnancy.wish"
					   v-on:click="nextStep();"/>
				<span class="icon icon-pregnant-yes"></span>
				<span class="icon icon-pregnant-no"></span>
				<br/>{{ trans('flow.questions.2-8.i-have-a-wish') }}
			</label>
		</div>

		<p class="substep-explanation">{!! trans('flow.questions.2-8.text') !!}</p>
	</div>

	<div data-sub-step="9" class="sub_step" v-bind:class="{'sub_step--skip': user_data.pregnant == 1}">
		<h3 class="substep-title">{{ trans('flow.questions.2-10.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[2][10]" value="1" v-model="user_data.joints" data-model="joints"
					   v-on:click="nextStep();"/>
				<span class="icon icon-joint-yes"></span>
				<br/>{{ trans('flow.questions.2-10.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[2][10]" value="2" v-model="user_data.joints" data-model="joints"
					   v-on:click="nextStep();"/>
				<span class="icon icon-joint-no"></span>
				<br/>{{ trans('flow.questions.2-10.options.2') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.2-10.text') }}</p>
	</div>

	<div data-sub-step="10" class="sub_step">
		<h3 class="substep-title">{{ trans('flow.questions.2-9.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[2][9]" value="1" v-model="user_data.vegetarian" data-model="vegetarian"
					   v-on:click="nextStep();"/>
				<span class="icon icon-vegetarian-yes"></span>
				<br/>{{ trans('flow.questions.2-9.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[2][9]" value="2" v-model="user_data.vegetarian" data-model="vegetarian"
					   v-on:click="nextStep();"/>
				<span class="icon icon-meat"></span>
				<br/>{{ trans('flow.questions.2-9.options.2') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.2-9.text') }}</p>
	</div>
</div>