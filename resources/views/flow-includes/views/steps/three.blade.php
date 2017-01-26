<div data-step="3" class="step">
	<div data-sub-step="1" class="sub_step sub_step--active" >
		<h3 class="substep-title">{{ trans('flow.questions.3-1.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[3][1]" value="1" v-model="user_data.foods.vegetables" data-model="foods.vegetables"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-1');"/>
				<span class="icon icon-portion-vegetables-1"></span>
				<br/>{{ trans('flow.questions.3-1.options.1') }}</label>
			<label>
				<input type="radio" name="step[3][1]" value="2" v-model="user_data.foods.vegetables" data-model="foods.vegetables"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-1');"/>
				<span class="icon icon-portion-vegetables-2"></span>
				<br/>{{ trans('flow.questions.3-1.options.2') }}</label>
			<label>
				<input type="radio" name="step[3][1]" value="3" v-model="user_data.foods.vegetables" data-model="foods.vegetables"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-1');"/>
				<span class="icon icon-portion-vegetables-3"></span>
				<br/>{{ trans('flow.questions.3-1.options.3') }}</label>
			<label>
				<input type="radio" name="step[3][1]" value="4" v-model="user_data.foods.vegetables" data-model="foods.vegetables"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-1');"/>
				<span class="icon icon-portion-vegetables-4"></span>
				<br/>{{ trans('flow.questions.3-1.options.4') }}</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.3-1.text') }}</p>
	</div>

	<div data-sub-step="2" class="sub_step">
		<h3 class="substep-title">{{ trans('flow.questions.3-2.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" data-model="foods.fruits" value="1"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-2');"/>
				<span class="icon icon-portion-fruit-1"></span>
				<br/>{{ trans('flow.questions.3-2.options.1') }}</label>
			<label>
				<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" data-model="foods.fruits" value="2"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-2');"/>
				<span class="icon icon-portion-fruit-2"></span>
				<br/>{{ trans('flow.questions.3-2.options.2') }}</label>
			<label>
				<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" data-model="foods.fruits" value="3"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-2');"/>
				<span class="icon icon-portion-fruit-3"></span>
				<br/>{{ trans('flow.questions.3-2.options.3') }}</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.3-2.text') }}</p>
	</div>

	<div data-sub-step="3" class="sub_step">
		<h3 class="substep-title">{{ trans('flow.questions.3-3.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[3][3]" value="1" v-model="user_data.foods.bread" data-model="foods.bread"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-3');"/>
				<span class="icon icon-portion-bread-1"></span>
				<br/>{{ trans('flow.questions.3-3.options.1') }}</label>
			<label>
				<input type="radio" name="step[3][3]" value="2" v-model="user_data.foods.bread" data-model="foods.bread"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-3');"/>
				<span class="icon icon-portion-bread-2"></span>
				<br/>{{ trans('flow.questions.3-3.options.2') }}</label>
			<label>
				<input type="radio" name="step[3][3]" value="3" v-model="user_data.foods.bread" data-model="foods.bread"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-3');"/>
				<span class="icon icon-portion-bread-3"></span>
				<br/>{{ trans('flow.questions.3-3.options.3') }}</label>
			@if(trans('flow.questions.3-3.options.4') != '' && trans('flow.questions.3-3.options.4') != 'flow.questions.3-3.options.4')
			<label>
				<input type="radio" name="step[3][3]" value="4" v-model="user_data.foods.bread" data-model="foods.bread"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-3');"/>
				<span class="icon icon-portion-bread-4"></span>
				<br/>{{ trans('flow.questions.3-3.options.4') }}</label>
			@endif
			@if(trans('flow.questions.3-3.options.5') != '' && trans('flow.questions.3-3.options.5') != 'flow.questions.3-3.options.5')
			<label>
				<input type="radio" name="step[3][3]" value="5" v-model="user_data.foods.bread" data-model="foods.bread"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-3');"/>
				<span class="icon icon-portion-bread-5"></span>
				<br/>{{ trans('flow.questions.3-3.options.5') }}</label>
			@endif
		</div>

		<p class="substep-explanation">{!! trans('flow.questions.3-3.text') !!}</p>
	</div>

	<div data-sub-step="4" class="sub_step">
		<h3 class="substep-title">{{ trans('flow.questions.3-4.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[3][4]" value="2" v-model="user_data.foods.butter" data-model="foods.butter"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-4');"/>
				<span class="icon icon-portion-butter-no"></span>
				<br/>{{ trans('flow.questions.3-4.options.2') }}
			</label>
			<label>
				<input type="radio" name="step[3][4]" value="3" v-model="user_data.foods.butter" data-model="foods.butter"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-4');"/>
				<span class="icon icon-portion-butter-sometimes"></span>
				<br/>{{ trans('flow.questions.3-4.options.3') }}
			</label>
			<label>
				<input type="radio" name="step[3][4]" value="1" v-model="user_data.foods.butter" data-model="foods.butter"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-4');"/>
				<span class="icon icon-portion-butter-yes"></span>
				<br/>{{ trans('flow.questions.3-4.options.1') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.3-4.text') }}</p>
	</div>

	<div data-sub-step="5" class="sub_step">
		<h3 class="substep-title">{{ trans('flow.questions.3-5.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[3][5]" value="1" v-model="user_data.foods.wheat" data-model="foods.wheat"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-5');"/>
				<span class="icon icon-portion-pasta-1"></span>
				<br/>{{ trans('flow.questions.3-5.options.1') }}</label>
			<label>
				<input type="radio" name="step[3][5]" value="2" v-model="user_data.foods.wheat" data-model="foods.wheat"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-5');"/>
				<span class="icon icon-portion-pasta-2"></span>
				<br/>{{ trans('flow.questions.3-5.options.2') }}</label>
			<label>
				<input type="radio" name="step[3][5]" value="3" v-model="user_data.foods.wheat" data-model="foods.wheat"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-5');"/>
				<span class="icon icon-portion-pasta-3"></span>
				<br/>{{ trans('flow.questions.3-5.options.3') }}</label>
			<label>
				<input type="radio" name="step[3][5]" value="4" v-model="user_data.foods.wheat" data-model="foods.wheat"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-5');"/>
				<span class="icon icon-portion-pasta-4"></span>
				<br/>{{ trans('flow.questions.3-5.options.4') }}</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.3-5.text') }}</p>
	</div>

	<div data-sub-step="6" class="sub_step"
		 v-bind:class="{'sub_step--skip': user_data.vegetarian == 1 }">
		<h3 class="substep-title">{{ trans('flow.questions.3-6.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[3][6]" value="1" v-model="user_data.foods.meat" data-model="foods.meat"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-6');"/>
				<span class="icon icon-portion-meat-1"></span>
				<br/>{{ trans('flow.questions.3-6.options.1') }}</label>
			<label>
				<input type="radio" name="step[3][6]" value="2" v-model="user_data.foods.meat" data-model="foods.meat"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-6');"/>
				<span class="icon icon-portion-meat-2"></span>
				<br/>{{ trans('flow.questions.3-6.options.2') }}</label>
			<label>
				<input type="radio" name="step[3][6]" value="3" v-model="user_data.foods.meat" data-model="foods.meat"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-6');"/>
				<span class="icon icon-portion-meat-3"></span>
				<br/>{{ trans('flow.questions.3-6.options.3') }}</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.3-6.text') }}</p>
	</div>

	<div data-sub-step="7" class="sub_step"
		 v-bind:class="{'sub_step--skip': user_data.vegetarian == 1 }">
		<h3 class="substep-title">{{ trans('flow.questions.3-7.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[3][7]" value="1" v-model="user_data.foods.fish" data-model="foods.fish"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-7');"/>
				<span class="icon icon-portion-fish-1"></span>
				<br/>{{ trans('flow.questions.3-7.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[3][7]" value="2" v-model="user_data.foods.fish" data-model="foods.fish"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-7');"/>
				<span class="icon icon-portion-fish-2"></span>
				<br/>{{ trans('flow.questions.3-7.options.2') }}
			</label>
			<label>
				<input type="radio" name="step[3][7]" value="3" v-model="user_data.foods.fish" data-model="foods.fish"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-7');"/>
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
				<input type="radio" name="step[3][8]" value="1" v-model="user_data.foods.dairy" data-model="foods.dairy"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-8');"/>
				<span class="icon icon-portion-milk-1"></span>
				<br/>{{ trans('flow.questions.3-8.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[3][8]" value="2" v-model="user_data.foods.dairy" data-model="foods.dairy"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-8');"/>
				<span class="icon icon-portion-milk-2"></span>
				<br/>{{ trans('flow.questions.3-8.options.2') }}
			</label>
			<label>
				<input type="radio" name="step[3][8]" value="3" v-model="user_data.foods.dairy" data-model="foods.dairy"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-8');"/>
				<span class="icon icon-portion-milk-3"></span>
				<br/>{{ trans('flow.questions.3-8.options.3') }}
			</label>
			@if(trans('flow.questions.3-8.options.4') != '' && trans('flow.questions.3-8.options.4') != 'flow.questions.3-8.options.4')
				<label>
					<input type="radio" name="step[3][8]" value="4" v-model="user_data.foods.dairy" data-model="foods.dairy"
						   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.3-8');"/>
					<span class="icon icon-portion-milk-4"></span>
					<br/>{{ trans('flow.questions.3-8.options.4') }}
				</label>
			@endif
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.3-8.text') }}</p>
	</div>
</div>