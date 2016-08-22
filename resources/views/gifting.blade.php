@extends('layouts.app')

@section('pageClass', 'gifting')

@section('title', 'Giv TakeDaily i gave - TakeDaily')
{{-- todo transalte --}}
@section('content')
	<div class="container text-center">
		<div class="gifting-block">
			<h1>Giv TakeDaily i gave</h1>
			<h2>Hvor mange måneder ønsker du at give?</h2>
			<form action="/checkout" id="giftingForm" method="get">
				<div class="gifting-selectors">
					<label class="gifting-selector" for="months_input_1">
						<input type="radio" name="product_name" value="giftcard_1" id="months_input_1"/>
						<strong class="gifting-price">149 kr.</strong>
						<span class="gifting-months">1 måned</span>

						<button class="button button--green button--full" type="button">Vælg gavekort</button>
					</label>

					<label class="gifting-selector" for="months_input_3">
						<input type="radio" name="product_name" value="giftcard_3" id="months_input_3"/>
						<strong class="gifting-price">447 kr.</strong>
						<span class="gifting-months">3 måneder</span>

						<button class="button button--green button--full" type="button">Vælg gavekort</button>
					</label>

					<label class="gifting-selector" for="months_input_6">
						<input type="radio" name="product_name" value="giftcard_6" id="months_input_6"/>
						<strong class="gifting-price">894 kr.</strong>
						<span class="gifting-months">6 måneder</span>

						<button class="button button--green button--full" type="button">Vælg gavekort</button>
					</label>
				</div>
			</form>
		</div>

		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 text-center"><img height="110"
																	 src="/images/gifting/step_1.png"
																	 alt="">
				<h3>1. Vælg et gavekort</h3>
				<p>Du kan vælge at give enten 1, 3 eller 6 måneders TakeDaily til en du holder af.</p>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 text-center"><img height="110"
																	 src="/images/gifting/step_2.png"
																	 alt="">
				<h3>2. Vi sender gavekortet</h3>
				<p>Du modtager gavekortet direkte på din e-mail, så der er ingen ventetid eller besvær, du har gaven
					lige med det samme.</p>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 text-center"><img height="110"
																	 src="/images/gifting/step_3.png"
																	 alt="">
				<h3>3. Giv gaven</h3>
				<p>Du printer bare gavekortet ud og giver det som gave.</p>
			</div>
		</div>
	</div>
@endsection

@section('footer_scripts')
	<script>
		$(".gifting-selector").click(function () {
			$("#giftingForm").submit();
		});
	</script>
@endsection
