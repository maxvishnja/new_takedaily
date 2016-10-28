@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Opkald</h3>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>Tlf. nummer</th>
					<th>Ønsket periode</th>
					<th>Oprettet d.</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($calls as $call)
					<tr>
						<td><a href="tel:{{ $call->phone }}">{{ $call->phone }}</a></td>
						<td>{{ $call->call_at }} {{ $call->period }}</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $call->created_at)->format('j. M Y H:i') }}</td>
						<td>
							@if($call->status == 'requested' )
								<div class="btn-group">
									<a class="btn btn-default" href="{{ URL::action('Dashboard\CallController@markDone', [ 'id' => $call->id ]) }}"><i class="icon-check"></i>
										Marker som færdig</a>
								</div>
							@else
								Der er blevet ringet.
							@endif
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
						"targets": [3],
						"sortable": false,
						"searchable": false
					}
				],
				"aaSorting": [[0, 'desc']]
			});
			$('.dataTables_paginate').addClass('btn-group datatable-pagination');
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		}
	</script>
@endsection