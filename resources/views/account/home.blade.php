@extends('layouts.account')

@section('pageClass', 'account page-account-home')

@section('content')
	<form method="post" action="{{ URL::action('AccountController@updatePreferences') }}" id="app">
		<h3>Hvilket køn er du?</h3>
		<select name="[1][1]" v-model="user_data.gender" class="select select--regular">
			<option value="1">Mand</option>
			<option value="2">Kvinde</option>
		</select>

		<h3>Din fødselsdag
			<template v-if="temp_age">(@{{ temp_age }} år)</template>
		</h3>

		<div class="datepicker-container-block">
			<input type="text" name="step[1][1]" v-model="user_data.birthdate" id="birthdate-picker" class="input input--regular" placeholder="Din fødselsdagsdato"/>
			<div id="datepicker-container"></div>
		</div>

		<h3>Hvilken hudfarve er tættest på din?</h3>
		<select name="[1][3]" v-model="user_data.skin" class="select select--regular">
			<option value="1">Hvid / Lys</option>
			<option value="2">Brun / Mørk</option>
			<option value="2">Sort / Mørkere</option>
		</select>

		<h3>Er du udenfor hver dag, efter solen er stået op, og før den går ned?</h3>
		<select name="[1][4]" v-model="user_data.outside" class="select select--regular">
			<option value="1">Ja</option>
			<option value="2">Nej</option>
		</select>

		<div v-show="user_data.gender == 2">
			<h3>Er du gravid, eller drømmer du om at blive det?</h3>
			<select name="[2][1]" v-model="user_data.pregnant" class="select select--regular">
				<option value="-1">--- Vælg ---</option>
				<option value="1">Ja</option>
				<option value="2">Nej</option>
			</select>
		</div>

		<h3>Er du på slankekur?</h3>
		<select name="[2][2]" v-model="user_data.diet" class="select select--regular">
			<option value="1">Ja</option>
			<option value="2">Nej</option>
		</select>

		<h3>Hvor meget og hvor ofte motionerer du?</h3>
		<select name="[2][3]" v-model="user_data.sports" class="select select--regular">
			<option value="1">Sjældent</option>
			<option value="2">Én gang om ugen</option>
			<option value="3">To gange om ugen</option>
			<option value="4">Oftere</option>
		</select>

		<h3>Hvordan har du det, når dagen er slut?</h3>
		<select name="[2][4]" v-model="user_data.stressed" class="select select--regular">
			<option value="1">Jeg føler mig lidt stresset</option>
			<option value="2">Jeg har det fint og er naturligt træt</option>
		</select>

		<h3>Føler du dig tit træt, eller mangler du energi?</h3>
		<select name="[2][5]" v-model="user_data.lacks_energy" class="select select--regular">
			<option value="1">Hver dag</option>
			<option value="2">Af og til</option>
			<option value="3">Aldrig</option>
		</select>

		<h3>Hvordan har du det, når dagen er slut?</h3>
		<select name="[2][6]" v-model="user_data.immune_system" class="select select--regular">
			<option value="1">Ja, jeg vil gerne beskyttes bedre</option>
			<option value="2">Nej, det behøver jeg ikke</option>
		</select>

		<h3>Ryger du?</h3>
		<select name="[2][7]" v-model="user_data.smokes" class="select select--regular">
			<option value="1">Ja</option>
			<option value="2">Nej</option>
		</select>

		<h3>Spiser du som en kanin?</h3>
		<select name="[2][8]" v-model="user_data.vegetarian" class="select select--regular">
			<option value="1">Ja, jeg er vegetar</option>
			<option value="2">Nej, jeg spiser også kød og fisk</option>
		</select>

		<h3>Har du ømme muskler eller ondt i dine led?</h3>
		<select name="[2][9]" v-model="user_data.joints" class="select select--regular">
			<option value="1">Ja</option>
			<option value="2">Nej</option>
		</select>

		<h3>Tager du allerede vitaminer og/eller mineraler?</h3>
		<select name="[2][10]" v-model="user_data.supplements" class="select select--regular">
			<option value="1">Ja</option>
			<option value="2">Nej</option>
		</select>

		<h3>Hvor mange grønsager spiser du dagligt?</h3>
		<select name="[3][1]" v-model="user_data.foods.vegetables" class="select select--regular">
			<option value="1">Ingen</option>
			<option value="2">1 portion (50 gram)</option>
			<option value="3">2 portioner (100 gram)</option>
			<option value="4">3 portioner (150 gram)</option>
			<option value="5">+4 portioner (+200 gram)</option>
		</select>

		<h3>Hvor meget frugt spiser/drikker du om dagen?</h3>
		<select name="[3][2]" v-model="user_data.foods.fruits" class="select select--regular">
			<option value="1">Intet</option>
			<option value="2">1 stk. / glas</option>
			<option value="3">+2 stk. / glas</option>
		</select>

		<h3>Hvor mange skiver brød spiser du om dagen?</h3>
		<select name="[3][3]" v-model="user_data.foods.bread" class="select select--regular">
			<option value="1">Intet</option>
			<option value="2">1-2 stk.</option>
			<option value="3">3-4 stk.</option>
			<option value="4">5-6 stk.</option>
			<option value="5">+7 stk.</option>
		</select>

		<h3>Kommer du smør på brødet eller bruger du margarine, smør eller olie, når du laver mad?</h3>
		<select name="[3][4]" v-model="user_data.foods.butter" class="select select--regular">
			<option value="1">Ja</option>
			<option value="2">Nej</option>
			<option value="3">Nogle gange</option>
		</select>

		<h3>Hvor mange portioner pasta, ris, kartofler, couscous, quinoa og lignede spiser du om dagen?</h3>
		<select name="[3][5]" v-model="user_data.foods.wheat" class="select select--regular">
			<option value="1">Ingen</option>
			<option value="2">1-2 portioner (50-100 gram)</option>
			<option value="3">3-4 portioner (150-200 gram)</option>
			<option value="3">+5 portioner (+250 gram)</option>
		</select>

		<h3>Hvor meget kød spiser du om dagen?</h3>
		<select name="[3][6]" v-model="user_data.foods.meat" class="select select--regular">
			<option value="1">0-75 gram</option>
			<option value="2">76-150 gram</option>
			<option value="3">+150 gram</option>
		</select>

		<h3>Hvor ofte spiser du fisk?</h3>
		<select name="[3][7]" v-model="user_data.foods.fish" class="select select--regular">
			<option value="1">Aldrig / sjældent</option>
			<option value="2">En gang om ugen</option>
			<option value="3">To, eller flere, gange om ugen</option>
		</select>

		<h3>Hvor meget mælk drikker du om dagen?</h3>
		<select name="[3][8]" v-model="user_data.foods.dairy" class="select select--regular">
			<option value="1">Ingen</option>
			<option value="2">1-2 glas</option>
			<option value="3">+3 glas</option>
		</select>

		{{ csrf_field() }}
		<textarea name="user_data" type="hidden" style="display: none;">@{{ $data.user_data | json }}</textarea>

		<div class="m-t-30">
			<button type="submit" class="button button--large button--green button--rounded">Gem præferencer</button>
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

		$birthdayPicker.pickadate('picker').set('select', app.user_data.birthdate, {format: 'yyyy-mm-dd'});
	</script>
@endsection