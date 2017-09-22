@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Snoozing mails</h3>
        </div>

        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0"
                   class="datatable-1 table table-bordered table-striped	display" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Send</th>
                    <th>Open</th>

                </tr>
                </thead>
                <tbody>
                @foreach($snoozing as $snooz)
                    <tr>
                        <td>
                            {{ $snooz->id }}
                        </td>
                        <td>
                            <a href="{{ URL::action('Dashboard\CustomerController@show', [ 'id' => $snooz->customer_id ]) }}">{{ $snooz->customer_id }}</a>
                        </td>
                        <td>{{ $snooz->email }}</td>
                        <td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $snooz->created_at)->format('j. M Y H:i') }}</td>
                        <td>
                            @if($snooz->open)
                                {{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $snooz->open)->format('j. M Y H:i') }}
                            @else
                                Not open
                            @endif
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
                        "targets": [2, 3],
                        "searchable": true
                    }
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