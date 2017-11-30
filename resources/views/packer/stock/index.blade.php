@extends('layouts.packer')

@section('content')

	<div class="clear"></div>

	<div class="module">
		<div class="module-head">
			<h3 class="pull-left"></h3>
			<span style="margin-left: 10px;"
				  class="label pull-left label"></span>
			<div class="clear"></div>
		</div>

		<div class="module-body">
			<div class="row">
				<div class="span8">
					<h3>Stock / Inventory</h3>
				</div>
				<div class="module-option clearfix">
					<div class="pull-right">
						<a href="/packaging/stock/new" class="btn btn-primary">Add New Item</a>
					</div>
				</div>
			</div>
			<hr/>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Item</th>
						<th>Item no.</th>
						<th>Requested Quantity</th>
						<th>Current Quantity</th>
					</tr>
				</thead>

				<tbody>
				@foreach($items as $item)
					<tr>
						<td>{{ $item->name }}</td>
						<td>{{ $item->number }}</td>
						<td>{{ $item->reqQty }}</td>
						<td>{{ $item->qty }}</td>
					</tr>
				@endforeach
				</tbody>

				
			</table>
		</div>
	</div><!--/.module-->
@stop