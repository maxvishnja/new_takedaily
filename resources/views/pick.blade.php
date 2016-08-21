@extends('layouts.app')

{{-- todo translate --}}

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
			<aside>
				<div class="card">
					<div v-cloak="">
						<div v-show="!hasSelectedEnoughVitamins">
							Du mangler at vælge mindst @{{ minVitamins - numSelectedVitamins }} vitaminer.
						</div>

						<div class="cart-selection" v-for="vitamin in selectedVitamins" style="display: table-row">
							<div style="display: table-cell; padding: 5px">
								<span class="icon pill-@{{ vitamin.code }}"></span>
							</div>

							<div style="display: table-cell; padding: 5px">
								@{{ vitamin.name }}
							</div>

							<div style="display: table-cell; padding: 5px">
								<a href="#" style="display: inline-block"
								   v-on:click="removeVitamin(vitamin, $event)"><span
										class="icon icon-cross-16-gray"></span></a>
							</div>
						</div>

						<div class="cart-selection cart-selection--empty" v-for="n in (minVitamins - Math.min(3, numSelectedVitamins))">
							<div style="display: table-cell; padding: 5px">
								&nbsp;&nbsp;&nbsp;
							</div>

							<div style="display: table-cell; padding: 5px">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</div>
						</div>

						<div v-show="hasSelectedEnoughVitamins">
							GO!
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
@endsection