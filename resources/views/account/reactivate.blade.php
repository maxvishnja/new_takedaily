@extends('layouts.app')

@section('pageClass', 'gifting')

@section('title', trans('account.reactivate-title'))

@section('mainClasses', 'm-b-50')

@section('content')
    <div class="header_image">
        <div class="container text-center">
            <h1>{{ trans('account.reactivate-name') }}</h1>

        </div>
    </div>

    <div class="container text-center m-t-30">
        <div class="gifting-block">
            <div class="row">
                <div class="col-md-6 col-md-push-3">
                    <h2>{{ trans('account.reactivate-text') }}</h2>
                    <a href="#coupon-field" class="button button--green button--large m-t-20"
                       id="toggle-coupon-form">{{ trans('checkout.index.coupon.link') }}</a>
                    <div id="coupon-field" style="display: none" class="m-t-20">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" id="coupon-input" maxlength="20"
                                       placeholder="{{ trans('checkout.index.coupon.input-placeholder') }}"
                                       class="input input--regular input--uppercase input--spacing input--full input--semibold"
                                       value="{{ Request::old('coupon', Session::get('applied_coupon')) }}"/>
                                <input type="hidden" value="{{$id}}" id="customer_id">
                            </div>

                            <div class="col-md-4">
                                <button type="button"
                                        class="button button--regular button--green button--full"
                                        id="coupon-button">{{ trans('checkout.index.coupon.button-text') }}</button>
                            </div>
                        </div>

                        <div id="coupon-form-successes" class="m-t-10"></div>
                        <div id="coupon-form-errors" class="m-t-10"></div>
                    </div>
                    <form action="{{ url()->route('reactivate') }}" method="post">
                        {{--<input type="text"  style="display: none" class="input input--large input--spacing text-center input--full m-t-20" placeholder="{{ trans('checkout.index.coupon.input-placeholder') }}"--}}
                               {{--name="coupon"/>--}}
                        <input type="hidden" value="{{$id}}" name="customer_id">


                        <button type="submit" class="button button--green button--large m-t-20">{{ trans('account.reactivate-submit') }}</button>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script>

        $("#toggle-coupon-form").click(function (e) {
            e.preventDefault();

            $("#coupon-field").toggle();
        });



        $("#coupon-button").click(function () {
            var button = $(this);

            $.ajax({
                url: "{{ URL::action('ReactivateController@applyCoupon') }}",
                method: "POST",
                data: {"coupon": $("#coupon-input").val(), 'id': $("#customer_id").val()},
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                beforeSend: function () {
                    button.text('{{ trans('flow.coupon.wait') }}').prop('disabled', true);
                },
                complete: function () {
                    button.text('{{ trans('flow.coupon.apply') }}').prop('disabled', false);
                },
                success: function (response) {
                    $("#coupon-form-successes").text(response.message);
                    $("#coupon-form-errors").text('');

                },
                error: function (response) {
                    $("#coupon-form-errors").text(response.responseJSON.message);
                    $("#coupon-form-successes").text('');

                }
            });
        });

        if ($("#coupon-input").val().length > 0) {
            $("#coupon-button").click();
        }


    </script>
@endsection