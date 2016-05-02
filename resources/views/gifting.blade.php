@extends('layouts.app')

@section('pageClass', 'gifting')

@section('title', 'Giv TakeDaily i gave - TakeDaily')
{{-- todo transalte --}}
@section('content')
	<div class="container text-center">
		<h1>Giv TakeDaily i gave</h1>
		<h2>Hvor mange måneder ønsker du at give?</h2>
		<form action="/checkout" method="get">
			<div class="gifting-selectors">
				<label class="gifting-selector" for="months_input_1">
					<input type="radio" name="product_name" value="giftcard_1" id="months_input_1"/>
					<span class="gifting-checkmark"><span class="icon icon-check-large"></span></span>
					<strong class="gifting-price">149 kr.</strong>
					<span class="gifting-months">1 måned</span>
				</label>

				<label class="gifting-selector" for="months_input_3">
					<input type="radio" name="product_name" value="giftcard_3" id="months_input_3"/>
					<span class="gifting-checkmark"><span class="icon icon-check-large"></span></span>
					<strong class="gifting-price">447 kr.</strong>
					<span class="gifting-months">3 måneder</span>
				</label>

				<label class="gifting-selector" for="months_input_6">
					<input type="radio" name="product_name" value="giftcard_6" id="months_input_6"/>
					<span class="gifting-checkmark"><span class="icon icon-check-large"></span></span>
					<strong class="gifting-price">894 kr.</strong>
					<span class="gifting-months">6 måneder</span>
				</label>
			</div>

			<button type="submit" class="button button--large button--rounded button--green m-t-30">Fortsæt</button>
		</form>
	</div>
@endsection
