@extends('layouts.packer')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Orders</h3>
		</div>

		<div class="module-body table">
			<form action="{{ URL::action('Packer\OrderController@handleMultiple') }}" method="post">
				{{ csrf_field() }}
				<div class="pull-right" style="padding: 0 10px 20px;">
					<div class="btn-group">
						<a class="btn btn-danger get-all-barcode-dk"  type="button">
							Get Barcode for DK
						</a>
						<a target="_blank" href="{{ url()->action('Packer\OrderController@printAll') }}" type="button" class="btn btn-primary print-all">
							Print all
						</a>
						{{--<a href="{{ url()->action('Packer\OrderController@shipAll') }}" type="button" class="btn btn-default">--}}
							{{--Mark all as shipped--}}
						{{--</a>--}}
					</div>
				</div>

				<div class="clear"></div>

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
								@if($order->getVitamins())
									@foreach($order->getVitamins() as $vitamin)

										{{--· {{\DB::table('ltm_translations')->where([--}}
										{{--['group', '=', 'pill-names'],--}}
										{{--['locale', '=', App::getLocale()],--}}
										{{--['key', '=', strtolower(\App\Vitamin::remember(60)->find($vitamin)->code)],--}}
										{{--])->value('value')}}--}}
										{{ \App\Apricot\Helpers\PillName::get(strtolower(\App\Vitamin::remember(60)->find($vitamin)->code)) }}
										<br/>
									@endforeach
								@else
									Not found vitamins
								@endif
							</td>
							<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
							<td>
								<div class="btn-group">
									@if($order->state == 'paid' )
										<span class="dao-request-{{$order->id}}">
											@if($order->getCustomer()->locale == 'da')
												@if($order->barcode == '')
											<a class="btn btn-danger get-barcode barcode-for-{{$order->id}}" data-id="{{$order->id}}"><i class="menu-icon icon-barcode"></i>
												Get Barcode {{$order->barcode}}</a>

											@else{
											<a class="btn btn-warning cancel-delivery cancel-delivery-for-{{$order->id}}"  data-id="{{$order->id}}" data-barcode="{{$order->barcode}}">
												Cancel delivery</a>
											}
												@endif
											@endif
										</span>
										<a class="btn btn-primary sent-{{$order->id}}" @if($order->getCustomer()->locale == 'da' and $order->barcode == '') disabled="disabled" @endif
										   href="{{ URL::action('Packer\OrderController@markSent', [ 'id' => $order->id ]) }}"><i
												class="icon-truck"></i>
											Mark sent</a>
										<a class="btn btn-default print-{{$order->id}}" @if($order->getCustomer()->locale == 'da' and $order->barcode == '') disabled="disabled" @endif target="_blank"
										   href="{{ URL::action('Packer\OrderController@print', [ 'id' => $order->id ]) }}"><i
												class="icon-download"></i>
											Print</a>
									@else
										<a class="btn btn-default"
										   href="{{ URL::action('Packer\OrderController@show', [ 'id' => $order->id ]) }}"><i
												class="icon-eye-open"></i>
											Show</a>
									@endif
								</div>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</form>
			@foreach($orders as $order)
				<form class="get-barcode-post {{$order->id}}">
					{{ csrf_field() }}
					<input type="hidden" value="{{$order->id}}" name="order_id">
				</form>
			@endforeach
		</div>
	</div><!--/.module-->
@stop

@section('scripts')
	<script>

        $('.get-all-barcode-dk').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('form').find('[name="_token"]').val()
                },
                url: '{{ route("get-all-barcode-dk") }}',
                success: function (response) {
                    if(response.message === 'OK') {
                        console.log(response);
                        window.location.reload();
                    }
                }
            });
        });

        $('.get-barcode').on('click', function (e) {
            e.preventDefault();
            var order_id = $(this).attr('data-id');
            $.ajax({
                type: 'POST',
                data: { order_id: order_id},
                headers: {
                    'X-CSRF-TOKEN': $('form.'+order_id).find('[name="_token"]').val()
                },
				url: '{{ route("barcode") }}',
                success: function (response) {
                    console.log(response);
                    if(response.message === 'Error'){
                        alert('Barcode for order ' +order_id+ ' not received - ' +response.result);
					}else{
                        $('.print-' +order_id).attr("disabled",false);
                        $('.sent-' +order_id).attr("disabled",false);
                        $('.dao-request-' + order_id).html('<a class="btn btn-warning cancel-delivery cancel-delivery-for-'+order_id+'" data-barcode="'+response.message+'" data-id="'+order_id+'">Cancel delivery</a>');
					}
                }
            });
        });

        $('body').on('click', '.cancel-delivery', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var barcode = $(this).attr('data-barcode');
            $.ajax({
                type: 'POST',
                data: { id: id, barcode: barcode},
                headers: {
                    'X-CSRF-TOKEN': $('form.'+ id).find('[name="_token"]').val()
                },
                url: '{{ route("cancel-delivery") }}',
                success: function (response) {
                    if(response.message === 'Error'){
                        alert('Delivery is not canceled');
                    }else{
                        $('body .dao-request-'+ id )
                            .html('<a class="btn btn-danger get-barcode barcode-for-'+id+'" data-id="'+id+'"><i class="menu-icon icon-barcode"></i>Get Barcode</a>');
                        }
                }
            });
        });


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