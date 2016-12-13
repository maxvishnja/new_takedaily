@extends('layouts.app')

@section('pageClass', 'page-pick')

@section('mainClasses', 'm-b-50 m-t-50')

@section('title', trans('pick.title'))

@section('content')
	<div class="container" id="app">
		@if(Request::has('flow_token'))
			<a href="{{ url()->route('flow',['token' => Request::get('flow_token') ]) }}">{{ trans('checkout.back') }}</a>
			<div class="clear"></div>
		@endif
		<div class="col-md-9">
			<div class="row" v-cloak="">
				<div v-for="group in groups">
					<div class="clear"></div>
					<h2 class="text-center">@{{ groupTranslations[group] }}</h2>
					<div class="clear"></div>

					<div class="pick-n-mix-flex">
						<div v-for="vitamin in vitaminsInGroup(group)" class="flex-vitamin">
							<div class="new_vitamin_item" v-bind:class="{ 'faded': (vitamin.type == 'multi' && hasMultivitamin && !vitamin.isSelected) }">

								<div class="pill_section">
									<span class="icon pill-@{{ vitamin.code.toLowerCase() }}"></span>
								</div>

								<div class="content_section">
									<strong>@{{ vitamin.name }}</strong>

									<p v-html="vitamin.description"></p>
									<div v-html="vitaminPraises(vitamin)"></div>

									<div class="extra_content">
										<div class="m-t-30 m-b-10">
											<a href="javascript:void(0);" v-on:click="toggleVitamin(vitamin, $event)" class="button button--light pull-right"
											   v-show="vitamin.isSelected">{{ trans('flow-actions.remove') }} ({{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat((\App\Apricot\Checkout\ProductPriceGetter::getPrice('vitamin') * -1)) ]) }})</a>
											<a href="javascript:void(0);" v-on:click="toggleVitamin(vitamin, $event)" class="button button--green pull-right"
											   v-show="!vitamin.isSelected">{{ trans('flow-actions.select') }} (+{{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat((\App\Apricot\Checkout\ProductPriceGetter::getPrice('vitamin'))) ]) }})</a>

											<a href="javascript:void(0);" class="readMoreBtn" v-on:click="readMore(vitamin, $event);">{{ trans('flow-actions.read-more') }}</a>
											<a href="javascript:void(0);" class="readLessBtn" style="display: none;" v-on:click="readLess(vitamin, $event);">{{ trans('flow-actions.read-less') }}</a>
										</div>

										<div class="clear"></div>

										<div v-html="vitamin.extra_content" class="m-t-10 vitamin_extra_content" style="display: none"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="clear"></div>
				</div>

				<div class="clear"></div>
				<div class="hidden-xs hidden-sm">@include('includes.disclaimer')</div>
			</div>
		</div>
		<div class="col-md-3" style="margin-top: 56px;">
			<div class="cart-bubble" v-on:click="show_popup = !show_popup">
				<div class="icon icon-cart">
					<span class="cart-bubble_count">@{{ selectedVitamins.length }}</span>
				</div>
			</div>
			<aside id="sticky" v-bind:class="{'enabled': show_popup}">
				<div class="card">
					<div v-cloak="">
						<div class="cart-selection" v-for="vitamin in selectedVitamins | orderBy vitamin.id">
							<div class="cart-selection_item cart-selection_code">
								<span class="icon pill-@{{ vitamin.code.toLowerCase() }}"></span>
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
			</aside>
		</div>
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
						<?php $praises = ''; ?>
							@if(is_array(trans("flow-praises.{$vitamin->code}")))
							@foreach((array) trans("flow-praises.{$vitamin->code}") as $icon => $text)
						<?php $praises .= '<div class="promise_v_item"><span class="icon icon-' . $icon . '-flow flow-promise-icon"></span><div class="flow-promise-text">' . $text . '</div></div><div class="clear"></div>'; ?>
							@endforeach
							@endif
						name: "{!! \App\Apricot\Helpers\PillName::get($vitamin->code) !!}",
						code: "{!! $vitamin->code !!}",
						id: "{{ $vitamin->id }}",
						description: "{!! $vitamin->getInfo() !!}",
						type: "{{ $vitamin->type }}",
						extra_content: "",
						praises: "{{ ($praises) }}",
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
				}
			},
			methods: {
				vitaminPraises: function (vitamin) {
					return this.decodeHtml(vitamin.praises);
				},
				decodeHtml: function (html) {
					var txt = document.createElement("textarea");
					txt.innerHTML = html;

					return txt.value;
				},
				readMore: function (vitamin, event) {
					$(event.target).hide();
					$(event.target).parent().find('.readLessBtn').show();

					$(event.target).parent().parent().find(".vitamin_extra_content").stop().slideToggle(200);
				},
				readLess: function (vitamin, event) {
					$(event.target).hide();
					$(event.target).parent().find('.readMoreBtn').show();

					$(event.target).parent().parent().find(".vitamin_extra_content").stop().slideToggle(200);
				},
				setCart: function () {
					var vitamins = [];

					this.selectedVitamins.forEach(function (vitamin) {
						vitamins.push(vitamin.code);
					});

					$.post('/cart-pick-n-mix', {
						vitamins: vitamins
					}).done(function (response) {
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
						swal({
							title: "{{ trans('message.warning-title') }}",
							text: "{!! trans('pick.errors.too-many') !!}",
							type: "warning",
							html: true,
							allowOutsideClick: true,
							confirmButtonText: "{{ trans('popup.button-close') }}",
							confirmButtonColor: "#3AAC87",
							timer: 6000
						});

						return false;
					}

					if (this.hasMultivitamin && vitamin.type == 'multi') {
						swal({
							title: "{{ trans('message.warning-title') }}",
							text: "{!! trans('pick.errors.already-has-multi') !!}",
							type: "warning",
							html: true,
							allowOutsideClick: true,
							confirmButtonText: "{{ trans('popup.button-close') }}",
							confirmButtonColor: "#3AAC87",
							timer: 6000
						});

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
				},
				loadAllDescriptions: function () {
					this.vitamins.forEach(function (vitamin) {
						$.get('{{ url()->route('pick-n-mix-info', ['']) }}/' + vitamin.code).done(function (response) {
							vitamin.extra_content = app.decodeHtml(response);
						});
					});
				}
			}
		});

		app.setCart();
		app.loadAllDescriptions();
	</script>
	<script>
		var isSticked = false;

		$(window).on('resize load', function () {
			if ($(window).width() >= 992) {
				if (!isSticked) {
					$("#sticky").sticky({topSpacing: 109 });
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

		$("body").on('click', '.seeIngredientsBtn', function (e) {
			e.preventDefault();

			$(this).parent().parent().find('.ingredients').stop().slideToggle(200);
		});
	</script>

	<style>
		.pick-n-mix-flex {
			display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between;
		}

		.pick-n-mix-flex .flex-vitamin {
			width: 49%;
		}

		@media all and (max-width: 767px)
		{
			.pick-n-mix-flex .flex-vitamin {
				width: 100%
			}
		}
	</style>
@endsection