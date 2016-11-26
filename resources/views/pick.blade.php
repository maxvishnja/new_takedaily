@extends('layouts.app')

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
								<a href="#" v-show="!vitamin.isSelected && !(vitamin.type == 'multi' && hasMultivitamin)" class="button button--green button--circular">
									<span class="icon icon-plus"></span> {{ trans('pick.select-btn') }}
								</a>

								<a href="#" v-show="vitamin.isSelected"
								   class="button button--green button--circular button--grey">
									<span class="icon icon-cross-16"></span> {{ trans('pick.deselect-btn') }}
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

						<form action="" method="post">
							<div class="pick-n-mix-total" v-show="numSelectedVitamins > 0">{{ trans('general.money-vue', ['amount' => 'total_sum']) }}</div>
							<button type="submit" v-show="numSelectedVitamins > 0" v-bind:class="{ 'button--disabled': !hasSelectedEnoughVitamins }"
									class="button button--circular button--green button--large button--full m-t-20">
								@if( !$isCustomer )
									{{ trans('pick.btn-order')}}
								@else
									{{ trans('pick.btn-save') }}
								@endif
							</button>

							<input type="hidden" value="@{{ vitamin.id }}" name="vitamins[]" v-for="vitamin in selectedVitamins"/>

							{{ csrf_field() }}
						</form>

						<div v-show="!hasSelectedEnoughVitamins" v-bind:class="{ 'm-t-10': numSelectedVitamins > 0 }" class="text-center notice">
							{!! trans('pick.min-vitamins') !!}
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
				maxVitamins: 4,
				minVitamins: 2,
				totals: [],
				groupTranslations: {
					@foreach(trans('pick.groups') as $key => $group)
					"{{ $key }}": "{{ $group }}",
					@endforeach
				},
				vitamins: [
						@foreach($vitamins as $vitamin)
					{
						name: "{!! \App\Apricot\Helpers\PillName::get($vitamin->code) !!}",
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
					return this.selectedVitamins.length;
				},
				numOils: function () {
					return this.selectedVitamins.filter(function (vitamin) {
						return vitamin.type == "oil";
					}).length;
				},
				hasMultivitamin: function () {
					return this.selectedVitamins.filter(function (vitamin) {
						return vitamin.type == "multi";
					}).length >= 1;
				},
				total_sum: function () {
					var sum = 0;

					$.each(this.totals, function (i, line) {
						sum += line.price;
					});

					sum = sum > 0 ? sum : 0;
					sum = sum <= parseFloat("{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Apricot\Checkout\ProductPriceGetter::getPrice('subscription') - \App\Apricot\Checkout\ProductPriceGetter::getPrice('vitamin')) }}") ? parseFloat("{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Apricot\Checkout\ProductPriceGetter::getPrice('subscription') - \App\Apricot\Checkout\ProductPriceGetter::getPrice('vitamin')) }}") : sum;

					return sum;
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
			},
			methods: {
				setCart: function() {
					var vitamins = [];

					this.selectedVitamins.forEach(function(vitamin)
					{
						vitamins.push(vitamin.code);
					});

					$.post('/cart-pick-n-mix', {
						vitamins: vitamins
					}).done(function(response) {
						app.getCart();
					});
				},
				getCart: function () {
					$.get('/cart').done(function (response) {
						app.totals = [];

						$.each(response.lines, function (i, line) {
							app.totals.push({
								name: line.name,
								price: line.amount,
								showPrice: line.hidePrice === undefined
							});
						});

						if (response.coupon !== undefined && response.coupon.applied !== undefined) {
							app.discount.applied = response.coupon.applied;
							app.discount.type = response.coupon.type;
							app.discount.amount = response.coupon.amount;
							app.discount.applies_to = response.coupon.applies_to;
							app.discount.description = response.coupon.description;
							app.discount.code = response.coupon.code;
						}

						if (response.giftcard !== undefined && response.giftcard.worth !== undefined) {
							app.totals.push({
								name: "{!! trans('checkout.index.total.giftcard') !!}",
								price: parseFloat(response.giftcard.worth) * -1,
								showPrice: true
							})
						}
					});
				},
				removeVitamin: function (vitamin, event) {
					event.preventDefault();

					vitamin.isSelected = false;

					this.setCart();
				},
				addVitamin: function (vitamin, event) {
					event.preventDefault();

					if (this.hasSelectedMaxVitamins) {
						alert('{!! trans('pick.errors.too-many') !!}');

						return false;
					}

					if(this.hasMultivitamin && vitamin.type == 'multi')
					{
						alert('{!! trans('pick.errors.already-has-multi') !!}');

						return false;
					}

					vitamin.isSelected = true;

					this.setCart();
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
				}
			}
		});

		app.setCart();
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