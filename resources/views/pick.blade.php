@extends('layouts.app')

{{-- todo translate --}}

@section('pageClass', 'page-pick')

@section('mainClasses', 'm-b-50 m-t-50')

@section('title', trans('pick.title'))

@section('content')
	<style>
		.cart-bubble {
			display: none;
		}
		@media all and (max-width: 991px) {
			.cart-bubble {
				display: block;
				height: 60px;
				width: 60px;
				border-radius: 100%;
				background: #fff;
				box-shadow: 0 0 40px rgba(0, 0, 0, .25);
				z-index: 3;
				text-align: center;
				left: 50%;
				margin-left: -30px;
				bottom: 60px;
				position: fixed;
				padding: 18px;
				user-select: none;
				cursor: pointer;
				transition: box-shadow 200ms, transform 200ms;
			}

			.cart-bubble:focus,
			.cart-bubble:hover,
			.cart-bubble:active {
				transform: translateY(-5px);
				box-shadow: 0 0 50px rgba(0, 0, 0, .35);
			}

			.cart-bubble .icon.icon-cart {
				position: relative;
				margin: 0 auto;
			}

			.cart-bubble:hover + aside#sticky {
				transform: translateY(-5px);
			}

			.cart-bubble .cart-bubble_count {
				position: absolute;
				font-size: 12px;
				color: #fff;
				font-weight: 600;
				padding: 2px 0;
				text-align: center;
				line-height: 1;
				background: #555;
				border: 2px solid #fff;
				right: -7px;
				bottom: -8px;
				display: block;
				border-radius: 100%;
				height: 19px;
				width: 19px;
			}

			aside#sticky {
				display: none;
				bottom: 140px;
				z-index: 3;
				position: fixed;
				width: 90%;
				left: 5%;
				background: #FFF;
				border: 2px solid #3AAC87;
				box-shadow: 0 0 40px 0 rgba(0, 0, 0, 0.15);
				border-radius: 10px;
				padding: 20px;
				transition: transform 200ms;
			}

			aside#sticky .card {
				border: none;
				border-radius: 0;
				box-shadow: none;
				padding: 0;
			}

			aside#sticky p {
				margin-bottom: 0;
			}

			aside#sticky:after, aside#sticky:before {
				top: 100%;
				left: 50%;
				border: solid transparent;
				content: " ";
				height: 0;
				width: 0;
				position: absolute;
				pointer-events: none;
			}

			aside#sticky:after {
				border-color: rgba(255, 255, 255, 0);
				border-top-color: #fff;
				border-width: 10px;
				margin-left: -10px;
			}

			aside#sticky:before {
				border-color: rgba(58, 172, 135, 0);
				border-top-color: #3AAC87;
				border-width: 13px;
				margin-left: -13px;
			}

			aside#sticky.enabled {
				display: block;
			}
		}

		@media all and (max-height: 600px) {
			aside#sticky {
				bottom: 100px;
			}

			aside#sticky p {
				line-height: 1.2;
			}

			.cart-bubble {
				bottom: 20px;
			}
		}
	</style>

	<div class="container" id="app">
		<div class="col-md-8">
			<div class="row" v-cloak="">
				<div class="col-md-6" v-for="vitamin in vitamins">
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
							<p>@{{ vitamin.description }}</p>
						</div>
					</div>
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
						<div class="cart-selection" v-for="vitamin in selectedVitamins">
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
							<button type="submit" v-bind:class="{ 'button--disabled': !hasSelectedEnoughVitamins }"
									class="button button--circular button--green button--large button--full m-t-20">
								@if( !$isCustomer )
									Gå til bestilling
								@else
									Gem ændringer
								@endif
							</button>

							<input type="hidden" value="@{{ vitamin.id }}" name="vitamins[]" v-for="vitamin in selectedVitamins"/>

							{{ csrf_field() }}
						</form>


						<div v-show="!hasSelectedEnoughVitamins" class="m-t-10 text-center notice">
							Du mangler at vælge mindst @{{ minVitamins - numSelectedVitamins }} vitamin<span
								v-show="(minVitamins - numSelectedVitamins) > 1">er</span>.
						</div>
					</div>
				</div>
				@include('includes.disclaimer')
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
				minVitamins: 3,
				vitamins: [
						@foreach($vitamins as $vitamin)
					{
						name: "{!! $vitamin->name !!}",
						code: "{!! $vitamin->code !!}",
						id: "{{ $vitamin->id }}",
						description: "{!! $vitamin->description !!}",
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
				}
			},
			methods: {
				removeVitamin: function (vitamin, event) {
					event.preventDefault();

					vitamin.isSelected = false;
				},
				addVitamin: function (vitamin, event) {
					event.preventDefault();

					if (this.hasSelectedMaxVitamins) {
						alert('Du har valgt det maksimale antal vitaminer, fravælg en for at vælge denne.'); // todo translate


						return false;
					}

					vitamin.isSelected = true;
				},
				toggleVitamin: function (vitamin, event) {

					if(vitamin.isSelected)
					{
						this.removeVitamin(vitamin, event);
					}
					else
					{
						this.addVitamin(vitamin, event);
					}
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