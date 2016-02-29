@extends('layouts.app')

@section('content')
	<div class="container">
		<a href="{{ url('/login') }}">Har du allerede en profil?</a>
		<hr/>

		<form role="form" method="POST" action="{{ url('/register') }}">
			{!! csrf_field() !!}

			<label for="input_name" class="label label--full">Dit navn</label>
			<input type="text" class="input input--regular input--full" name="name" value="{{ old('name') }}" id="input_name" />
			@if ($errors->has('name'))
				<span class="help-block">
				<strong>{{ $errors->first('name') }}</strong>
			</span>
			@endif

			<label for="input_email" class="label label--full">Din e-mail adresse</label>
			<input type="email" class="input input--regular input--full" name="email" value="{{ old('email') }}" id="input_email" />
			@if ($errors->has('email'))
				<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
			@endif

			<label for="input_password" class="label label--full">Dit ønskede kodeord</label>
			<input type="password" class="input input--regular input--full" name="password" id="input_password" />
			@if ($errors->has('password'))
				<span class="help-block">
				<strong>{{ $errors->first('password') }}</strong>
			</span>
			@endif

			<label for="input_password_confirm" class="label label--full">Gentag kodeord</label>
			<input type="password" class="input input--regular input--full" name="password_confirmation" id="input_password_confirm" />
			@if ($errors->has('password_confirmation'))
				<span class="help-block">
				<strong>{{ $errors->first('password_confirmation') }}</strong>
			</span>
			@endif

			<button type="submit" class="button button--large button--green button--rounded m-t-20">
				Register
			</button>
		</form>
	</div>
@endsection