@extends('layouts.app')

@section('pageClass', 'gifting')

@section('title', trans('use-gifting.title'))

@section('mainClasses', 'm-b-50')

@section('content')
	<div class="header_image">
		<div class="container text-center">
			<h1>{{ trans('use-gifting.title-element') }}</h1>
			<h2>{{ trans('use-gifting.subtitle') }}</h2>
		</div>
	</div>

	<div class="container text-center m-t-30">
		<div class="gifting-block">
			<div class="row">
				<div class="col-md-6 col-md-push-3">
					<form action="{{ url()->route('use-giftcard-post') }}" method="post">
						<input type="text" class="input input--large input--spacing text-center input--full m-t-20" placeholder="{{ trans('use-gifting.placeholder') }}"
							   name="giftcard_code"/>

						<button type="submit" class="button button--green button--large m-t-20">{{ trans('use-gifting.button') }}</button>

						{{ csrf_field() }}
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
