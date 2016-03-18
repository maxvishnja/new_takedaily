@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-basic')

@section('title', 'Profil indstillinger - Take Daily')

@section('content')
	<h1>Indstillinger</h1>

	<form method="post" class="account-form">
		@foreach($attributes as $attribute)
			<label style="display: block;">
				<span>{{ trans("attributes.{$attribute->identifier}") }}</span>
				<input type="text" id="{{ $attribute->identifier }}" class="input input--full input--regular" name="attributes[{{ $attribute->id }}]" data-original="{{ $attribute->value }}" value="{{ Request::old($attribute->identifier, $attribute->value) }}"/>
			</label>
		@endforeach

		<label style="display: block;">
			<span>{{ trans("attributes.birthday") }}</span>
			<input type="text" id="birthday" class="input input--full input--regular" name="birthday" data-original="{{ $customer->getBirthday() }}" value="{{ Request::old('birthday', $customer->getBirthday()) }}" required="required" aria-required="true"/>
		</label>

		<label style="display: block;">
			<span>{{ trans("attributes.email") }}</span>
			<input type="text" id="email" class="input input--full input--regular" name="email" data-original="{{ $customer->getUser()->email }}" value="{{ Request::old('email', $customer->getUser()->email) }}" required="required" aria-required="true"/>
		</label>

		<label style="display: block;">
			<span>{{ trans("attributes.name") }}</span>
			<input type="text" id="name" class="input input--full input--regular" name="name" data-original="{{ $customer->getName() }}" value="{{ Request::old('name', $customer->getName()) }}" required="required" aria-required="true"/>
		</label>

		<label style="display: block;">
			<span>{{ trans("attributes.newsletters") }}</span>
			<input type="checkbox" name="newsletters" id="newsletters" class="input input--full input--regular" data-original="{{ $customer->acceptNewsletters() ? 1 : 0 }}" @if(Request::old('newsletters') || $customer->acceptNewsletters()) checked="checked" @endif />
		</label>

		<label style="display: block;">
			<span>{{ trans("attributes.gender") }}</span>
			<select name="gender" data-original="{{ $customer->getGender() }}" required="required" aria-required="true" class="select select--regular select--full">
				<option value="male" @if(Request::old('gender') == 'male' || $customer->getGender() == 'male') selected="selected" @endif>Male</option>
				<option value="female" @if(Request::old('gender') == 'female' || $customer->getGender() == 'female') selected="selected" @endif>Female</option>
			</select>
		</label>


		<label style="display: block;">
			<span>{{ trans("attributes.new_password") }}</span>
			<input type="password" id="password" class="input input--full input--regular" name="password" value=""/><br/>
			<input type="password" id="password_confirmation" class="input input--full input--regular" name="password_confirmation" data-original="" value=""/>
		</label>

		<button type="submit" class="button button--medium button--green button--rounded m-t-30">Gem</button>
		{{ csrf_field() }}
	</form>
@endsection