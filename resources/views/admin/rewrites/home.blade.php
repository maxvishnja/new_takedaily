@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Omdirigeringer</h3>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>Original url</th>
					<th>Nyt url</th>
					<th>Type</th>
					<th>Oprettet d.</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($rewrites as $rewrite)
					<tr>
						<td>{{ $rewrite->requested_path }}</td>
						<td>{{ $rewrite->actual_path }}</td>
						<td>{{ $rewrite->redirect_type }}</td>
						<td>{{ $rewrite->created_at }}</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-danger" href="{{ URL::action('Dashboard\RewriteController@remove', [ 'id' => $rewrite->id ]) }}"><i class="icon-trash"></i> Slet</a>
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
					}
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