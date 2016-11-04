@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>FAQ</h3>
		</div>

		<div class="module-option clearfix">
			<div class="pull-right">
				<a href="{{ URL::action('Dashboard\FaqController@create') }}" class="btn btn-primary">Add new</a>
			</div>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>Question</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($faqs as $faq)
					<tr>
						<td>{{ $faq->question }}</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-info" href="{{ URL::action('Dashboard\FaqController@edit', [ 'id' => $faq->id ]) }}"><i class="icon-pencil"></i>
									Edit</a>
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
						"targets": [1],
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