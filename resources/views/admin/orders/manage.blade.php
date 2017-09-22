@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Rediger ordre ({{ $order->getPaddedId() }})</h3>
		</div>

		<div class="module-body">

			<form method="POST" class="form-horizontal row-fluid" action="{{ URL::action('Dashboard\OrderController@update', [ $order->id ]) }}" enctype="multipart/form-data">
				<div class="clear"></div>

				<div class="control-group">
					<label for="page_title" class="control-label">Status</label>
					<div class="controls">
						<select name="state" id="input_state">
							@foreach(['new', 'sent', 'cancelled', 'completed', 'paid'] as $state)
								<option value="{{ $state }}" @if($state == $order->state) selected="selected" @endif>{{ ucfirst($state) }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="control-group">
					<div class="controls clearfix">
						<a href="{{ URL::action('Dashboard\OrderController@show', [ $order->id ]) }}" class="btn btn-default pull-right">Annuller</a>
						<button type="submit" class="btn btn-primary btn-large pull-left">Gem</button>
					</div>
				</div>
				{{ csrf_field() }}
				{{ method_field('PUT') }}
			</form>
		</div>
	</div><!--/.module-->
	<div>
		<form method="POST" action="{{ URL::action('Dashboard\OrderController@destroy', [ $order->id ]) }}" onsubmit="return confirm('Er du sikker på at du slette denne ordre?');">
			<button type="submit" class="btn btn-link">Slet ordren</button>
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
		</form>
	</div>
@stop