@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Produkter</h3>
		</div>

		<div class="module-option clearfix">
			<div class="pull-right">
				<a href="{{ URL::action('Dashboard\ProductController@create') }}" class="btn btn-primary">Opret nyt</a>
			</div>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>#</th>
					<th>Navn</th>
					<th>Normalpris</th>
					<th>Tilbudspris</th>
					<th>Oprettet d.</th>
					<th>Opdateret d.</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($products as $product)
					<tr>
						<td>{{ $product->id }}</td>
						<td>{{ $product->name }}</td>
						<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price_default, true) }} kr.</td>
						<td>@if($product->price_special){{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price_special, true) }} kr. @else - @endif</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $product->created_at)->format('j. M Y H:i') }}</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $product->updated_at)->format('j. M Y H:i') }}</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-info" href="{{ URL::action('Dashboard\ProductController@edit', [ 'id' => $product->id ]) }}"><i class="icon-pencil"></i>
									Rediger</a>

								<a class="btn btn-default" target="_blank" href="{{ URL::to('/product', [ 'slug' => $product->slug ]) }}"><i class="icon-eye-open"></i>
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
						"targets": [6],
						"sortable": false,
						"searchable": false
					},
					{
						"targets": [2,3,4,5],
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