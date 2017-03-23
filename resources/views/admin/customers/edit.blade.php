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
                        <input type="text" class="form-control span8 datepicker" name="user_data.birthdate" id="birthdate-picker"
                               value="{{ Request::old('user_data.birthdate', ($customer->getBirthday()) ? $customer->getBirthday() : '' ) }}"
                               placeholder="Age"/>
                    </div>
                </div>

                @if(!is_null($customer->plan->getRebillAt()))
                <div class="control-group">
                    <label for="page_title" class="control-label">Re-bill date</label>
                    <div class="controls">
                        <input type="text" class="form-control span8 datepicker" name="rebill" id="rebill-picker"
                               value="{{ Request::old('rebill', ( Date::createFromFormat( 'Y-m-d H:i:s',$customer->plan->getRebillAt())) ? Date::createFromFormat( 'Y-m-d H:i:s',$customer->plan->getRebillAt())->format('Y-m-d') : '' ) }}"
                               placeholder="Re-bill date"/>
                    </div>
                </div>
                @endif
                @if($customer->plan->isActive())

                    @foreach ( $customer->plan->getVitamiPlan() as $vitamin)
                        <div class="control-group">
                            <label for="page_title" class="control-label">Vitamin {{substr($vitamin->code,0,1)}}</label>
                            <div class="controls">
                                <select name="vitamin-{{substr($vitamin->code,0,1)}}[]" id="input_state">
                                    @foreach($allvit as $vitamins)
                                        <option value="{{$vitamins->key }}"
                                                @if($vitamins->key == strtolower($vitamin->code)) selected="selected" @endif>{{ ucfirst($vitamins->value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    @endforeach

                        <div class="control-group">
                            <label for="page_title" class="control-label">Add new vitamin</label>
                            <div class="controls">
                                <select name="new_vitamin" id="input_state">
                                    <option value=""></option>
                                    @foreach($allvit as $vitamins)
                                        <option value="{{$vitamins->key }}">{{ ucfirst($vitamins->value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                @endif


                <div class="control-group">
                    <label for="page_title" class="control-label">Ambasador</label>
                    <div class="controls">
                        <select name="ambas" id="input_state" onchange="if( $(this).val() == 1 ) { $('.ambas').show() } else { $('.ambas').hide() }">
                            @foreach([0 => 'No', 1=>'Yes' ] as $key=> $value)
                                <option @if($customer->ambas == $key) selected   @endif value="{{$key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($customer->couponAmbassador())
                <div class="control-group ambas" style="@if ($customer->ambas == 1) display:block @else display:none @endif">
                    <label for="page_title" class="control-label">Ambasador coupone</label>
                    <div class="controls">
                        <select name="coupon" id="input_state">
                            <option value="">---</option>
                            @foreach($customer->couponAmbassador() as $coupon)
                                <option @if($customer->coupon == $coupon->code) selected   @endif value="{{$coupon->code }}">{{ $coupon->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                @if($customer->ambas == 1 && $newusers > 0)
                    <div class="control-group">
                        <label for="page_title" class="control-label">Discount</label>
                        <div class="controls">
                            <input type="text" class="form-control span4" name="coupon_free" id="page_subtitle"
                                   value="{{ Request::old($customer->plan->getCouponCount(), ($customer->plan->getCouponCount()) ? $customer->plan->getCouponCount() : '' ) }}"
                                   placeholder="ex. 2 Month or 20 Percent"/>
                            <select name="discount_type" id="input_state">
                                <option value="">Choose type discount</option>
                                @foreach(['month' => 'Free month', 'percent' =>'Percent on next rebill' ] as $key=>$value)
                                    <option value="{{$key }}" @if($key==$customer->plan->getDiscountType()) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="page_title" class="control-label">Goal to target</label>
                        <div class="controls">
                            <input type="text" class="form-control span4" name="goal" id="page_subtitle"
                                   value="{{ Request::old($customer->goal, ($customer->goal) ? $customer->goal : '' ) }}"
                                   placeholder=""/>
                        </div>
                    </div>



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
@section('scripts')
    <script>
        $(function() {
            $('.datepicker').datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
@endsection