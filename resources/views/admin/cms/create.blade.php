@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Opret ny side</h3>
		</div>

		<div class="module-body">
			<form method="post" action="{{ URL::action('Dashboard\PageController@store') }}" enctype="multipart/form-data">

				<div class="form-group">
					<label for="page_title">Sidens titel</label>
					<input type="text" class="form-control" name="title" id="page_title" placeholder="Sidens titel"/>
					<p class="help-block">Sidens url bliver: <mark id="page_handle_preview">/</mark></p>
				</div>

				<div class="clearfix">
					<a href="{{ URL::action('Dashboard\PageController@index') }}" class="btn btn-default pull-right">Annuller</a>
					<button type="submit" class="btn btn-primary btn-large pull-left">Opret</button>
				</div>
				{{ csrf_field() }}
			</form>
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

		$("#page_title").on('input', function()
		{
			var handle = $(this).val();
			handle = handle.trim(' ');
			handle = handle.toLowerCase();
			handle = handle.replace(/(å)/g, 'aa');
			handle = handle.replace(/(ø)/g, 'oe');
			handle = handle.replace(/(æ)/g, 'ae');
			handle = handle.replace(/\s\s+/g, ' ');
			handle = handle.replace(/( )/g, '-');
			handle = handle.replace(/([^a-z0-9-])/g, '');
			handle = handle.replace(/\-\-+/g, '-');
			handle = handle.substr(0, 50);

			$("#page_handle_preview").text('/' + handle);
		});
	</script>
@endsection