@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Kunde (#{{ $customer->id }})</h3>
        </div>

        <div class="module-body">
         <div class="clear"></div>
            <hr/>
            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{  URL::action('Dashboard\CustomerController@update', [ $customer->id ]) }}"
                  enctype="multipart/form-data">


                <div class="control-group">
                    <label for="page_title" class="control-label">Navn</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="cust_name" id="page_subtitle"
                               value="{{ Request::old('cust_name', ($customer->getName()) ? $customer->getName() : '' ) }}"
                               placeholder="Sidens undertitel"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">E-mail</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="cust_email" id="page_subtitle"
                               value="{{ Request::old('cust_email', ($customer->getEmail()) ? $customer->getEmail() : '' ) }}"
                               placeholder="Sidens undertitel"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Age</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="user_data.birthdate" id="birthdate-picker"
                               value="{{ Request::old('user_data.birthdate', ($customer->getBirthday()) ? $customer->getBirthday() : '' ) }}"
                               placeholder="Age"/>
                    </div>
                </div>

                @if($customer->plan->isActive())

                    @foreach ( $customer->plan->getVitamiPlan() as $vitamin)
                        <div class="control-group">
                            <label for="page_title" class="control-label">Vitamin {{substr($vitamin->code,0,1)}}</label>
                            <div class="controls">
                                <select name="vitamin-{{substr($vitamin->code,0,1)}}" id="input_state">
                                    @foreach($allvit as $vitamins)
                                        <option value="{{$vitamins->key }}"
                                                @if($vitamins->key == strtolower($vitamin->code)) selected="selected" @endif>{{ ucfirst($vitamins->value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    @endforeach
                @endif

                @foreach($customer->customerAttributes as $attribute)

                    @if($attribute->editable=='1' or $attribute->identifier=='phone')
                    <div class="control-group">
                        <label for="page_title" class="control-label">{{ trans("attributes.{$attribute->identifier}") }}</label>
                        <div class="controls">
                            <input type="text" class="form-control span8" name="{{$attribute->identifier}}" id="page_subtitle"
                                   value="{{ Request::old($attribute->identifier, ($attribute->value) ? $attribute->value : '' ) }}"
                                   placeholder="Sidens undertitel"/>
                        </div>
                    </div>
                    @endif
                @endforeach
                <div class="clear"></div>
                <div class="pull-right">
                     <button class="btn btn-info"  type="submit"><i
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