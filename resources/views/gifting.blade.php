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

	<style>
		.gifting-selectors .gifting-selector input[type="radio"] {
			display: none;
		}

		.gifting-selector {
			margin:              20px;
			display:             inline-block;
			-webkit-user-select: none;
			user-select:         none;
			text-align:          center;
			cursor:              pointer;
			text-align:          right;
			background:          transparent url(/images/giftcard-bg.png) no-repeat center center;
			position:            relative;
			width:               260px;
			height:              160px;
			border-radius:       4px;
			box-shadow:          0 0 20px rgba(0, 0, 0, .2);
			transition: box-shadow 300ms;
		}

		.gifting-selector:hover {
			z-index: 2;
			box-shadow:          0 0 50px rgba(0, 0, 0, .2);
		}

		.gifting-selector strong.gifting-price {
			width:       230px;
			display:     block;
			font-size:   36px;
			position:    relative;
			font-weight: 700;
			color:       #11834E;
			top:         15px;
			right:       15px;
			float:       right;
		}

		.gifting-selector span.gifting-months {
			width:       230px;
			display:     block;
			position:    relative;
			font-weight: normal;
			font-size:   20px;
			color:       #555555;
			top:         15px;
			right:       15px;
			float:       right;
		}

		.gifting-selector .gifting-checkmark {
			display: none;
			position: absolute;
		}

		.gifting-selector input[type="radio"]:checked ~ .gifting-checkmark {
			display: block;
			background: #333;
			border-radius: 100%;
			padding: 20px 0;
			top: 50%;
			left: 50%;
			margin-left: -35px;
			margin-top: -35px;
			width: 70px;
			height: 70px;
			z-index: 2;
			text-align: center;
			box-shadow: 0 0 0 6px #fff, 0 0 50px #fff;
		}

		@media (-webkit-min-device-pixel-ratio: 2),
		(min-resolution: 192dpi) {
			.gifting-selector {
				background-image: url(/images/giftcard-bg@2x.png);
				background-size: 260px 160px;
			}
		}
	</style>
@endsection
