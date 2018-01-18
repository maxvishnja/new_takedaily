<div class="col-md-5">
	<div class="card">
		<table class="order_table">
			<tbody>
			<tr v-for="item in totals">
				<td>
					<span v-show="!item.showPrice" style="margin-right: 30px"></span>
					@{{ item.name }}
				</td>
				<td>
					<span v-show="!item.showPrice">-</span>
					<span v-show="item.showPrice">
						<span v-show="item.price !== 0 && discount.type != 'fixed'">{{ trans('general.money-vue', ['amount' => 'item.price']) }}</span>
						<span v-show="item.price !== 0 && discount.type == 'fixed'">{{ trans('general.money-vue', ['amount' => 'total']) }}</span>
						<span v-show="item.price === 0">{{ trans('products.free_shipping') }}</span>
					</span>
				</td>
			</tr>
			<tr v-show="discount.applied">
				<td>@{{ discount.code }}</td>
				<td>
					<div v-show="discount.type == 'amount'">-{{ trans('general.money-vue', ['amount' => 'total_discount']) }}</div>
					<div v-show="discount.type == 'percentage'">-@{{ total_discount }}</div>
					<div v-show="discount.type == 'free_shipping'">-100%</div>
					<div v-show="discount.type == 'fixed'">{{ trans('general.money-vue', ['amount' => 'total_discount']) }} x @{{ total_month }} {{ trans('general.month')}}</div>
				</td>
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
		@if(Auth::check())
			<div class="text-center">
				<button type="button"
						class="button button--green button--huge button--full-mobile m-t-30" onclick="forceUpdateAndSubmit();">{{ trans('flow.button-save-text') }}</button>
			</div>
		@endif
		<div class="text-center">
			@if(!$giftcard)
				{{--<div class="m-t-20 m-b-20">--}}
				{{--<a href="#coupon-field"--}}
				{{--id="toggle-coupon-form">{{ trans('checkout.index.coupon.link') }}</a>--}}
				{{--</div>--}}
				@if(!Auth::check() )
				<div id="coupon-field"  class="m-t-20">
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
			@endif
			@endif
			<button type="submit" onclick="updateNewVitamin();" class="button @if(!Auth::check() ) button--green @else  button--light  @endif button--huge button--full-mobile m-t-10">{{ trans('flow.button-order-text') }}</button>


		</div>
	</div>
	<div class="card card--no-style">
		<div class="m-b-40">
			{!! trans('checkout.index.disclaimer') !!}
		</div>
		@include('includes.promo')
	</div>
</div>