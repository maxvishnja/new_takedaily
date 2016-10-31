@extends('layouts.app')

@section('pageClass', 'page-package-pick')

@section('mainClasses', 'm-b-50 m-t-50')

@section('title', trans('pick-package.title'))

@section('content')
	<div class="container" id="app">
		<h1 class="text-center">{{ trans('pick-package.title') }}</h1>
		<div v-cloak="" class="packages">
			<div v-for="package in packages" class="package">
				<strong v-html="package.name"></strong>

				<div v-html="package.description">

				</div>

				<a v-bind:href="'{{ url()->route('pick-package-select', ['id' => '']) }}/' + package.id" class="button button--green">{{ trans('pick-package.select-btn') }}</a>
			</div>
		</div>
	</div>
@endsection

@section('footer_scripts')
	<script>
		var app = new Vue({
			el: '#app',
			data: {
				packages: [@foreach($packages as $package) {
					name: "{{ trans("pick-package.packages.{$package->identifier}.name") }}",
					description: "{{ trans("pick-package.packages.{$package->identifier}.description") }}",
					id: parseInt("{{ $package->id }}")
				}, @endforeach]
			}
		});
	</script>
@endsection