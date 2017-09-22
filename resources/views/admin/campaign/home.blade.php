@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Campaign</h3>
        </div>

        <div class="module-option clearfix">
            <div class="pull-right">
                <a href="{{ URL::action('Dashboard\CampaignController@create') }}" class="btn btn-primary">Opret ny</a>
            </div>
        </div>

        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	display" width="100%">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Partner name</th>
                    <th>Text</th>
                    <th>Country</th>
                    <th>Created at</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($campaigns as $campaign)
                    <tr>
                        <td>{{ $campaign->id }}</td>
                        <td>{{ $campaign->partner_name }}</td>
                        <td>{{ $campaign->description }}</td>
                        <td>
                            @if($campaign->country == 'da')
                               Denmark
                            @else
                                Netherlands
                            @endif
                        </td>
                        <td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $campaign->created_at)->format('j. M Y H:i') }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-info" href="{{ URL::action('Dashboard\CampaignController@edit', [ 'id' => $campaign->id ]) }}"><i class="icon-pencil"></i>
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