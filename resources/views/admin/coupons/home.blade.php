@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Kuponner</h3>
		</div>

		<div class="module-option clearfix">
			<div class="pull-right">
				<a href="{{ URL::action('Dashboard\CouponController@create') }}" class="btn btn-primary">Opret ny</a>
			</div>
		</div>

		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>Kode</th>
					<th>Beskrivelse</th>
					<th>Værdi</th>
					<th>Anvendelser</th>
					<th>Udløb</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($coupons as $coupon)
					<tr @if($coupon->valid_to <= date('Y-m-d')) style="color: #aaa; background: #eee;" @endif>
						<td>{{ $coupon->code }}</td>
						<td>{{ $coupon->description }}</td>
						<td>
							@if($coupon->isAmount() )
								-{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($coupon->discount, true) }} kr. på {{ $coupon->usage() }}
							@elseif($coupon->isPercentage())
								-{{ $coupon->discount }}% på {{ $coupon->usage() }}
							@else
								Gratis fragt på {{ $coupon->usage() }}
							@endif
						</td>
						<td>{{ $coupon->uses_left >= 0 ? $coupon->uses_left : '&infin;' }}</td>
						<td>{{ $coupon->valid_to == '0000-00-00' ? '-' : \Jenssegers\Date\Date::createFromFormat('Y-m-d', $coupon->valid_to)->diffForHumans(null) }}</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-info" href="{{ URL::action('Dashboard\CouponController@edit', [ 'id' => $coupon->id ]) }}"><i class="icon-pencil"></i>
									Rediger</a>
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
					},
					{
						"targets": [2,3,4],
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