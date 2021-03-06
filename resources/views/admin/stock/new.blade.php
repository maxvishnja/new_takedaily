@extends('layouts.admin')

@section('content')

    <div class="clear"></div>

    <div class="module">
        <div class="module-head">
            <h3 class="pull-left"></h3>
            <span style="margin-left: 10px;"
                  class="label pull-left label"></span>
            <div class="clear"></div>
        </div>

        <div class="module-body">
            <div class="row">
                <div class="span8">
                    <h3>Create New Item</h3>
                </div>
            </div>
            <hr/>
            <form action="{{ URL::action('Stock\StockController@insert') }}" method="post">
                <div class="control-group">
                    <label for="item-name" class="control-label">Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-name" id="item-name" placeholder="Item Name"/>
                    </div>
                    <label for="item-type" class="control-label">Type</label>
                    <div class="controls">
                        <select name="item-type" id="item-type">
                            <option value="vitamin">Vitamin</option>
                            <option value="material">Material</option>
                        </select>
                    </div>
                    <label for="item-number" class="control-label">Number</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-number" id="item-number" placeholder="Item Number"/>
                    </div>
                    <label for="item-reqQty" class="control-label">NEW Stock</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-reqQty" id="item-reqQty" placeholder="Requested Quantity"/>
                    </div>
                    <label for="item-qty" class="control-label">Quantity in Stock</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-qty" id="item-qty" placeholder="Quantity" />
                    </div>
                    <label for="item-alarm" class="control-label">Set Alarm on Packages Left</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-alarm" id="item-alarm" placeholder="Alarm"/>
                    </div>

                    <hr>

                    <label for="item-alarm" class="control-label">Email(s) to alert</label>
                    <small>(hit tab to add new email)</small>
                    <div class="controls">
                        <input type="text" data-role="tagsinput" class="form-control span8" name="item-alarm-email" id="item-alarm-email" placeholder="Add email"/>
                    </div>

                    <hr>

                    {{ csrf_field() }}
                    <div class="controls">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div><!--/.module-->
@stop

@section('scripts')

@endsection