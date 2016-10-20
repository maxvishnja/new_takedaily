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

			<div class="m-t-20" v-show="user_data.double_oil == 0">
				Tilføj 1000 mg premium fiskolie mere til din TakeDaily for kun 19 kr./mdr
				Tilføj 1000 mg premium chiaolie mere til din TakeDaily for kun 19 kr./mdr
				<a href="#" class="button" v-on:click="addAdditionalOil();">Tilføj</a>

				{{--<a href="#" v-on:click="moreInfo('fishoil', $event);">Hvad er fiskeolie?</a>--}}
				{{--<a href="#" v-on:click="moreInfo('chiaoil', $event);">Hvad er chiaolie?</a>--}}
			</div>
		</div>

		<div id="advises-content" class="tab-block"></div>
	</div>

	<p>Ønsker du at ændre dine vitaminer? <a href="/pick-n-mix" id="link-to-change">Tryk
			her</a></p>

	@include('includes.disclaimer')
</div>{{-- todo translate --}}