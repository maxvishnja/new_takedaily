@extends('layouts.app')

@section('mainClasses', 'm-b-50')

@section('content')
    <div class="header_image">
        <h1>
            {{ trans('general.feedback_head_title') }}
        </h1>
    </div>

    <div class="container m-t-30">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <h2> {!! str_replace('{name}', $name, nl2br(trans('general.feedback_welcome'))) !!}</h2>
                <div class="card">
                    <form role="form" class="feed-form" method="POST">
                        {!! csrf_field() !!}

                        <input type="hidden" name="customer_id" value="{{$customer_id}}">

                        <div>
                            <label for="input_email"
                                   class="label label--full">{{ trans('general.feedback_input_title') }}</label>

                            <input type="text" required id="input_email" class="input input--regular input--full" name="title"
                                   value="">

                            @if ($errors->has('title'))
                                <div class="help-block">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>
                        <div class="m-t-20">
                            <label for="input_password_confirm"
                                   class="label label--full">{{ trans('general.feedback_input_text') }}</label>
                            <div>
                                <textarea required for="input_password_confirm" rows="5" class="input input--full" name="text"></textarea>

                                @if ($errors->has('text'))
                                    <div class="help-block">
                                        {{ $errors->first('text') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="button button--large button--green button--rounded m-t-20">
                                {{ trans('general.feedback_button_send') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
        <script>

            $('.feed-form').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    data: $('form.feed-form').serialize(),
                    url: '{{ route("feed-add") }}',
                    success: function (data) {
                        swal({
                            title: " {{ trans('general.feedback_add') }}",
                            text: "",
                            type: "success",
                            allowOutsideClick: true,
                            confirmButtonText: "{{ trans('popup.button-close') }}",
                            confirmButtonColor: "#17AA66"
                        });

                        $('form.feed-form')[0].reset();

                    }

                });
            });


        </script>
@endsection