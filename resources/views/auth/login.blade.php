@extends('layouts.app')

@section('content')
	<div class="container">
		<a href="{{ url('/register') }}">Har du ikke en profil?</a>
		<hr/>

		<form role="form" method="POST" action="{{ url('/login') }}">
			{!! csrf_field() !!}

			<label for="input_email" class="label label--full">Din e-mail adresse</label>
			<input type="email" class="input input--regular input--full" name="email" value="{{ old('email') }}" id="input_email"/>
			@if ($errors->has('email'))
				<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
			@endif

			<label for="input_password" class="label label--full">Din adgangskode</label>
			<input type="password" class="input input--regular input--full" name="password" id="input_password"/>
			@if ($errors->has('password'))
				<span class="help-block">
				<strong>{{ $errors->first('password') }}</strong>
			</span>
			@endif

			<label class="label label--full" for="input_remember">
				<input type="checkbox" name="remember" id="input_remember"> Remember Me
			</label>

			<div>
				<button type="submit" class="button button--large button--green button--rounded m-t-20 m-b-20">
					Log in
				</button>
			</div>

			<div><a href="{{ url('/password/reset') }}">Forgot Your Password?</a></div>
		</form>
	</div>
@endsection

{{-- todo translate --}}