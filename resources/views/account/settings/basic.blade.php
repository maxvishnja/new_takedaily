@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-basic')

@section('content')
	<h1>Indstillinger</h1>

	<form method="post">
		@foreach($attributes as $attribute)
			<label style="display: block;">
				<span>{{ trans("attributes.{$attribute->identifier}") }}</span>
				<input type="text" id="{{ $attribute->identifier }}" name="attributes[{{ $attribute->id }}]" data-original="{{ $attribute->value }}" value="{{ $attribute->value }}"/>
			</label>
		@endforeach

		<label style="display: block;">
			<span>{{ trans("attributes.birthday") }}</span>
			<input type="text" id="birthday" name="birthday" data-original="{{ $customer->getBirthday() }}" value="{{ $customer->getBirthday() }}" required="required" aria-required="true"/>
		</label>

		<label style="display: block;">
			<span>{{ trans("attributes.email") }}</span>
			<input type="text" id="email" name="email" data-original="{{ $customer->getUser()->email }}" value="{{ $customer->getUser()->email }}" required="required" aria-required="true"/>
		</label>

		<label style="display: block;">
			<span>{{ trans("attributes.name") }}</span>
			<input type="text" id="name" name="name" data-original="{{ $customer->getName() }}" value="{{ $customer->getName() }}" required="required" aria-required="true"/>
		</label>

		<label style="display: block;">
			<span>{{ trans("attributes.newsletters") }}</span>
			<input type="checkbox" name="newsletters" id="newsletters" data-original="{{ $customer->acceptNewsletters() ? 1 : 0 }}" @if($customer->acceptNewsletters()) checked="checked" @endif />
		</label>

		<label style="display: block;">
			<span>{{ trans("attributes.gender") }}</span>
			<select name="gender" data-original="{{ $customer->getGender() }}" required="required" aria-required="true">
				<option value="male" @if($customer->getGender() == 'male') selected="selected" @endif>Male</option>
				<option value="female" @if($customer->getGender() == 'female') selected="selected" @endif>Female
				</option>
			</select>
		</label>


		<label style="display: block;">
			<span>{{ trans("attributes.new_password") }}</span>
			<input type="password" id="password" name="password" value=""/><br/>
			<input type="password" id="password_repeated" name="password_repeated" data-original="" value=""/>
		</label>

		<button type="submit">Gem</button>
		{{ csrf_field() }}
	</form>
@endsection