@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Kunde</h3>
        </div>

        <div class="module-body">
         <div class="clear"></div>
            <hr/>
            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{  URL::action('Dashboard\NutritionistController@store') }}"
                  enctype="multipart/form-data">


                <div class="control-group">
                    <label for="page_title" class="control-label">First Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="first_name"
                               value="{{ Request::old('first_name') }}"
                               placeholder="First Name"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Last Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="last_name" id="page_subtitle"
                               value="{{ Request::old('last_name') }}"
                               placeholder="Last Name"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">E-mail</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="email"
                               value="{{ Request::old('email') }}"
                               placeholder="E-mail"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Photo</label>
                    <div class="controls">
                        <input type="file" class="form-control span8" name="image">
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Locale</label>
                    <div class="controls">
                        <select name="locale">
                            <option value="da" selected="selected">DK</option>
                            <option value="nl">NL</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Active</label>
                    <div class="controls">
                        <select name="active">
                            <option value="1" selected="selected">Active</option>
                            <option value="0">Not Active</option>
                        </select>
                    </div>
                </div>

                   <div class="clear"></div>
                   <div class="pull-right">
                        <button class="btn btn-info"  type="submit"><i class="icon-pencil"></i>Create</button>
                   </div>
                   {{ csrf_field() }}
                   {{ method_field('POST') }}
                   <div class="clear"></div>

               </form>
           </div>
       </div><!--/.module-->
   @stop