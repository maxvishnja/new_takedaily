@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Kunde (#{{ $customer->id }}) @if($customer->ambas == 1)(is Ambassador)@endif</h3>
		</div>

		<div class="module-body">
			<div class="pull-right">
				<a class="btn btn-default" onclick="javascript:history.back();">Back</a>
				<a class="btn btn-info" href="{{ URL::action('Dashboard\CustomerController@edit', [ 'id' => $customer->id ]) }}"><i class="icon-pencil"></i>
					Rediger</a>

				<a class="btn btn-warning" href="{{ URL::action('Dashboard\CustomerController@newPass', [ 'id' => $customer->id ]) }}" onclick="return confirm('Er du sikker på at du vil sende en ny adgangskode til brugeren? Den nuværende adgangskode bliver ugyldig.');"><i class="icon-key"></i>
					Send ny adgangskode</a>

				@if( $customer->plan && $customer->plan->isActive() )
					<a class="btn btn-success" href="{{ URL::action('Dashboard\CustomerController@repeat', [ 'id' => $customer->id ]) }}" onclick="return confirm('Er du sikker på at du vil oprette en ny ordre?');"><i class="icon-truck"></i>
						Resend order</a>
					<a class="btn btn-success" href="{{ URL::action('Dashboard\CustomerController@bill', [ 'id' => $customer->id ]) }}" onclick="return confirm('Er du sikker på at du vil trække penge og oprette en ny ordre?');"><i class="icon-credit-card"></i>
						Træk penge
						({{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($customer->plan->price, true) }} kr.)</a>
					<a class="btn btn-danger opsig" href="#"><i class="icon-remove"></i>
						Opsig</a>
				@endif

				<a class="btn btn-danger" href="{{ URL::action('Dashboard\CustomerController@destroy', [ 'id' => $customer->id ]) }}" onclick="return confirm('Er du sikker på at du ønsker at opsige kundens abonnent?');"><i class="icon-remove"></i>
					Delete</a>

			</div>
			<div class="clear"></div>
			<hr/>
			@if( $customer->plan->getReasonCancel())
				<h5>Unsubscribe reason: {{ $customer->plan->getReasonCancel() }}</h5>
				<hr/>
			@endif

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
					<td>Gender</td>
					<td>{{ ((string) $customer->getCustomerAttribute('user_data.gender', '1') === '1') ? 'Male' : 'Female' }}<br/></td>
				</tr>

				@if($customer->ambas == 1)
					<tr>
						<td>New customers in this month</td>
						<td>{{ $newusers }}</td>
					</tr>
					<tr>
						<td>All new customers from this customers</td>
						<td>{{ $allnewusers }}</td>
					</tr>
				@endif

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

				<tr>
					<td>Betalingsmetode</td>
					<td>{{ $customer->plan->getPaymentMethod() }}</td>
				</tr>

				@if( $customer->plan->isActive() )
					<tr>
						<td>Next re-bill/shipment date</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getRebillAt())->format('j. M Y H:i') }}
							({{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getRebillAt())->diffForHumans() }}
							)
						</td>
					</tr>
					<tr>
						<td>Next delivery date</td>
						<td>{{  \Jenssegers\Date\Date::createFromFormat('Y-m-d', $customer->plan->getNextDelivery())->format('j. M Y') }}

						</td>
					</tr>
				@else
					<tr>
						<td>Canceled date</td>
						<td>{{  \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getSubscriptionCancelledAt())->format('j. M Y') }}

						</td>
					</tr>

				@endif
				<tr>
					<td>Nutritionist</td>
					<td>
						@if($nutritionist)
							{{ $nutritionist->last_name}} {{ $nutritionist->first_name}}
						@endif
					</td>
				</tr>
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


			@if(count($customer->getNotes())>0)
				<h3>Note</h3>
				<table class="table table-striped">
					<thead>
					<tr>
					<tr>
						<th>#</th>
						<th>Author</th>
						<th>Note</th>
						<th>Date</th>
					</tr>
					</thead>
					<tbody>
					@foreach($customer->getNotes() as $note)
						<tr>
							<td>
								{{ $note->id }}
							</td>
							<td>{{ $note->getAuthor() }}</td>
							<td>{!! $note->note  !!} </td>
							<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d', $note->date)->format('j. M Y H:i') }}</td>

						</tr>
					@endforeach
					</tbody>
				</table>
			@endif

				<div class="clearfix"></div>
				<br/>

				<div style="display: none" class="add-note">
						<form method="post" action="{{ URL::action('Dashboard\CustomerController@addNote', [ 'id' => $customer->id ]) }}" class="form-horizontal row-fluid">
							<div class="control-group">
								<label for="code" class="control-label">Author </label>
								<div class="controls">
									<input type="text" class="form-control span8" name="author" id="code" value="" placeholder="(ex. Marie or Kirsten)"/>
								</div>
							</div>


							<div class="control-group">
								<label for="page_title" class="control-label">Date</label>
								<div class="controls">
									<input type="text" class="form-control span8 datepicker" name="date" id="birthdate-picker"
										   value=""
										   placeholder="Date"/>
								</div>
							</div>

							<div class="control-group">
								<label for="description" class="control-label">Note</label>
								<div class="controls">
									<textarea name="note" id="note" class="form-control span8" rows="5" placeholder=""></textarea>


								</div>
							</div>
							<div class="control-group">
								<div class="controls clearfix">
									<button type="submit" class="btn btn-primary btn-large pull-left">Add</button>
								</div>
							</div>
							{{ csrf_field() }}
						</form>
						<br/>
				</div>


				<div class="text-center" style="text-align: center">
					<a class="btn btn-info adds" href="#">
						Show note form</a>
				</div>

		</div>
	</div><!--/.module-->
	<div class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Reason for unsubscribing</h4>
				</div>
				<form action="{{ URL::action('Dashboard\CustomerController@cancel') }}" id="form" method="post">
				<div class="modal-body">
						<div  id="other_reason" class="m-t-15 m-b-15">
							<input type="hidden" name="id" value="{{$customer->id }}">
							<input style="width: 99%; height: 50px;" required type="text" name="reason" placeholder="Text input here" class="input input--regular input--full m-t-10">
						</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Unsubcribe</button>
				</div>
					{{csrf_field()}}
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@stop
@section('scripts')
	<script>
		$(function() {

			$(".opsig").click(function (e) {
				e.preventDefault();
				$('.modal').modal('show');

			});






			$('.adds').on('click', function(e){
				e.preventDefault();
				$('.add-note').toggle(500);
			});
			CKEDITOR.replace('note', {
				height: 300,
				language: "en",
				filebrowserImageUploadUrl: '/dashboard/upload/image'
			});

			$('.datepicker').datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
	</script>
@endsection