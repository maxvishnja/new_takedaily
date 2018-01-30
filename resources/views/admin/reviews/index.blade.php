@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Reviews</h3>
        </div>

        <div class="module-option clearfix">
            <div class="pull-right">
                <a href="{{ URL::action('Dashboard\ReviewsController@create') }}" class="btn btn-primary">Opret ny</a>
            </div>
        </div>

        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Review</th>
                    <th>Country</th>
                    <th>Oprettet d.</th>
                    <th>Opdateret d.</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ $review->name  }}</td>
                        <td>{{ $review->age }}</td>
                        <td>{{ $review->review }}</td>
                        <td>{{ $review->locale }}</td>
                        <td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $review->created_at)->format('j. M Y H:i') }}</td>
                        <td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $review->updated_at)->format('j. M Y H:i') }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-info" href="{{ URL::action('Dashboard\ReviewsController@edit', [ 'id' => $review->id ]) }}"><i class="icon-pencil"></i>
                                    Rediger</a>
                                <a class="btn btn-default" href="{{ URL::action('Dashboard\ReviewsController@show', [ 'id' => $review->id ]) }}">
                                    <i class="icon-eye-open"></i>Vis</a>
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
                        "targets": [3,4],
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