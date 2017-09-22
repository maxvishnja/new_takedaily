@extends('layouts.app')

@section('pageClass', 'products')

@section('content')
	@foreach($products as $product)
		{{ $product }}
	@endforeach
@endsection
