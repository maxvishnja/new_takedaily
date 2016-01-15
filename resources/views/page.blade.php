@extends('layouts.app')

@section('pageClass', 'cms page')

@section('content')
	<article>
		<h1>{{ $page->title }}</h1>
		@if( $page->sub_title != '')
			<h2>{{ $page->sub_title }}</h2>
		@endif
		{!! $page->body !!}
	</article>
@endsection
