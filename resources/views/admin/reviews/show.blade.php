@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Review (#{{ $review->id }})</h3>
        </div>

        <div class="module-body">
            <div class="pull-right">


                <a class="btn btn-danger" href="{{ URL::action('Dashboard\ReviewsController@destroy', [ 'id' => $review->id ]) }}" onclick="return confirm('Er du sikker på at du ønsker at opsige kundens abonnent?');"><i class="icon-remove"></i>
                    Delete</a>

            </div>

            <div class="clear"></div>
            <hr/>

            <h3>{{$review->name}}</h3>
            {{$review->review}}

        </div>
    </div><!--/.module-->
@stop