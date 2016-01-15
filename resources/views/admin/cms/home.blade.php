@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Sider</h3>
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
					<th>Url</th>
					<th>Titel</th>
					<th>Oprettet d.</th>
					<th>Opdateret d.</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($pages as $page)
					<tr>
						<td>{{ $page->id }}</td>
						<td>/{{ $page->url_identifier }}@if($page->url_identifier == 'home')
								<span class="badge badge-info small">Forsiden</span> @endif</td>
						<td>{{ $page->title }}</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $page->created_at)->format('j. M Y H:i') }}</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $page->updated_at)->format('j. M Y H:i') }}</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-info" href="{{ URL::action('Dashboard\PageController@edit', [ 'id' => $page->id ]) }}"><i class="icon-pencil"></i>
									Rediger</a>
								<a class="btn btn-default" href="/@if($page->url_identifier != 'home'){{ $page->url_identifier }}@endif" target="_blank"><i class="icon-eye-open"></i>
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
				"columnDefs": [
					{
						"targets": [5],
						"sortable": false,
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