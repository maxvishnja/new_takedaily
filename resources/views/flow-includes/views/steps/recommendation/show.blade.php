<div class="col-md-7">
	<div class="tabs m-b-30">
		<div class="options">
			<div data-tab="#advises-label-tab" class="tab tab-toggler tab--active">
				Supplementer
			</div>
			<div data-tab="#advises-content" class="tab tab-toggler">Beskrivelse</div>

			<div class="clear"></div>
		</div>

		<div id="advises-label-tab" class="tab-block tab-block--active">
			<div id="advises-label"></div>

			<div class="m-t-20 card" v-show="user_data.double_oil == 0">
				<div class="card_content text-center">
					<strong v-show="result.three == 'e' || result.four == 'e'">Tilføj 1000 mg premium fiskolie mere til din TakeDaily for kun 19 kr./mdr</strong>{{-- todo unhardcode --}}
					<strong v-show="result.three == 'g' || result.four == 'g'">Tilføj 1000 mg premium chiaolie mere til din TakeDaily for kun 19 kr./mdr</strong>{{-- todo unhardcode --}}

					<a href="#" class="m-t-10 button button-green-border button-doubleup" v-on:click="addAdditionalOil($event);">
						<span class="icon icon-double"></span>
						<span>Få dobbelt op på olien</span>{{-- todo translate --}}
					</a>

					{{--<a href="#" v-on:click="moreInfo('fishoil', $event);">Hvad er fiskeolie?</a>--}}
					{{--<a href="#" v-on:click="moreInfo('chiaoil', $event);">Hvad er chiaolie?</a>--}}
				</div>
			</div>
		</div>

		<div id="advises-content" class="tab-block"></div>
	</div>

	<p>Ønsker du at ændre dine vitaminer? <a href="/pick-n-mix" id="link-to-change">Tryk
			her</a></p>

	@include('includes.disclaimer')
</div>{{-- todo translate --}}