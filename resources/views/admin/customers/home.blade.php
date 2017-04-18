@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Kunder</h3>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>#</th>
					<th>Navn</th>
					<th>E-mail</th>
					<th>Oprettet d.</th>
					<th>Canceled</th>
					<th>Rebill</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($customers as $customer)
					<tr>
						<td>
							<a href="{{ URL::action('Dashboard\CustomerController@show', [ 'id' => $customer->id ]) }}">{{ $customer->id }}</a>
						</td>
						<td>{{ $customer->getName() }}</td>
						<td><a href="mailto:{{ $customer->getEmail() }}">{{ $customer->getEmail() }}</a></td>
						<td>
							{{ \Date::createFromFormat('Y-m-d H:i:s', $customer->created_at)->format('Y/m/d H:i')}}
						</td>
						<td>
							@if($customer->plan->getSubscriptionCancelledAt())
							{{ \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getSubscriptionCancelledAt())->format('Y/m/d H:i') }}
							@else
								No
							@endif
						</td>
						<td>
							@if($customer->plan->getRebillAt())
							{{ \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getRebillAt())->format('Y/m/d H:i')}}
							@endif
						</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-info" href="{{ URL::action('Dashboard\CustomerController@edit', [ 'id' => $customer->id ]) }}"><i class="icon-pencil"></i>
									</a>

								<a class="btn btn-default" href="{{ URL::action('Dashboard\CustomerController@show', [ 'id' => $customer->id ]) }}"><i class="icon-eye-open"></i>
									Vis</a>
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div><!--/.module-->
@stop

@section('scripts')
	<script>
		if ($('.datatable-1').length > 0)
		{
			$('.datatable-1').dataTable({
				stateSave: true,
				"columnDefs": [
					{
						"targets": [6],
						"sortable": false,
						"searchable": false
					},
					{
						"targets": [3, 4],
						"searchable": false
					}
				],
				"aaSorting": [[3, 'desc'],[4, 'desc']]
			});
			$('.dataTables_paginate').addClass('btn-group datatable-pagination');
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		}
	</script>
@endsection