@extends('layouts.packer')

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
                    <h3>New Item</h3>
                </div>
            </div>
            <hr/>
            <form action="/stock" method="post">
                <div class="control-group">
                    <label for="item-name" class="control-label">Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-name" id="item-name" placeholder="Item Name"/>
                    </div>
                    <label for="item-number" class="control-label">Number</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-number" id="item-number" placeholder="Item Number"/>
                    </div>
                    <label for="item-reqQty" class="control-label">Requested Quantity</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-reqQty" id="item-reqQty" placeholder="Requested Quantity"/>
                    </div>
                    <label for="item-qty" class="control-label">Quantity</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="item-qty" id="item-qty" placeholder="Quantity"/>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div><!--/.module-->
@stop