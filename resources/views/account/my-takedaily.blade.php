@extends('layouts.account')

@section('pageClass', 'account page-account-home')

@section('title', trans('account.personal.title'))

@section('content')
	<h1>{{ trans('account.home.header') }}</h1>

	@foreach(Auth::user()->getCustomer()->getVitaminModels() as $vitamin)
		<div class="new_vitamin_item">

			<div class="pill_section">
				<span class="icon pill-{{ strtolower($vitamin->code) }}"></span>
			</div>

			<div class="content_section">
				<strong>
					{{ $vitamin->name }}
				</strong>
				<p>{!! trans("label-{$vitamin->code}.web_description") !!}</p>
			</div>
		</div>
	@endforeach



	<div class="m-t-10"><a href="/flow" class="button button--green">{{ trans('account.home.button-change') }}</a></div>
@endsection