@extends('layouts.app')

{{-- todo translate --}}

@section('pageClass', 'page-pick')

@section('mainClasses', 'm-b-50 m-t-50')

@section('title', trans('pick.title'))

@section('content')
	<div class="container" id="app">
		<div class="col-md-8">
			<div class="row" v-cloak="">
				<div v-for="group in groups">
					<h2 class="text-center">@{{ groupTranslations[group] }}</h2>

					<div class="col-md-6" v-for="vitamin in vitaminsInGroup(group)">
						<div class="vitamin-item" v-on:click="toggleVitamin(vitamin, $event)" v-bind:class="{ 'vitamin-item--selected': vitamin.isSelected }">
							<div class="vitamin-item-action">
								<a href="#" v-show="!vitamin.isSelected"
								   class="button button--green button--circular">
									<span class="icon icon-plus"></span> Vælg denne
								</a>

								<a href="#" v-show="vitamin.isSelected"
								   class="button button--green button--circular button--grey">
									<span class="icon icon-cross-16"></span> Fravælg denne
								</a>
							</div>

							<div class="vitamin-item-left">
								<span class="icon pill-@{{ vitamin.code }}"></span>
							</div>

							<div class="vitamin-item-right">
								<strong>@{{ vitamin.name }}</strong>
								<p v-html="vitamin.description"></p>
							</div>
						</div>
					</div>

					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="cart-bubble" v-on:click="show_popup = !show_popup">
				<div class="icon icon-cart">
					<span class="cart-bubble_count">@{{ selectedVitamins.length }}</span>
				</div>
			</div>
			<aside id="sticky" v-bind:class="{'enabled': show_popup}">
				<div class="card">
					<div v-cloak="">
						<div class="cart-selection" v-for="vitamin in selectedVitamins | orderBy 'type'">
							<div class="cart-selection_item cart-selection_code">
								<span class="icon pill-@{{ vitamin.code }}"></span>
							</div>

							<div class="cart-selection_item cart-selection_name">
								@{{ vitamin.name }}
							</div>

							<div class="cart-selection_item cart-selection_action">
								<a href="#" style="display: inline-block"
								   v-on:click="removeVitamin(vitamin, $event)"><span
										class="icon icon-cross-16-gray"></span></a>
							</div>

							<div class="clear"></div>
						</div>

						<div v-show="numOils == 1" class="m-t-20 m-b-20 text-center">
							<a href="#" class="button button-green-border button-doubleup" v-bind:class="{ 'button-green-border--active': double_oil }"
							   v-on:click="toggleDoubleOil($event)">
								<span class="icon icon-double"></span>
								<span v-show="!double_oil">Få dobbelt op på olien</span>
								<span v-show="double_oil">Undlad dobbelt op</span>
							</a>
						</div>

						<form action="" method="post">
							{{-- todo when logged in, fix double_oil!! --}}
							<div class="pick-n-mix-total" v-show="numSelectedVitamins > 0">{{ trans('general.money-vue', ['amount' => 'cartTotal']) }}</div>
							<button type="submit" v-show="numSelectedVitamins > 0" v-bind:class="{ 'button--disabled': !hasSelectedEnoughVitamins }"
									class="button button--circular button--green button--large button--full m-t-20">
								@if( !$isCustomer )
									Gå til bestilling
								@else
									Gem ændringer
								@endif
							</button>

							<input type="hidden" value="@{{ vitamin.id }}" name="vitamins[]" v-for="vitamin in selectedVitamins"/>
							<input type="hidden" value="@{{ vitamin.id }}" name="extra_vitamins[]" v-for="vitamin in vitaminsInGroup('oil')"
								   v-if="double_oil && vitaminIsSelected(vitamin)"/>

							{{ csrf_field() }}
						</form>

						<div v-show="!hasSelectedEnoughVitamins" v-bind:class="{ 'm-t-10': numSelectedVitamins > 0 }" class="text-center notice">
							Du mangler at vælge mindst @{{ minVitamins - numSelectedVitamins }} vitamin<span
								v-show="(minVitamins - numSelectedVitamins) > 1">er</span>.
						</div>
					</div>
				</div>
				<div class="hidden-xs hidden-sm">@include('includes.disclaimer')</div>
			</aside>
		</div>
	</div>
	<div class="visible-xs visible-sm">
		<div class="container">@include('includes.disclaimer')</div>
	</div>
@endsection

@section('footer_scripts')
	<script>
		var app = new Vue({
			el: '#app',
			data: {
				show_popup: false,
				double_oil: false,
				maxVitamins: 4,
				minVitamins: 3,
				groupTranslations: {
					@foreach(trans('pick.groups') as $key => $group)
					"{{ $key }}": "{{ $group }}",
					@endforeach
				},
				vitamins: [
						@foreach($vitamins as $vitamin)
					{
						name: "{!! $vitamin->name !!}",
						code: "{!! $vitamin->code !!}",
						id: "{{ $vitamin->id }}",
						description: "{!! $vitamin->description !!}",
						type: "{{ $vitamin->type }}",
						isSelected: @if( in_array($vitamin->id, $selectedVitamins) ) true @else false @endif
					},
					@endforeach
				]
			},
			computed: {
				selectedVitamins: function () {
					return this.vitamins.filter(function (vitamin) {
						return vitamin.isSelected;
					});
				},
				hasSelectedMaxVitamins: function () {
					return this.numSelectedVitamins >= this.maxVitamins;
				},
				hasSelectedEnoughVitamins: function () {
					return this.numSelectedVitamins >= this.minVitamins;
				},
				numSelectedVitamins: function () {
					return this.selectedVitamins.length + (this.double_oil ? 1 : 0); // todo unhardcode this crap
				},
				numOils: function () {
					return this.selectedVitamins.filter(function (vitamin) {
						return vitamin.type == "oil";
					}).length;
				},
				groups: function () {
					var groups = [];

					this.vitamins.filter(function (vitamin) {
						if (groups.indexOf(vitamin.type) === -1) {
							groups.push(vitamin.type)
						}
					});

					return groups;
				},
				cartItems: function () {
					// todo get prices from db and such
					var items = [];

					items.push({name: "subscription", price: 149});

					if (this.numSelectedVitamins > 4) {
						for (var i = 0; i < this.numSelectedVitamins - 4; i++) {
							items.push({name: "Extra vitamin", price: 19});
						}
					}

					return items;
				},
				cartTotal: function () {
					var total = 0;

					this.cartItems.filter(function (item) {
						total += item.price;
					});

					return total;
				}
			},
			methods: {
				removeVitamin: function (vitamin, event) {
					event.preventDefault();

					vitamin.isSelected = false;

					if (this.numOils == 0) {
						this.double_oil = false;
					}
				},
				addVitamin: function (vitamin, event) {
					event.preventDefault();

					if (this.hasSelectedMaxVitamins) {
						alert('Du har valgt det maksimale antal vitaminer, fravælg en for at vælge denne.'); // todo translate

						return false;
					}

					vitamin.isSelected = true;

					if (this.numOils == 2) {
						this.double_oil = false;
					}
				},
				toggleVitamin: function (vitamin, event) {

					if (vitamin.isSelected) {
						this.removeVitamin(vitamin, event);
					}
					else {
						this.addVitamin(vitamin, event);
					}
				},
				vitaminsInGroup: function (group) {
					return this.vitamins.filter(function (vitamin) {
						return vitamin.type == group;
					});
				},
				vitaminIsSelected: function (vitamin) {
					return vitamin.isSelected;
				},
				toggleDoubleOil: function (event) {
					event.preventDefault();

					this.double_oil = !this.double_oil;
				}
			}
		});
	</script>
	<script>
		var isSticked = false;

		$(window).on('resize load', function () {
			if ($(window).width() >= 992) {
				if (!isSticked) {
					$("#sticky").sticky({topSpacing: 20});
					isSticked = true;
				}
			}
			else {
				if (isSticked) {
					$("#sticky").unstick();
					isSticked = false;
				}
			}
		});
	</script>
@endsection