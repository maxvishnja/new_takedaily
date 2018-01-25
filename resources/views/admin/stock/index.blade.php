@extends('layouts.admin')

@section('content')

	@if(Session::has('message-success'))
		<div class="alert alert-success">
			<strong>Success! {{Session::get('message-success')}}</strong>
		</div>
	@endif

	@if(Session::has('message-fail'))
		<div class="alert alert-danger">
			<strong>Something went wrong! {{ Session::get('message-fail') }}</strong>
		</div>
	@endif

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
						<a href="/dashboard/stock/new" class="btn btn-primary">Add New Item</a>
					</div>
				</div>
			</div>
			<hr/>
			<table class="table table-striped">
				<thead>
				<tr>
					<th>Item</th>
					<th>Item no.</th>
					<th>NEW Stock</th>
					<th>Quantity</th>
					<th>Status</th>
					<th></th>
					<th></th>
				</tr>
				</thead>

				<tbody>
				@foreach($items as $item)
					<tr>
						<td>{{ $item->name }}</td>
						<td>{{ $item->number }}</td>
						<td>{{ $item->reqQty }}</td>
						<td>{{ $item->qty }}</td>
						<td>
							@if($item->status == 0)
								<span class="icon icon-ok-circle"></span>
							@elseif($item->status == 1)
								<span class="icon icon-exclamation-sign"></span>
							@endif
						</td>
						<td><a href="/dashboard/stock/edit/{{$item->id}}" class="btn btn-default">Edit</a></td>
						<td><a href="/dashboard/stock/delete/{{$item->id}}" class="btn btn-danger" onclick="return confirm('Are you sure?');">X</a></td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div><!--/.module-->
@stop

@section('scripts')
	<script>
        $(document).ready(function () {
            $('.alert').delay(3000).fadeOut();

            // check item status

        })
	</script>
@endsection