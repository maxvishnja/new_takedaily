@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Indstillinger</h3>
        </div>

        <div class="module-body table">

            <table cellpadding="0" cellspacing="0" border="0" class=" table table-bordered table-striped	display"
                   width="100%">
                <tbody>
                <tr>
                    <form method="POST" class="form-horizontal row-fluid" action="{{URL::action('Dashboard\SettingController@update', [ $settings[16]->id ])}}">
                    <td><label for="input_sales">Type of sale</label>
                        <div class="controls">
                            <select name="identifier" id="input_state">
                                @foreach(['percent' => 'Percent', 'motnh' => 'Free month' ] as $key=> $value)
                                    <option @if(isset($settings[16]) && $settings[16]->identifier == $key) selected
                                            @endif value="{{$key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <label for="uses_left" class="control-label">Value</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="value" id="uses_left"
                                   value="{{ Request::old('value', isset($settings[16]) ? $settings[16]->value : '' ) }}"
                                   placeholder="Example.: 50 or 1"/>
                        </div>
                    </td>

                    <td>
                        <div class="controls">
                        <button type="submit" class="btn btn-primary btn-large" style="margin-top:20px"> Save </button>
                            </div>
                    </td>
                                {{ csrf_field() }}
                            {{ method_field('PUT') }}

                    </form>
                </tr>
                </tbody>
            </table>
            <br/>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped	display"
                   width="100%">
                <thead>
                <tr>
                    <th>Indstilling</th>
                    <th>Værdi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($settings as $setting)
                    <tr>
                        <td><label for="input_{{ $setting->identifier }}">{{ $setting->identifier }}</label></td>
                        <td><textarea class="span5" rows="3" name="{{ $setting->id }}"
                                      id="input_{{ $setting->identifier }}" cols="30" rows="10"
                                      placeholder="{{ $setting->value }}">{{ $setting->value }}</textarea></td>
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
                        "targets": [1],
                        "sortable": false,
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