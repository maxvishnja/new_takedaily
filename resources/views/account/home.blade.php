@extends('layouts.account')

@section('pageClass', 'account page-account-home')

@section('title', trans('account.home.title'))

@section('content')
	<form method="post" action="{{ URL::action('AccountController@updatePreferences') }}" id="app">
		<h3 class="m-b-10">{{ trans('flow.questions.1-1.title') }}</h3>
		<select name="[1][1]" v-model="user_data.gender" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.1-1.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.1-1.options.2') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.1-2.age') }}
			<template v-if="temp_age">(@{{ temp_age }} {{ trans('account.home.years') }})</template>
		</h3>

		<div class="datepicker-container-block">
			<input type="text" name="step[1][1]" v-model="user_data.birthdate" id="birthdate-picker" class="input input--regular input--full-mobile" placeholder="{{ trans('flow.questions.1-2.button-text') }}"/>
			<div id="datepicker-container"></div>
		</div>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.1-3.title') }}</h3>
		<select name="[1][3]" v-model="user_data.skin" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.1-3.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.1-3.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.1-3.options.3') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.1-4.title') }}</h3>
		<select name="[1][4]" v-model="user_data.outside" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.1-4.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.1-4.options.2') }}</option>
		</select>

		<div v-show="user_data.gender == 2">
			<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.2-1.title') }}</h3>
			<select name="[2][1]" v-model="user_data.pregnant" class="select select--regular select--full-mobile">
				<option value="-1">{{ trans('account.home.pick') }}</option>
				<option value="1">{{ trans('flow.questions.2-1.options.1') }}</option>
				<option value="2">{{ trans('flow.questions.2-1.options.2') }}</option>
			</select>
		</div>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.2-2.title') }}</h3>
		<select name="[2][2]" v-model="user_data.diet" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.2-2.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.2-2.options.2') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.2-3.title') }}</h3>
		<select name="[2][3]" v-model="user_data.sports" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.2-3.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.2-3.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.2-3.options.3') }}</option>
			<option value="4">{{ trans('flow.questions.2-3.options.4') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.2-4.title') }}</h3>
		<select name="[2][4]" v-model="user_data.stressed" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.2-4.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.2-4.options.2') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.2-5.title') }}</h3>
		<select name="[2][5]" v-model="user_data.lacks_energy" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.2-5.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.2-5.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.2-5.options.3') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.2-6.title') }}</h3>
		<select name="[2][6]" v-model="user_data.immune_system" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.2-6.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.2-6.options.2') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.2-7.title') }}</h3>
		<select name="[2][7]" v-model="user_data.smokes" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.2-7.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.2-7.options.2') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.2-8.title') }}</h3>
		<select name="[2][8]" v-model="user_data.vegetarian" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.2-8.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.2-8.options.2') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.2-9.title') }}</h3>
		<select name="[2][9]" v-model="user_data.joints" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.2-9.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.2-9.options.2') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.2-10.title') }}</h3>
		<select name="[2][10]" v-model="user_data.supplements" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.2-10.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.2-10.options.2') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.3-1.title') }}</h3>
		<select name="[3][1]" v-model="user_data.foods.vegetables" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.3-1.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.3-1.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.3-1.options.3') }}</option>
			<option value="4">{{ trans('flow.questions.3-1.options.4') }}</option>
			<option value="5">{{ trans('flow.questions.3-1.options.5') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.3-2.title') }}</h3>
		<select name="[3][2]" v-model="user_data.foods.fruits" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.3-2.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.3-2.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.3-2.options.3') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.3-3.title') }}</h3>
		<select name="[3][3]" v-model="user_data.foods.bread" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.3-3.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.3-3.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.3-3.options.3') }}</option>
			<option value="4">{{ trans('flow.questions.3-3.options.4') }}</option>
			<option value="5">{{ trans('flow.questions.3-3.options.5') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.3-4.title') }}</h3>
		<select name="[3][4]" v-model="user_data.foods.butter" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.3-4.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.3-4.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.3-4.options.3') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.3-5.title') }}</h3>
		<select name="[3][5]" v-model="user_data.foods.wheat" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.3-5.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.3-5.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.3-5.options.3') }}</option>
			<option value="4">{{ trans('flow.questions.3-5.options.4') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.3-6.title') }}</h3>
		<select name="[3][6]" v-model="user_data.foods.meat" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.3-6.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.3-6.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.3-6.options.3') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.3-7.title') }}</h3>
		<select name="[3][7]" v-model="user_data.foods.fish" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.3-7.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.3-7.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.3-7.options.3') }}</option>
		</select>

		<h3 class="m-t-40 m-b-10">{{ trans('flow.questions.3-8.title') }}</h3>
		<select name="[3][8]" v-model="user_data.foods.dairy" class="select select--regular select--full-mobile">
			<option value="1">{{ trans('flow.questions.3-8.options.1') }}</option>
			<option value="2">{{ trans('flow.questions.3-8.options.2') }}</option>
			<option value="3">{{ trans('flow.questions.3-8.options.3') }}</option>
		</select>

		{{ csrf_field() }}
		<textarea name="user_data" type="hidden" style="display: none;">@{{ $data.user_data | json }}</textarea>

		<div class="m-t-30">
			<button type="submit" class="button button--large button--green button--rounded">{{ trans('account.home.button-save-text') }}</button>
		</div>
	</form>
@endsection

@section('footer_scripts')
	<script type="text/javascript">
		var app = new Vue({
			el: '#app',
			data: {
				temp_age: {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.age', 18) }},
				user_data: {
					gender: {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.gender', 1) }},
					birthdate: "{{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.birthdate', 1) }}",
					age:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.age', 18) }},
					skin:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.skin', 1) }},
					outside:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.outside', 1) }},
					pregnant:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.pregnant', 1) ?: "-1" }},
					diet:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.diet', 1) }},
					sports:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.sports', 1) }},
					lacks_energy:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.lacks_energy', 1) }},
					smokes:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.smokes', 1) }},
					immune_system:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.immune_system', 1) }},
					vegetarian:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.vegetarian', 1) }},
					supplements:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.supplements', 2) }},
					joints:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.joints', 1) }},
					stressed:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.stressed', 1) }},
					foods: {
						fruits:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.foods.fruits', 1) }},
						vegetables:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.foods.vegetables', 1) }},
						bread:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.foods.bread', 1) }},
						wheat:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.foods.wheat', 1) }},
						dairy:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.foods.dairy', 1) }},
						meat:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.foods.meat', 1) }},
						fish:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.foods.fish', 1) }},
						butter:  {{ Auth::user()->getCustomer()->getCustomerAttribute('user_data.foods.butter', 1) }}
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
				}
			}
		});
	</script>
	<script>
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

		$birthdayPicker.pickadate('picker').set('select', app.user_data.birthdate, {format: 'yyyy-mm-dd'});
	</script>
@endsection