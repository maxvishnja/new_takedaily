@extends($layout)

@section('title', trans('mails.shared.title'))

@section('content')

    <p>
        {{$formMessage}}
    </p>
    <h3><a href="{{$sharedLink}}">{!! trans('mails.shared.link-text') !!}</a></h3>
@endsection