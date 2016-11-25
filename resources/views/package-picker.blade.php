@extends('layouts.app')

@section('pageClass', 'page-package-pick')

@section('mainClasses', 'm-b-50')

@section('title', trans('pick-package.title'))

@section('content')
	<div class="header_image">
		<div class="container text-center">
			<h1>{{ trans('pick-package.title') }}</h1>
			<h2>{{ trans('pick-package.sub-title') }}</h2>
		</div>
	</div>

	<div class="container m-t-30" id="app">
		<div v-cloak="" class="packages">
			<div v-for="package in packages" class="package">
				<strong v-html="package.name"></strong>

				<div class="promise_icons">
					<span v-for="icon in package.icons" v-bind:class="'icon icon-' + icon + '-flow'"></span>
				</div>

				<div v-html="package.description"></div>

				<div class="package_bottom">
					<a v-bind:href="'{{ url()->route('pick-package-select', ['id' => '']) }}/' + package.id" class="button button--green">{{ trans('pick-package.select-btn') }}</a>
				</div>
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
					description: "{{ nl2br(trans("pick-package.packages.{$package->identifier}.description")) }}",
					id: parseInt("{{ $package->id }}"),
					icons: [
						@if(is_array(trans("pick-package.packages.{$package->identifier}.icons")))
							@foreach(trans("pick-package.packages.{$package->identifier}.icons") as $icon)
								"{{ $icon }}",
							@endforeach
						@endif
					]
				}, @endforeach]
			}
		});
	</script>
@endsection