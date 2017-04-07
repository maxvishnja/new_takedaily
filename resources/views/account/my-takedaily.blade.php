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
	<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true), 'currency' => $plan->currency])]) !!}</h2>

	@if( $plan->isActive() )
		<p>{!! strip_tags(trans('account.settings_subscription.next-date', ['date' => Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y') ]), '<strong>') !!}</p>
	@endif

	@foreach(Auth::user()->getCustomer()->getVitaminModels() as $vitamin)
		<div class="new_vitamin_item">

			<div class="pill_section">
				<span class="icon pill-{{ strtolower($vitamin->code) }}"></span>
			</div>

			<div class="content_section">
				<strong class="title">
					{{ $vitamin->name }}
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

	<div class="m-t-10">
		<a href="/flow" class="button button--green">{{ trans('account.home.button-change') }}</a>
		<a href="{{ url()->action('AccountController@getSeeRecommendation') }}" class="button button--green">{{ trans('account.home.button-see_recommendation') }}</a>
	</div>

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
	</script>
@endsection