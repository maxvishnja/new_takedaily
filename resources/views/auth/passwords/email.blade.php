@extends('layouts.app')

<!-- Main Content -->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-push-3">
                <div class="card">
                    <h1 class="card_title">{{ trans('password_email.title') }}</h1>
                    <hr class="hr--dashed hr--small-margin"/>

                    <form role="form" method="POST" action="{{ URL::action('Auth\PasswordController@sendResetLinkEmail') }}">
                        {!! csrf_field() !!}

                        <label for="input_email"
                               class="label label--full">{{ trans('password_email.email_label') }}</label>
                        <input id="input_email" type="email" class="input input--regular input--full" name="email"
                               value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <div class="help-block">
                                {{ $errors->first('email') }}
                            </div>
                        @endif

                        <div>
                            <button type="submit"
                                    class="button button--large button--green button--rounded m-t-20">{{ trans('password_email.button') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    @if (session('status'))
        <script>
            swal({
                title: "{{ session('status') }}",
                text: "",
                type: "success",
                allowOutsideClick: true,
                confirmButtonText: "{{ trans('popup.button-close') }}",
                confirmButtonColor: "#17AA66"
            });
        </script>
    @endif
@endsection