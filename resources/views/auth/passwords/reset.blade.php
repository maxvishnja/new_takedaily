@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-push-3">
                <div class="card">
                    <h1 class="card_title">{{ trans('password_reset.title') }}</h1>
                    <hr class="hr--dashed hr--small-margin"/>
                    <form role="form" method="POST" action="{{ URL::action('Auth\PasswordController@reset') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div>
                            <label for="input_email"
                                   class="label label--full">{{ trans('password_reset.email_label') }}</label>

                            <input type="email" id="input_email" class="input input--regular input--full" name="email"
                                   value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <div class="help-block">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="m-t-20">
                            <label class="label label--full"
                                   for="input_password">{{ trans('password_reset.password_label') }}</label>

                            <input type="password" class="input input--regular input--full" name="password"
                                   id="input_password">

                            @if ($errors->has('password'))
                                <div class="help-block">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="m-t-20">
                            <label for="input_password_confirm"
                                   class="label label--full">{{ trans('password_reset.password_confirm_label') }}</label>
                            <div>
                                <input for="input_password_confirm" type="password"
                                       class="input input--regular input--full"
                                       name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <div class="help-block">
                                        {{ $errors->first('password_confirmation') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="button button--large button--green button--rounded m-t-20">
                                {{ trans('password_reset.button') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
