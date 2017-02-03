@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Sold</h3>
        </div>

        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Count</th>

                </tr>
                </thead>
                <tbody>
                @foreach($vitamins as $vitamin)
                    <tr>
                        <td>
                            {{ $vitamin['name'] }}
                        </td>
                        <td>{{ $vitamin['count'] }}</td>
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
                        "targets": [0],
                        "sortable": false,
                        "searchable": true
                    }
                ],
                "aaSorting": [[1, 'desc']]
            });
            $('.dataTables_paginate').addClass('btn-group datatable-pagination');
            $('.dataTables_paginate > a').wrapInner('<span />');
            $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
            $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
        }
    </script>
@endsection