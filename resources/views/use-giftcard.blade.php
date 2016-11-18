@extends('layouts.app')

@section('pageClass', 'gifting')

@section('title', trans('use-gifting.title'))

@section('content')
	<div class="container text-center">
		<div class="gifting-block">
			<h1>{{ trans('use-gifting.title-element') }}</h1>
			<h2>{{ trans('use-gifting.subtitle') }}</h2>

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
