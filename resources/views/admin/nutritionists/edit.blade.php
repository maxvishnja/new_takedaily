@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Kunde (#{{ $nutritionist->id }}</h3>
        </div>

        <div class="module-body">
         <div class="clear"></div>
            <hr/>
            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{  URL::action('Dashboard\NutritionistController@update', [ $nutritionist->id ]) }}"
                  enctype="multipart/form-data">


                <div class="control-group">
                    <label for="page_title" class="control-label">First Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="first_name"
                               value="{{ Request::old('first_name', ($nutritionist->first_name) ? $nutritionist->first_name : '' ) }}"
                               placeholder="Sidens undertitel"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Last Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="last_name"
                               value="{{ Request::old('last_name', ($nutritionist->last_name) ? $nutritionist->last_name : '' ) }}"
                               placeholder="Sidens undertitel"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">E-mail</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="email"
                               value="{{ Request::old('email', ($nutritionist->email) ? $nutritionist->email : '' ) }}"
                               placeholder="E-mail"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Photo</label>
                    <div class="controls">
                        @if(!empty($nutritionist->image))
                            <img src="/images/nutritionist/thumb_{!! $nutritionist->image !!}" class="img-thumbnail"><br/><br/>
                        @endif
                        <input type="file" class="form-control span8" name="image" value="">
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Locale</label>
                    <div class="controls">
                        <select name="locale">
                            <option value="da" {{ ($nutritionist->locale == 'dk') ? 'selected="selected"' : '' }}>DK</option>
                            <option value="nl" {{ ($nutritionist->locale == 'nl') ? 'selected="selected"' : '' }}>NL</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Active</label>
                    <div class="controls">
                        <select name="active">
                            <option value="1" {{ ($nutritionist->active == '1') ? 'selected="selected"' : '' }}>Active</option>
                            <option value="0" {{ ($nutritionist->active == '0') ? 'selected="selected"' : '' }}>Not Active</option>
                        </select>
                    </div>
                </div>

                   <div class="clear"></div>
                   <div class="pull-right">
                        <button class="btn btn-info"  type="submit"><i class="icon-pencil"></i>Update</button>
                   </div>
                   {{ csrf_field() }}
                   {{ method_field('PUT') }}
                   <div class="clear"></div>

               </form>
           </div>
       </div><!--/.module-->
   @stop