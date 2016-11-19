@extends('layouts.app')

@section('pageClass', 'page page-faq')

@section('title', trans('faq.title'))

@section('mainClasses', 'm-b-50 m-t-50')

@section('content')
	<div class="container">
		<article>
			<h1 class="text-center">{{ trans('faq.title') }}</h1>
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