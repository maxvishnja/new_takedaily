<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
	<title>Packaging login</title>

	<meta charset="UTF-8"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport"
		  content="width=device-width, initial-scale=1.0, minimum-scale=1, user-scalable=no, maximum-scale=1.0"/>

	<link rel="stylesheet" href="/css/app.css"/>

	<style>
		form {
			margin: 10% 0 0;
			padding: 20px;
			border: 1px solid #ddd;
			border-radius: 3px;
			box-shadow: 0 6px 14px rgba(0,0,0,.1);
		}

		h1 {
			margin-top: 0;
		}
	</style>
</head>

<body>
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-push-3">
			<form role="form" method="POST" action="{{ url('/packaging/login') }}">
				<h1>Login</h1>
				<hr>
				{!! csrf_field() !!}

				<label for="input_email" class="label label--full">{{ trans('login.email_label') }}</label>
				<input type="email" class="input input--regular input--full" name="email" value="{{ old('email') }}"
					   id="input_email"/>
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
	</div>
</div>
</body>
</html>