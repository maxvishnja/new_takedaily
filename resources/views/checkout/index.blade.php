@extends('layouts.app')

@section('pageClass', 'page-checkout')

@section('mainClasses', 'm-b-50 m-t-50')
@section('title', 'Betaling - Take Daily')

@section('content')
	<div class="container">
		<h1>Betaling</h1>

		<div class="row">
			<div class="col-md-4 col-md-push-8">

			</div><!-- /Totals-->

			<div class="col-md-8 col-md-pull-4">
				<form method="post" action="{{ URL::action('CheckoutController@postCheckout') }}">

				</form>
			</div><!-- /Form-->
		</div>
	</div>
@endsection

@section('footer_scripts')
@endsection
