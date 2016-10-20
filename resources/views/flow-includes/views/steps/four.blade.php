<div data-step="4" class="step">
	<div id="advises-loader" class="text-center">
		<div class="spinner" style="display: inline-block;">
			<div class="rect1"></div>
			<div class="rect2"></div>
			<div class="rect3"></div>
			<div class="rect4"></div>
			<div class="rect5"></div>
		</div>

		<h2>Vent venligst..</h2> {{-- todo translate --}}
		<p>Vent et øjeblik mens vi sammensætter den ideelle Takedaily pakke til
			dig</p> {{-- todo translate --}}
	</div>

	<div id="advises-block" class="text-left" style="display: none;">
		<h2>Dine anbefalinger</h2> {{-- todo translate --}}
		<button type="submit"
				class="button button--green button--large visible-xs button--full-mobile m-t-30 m-b-30">{{ trans('flow.button-order-text') }}</button>

		<div class="row">
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

						<div class="m-t-20">
							Tilføj 1000 mg premium fiskolie mere til din TakeDaily for kun 19 kr./mdr
							Tilføj 1000 mg premium chiaolie mere til din TakeDaily for kun 19 kr./mdr
							<a href="#" class="button" v-on:click="addAdditionalOil();">Tilføj</a>

							{{--<a href="#" v-on:click="moreInfo('fishoil', $event);">Hvad er fiskeolie?</a>--}}
							{{--<a href="#" v-on:click="moreInfo('chiaoil', $event);">Hvad er chiaolie?</a>--}}
						</div>{{-- todo double up --}}
					</div>
					<div id="advises-content" class="tab-block"></div>
				</div>

				<p>Ønsker du at ændre dine vitaminer? <a href="/pick-n-mix" id="link-to-change">Tryk
						her</a></p>

				@include('includes.disclaimer')
			</div>
			<div class="col-md-5">
				<div class="card">
					<table class="order_table">
						<tbody>
						<tr>
							<td>{{ trans("products." . (Session::get('force_product_name', false) ? ( Session::get('product_name', 'subscription')) : 'subscription')) }}</td>
							<td>{{ trans('general.money-vue', ['amount' => 'sub_price']) }}</td>
						</tr>
						@if($product->is_subscription == 1)
							<tr>
								<td>{{ trans('checkout.index.total.shipping') }}</td>
								<td>
													<span
														v-show="shipping == 0">{{ trans('checkout.index.total.free') }}</span>
									<span
										v-show="shipping > 0">{{ trans('general.money-vue', ['amount' => 'shipping']) }}</span>
								</td>
							</tr>
						@endif
						@if($giftcard)
							<tr>
								<td>{{ trans('checkout.index.total.giftcard	') }}</td>
								<td>{{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($giftcard->worth, true, 2, '.')]) }}</td>
							</tr>
						@endif
						<tr v-show="discount.applied">
							<td>@{{ discount.code }}: @{{ discount.description }}</td>
							<td>-{{ trans('general.money-vue', ['amount' => 'total_discount']) }}</td>
						</tr>
						<tr v-show="giftcard">
							<td>@{{ discount.code }}: @{{ discount.description }}</td>
							<td>-{{ trans('general.money-vue', ['amount' => 'total_discount']) }}</td>
						</tr>
						<tr>
							<td>{{ trans('checkout.index.total.taxes') }}</td>
							<td>{{ trans('general.money-vue', ['amount' => 'total_taxes']) }}</td>
						</tr>
						<tr class="row--total">
							<td>{{ trans('checkout.index.total.total') }}</td>
							<td>{{ trans('general.money-vue', ['amount' => 'total']) }}</td>
						</tr>
						</tbody>
					</table>

					<button type="submit"
							class="button button--green button--huge button--full-mobile m-t-30">{{ trans('flow.button-order-text') }}</button>

					<div class="m-t-20 m-b-20">
						<a href="#coupon-field"
						   id="toggle-coupon-form">{{ trans('checkout.index.coupon.link') }}</a>
					</div>

					<div id="coupon-field" style="display: none;" class="m-t-20">
						<!-- todo make the coupon part work -->
						<div class="row">
							<div class="col-md-8">
								<input type="text" id="coupon-input" maxlength="20"
									   placeholder="{{ trans('checkout.index.coupon.input-placeholder') }}"
									   class="input input--regular input--uppercase input--spacing input--full input--semibold"
									   value="{{ Request::old('coupon', Session::get('applied_coupon')) }}"/>
							</div>

							<div class="col-md-4">
								<button type="button"
										class="button button--regular button--green button--full"
										id="coupon-button">{{ trans('checkout.index.coupon.button-text') }}</button>
							</div>
						</div>

						<div id="coupon-form-successes" class="m-t-10"></div>
						<div id="coupon-form-errors" class="m-t-10"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="m-b-20 m-t-20">
			<button type="button" class="link-button" id="send-by-mail-button">Send et link til mine
				anbefalinger
			</button>{{-- todo translate --}}
		</div>
	</div>

	<textarea name="user_data" id="user_data_field" type="hidden"
			  style="display: none;">@{{ $data.user_data | json }}</textarea>
</div>