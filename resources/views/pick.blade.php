@extends('layouts.app')

{{-- todo translate --}}
{{-- todo have it select current vitamins if logged in --}}
{{-- todo - and if logged in, do not have form action be checkout, but an account route to update vitamins --}}
{{-- todo - fix so that vitamins are not updated when user info is saved (maybe add a button to generate recommendations in account view) --}}

@section('pageClass', 'page-pick')

@section('mainClasses', 'm-b-50 m-t-50')

@section('title', trans('pick.title'))

@section('content')
	<div class="container" id="app">
		<div class="col-md-8">
			<div class="row" v-cloak="">
				<div class="col-md-6" v-for="vitamin in vitamins">
					<div class="vitamin-item" v-bind:class="{ 'vitamin-item--selected': vitamin.isSelected }">
						<div class="vitamin-item-action">
							<a href="#" v-on:click="addVitamin(vitamin, $event)" v-show="!vitamin.isSelected"
							   class="button button--green button--circular">
								<span class="icon icon-plus"></span> Vælg denne
							</a>

							<a href="#" v-on:click="removeVitamin(vitamin, $event)" v-show="vitamin.isSelected"
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
			<aside id="sticky">
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
								Gå til bestilling
							</button>

							<input type="hidden" value="@{{ vitamin.id }}" name="vitamins[]" v-for="vitamin in selectedVitamins" />

							{{ csrf_field() }}
						</form>


						<div v-show="!hasSelectedEnoughVitamins" class="m-t-10 text-center">
							Du mangler at vælge mindst @{{ minVitamins - numSelectedVitamins }} vitamin<span
								v-show="(minVitamins - numSelectedVitamins) > 1">er</span>.
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
				maxVitamins: 4,
				minVitamins: 3,
				vitamins: [
						@foreach($vitamins as $vitamin)
					{
						name: "{!! $vitamin->name !!}",
						code: "{!! $vitamin->code !!}",
						id: "{{ $vitamin->id }}",
						description: "{!! $vitamin->description !!}",
						isSelected: false
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