@extends('layouts.app')

@section('content')
	<div class="header_image">
		<h1>{{ trans('login.title') }}</h1>
	</div>
	<div class="container" style="margin: 200px auto">
		<form role="form" method="POST" action="{{ url('/dashboard/login') }}">
			{!! csrf_field() !!}

			<label for="input_email" class="label label--full">{{ trans('login.email_label') }}</label>
			<input type="email" class="input input--regular input--full" name="email" value="{{ old('email') }}" id="input_email"/>
			@if ($errors->has('email'))
				<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
			@endif

			<label for="input_password" class="label label--full">{{ trans('login.password_label') }}</label>
			<input type="password" class="input input--regular input--full" name="password" id="input_password"/>
			@if ($errors->has('password'))
				<span class="help-block">
				<strong>{{ $errors->first('password') }}</strong>
			</span>
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
@endsection