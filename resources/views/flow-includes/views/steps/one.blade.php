<div data-step="1" class="step step--active">
	<div data-sub-step="1" class="sub_step sub_step--active">
		<div class="count-step">(1/7)</div>
		<h3 class="substep-title">{{ trans('flow.questions.1-1.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[1][1]" value="1" v-model="user_data.gender" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-1' );" data-model="gender"
					   v-on:click="nextStep();"/>
				<span class="icon icon-gender-male"></span>
				<br/>{{ trans('flow.questions.1-1.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[1][1]" value="2" v-model="user_data.gender" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-1' );" data-model="gender"
					   v-on:click="nextStep();"/>
				<span class="icon icon-gender-female"></span>
				<br/>{{ trans('flow.questions.1-1.options.2') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.1-1.text') }}</p>
	</div>

	<div data-sub-step="2" class="sub_step" >
		<div class="count-step">(2/7)</div>
		<h3 class="substep-title"
			v-show="user_data.gender == 1">{{ trans('flow.questions.1-2.title') }}</h3>
		<h3 class="substep-title"
			v-show="user_data.gender == 2">{{ trans('flow.questions.1-2.title-alt') }}</h3>

		<div class="datepicker-container-block">
			{{--<label for="birthdate-picker" class="text-center flow_label_noclick" id="openPicker">--}}
								{{--<span class="icon calendar-icon"--}}
									  {{--style="vertical-align: middle; margin-right: 6px;"></span>--}}
				{{--<span>{{ trans('flow.questions.1-2.button-text') }}</span>--}}
			{{--</label>--}}

			<select name="day" class="days" id="">
				<option value="">{!! trans('flow.datepicker.pick-day') !!}</option>
				@foreach(range(1,31) as $i)
					<option value="{{ $i }}">{{ $i }}</option>
				@endforeach
			</select>

			<select name="month" class="birthday month" id="">
				<option value="">{!! trans('flow.datepicker.pick-month') !!}</option>
				@foreach(trans('flow.datepicker.months_long') as $key=>$month)
					<option value="{{ $key }}">{{ $month }}</option>
				@endforeach
			</select>



			<select name="year" class="birthday years" id="">
				<option value="">{!! trans('flow.datepicker.pick-year') !!}</option>
				@foreach(range(1929,1999) as $y)
					<option value="{{ $y }}" @if($y == 1970) selected @endif>{{ $y }}</option>
				@endforeach
			</select>

			{{--<input class="birthday days" value="" name="day" id="" placeholder="{!! trans('flow.datepicker.pick-day') !!}">--}}
			{{--<input class="birthday years" value="" name="year" id="" placeholder="{!! trans('flow.datepicker.pick-year') !!}">--}}
			<input type="text" name="step[1][2]" v-model="user_data.birthdate" id="birthdate-picker"  data-model="birthdate"
				   style="display: none;"/>
		</div>

		<template v-if="temp_age">
			<br/>
			<button v-on:click="nextStep();" type="button" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-2' );"
					class="button button--rounded button--medium button--green">{!! trans('flow.questions.1-2.button-submit-text') !!}</button>
		</template>

		<p class="substep-explanation">{{ trans('flow.questions.1-2.text') }}</p>
	</div>


	<div data-sub-step="3" class="sub_step">
		<div class="count-step">(3/7)</div>
		<h3 class="substep-title">{{ trans('flow.questions.1-5.title') }}</h3>
		<div class="can-scroll visible-xs"><span class="icon icon-canscroll"></span></div>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[1][3]" value="1" v-model="user_data.relation" data-model="relation"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-3' );"/>
				<span class="icon icon-relate-single"></span>
				<br/>{{ trans('flow.questions.1-5.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[1][3]" value="2" v-model="user_data.relation" data-model="relation"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-3' );"/>
				<span class="icon icon-relate-relation"></span>
				<br/>{{ trans('flow.questions.1-5.options.2') }}
			</label>
			<label>
				<input type="radio" name="step[1][3]" value="3" v-model="user_data.relation" data-model="relation"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-3' );"/>
				<span class="icon icon-relate-family"></span>
				<br/>{{ trans('flow.questions.1-5.options.3') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.1-5.text') }}</p>
	</div>


	<div data-sub-step="4" class="sub_step">
		<div class="count-step">(4/7)</div>
		<h3 class="substep-title">{{ trans('flow.questions.1-6.title') }}</h3>
		<div class="can-scroll visible-xs"><span class="icon icon-canscroll"></span></div>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[1][4]" value="1" v-model="user_data.child" data-model="child"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-4' );"/>
				<span class="icon icon-child-no"></span>
				<br/>{{ trans('flow.questions.1-6.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[1][4]" value="2" v-model="user_data.child" data-model="child"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-4' );"/>
				<span class="icon icon-child-yes"></span>
				<br/>{{ trans('flow.questions.1-6.options.2') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.1-6.text') }}</p>
	</div>


	<div data-sub-step="5" class="sub_step" v-bind:class="{ 'sub_step--skip': user_data.child == 1 }">
		<div class="count-step">(5/7)</div>
		<h3 class="substep-title">{{ trans('flow.questions.1-7.title') }}</h3>
		<div class="can-scroll visible-xs"><span class="icon icon-canscroll"></span></div>
		<div class="sub_step_answers">
			<select name="child_count" v-model="user_data.child_count" class="child_count" id="" data-model="child_count">
				<option value="1">1</option>
				@foreach(range(2,5) as $i)
					<option value="{{ $i }}">{{ $i }}</option>
				@endforeach
			</select>
			<div class="max_heights">
				<label class="child_age_label">
					<input type="text" name="step[1][5]" class="child_age_class" v-model="user_data.child_age_1" placeholder="{{ trans('flow.questions.1-7.options') }}" data-model="child_age"/>
				</label>
				<label class="child_age_label hide"  v-bind:class="{ 'show-inline': user_data.child_count >= 2  }">
					<input type="text" name="step[1][5]" class="child_age_class" placeholder="{{ trans('flow.questions.1-7.options') }}" v-model="user_data.child_age_2" data-model="child_age"/>
				</label>
				<label class="child_age_label hide" v-bind:class="{ 'show-inline': user_data.child_count >= 3 }">
					<input type="text" name="step[1][5]" class="child_age_class" placeholder="{{ trans('flow.questions.1-7.options') }}" v-model="user_data.child_age_3" data-model="child_age"/>
				</label>
				<label class="child_age_label hide"  v-bind:class="{ 'show-inline': user_data.child_count >= 4 }">
					<input type="text" name="step[1][5]" class="child_age_class" placeholder="{{ trans('flow.questions.1-7.options') }}" v-model="user_data.child_age_4" data-model="child_age"/>
				</label>
				<label class="child_age_label hide"  v-bind:class="{ 'show-inline': user_data.child_count >= 5 }">
					<input type="text" name="step[1][5]" class="child_age_class" placeholder="{{ trans('flow.questions.1-7.options') }}" v-model="user_data.child_age_5" data-model="child_age"/>
				</label>
			</div>
		</div>
		<button v-on:click="nextStep();" type="button" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-7' );"
				class="button button--rounded button--medium button--green">{!! trans('flow.questions.1-7.button-submit-text') !!}</button>
		<p class="substep-explanation">{{ trans('flow.questions.1-7.text') }}</p>
	</div>





	<div data-sub-step="6" class="sub_step">
		<div class="count-step">(6/7)</div>
		<h3 class="substep-title">{{ trans('flow.questions.1-3.title') }}</h3>
		<div class="can-scroll visible-xs"><span class="icon icon-canscroll"></span></div>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[1][6]" value="1" v-model="user_data.skin" data-model="skin"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-6' );"/>
				<span class="icon icon-skin-white"></span>
				<br/>{{ trans('flow.questions.1-3.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[1][6]" value="2" v-model="user_data.skin" data-model="skin"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-6' );"/>
				<span class="icon icon-skin-mediterranean"></span>
				<br/>{{ trans('flow.questions.1-3.options.2') }}
			</label>
			<label>
				<input type="radio" name="step[1][6]" value="3" v-model="user_data.skin" data-model="skin"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-6' );"/>
				<span class="icon icon-skin-dark"></span>
				<br/>{{ trans('flow.questions.1-3.options.3') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.1-3.text') }}</p>
	</div>

	<div data-sub-step="7" class="sub_step">
		<div class="count-step">(7/7)</div>
		<h3 class="substep-title">{{ trans('flow.questions.1-4.title') }}</h3>
		<div class="sub_step_answers">
			<label>
				<input type="radio" name="step[1][7]" value="1" v-model="user_data.outside" data-model="outside"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-7' );"/>
				<span class="icon icon-sun-yes"></span>
				<br/>{{ trans('flow.questions.1-4.options.1') }}
			</label>
			<label>
				<input type="radio" name="step[1][7]" value="2" v-model="user_data.outside" data-model="outside"
					   v-on:click="nextStep();" onclick="ga('send', 'event', 'flow' , 'completed' , 'question.1-7' );"/>
				<span class="icon icon-sun-no"></span>
				<br/>{{ trans('flow.questions.1-4.options.2') }}
			</label>
		</div>

		<p class="substep-explanation">{{ trans('flow.questions.1-4.text') }}</p>
	</div>
</div>