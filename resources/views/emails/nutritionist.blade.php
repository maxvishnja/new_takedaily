@extends($layout)

@section('title', trans('mails.nutritionist.title'))

@section('content')

    <h3>{{$CustomerName}}</h3>

    <p>{{ trans('mails.nutritionist.text') }}</p>

@endsection