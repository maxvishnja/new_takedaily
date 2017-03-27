@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Payment Errors</h3>
        </div>

        <div class="module-option clearfix">
            <div class="pull-right">

            </div>
        </div>

        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Payment</th>
                    <th>Type</th>
                    <th>Text</th>
                    <th>Check</th>
                    <th>Created</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($perrors as $perror)
                    <tr @if($perror->check == 0) style="font-weight: bold; color: red" @endif>
                        <td>{{ $perror->id }}</td>
                        <td>{{ $perror->payment }}</td>
                        <td>{{ $perror->type }}</td>
                        <td>{{ $perror->errors }}</td>
                        <td>
                            @if($perror->check == 0)
                                     No
                            @else
                                    Yes
                            @endif
                        </td>
                        <td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $perror->created_at)->format('j. M Y H:i') }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-info" href="{{ URL::action('Dashboard\PaymentsErrorController@check', [ 'id' => $perror->id ]) }}"><i class="icon-pencil"></i>
                                    Check</a>
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