@extends('layouts.app')

@section('pageClass', 'gifting')

@section('title', 'Giv Take Daily i gave - Take Daily')

@section('content')
	<div class="container text-center">
		<h1>Giv Take Daily i gave</h1>
		<h2>Hvor mange måneder ønsker du at give?</h2>
		<form action="/checkout" method="get">
			<div class="gifting-selectors">
				<label class="gifting-selector" for="months_input_1">
					<input type="radio" name="product_name" value="giftcard_1" id="months_input_1"/>
					<div class="gifting-selector-content">
						<strong>1 måned</strong>
						<span>149 kr.</span>
					</div>
				</label>

				<label class="gifting-selector" for="months_input_3">
					<input type="radio" name="product_name" value="giftcard_3" id="months_input_3"/>
					<div class="gifting-selector-content">
						<strong>3 måneder</strong>
						<span>447 kr.</span>
					</div>
				</label>

				<label class="gifting-selector" for="months_input_6">
					<input type="radio" name="product_name" value="giftcard_6" id="months_input_6"/>
					<div class="gifting-selector-content">
						<strong>6 måneder</strong>
						<span>894 kr.</span>
					</div>
				</label>
			</div>

			<button type="submit" class="button button--large button--rounded button--green m-t-30">Fortsæt</button>
		</form>
	</div>

	<style>
		.gifting-selectors .gifting-selector input[type="radio"] {
			display: none;
		}

		.gifting-selector {
			display:             inline-block;
			margin-right:        16px;
			-webkit-user-select: none;
			user-select:         none;
			text-align:          center;
			cursor:              pointer;
		}

		.gifting-selector:last-of-type {
			margin-right: 0;
		}

		.gifting-selector .gifting-selector-content strong {
			display:     block;
			color:       #777;
			font-size:   22px;
			font-weight: 600;
			line-height: 1.2;
		}

		.gifting-selector .gifting-selector-content span {
			display:     block;
			color:       #aaa;
			font-size:   16px;
			line-height: 1.2;
		}

		.gifting-selector .gifting-selector-content {
			border:        2px solid #777;
			border-radius: 4px;
			color:         red;
			padding:       30px 20px;
		}

		.gifting-selector:hover .gifting-selector-content {
			border-color: #555;
		}

		.gifting-selector:hover .gifting-selector-content strong {
			color: #555;
		}

		.gifting-selector:hover .gifting-selector-content span {
			color: #777;
		}

		.gifting-selector input[type="radio"]:checked ~ .gifting-selector-content {
			border-color: #17AA66;
		}

		.gifting-selector input[type="radio"]:checked ~ .gifting-selector-content strong {
			color: #11834E;
		}

		.gifting-selector input[type="radio"]:checked ~ .gifting-selector-content span {
			color: #5BBA8E;
		}
	</style>
@endsection
