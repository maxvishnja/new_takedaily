@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Ordre / Leverancer</h3>
		</div>

		<div class="module-option clearfix">
			<div class="pull-right">
				<a href="{{ URL::action('Dashboard\PageController@create') }}" class="btn btn-primary">Opret ny</a>
			</div>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>#</th>
					<th>Status</th>
					<th>Total</th>
					<th>Oprettet d.</th>
					<th>Opdateret d.</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($orders as $order)
					<tr>
						<td><a href="{{ URL::action('Dashboard\OrderController@show', [ 'id' => $order->id ]) }}">{{ $order->getPaddedId() }}</a></td>
						<td><span class="label label-{{ $order->stateToColor()  }}">{{ $order->state }}</span></td>
						<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true) }} kr.</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->updated_at)->format('j. M Y H:i') }}</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-info" href="{{ URL::action('Dashboard\OrderController@edit', [ 'id' => $order->id ]) }}"><i class="icon-pencil"></i>
									Rediger</a>

								@if($order->state == 'paid' )
									<a class="btn btn-default" href="{{ URL::action('Dashboard\OrderController@edit', [ 'id' => $order->id ]) }}"><i class="icon-truck"></i>
										Marker som sendt</a> <!-- todo -->
								@else
									<a class="btn btn-default" href="{{ URL::action('Dashboard\OrderController@show', [ 'id' => $order->id ]) }}"><i class="icon-eye-open"></i>
										Vis</a>
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
						"targets": [5],
						"sortable": false,
						"searchable": false
					},
					{
						"targets": [2,3,4],
						"searchable": false
					}
				]
			});
			$('.dataTables_paginate').addClass('btn-group datatable-pagination');
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		}
	</script>
@endsection