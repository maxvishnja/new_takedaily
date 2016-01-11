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

		<button type="submit">Gem</button>
		{{ csrf_field() }}
	</form>
@endsection