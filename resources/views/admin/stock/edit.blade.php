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
                    <h3>Edit Item #{{$item->id}} - {{$item->name}}</h3>
                </div>
            </div>
            <hr/>
            <form action="{{ URL::action('Stock\StockController@update') }}" method="post">
                <div class="control-group">
                    <label for="item-name" class="control-label">Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-name" value="{{$item->name}}" id="item-name" placeholder="Item Name"/>
                    </div>
                    <label for="item-number" class="control-label">Number</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-number" value="{{$item->number}}" id="item-number" placeholder="Item Number"/>
                    </div>
                    <label for="item-type" class="control-label">Type</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-typer" value="{{$item->type}}" id="item-type" placeholder="Item Type"/>
                    </div>
                    <label for="item-reqQty" class="control-label">Requested Quantity</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-reqQty" value="{{$item->reqQty}}" id="item-reqQty" placeholder="Requested Quantity"/>
                    </div>
                    <label for="item-qty" class="control-label">Quantity in Stock</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-qty" id="item-qty" value="{{$item->qty}}" placeholder="Quantity" readonly/>
                    </div>
                    <label for="item-alarm" class="control-label">Set Alarm on Packages Left</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-alarm" id="item-alarm" value="{{$item->alert}}" placeholder="Alarm"/>
                    </div>

                    {{ csrf_field() }}
                    <input type="hidden" name="item-id" value="{{$item->id}}">
                    <div class="controls">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div><!--/.module-->
@stop