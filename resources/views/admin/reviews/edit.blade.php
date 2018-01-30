@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Kunde (#{{ $review->id }})</h3>
        </div>

        <div class="module-body">
            <div class="clear"></div>
            <hr/>
            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{  URL::action('Dashboard\ReviewsController@update', [ $review->id ]) }}"
                  enctype="multipart/form-data">

                <div class="control-group">
                    <label for="rev_name" class="control-label">Navn</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="rev_name" id="rev_name"
                               value="{{ Request::old('rev_name', $review->name) }}"
                               placeholder="Sidens undertitel"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="rev_age" class="control-label">Age</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="rev_age" id="rev_age"
                               value="{{ Request::old('rev_age', $review->age ) }}"
                               placeholder="Sidens undertitel"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="rev_review" class="control-label">Review</label>
                    <div class="controls">
                        <textarea name="rev_review" id="rev_review" style="width: 64%; height: 100px">{{ $review->review }}</textarea><br>
                        <span id='remainingC'></span>
                    </div>
                </div>

                <div class="control-group">
                    <label for="rev_review" class="control-label">Locale</label>
                    <select name="rev_locale" id="rev_locale">
                        <option value="da" @if($review->locale == 'da') {{ 'selected' }} @endif>DA</option>
                        <option value="nl" @if($review->locale == 'nl') {{ 'selected' }} @endif>NL</option>
                    </select>
                </div>

                <div class="control-group">
                    <label for="rev_active">Active</label>
                    <input type="checkbox" name="rev_active" @if($review->active) {{ 'checked' }} @endif>
                </div>

                <div class="clear"></div>
                <div class="pull-right">
                    <button class="btn btn-info" type="submit"><i
                            class="icon-pencil"></i>Update
                    </button>

                </div>
                {{ csrf_field() }}


                {{ method_field('PUT') }}

                <div class="clear"></div>

            </form>
        </div>
    </div><!--/.module-->
@stop

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#rev_review').on('keypress', function(){

                if(this.value.length > 122){
                    return false;
                }
                $("#remainingC").html("Remaining characters : " +(122 - this.value.length));
            })
        })
    </script>
@endsection