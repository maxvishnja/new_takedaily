@extends('layouts.packer')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Orders</h3>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>#</th>
					<th>Status</th>
					<th>Total</th>
					<th>Date</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($orders as $order)
					<tr>
						<td>
							<a href="{{ URL::action('Packer\OrderController@show', [ 'id' => $order->id ]) }}">{{ $order->getPaddedId() }}</a>
						</td>
						<td><span class="label label-{{ $order->stateToColor()  }}">{{ $order->state }}</span></td>
						<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true) }} kr.</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
						<td>
							<div class="btn-group">
								@if($order->state == 'paid' )
									<a class="btn btn-default" href="{{ URL::action('Packer\OrderController@markSent', [ 'id' => $order->id ]) }}"><i class="icon-truck"></i>
										Mark as sent</a>
									<a class="btn btn-default" href="{{ URL::action('Packer\OrderController@download', [ 'id' => $order->id ]) }}"><i class="icon-download"></i>
										Download labels</a>
								@else
									<a class="btn btn-default" href="{{ URL::action('Packer\OrderController@show', [ 'id' => $order->id ]) }}"><i class="icon-eye-open"></i>
										Show</a>
								@endif
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
				"columnDefs": [
					{
						"targets": [4],
						"sortable": false,
						"searchable": false
					},
					{
						"targets": [2, 3, 3],
						"searchable": false
					},
				],
				"aaSorting": [[3, 'desc']]
			});
			$('.dataTables_paginate').addClass('btn-group datatable-pagination');
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		}
	</script>
@endsection