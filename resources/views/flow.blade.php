@extends('layouts.app')

@section('pageClass', 'page-flow')

@section('mainClasses', 'm-b-50')

@section('title', trans('flow.title'))

@section('content')
	@include('flow-includes.views.noscript')

	<div id="app" class="flow-container">
		@include('flow-includes.views.progress')

		<div style="position: relative">
			@include('flow-includes.views.help')

			<div class="container">
				<div class="flow-step-back" v-bind:class="{ 'clickable': step > 1 || sub_step > 1}">
					<a href="javascript: void(0);" v-on:click="previousStep();">{{ trans('flow.back') }}</a>
				</div>

				<form method="post" action="" id="flow_form">
					@include('flow-includes.views.steps.one')
					@include('flow-includes.views.steps.two')
					@include('flow-includes.views.steps.three')
					@include('flow-includes.views.steps.four')

					{{ csrf_field() }}
					<input type="hidden" name="product_name"
						   value="{{ Session::get('force_product_name', false) ? ( Session::get('product_name', 'subscription')) : 'subscription' }}"/>
				</form>
			</div>
		</div>
	</div>

	{{--@include('flow-includes.views.call-me')--}}
@endsection

@section('footer_scripts')
	@include('flow-includes.scripts.window')
	@include('flow-includes.scripts.app')
	@include('flow-includes.scripts.toggles')
	@include('flow-includes.scripts.coupon')
	@include('flow-includes.scripts.send-by-mail')
@endsection
