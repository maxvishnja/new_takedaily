@extends('layouts.account')

@section('pageClass', 'account page-account-home')

@section('title', trans('account.personal.title'))

@section('content')
	@if(Auth::user()->getCustomer()->hasNewRecommendations())
		{{--<div class="card m-b-50">--}}
			{{--<div class="card-body">--}}
				{{--<h2 class="card_title">{{ trans('account.settings_subscription.new-recommendation.title') }}</h2>--}}
				{{--<hr>--}}
				{{--<p>{{ trans('account.settings_subscription.new-recommendation.text') }}</p>--}}
				{{--<a href="{{ URL::action('AccountController@updateVitamins') }}"--}}
				   {{--class="button button--green button--large">{{ trans('account.settings_subscription.new-recommendation.btn') }}</a>--}}
			{{--</div>--}}
		{{--</div>--}}
	@endif

	<h1>{{ trans('account.home.header') }} - {{ trans('account.settings_subscription.plan.' . ( $plan->isActive() ? 'active' : 'cancelled' ) ) }}</h1>

	@if($customer->getPlan()->getCouponCount() > 0 and ($customer->getPlan()->getDiscountType() == 'month' or $customer->getPlan()->getDiscountType() == '' ))

		<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => 0, 'currency' => $plan->currency])]) !!}</h2>

	@elseif($customer->getPlan()->getCouponCount() > 0 and $customer->getPlan()->getDiscountType() == 'percent')

		<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal() - ($plan->getTotal() * ($customer->getPlan()->getCouponCount()/100)), true), 'currency' => $plan->currency])]) !!}</h2>
		@else
		<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true), 'currency' => $plan->currency])]) !!}</h2>
		@endif


	@if( $plan->isActive() )
		<p>{!! strip_tags(trans('account.settings_subscription.next-date', ['date' => Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y') ]), '<strong>') !!}</p>
	@endif
	<div class="m-t-10 m-b-10 m-center">
		<a href="/flow" class="button button--green">{{ trans('account.home.button-change') }}</a>
		<a href="/pick-n-mix" class="button button--green">{{ trans('account.home.button-pick-n-mix') }}</a>
		<a href="#coupon-field" class="button button--green"
		id="toggle-coupon-form">{{ trans('checkout.index.coupon.link') }}</a>
	</div>
	<div id="coupon-field" style="display: none" class="m-t-20">
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
	@foreach(Auth::user()->getCustomer()->getVitaminModels() as $vitamin)
		<div class="new_vitamin_item">

			<div class="pill_section">
				<span class="icon pill-{{ strtolower($vitamin->code) }}"></span>
			</div>

			<div class="content_section">
				<strong class="title">
					{{ \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)) }}
				</strong>
				<p>{!! $vitamin->getInfo() !!}</p>
				@if(is_array(trans("flow-praises.{$vitamin->code}")))
					@foreach((array) trans("flow-praises.{$vitamin->code}") as $icon => $text)
						<div class="promise_v_item">
							<span class="icon icon-{{ $icon }}-flow flow-promise-icon"></span>
							<div class="flow-promise-text">{{ $text }}</div>
						</div>
						<div class="clear"></div>
					@endforeach
				@endif

				<div class="extra_content">
					<div class="m-t-30 m-b-10">
						<a href="#" class="readMoreBtn">{{ trans('flow-actions.read-more') }}</a>
						<a href="#" class="readLessBtn" style="display: none">{{ trans('flow-actions.read-less') }}</a>
					</div>

					<div class="description">
						@if(trans('label-' . strtolower($vitamin->code) . '.web_description') != 'label-' . strtolower($vitamin->code) . '.web_description')
							<p>{!! nl2br(trans('label-' . strtolower($vitamin->code) . '.web_description')) !!}</p>
						@endif

						@if(trans('label-' . strtolower($vitamin->code) . '.web_advantage_list') != 'label-' . strtolower($vitamin->code) . '.web_advantage_list')
							<div class="vitamin_advantage_list">
								{!! trans('label-' . strtolower($vitamin->code) . '.web_advantage_list') !!}
							</div>
						@endif

						@if(trans('label-' . strtolower($vitamin->code) . '.foot_note_disclaimer') != 'label-' . strtolower($vitamin->code) . '.foot_note_disclaimer')
							<small class="m-t-15">
								{!! trans('label-' . strtolower($vitamin->code) . '.foot_note_disclaimer') !!}
							</small>
						@endif

						<div class="m-t-20 m-b-10"><a href="#" class="seeIngredientsBtn">{{ trans('flow-actions.see-ingredients') }}</a></div>
						<div class="ingredients">@include('flow-includes.views.vitamin_table', ['label' => strtolower($vitamin->code)])</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach



	@if($orders->count() > 0 )
		<hr>
		<h1>{{ trans('account.transactions.header') }}</h1>
		<table class="table table--full table--striped text-left table--responsive">
			<thead>
			<tr>
				<th>#</th>
				<th>{{ trans('account.transactions.table.date') }}</th>
				<th>{{ trans('account.transactions.table.amount') }}</th>
				<th>{{ trans('account.transactions.table.status') }}</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			@foreach($orders as $order)
				<tr>
					<td data-th="#">#{{ $order->getPaddedId() }}</td>
					<td data-th="{{ trans('account.transactions.table.date') }}">{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
					<td data-th="{{ trans('account.transactions.table.amount') }}">
						<strong>{{ trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true), 'currency' => $order->currency]) }}</strong>
					</td>
					<td data-th="{{ trans('account.transactions.table.status') }}"><span
							class="state-label state-label--{{ $order->state  }}">{{ trans("order.state.{$order->state}") }}</span></td>
					<td data-th="&nbsp;"><a href="{{URL::action('AccountController@getTransaction', [ 'id' => $order->id ]) }}"
											class="button button--small button--rounded button--grey">{{ trans('account.transactions.button-show-text') }}</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@endif
@endsection

@section('footer_scripts')
	<script>

		$('.readMoreBtn').click(function (e) {
			e.preventDefault();

			$(this).hide();
			$(this).parent().find('.readLessBtn').show();
			$(this).parent().parent().find('.description').stop().slideToggle(200);
		});

		$('.readLessBtn').click(function (e) {
			e.preventDefault();

			$(this).hide();
			$(this).parent().find('.readMoreBtn').show();
			$(this).parent().parent().find('.description').stop().slideToggle(200);
		});

		$('.seeIngredientsBtn').click(function (e) {
			e.preventDefault();

			$(this).parent().parent().find('.ingredients').stop().slideToggle(200);
		});
        $("#toggle-coupon-form").click(function (e) {
            e.preventDefault();

            $("#coupon-field").toggle();
        });
        $("#coupon-button").click(function () {
            var button = $(this);

            $.ajax({
                url: "{{ URL::action('AccountController@applyCoupon') }}",
                method: "POST",
                data: {"coupon": $("#coupon-input").val()},
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                beforeSend: function () {
                    button.text('{{ trans('flow.coupon.wait') }}').prop('disabled', true);
                },
                complete: function () {
                    button.text('{{ trans('flow.coupon.apply') }}').prop('disabled', false);
                },
                success: function (response) {
                    $("#coupon-form-successes").text(response.message);
                    $("#coupon-form-errors").text('');
                    window.location.reload();

                },
                error: function (response) {
                    $("#coupon-form-errors").text(response.responseJSON.message);
                    $("#coupon-form-successes").text('');

                }
            });
        });

        if ($("#coupon-input").val().length > 0) {
            $("#coupon-button").click();
        }
	</script>
@endsection