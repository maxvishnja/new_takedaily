@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3 style="display: inline-block">Almost customers</h3>
            <div class="pull-right" style="margin-top: -5px;">
                <a class="btn btn-success" href="{{ URL::action('Dashboard\AlmostCustomersController@sendAll') }}"><i class="icon-envelope"></i>
                    Send all mail</a>
            </div>
        </div>

        <div class="module-body table">

            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>E-mail</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Oprettet d.</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($almosts as $almost)
                    <tr>
                        <td>
                           {{ $almost->id }}
                        </td>
                        <td><b>{{ $almost->email }}</b></td>
                        <td>
                            @if($almost->email == 'nl')
                                Dutch
                            @else
                                Danish
                            @endif
                        </td>
                        <td>
                            @if($almost->sent == 0)
                                <span class="label label-important">Not send coupon</span>
                                @else
                                <span class="label label-success">Sent coupon</span>
                            @endif
                        </td>
                        <td>
                            {{ \Date::createFromFormat('Y-m-d H:i:s', $almost->created_at)->format('Y/m/d H:i')}}
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger" href="{{ URL::action('Dashboard\AlmostCustomersController@destroy', [ 'id' => $almost->id ]) }}" onclick="return confirm('Er du sikker på at du ønsker at opsige kundens abonnent?');"><i class="icon-remove"></i>
                                    Delete</a>
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
                        "targets": [3],
                        "sortable": false,
                        "searchable": false
                    },
                    {
                        "targets": [1, 3],
                        "searchable": false
                    }
                ],
                "aaSorting": [[3, 'asc'],[3, 'desc']]
            });
            $('.dataTables_paginate').addClass('btn-group datatable-pagination');
            $('.dataTables_paginate > a').wrapInner('<span />');
            $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
            $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
        }
    </script>
@endsection