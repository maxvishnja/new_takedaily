@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Kunde (#{{ $customer->id }})</h3>
		</div>

		<div class="module-body">
			<div class="pull-right">
				{{--<a class="btn btn-info" href="{{ URL::action('Dashboard\CustomerController@edit', [ 'id' => $customer->id ]) }}"><i class="icon-pencil"></i>
					Rediger</a>--}}

				<a class="btn btn-warning" href="{{ URL::action('Dashboard\CustomerController@newPass', [ 'id' => $customer->id ]) }}" onclick="return confirm('Er du sikker på at du vil sende en ny adgangskode til brugeren? Den nuværende adgangskode bliver ugyldig.');"><i class="icon-key"></i>
					Send ny adgangskode</a>

				@if( $customer->plan->isActive() )
					<a class="btn btn-success" href="{{ URL::action('Dashboard\CustomerController@bill', [ 'id' => $customer->id ]) }}" onclick="return confirm('Er du sikker på at du vil trække penge og oprette en ny ordre?');"><i class="icon-credit-card"></i>
						Træk penge
						({{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($customer->plan->price, true) }} kr.)</a>

					<a class="btn btn-danger" href="{{ URL::action('Dashboard\CustomerController@cancel', [ 'id' => $customer->id ]) }}" onclick="return confirm('Er du sikker på at du ønsker at opsige kundens abonnent?');"><i class="icon-remove"></i>
						Opsig</a>
				@endif
			</div>

			<div class="clear"></div>
			<hr/>

			<table class="table table-striped">
				<tbody>
				<tr>
					<td>Id</td>
					<td>{{ $customer->id }}</td>
				</tr>

				<tr>
					<td>Navn</td>
					<td>{{ $customer->getName() }}</td>
				</tr>

				<tr>
					<td>E-mail</td>
					<td><a href="mailto:{{ $customer->getEmail() }}">{{ $customer->getEmail() }}</a></td>
				</tr>

				<tr>
					<td>Køn</td>
					<td>{{ $customer->gender }}</td>
				</tr>

				@if($customer->hasBirthday())
					<tr>
						<td>Fødselsdag</td>
						<td>{{ $customer->getBirthday() }} ({{ $customer->getAge() }} år)</td>
					</tr>
				@endif

				<tr>
					<td>Antal ordre</td>
					<td>{{ $customer->getOrderCount() }}</td>
				</tr>

				<tr>
					<td>Abonnent aktivt</td>
					<td>{{ $customer->plan->isActive() ? 'Ja' : 'Nej' }}</td>
				</tr>

				@if( $customer->plan->isActive() )
					<tr>
						<td>Næste ordre/trækning</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getRebillAt())->format('j. M Y H:i') }}
							({{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getRebillAt())->diffForHumans() }}
							)
						</td>
					</tr>
				@endif

				@foreach($customer->customerAttributes as $attribute)
					<tr>
						<td>{{ trans("attributes.{$attribute->identifier}") }}</td>
						<td>{{ $attribute->value }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>

			@if($customer->getOrderCount() > 0)
				<h3>Ordre</h3>
				<table class="table table-striped">
					<thead>
					<tr>
					<tr>
						<th>#</th>
						<th>Status</th>
						<th>Total</th>
						<th>Oprettet d.</th>
						<th>Opdateret d.</th>
					</tr>
					</thead>
					<tbody>
					@foreach($customer->orders as $order)
						<tr>
						<td>
							<a href="{{ URL::action('Dashboard\OrderController@show', [ 'id' => $order->id ]) }}">{{ $order->getPaddedId() }}</a>
						</td>
						<td><span class="label label-{{ $order->stateToColor()  }}">{{ $order->state }}</span></td>
						<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true) }} kr.</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->updated_at)->format('j. M Y H:i') }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</div><!--/.module-->
@stop