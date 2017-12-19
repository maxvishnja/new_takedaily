@extends('layouts.app')

@section('pageClass', 'page page-faq')

@section('title', trans('faq.title'))

@section('mainClasses', 'm-b-50')

@section('content')
	<div class="header_image" style="margin-top: 6.6rem">
		<div class="container text-center">
			<h1>{{ trans('faq.title') }}</h1>
		</div>
	</div>

	<div class="container">
		<article>
			<div class="row">
				<div class="col-md-8 col-md-push-2">
					<div class="faqs">
						@foreach($faqs as $faq)
							<div class="faq open uncloseable">
								<div class="faq_header">
									<strong>{{ $faq->question }}</strong>
									<div class="clear"></div>
								</div>

								<div class="faq_answer">
									{!! $faq->answer !!}
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</article>
	</div>
@endsection