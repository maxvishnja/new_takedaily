@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            @if( ! isset( $campaign ) )
                <h3>Add new campaign</h3>
            @else
                <h3>Edit campaign: {{ $campaign->partner_name }} ({{ $campaign->id }})</h3>
            @endif
        </div>

        <div class="module-body">

            <form method="POST" class="form-horizontal row-fluid" action="{{ isset( $campaign ) ? URL::action('Dashboard\CampaignController@update', [ $campaign->id ]) : URL::action('Dashboard\CampaignController@store') }}">
                <div class="clear"></div>

                <div class="control-group">
                    <label for="code" class="control-label">Partner name (use for URL)</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="partner_name" id="code" value="{{ Request::old('partner_name', isset($campaign) ? $campaign->partner_name : '' ) }}" placeholder="Partner name (example.: best_partner)"/>
                    </div>
                </div>


                <div class="control-group">
                    <label for="description" class="control-label">Country</label>
                    <div class="controls">
                        <select name="country" id="type">
                            @foreach(['da'=>'Denmark', 'nl'=> 'Netherlands'] as $key=>$value)
                                <option value="{{ $key }}" @if(isset($campaign) && $campaign->country == $key) selected="selected" @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="description" class="control-label">Description</label>
                    <div class="controls">
                        <textarea name="description" id="description" class="form-control span8" rows="5" placeholder="This will be shown on the top!">{!! Request::old('description', isset($campaign) ? $campaign->description : '' ) !!}</textarea>


                    </div>
                </div>




                <div class="control-group">
                    <div class="controls clearfix">
                        <a href="{{ URL::action('Dashboard\CampaignController@index') }}" class="btn btn-default pull-right">Annuller</a>
                        <button type="submit" class="btn btn-primary btn-large pull-left">@if(isset($campaign)) Save @else
                                Create @endif</button>
                    </div>
                </div>
                {{ csrf_field() }}

                @if(isset($campaign))
                    {{ method_field('PUT') }}
                @endif
            </form>
        </div>
    </div><!--/.module-->
    @if( isset($campaign) )
        <div>
            <form method="POST" action="{{ URL::action('Dashboard\CampaignController@destroy', [ $campaign->id ]) }}" onsubmit="return confirm('Are you sure?');">
                <button type="submit" class="btn btn-link">Delete campaign</button>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>
        </div>
    @endif
@stop

@section('scripts')
    <script>
        $(function() {
            $( ".datepicker" ).datepicker({
                dateFormat: "yy-mm-dd"
            });

            CKEDITOR.replace('description', {
                height: 300,
                language: "en",
                filebrowserImageUploadUrl: '/dashboard/upload/image'
            });
        });
    </script>
@endsection