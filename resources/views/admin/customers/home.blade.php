@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Kunder</h3>
			<div class="pull-right" style="margin-top: -25px;">
				<a class="btn btn-success" href="{{ URL::action('Dashboard\CustomerController@getDuplicate') }}"><i class="icon-edit"></i>
					Get Duplicate</a>
			</div>
		</div>

		<div class="module-body table">
			<div style="text-align: right;" class="search-div">
				<form class="form-inline" id="search-form" method="post" action="">
					<div class="form-group">
						<input name="find" id="search-input" class="form-control" placeholder="What search">
					</div>
					<div class="form-group">
						<button name="submit"  id='search-button' class="btn btn-success" type="submit">Search</button>
					</div>
					{{ csrf_field() }}
				</form>
			</div>


			<table cellpadding="0" cellspacing="0" border="0" class="datatable-2 table table-bordered table-striped	display" width="100%">
				<thead>
				<tr>
					<th>#</th>
					<th>Navn</th>
					<th>E-mail</th>
					<th>Oprettet d.</th>
					<th>Canceled</th>
					<th>Rebill</th>
					<th></th>
				</tr>
				</thead>
				<tbody id="results">

				@foreach($customers as $customer)

					<tr>
						<td>
							<a href="{{ URL::action('Dashboard\CustomerController@show', [ 'id' => $customer->id ]) }}">{{ $customer->id }}</a>
						</td>
						<td>{{ $customer->getName() }}</td>
						<td><a href="mailto:{{ $customer->getEmail() }}">{{ $customer->getEmail() }}</a></td>
						<td>
							{{ \Date::createFromFormat('Y-m-d H:i:s', $customer->created_at)->format('Y/m/d H:i')}}
						</td>
						<td>

							@if($customer->plan->getSubscriptionCancelledAt())
								{{ \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getSubscriptionCancelledAt())->format('Y/m/d H:i') }}
							@else
								No
							@endif
						</td>
						<td>
							@if($customer->plan->getRebillAt())
								{{ \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getRebillAt())->format('Y/m/d H:i')}}
							@endif
						</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-info" href="{{ URL::action('Dashboard\CustomerController@edit', [ 'id' => $customer->id ]) }}"><i class="icon-pencil"></i>
								</a>

								<a class="btn btn-default" href="{{ URL::action('Dashboard\CustomerController@show', [ 'id' => $customer->id ]) }}"><i class="icon-eye-open"></i>
									Vis</a>
							</div>
						</td>
					</tr>

				@endforeach
				</tbody>
			</table>
			<div style="text-align: right" id="pagination">
				{{ $customers->links() }}
			</div>
		</div>
	</div><!--/.module-->
@stop

@section('scripts')
	<script>
        if ($('.datatable-1').length > 0)
        {
            $('.datatable-1').dataTable({
                stateSave: true,
                // serverSide: true,
                "columnDefs": [
                    {
                        "targets": [6],
                        "sortable": false,
                        "searchable": false
                    },
                    {
                        "targets": [3, 4],
                        "searchable": false
                    }
                ],
                "aaSorting": [[3, 'desc'],[4, 'desc']]
            });
            $('.dataTables_paginate').addClass('btn-group datatable-pagination');
            $('.dataTables_paginate > a').wrapInner('<span />');
            $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
            $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
        }


        $('#search-button').on('click', function (e) {
            e.preventDefault();
            $('#pagination').hide();
            $.ajax({
                type: 'POST',
                data: $('form#search-form').serialize(),
                url: '{{ route("find-customer") }}',
                success: function (data) {
                    if(data && data != 0){
                        $('#results').html(data);
                    }

                }

            });
        });

	</script>
@endsection