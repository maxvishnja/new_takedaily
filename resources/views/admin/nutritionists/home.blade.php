@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Nutritionists</h3>
			<div class="pull-right" style="margin-top: -25px;">
				<a class="btn btn-success" href="{{ URL::action('Dashboard\NutritionistController@create') }}"><i class="icon-plus"></i>
					Add New Nutritionist</a>
			</div>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>#</th>
					<th>Navn</th>
					<th>E-mail</th>
					<th>Active</th>
					<th></th>
				</tr>
				</thead>
				<tbody>

				@foreach($nutritionists as $nutritionist)

					<tr>
						<td>
							<a href="{{ URL::action('Dashboard\NutritionistController@show', [ 'id' => $nutritionist->id ]) }}">{{ $nutritionist->id }}</a>
						</td>
						<td>{{ $nutritionist->first_name }} {{ $nutritionist->last_name }}</td>
						<td><a href="mailto:{{ $nutritionist->email }}">{{ $nutritionist->email }}</a></td>
						<td>
							{{ \Date::createFromFormat('Y-m-d H:i:s', $nutritionist->created_at)->format('Y/m/d H:i')}}
						</td>
						<td>
							{{ \Date::createFromFormat('Y-m-d H:i:s', $nutritionist->created_at)->format('Y/m/d H:i')}}
						</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-info" href="{{ URL::action('Dashboard\NutritionistController@edit', [ 'id' => $nutritionist->id ]) }}"><i class="icon-pencil"></i>
									</a>
								<a class="btn btn-default" href="{{ URL::action('Dashboard\NutritionistController@show', [ 'id' => $nutritionist->id ]) }}"><i class="icon-eye-open"></i>
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

{{--@section('scripts')--}}
	{{--<script>--}}
		{{--if ($('.datatable-1').length > 0)--}}
		{{--{--}}
			{{--$('.datatable-1').dataTable({--}}
				{{--stateSave: true,--}}
				{{--"columnDefs": [--}}
					{{--{--}}
						{{--"targets": [6],--}}
						{{--"sortable": false,--}}
						{{--"searchable": false--}}
					{{--},--}}
					{{--{--}}
						{{--"targets": [3, 4],--}}
						{{--"searchable": false--}}
					{{--}--}}
				{{--],--}}
				{{--"aaSorting": [[3, 'desc'],[4, 'desc']]--}}
			{{--});--}}
			{{--$('.dataTables_paginate').addClass('btn-group datatable-pagination');--}}
			{{--$('.dataTables_paginate > a').wrapInner('<span />');--}}
			{{--$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');--}}
			{{--$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');--}}
		{{--}--}}
	{{--</script>--}}
{{--@endsection--}}