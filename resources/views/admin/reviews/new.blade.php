@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>New review</h3>
        </div>

        <div class="module-body">
            <div class="clear"></div>
            <hr/>
            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{  URL::action('Dashboard\ReviewsController@store') }}"
                  enctype="multipart/form-data">


                <div class="control-group">
                    <label for="rev_name" class="control-label">Navn</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="rev_name" id="rev_name"
                               placeholder="Sidens undertitel"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="rev_age" class="control-label">Age</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="rev_age" id="rev_age"
                               placeholder="Sidens undertitel"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="rev_review" class="control-label">Review</label>
                    <div class="controls">
                        <textarea name="rev_review" id="rev_review" style="width: 64%; height: 100px"></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label for="rev_review" class="control-label">Locale</label>
                    <select name="rev_locale" id="rev_locale">
                        <option value="da">DA</option>
                        <option value="nl">NL</option>
                    </select>
                </div>

                <div class="control-group">
                    <label for="rev_active">Active</label>
                    <input type="checkbox" name="rev_active">
                </div>

                <div class="clear"></div>
                <div class="pull-right">
                    <button class="btn btn-info" type="submit">Save
                    </button>

                </div>
                {{ csrf_field() }}

                <div class="clear"></div>

            </form>
        </div>
    </div><!--/.module-->
@stop