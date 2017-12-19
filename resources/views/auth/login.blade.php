@extends('layouts.app')

@section('mainClasses', 'm-b-50')

@section('content')
	<div class="header_image" style="margin-top: 6.6rem">
		<h1>{{ trans('login.title') }}</h1>
	</div>

	<div class="container" style="margin: 150px auto">
		<div class="row">
			<div class="col-md-6 col-md-push-3">
				<div class="card">
					<form role="form" method="POST" action="{{ URL::action('Auth\AuthController@login') }}">
						{!! csrf_field() !!}

						<label for="input_email" class="label label--full">{{ trans('login.email_label') }}</label>
						<input type="email" class="input input--regular input--full" name="email" value="{{ old('email') }}" id="input_email"/>
						@if ($errors->has('email'))
							<div class="help-block">
								{{ $errors->first('email') }}
							</div>
						@endif

						<label for="input_password" class="label label--full">{{ trans('login.password_label') }}</label>
						<input type="password" class="input input--regular input--full" name="password" id="input_password"/>
						@if ($errors->has('password'))
							<div class="help-block">
								{{ $errors->first('password') }}
							</div>
						@endif

						<label class="label label--full" for="input_remember">
							<input type="checkbox" name="remember" id="input_remember"> {{ trans('login.remember_me') }}
						</label>

						<div>
							<button type="submit" class="button button--large button--green button--rounded m-t-20 m-b-20">
								{{ trans('login.button') }}
							</button>
						</div>

						<div><a href="{{ url('/password/reset') }}">{{ trans('login.forgot') }}</a></div>
					</form>
				</div>

				<div class="text-center m-t-50">
					<h2>{{ trans('auth.new') }}</h2>
					<a href="{{ url()->route('flow') }}"
					   class="button button--rounded button--huge button--landing button--green">
						<strong>{!! trans('home2.header.button-click-here') !!}</strong>
					</a>
					{{--					<div class="m-t-10"><a href="{{ url()->route('pick-package') }}">{{ trans('home.header.pick') }}</a></div>--}}
				</div>
			</div>
		</div>
	</div>
@endsection