@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Indstillinger</h3>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>Indstilling</th>
					<th>Værdi</th>
				</tr>
				</thead>
				<tbody>
				@foreach($settings as $setting)
					<tr>
						<td><label for="input_{{ $setting->identifier }}">{{ $setting->identifier }}</label></td>
						<td><textarea class="span5" rows="3" name="{{ $setting->id }}" id="input_{{ $setting->identifier }}" cols="30" rows="10" placeholder="{{ $setting->value }}">{{ $setting->value }}</textarea></td>
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
				]
			});
			$('.dataTables_paginate').addClass('btn-group datatable-pagination');
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		}
	</script>
@endsection