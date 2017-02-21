@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Feedback</h3>
        </div>

        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Text</th>
                    <th>Customer</th>
                    <th>Oprettet d.</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($feedbacks as $feedback)
                    <tr>
                        <td>
                            <a href="{{ URL::action('Dashboard\FeedbackController@show', [ 'id' => $feedback->id ]) }}">{{ $feedback->id }}</a>
                        </td>
                        <td>{{ $feedback->title }}</td>
                        <td>{{ str_limit($feedback->text, 20) }}</td>
                        <td><a href="{{ URL::action('Dashboard\CustomerController@show', [ 'id' => $feedback->getCustomer() ]) }}">{{ $feedback->getCustomer() }}</a></td>
                        <td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $feedback->created_at)->format('j. M Y H:i') }}</td>
                        <td>
                            <div class="btn-group">

                                <a class="btn btn-default" href="{{ URL::action('Dashboard\FeedbackController@show', [ 'id' => $feedback->id ]) }}"><i class="icon-eye-open"></i>
                                    Vis</a>

                                <a class="btn btn-danger" href="{{ URL::action('Dashboard\FeedbackController@destroy', [ 'id' => $feedback->id ]) }}" onclick="return confirm('Er du sikker på at du ønsker at opsige kundens abonnent?');"><i class="icon-remove"></i>
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
                        "targets": [5],
                        "sortable": false,
                        "searchable": false
                    },
                    {
                        "targets": [3, 4],
                        "searchable": false
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