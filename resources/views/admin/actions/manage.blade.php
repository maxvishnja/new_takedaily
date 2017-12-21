@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            @if( ! isset( $action ) )
                <h3>Add action</h3>
            @else
                <h3>Edit action {{ $action->id }}</h3>
            @endif
        </div>

        <div class="module-body">

            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{ isset( $action ) ? URL::action('Dashboard\ActionsController@update', [ $action->id ]) : URL::action('Dashboard\ActionsController@store') }}"
                  enctype="multipart/form-data">


                <div class="clear">

                            <div class="control-group">
                                <label for="faq_question" class="control-label">Title</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8" name="title" id="title"
                                           value="{{ Request::old('action', isset($action) ? $action->title : '' ) }}"
                                           placeholder="New action"/>
                                </div>
                            </div>

                        <div class="control-group">
                            <label for="faq_question" class="control-label">Price DK</label>
                            <div class="controls">
                                <input type="text" class="form-control span8" name="price_da" id="price_da"
                                       value="{{ Request::old('action', isset($action) ? $action->price_da : '' ) }}"
                                       placeholder="99"/> DK
                            </div>
                        </div>

                    <div class="control-group">
                        <label for="faq_question" class="control-label">Price NL</label>
                        <div class="controls">
                            <input type="text" class="form-control span8" name="price_nl" id="price_nl"
                                   value="{{ Request::old('action', isset($action) ? $action->price_nl : '' ) }}"
                                   placeholder="15.95"/> EUR
                        </div>
                    </div>


                    <div class="control-group">
                        <label for="faq_question" class="control-label">Month</label>
                        <div class="controls">
                            <input type="text" class="form-control span8" name="month" id="month"
                                   value="{{ Request::old('action', isset($action) ? $action->month : '' ) }}"
                                   placeholder="3"/>
                        </div>
                    </div>


                    <div class="control-group">
                        <label for="discount" class="control-label">Active</label>
                        <div class="controls">
                            <select name="active" >
                                @foreach(['0' => 'No', '1' =>'Yes' ] as $key=> $value)
                                    <option @if(isset($action) && $action->active == $key) selected   @endif value="{{$key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                    <div class="controls clearfix">
                        <a href="{{ URL::action('Dashboard\ActionsController@index') }}"
                           class="btn btn-default pull-right">Annuller</a>
                        <button type="submit" class="btn btn-primary btn-large pull-left">@if(isset($action)) Save @else
                                Add @endif</button>
                    </div>
                </div>
                {{ csrf_field() }}

                @if(isset($action))
                    {{ method_field('PUT') }}
                @endif
            </form>
    </div><!--/.module-->
    @if( isset($action) )
        <div>
            <form method="POST" action="{{ URL::action('Dashboard\ActionsController@destroy', [ $action->id ]) }}"
                  onsubmit="return confirm('Are you sure?');">
                <button type="submit" class="btn btn-link">Delete action</button>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>
        </div>
    @endif
@stop