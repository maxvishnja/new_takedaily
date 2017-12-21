@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Actions</h3>
        </div>

        <div class="module-option clearfix">
            <div class="pull-right">
                <a href="{{ URL::action('Dashboard\ActionsController@create') }}" class="btn btn-primary">Add new</a>
            </div>
        </div>

        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>Price DK</th>
                    <th>Price NL</th>
                    <th>Month</th>
                    <th>Active</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if(isset($actions) and !empty($actions))
                    @foreach($actions as $action)
                        <tr>
                            <td>{{$action->title}}</td>
                            <td>{{$action->price_da}} DKK</td>
                            <td>{{$action->price_da}} EUR</td>
                            <td>{{$action->month}}</td>
                            <td>
                                @if($action->active == 1)
                                 Active
                                @else
                                 Not active
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info" href="{{ URL::action('Dashboard\ActionsController@edit', [ 'id' => $action->id ]) }}"><i class="icon-pencil"></i>
                                        Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
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
                        "targets": [1],
                        "sortable": false,
                        "searchable": false
                    }
                ],
                "aaSorting": [[0, 'desc']]
            });
            $('.dataTables_paginate').addClass('btn-group datatable-pagination');
            $('.dataTables_paginate > a').wrapInner('<span />');
            $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
            $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
        }
    </script>
@endsection