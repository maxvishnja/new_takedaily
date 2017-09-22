@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Feedback (#{{ $feedback->id }})</h3>
        </div>

        <div class="module-body">
            <div class="pull-right">


                <a class="btn btn-danger" href="{{ URL::action('Dashboard\FeedbackController@destroy', [ 'id' => $feedback->id ]) }}" onclick="return confirm('Er du sikker på at du ønsker at opsige kundens abonnent?');"><i class="icon-remove"></i>
                Delete</a>

            </div>

            <div class="clear"></div>
            <hr/>

            <h3>{{$feedback->title}}</h3>
            {{$feedback->text}}

        </div>
    </div><!--/.module-->
@stop