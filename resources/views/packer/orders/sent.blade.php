@extends('layouts.packer')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Sent orders</h3>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0"
				   class="datatable-1 table table-bordered table-striped display" width="100%">
				<thead>
				<tr>
					<th>#</th>
					<th>Status</th>
					<th>Vitamins</th>
					<th>Date</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($orders as $order)
					<tr>
						<td>
							<a href="{{ URL::action('Packer\OrderController@show', [ 'id' => $order->id ]) }}">{{ $order->getPaddedId() }}</a>
						</td>
						<td><span class="label label-{{ $order->stateToColor()  }}">{{ $order->state }}</span></td>
						<td>
							@if($order->getCustomer() && $order->getCustomer()->getPlan() && $vitamins = json_decode($order->getCustomer()->getPlan()->vitamins))
								@foreach($vitamins as $vitamin)

									{{--· {{\DB::table('ltm_translations')->where([--}}
																		{{--['group', '=', 'pill-names'],--}}
																		{{--['locale', '=', App::getLocale()],--}}
																		{{--['key', '=', strtolower(\App\Vitamin::remember(60)->find($vitamin)->code)],--}}
																	{{--])->value('value')}}--}}
									· {{ \App\Apricot\Helpers\PillName::get(strtolower(\App\Vitamin::remember(60)->find($vitamin)->code)) }}
									<br/>
								@endforeach
							@else
								No vitamins selected
							@endif
						</td>
						<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-default" target="_blank"
								   href="{{ URL::action('Packer\OrderController@print', [ 'id' => $order->id ]) }}"><i
										class="icon-download"></i>
									Print</a>
								<a class="btn btn-default"
								   href="{{ URL::action('Packer\OrderController@show', [ 'id' => $order->id ]) }}"><i
										class="icon-eye-open"></i>
									Show</a>
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
		if ($('.datatable-1').length > 0) {
			$('.datatable-1').dataTable({
				"columnDefs": [
					{
						"targets": [4],
						"sortable": false,
						"searchable": false
					},
					{
						"targets": [2, 3, 4],
						"searchable": false
					},
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