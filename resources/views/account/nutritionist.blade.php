@extends('layouts.account')

@section('pageClass', 'account page-account-home')

@section('title', trans('account.personal.title'))

@section('content')

	<h1>{{ trans('account.nutritionist.header')}}</h1>
	<hr>

	@if(!empty($nutritionist) and !empty($nutritionist->email))
		<div class="row nutritionist-block">
			<div class="col-md-2">
				@if(!empty($nutritionist->image))
					<img src="/images/nutritionist/thumb_{!! $nutritionist->image !!}" class="nutritionist-img">
				@endif
			</div>
			<div class="col-md-10">
				{!! $nutritionist->first_name !!} {!! $nutritionist->last_name !!}
			</div>
			<hr>
		</div>
		<div class="row text-center">
			<form method="POST" class="nutritionistEmail" action="" enctype="multipart/form-data">
				<div class="col-md-4 offset-md-3">
					<input type="hidden" name="customer_id" value="{{$nutritionist->id}}">
					<button class="nutritionist-send-mail" type="submit">Send Message</button>
				</div>
				{{ csrf_field() }}
			</form>
		</div>
		<hr>
	@endif


@endsection

@section('footer_scripts')
	<script>
        $('.nutritionist-send-mail').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                data: $('form.nutritionistEmail').serialize(),
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: '{{ route("nutritionist-email") }}',
                complete: function () {
                    swal({
                        title: "{{ trans('message.success-nutritionist-title') }}",
                        type: "success",
                        html: true,
                        allowOutsideClick: true,
                        confirmButtonText: "{{ trans('popup.button-close') }}",
                        confirmButtonColor: "#3AAC87",
                        timer: 6000
                    });
                }

            });
        });
	</script>
@endsection