<div class="col-md-5">
	<div class="card">
		@if(!Auth::check())
			<table class="order_table">
			<tbody>
			<tr v-for="item in totals" v-show="item.showPrice">
				<td>@{{ item.name }}</td>
				<td>{{ trans('general.money-vue', ['amount' => 'item.price']) }}</td>
			</tr>
			@if($giftcard)
				<tr>
					<td>{{ trans('checkout.index.total.giftcard') }}</td>
					<td>{{ trans('general.money', ['amount' => (new \App\Apricot\Helpers\Money(\App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($giftcard->worth, true, 2, '.')))->toCurrency(trans('general.currency'))]) }}</td>
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
		@else
			<button type="submit"
					class="button button--green button--huge button--full-mobile">{{ trans('flow.button-save-text') }}</button>
		@endif
	</div>

	<div class="card card--no-style m-t-20">
		@include('includes.promo')
	</div>
</div>