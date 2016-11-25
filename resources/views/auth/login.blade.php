@extends('layouts.app')

@section('content')
	<div class="container">

		<div class="text-center m-b-50">
			<a href="{{ url()->route('flow') }}"
			   class="button button--rounded button--huge button--landing button--green">
				<strong>{!! trans('home.header.button-click-here') !!}</strong>
			</a>
			<div class="m-t-10"><a href="{{ url()->route('pick-package') }}">{{ trans('home.header.pick') }}</a></div>
		</div>

		<div class="row">
			<div class="col-md-6 col-md-push-3">
				<div class="card">
					<h1 class="card_title">{{ trans('login.title') }}</h1>
					<hr class="hr--dashed hr--small-margin"/>
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
			</div>
		</div>
	</div>
@endsection