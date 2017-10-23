@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Nutritionists (#{{ $nutritionist->id }})</h3>
		</div>

		<div class="module-body">
			<div class="pull-right">
				<a class="btn btn-default" onclick="javascript:history.back();">Back</a>
				<a class="btn btn-info" href="{{ URL::action('Dashboard\NutritionistController@edit', [ 'id' => $nutritionist->id ]) }}"><i class="icon-pencil"></i>
					Edit</a>
				<a class="btn btn-danger" href="{{ URL::action('Dashboard\NutritionistController@destroy', [ 'id' => $nutritionist->id ]) }}" onclick="return confirm('Er du sikker på at du ønsker at opsige kundens abonnent?');"><i class="icon-remove"></i>
					Delete</a>
			</div>

			<div class="clear"></div>
			<hr/>

			<table class="table table-striped">
				<tbody>
				<tr>
					<td>Id</td>
					<td>{{ $nutritionist->id }}</td>
				</tr>

				<tr>
					<td>First name</td>
					<td>{{ $nutritionist->first_name }}</td>
				</tr>

				<tr>
					<td>Last name</td>
					<td>{{ $nutritionist->last_name }}</td>
				</tr>

				@if(!empty($nutritionist->image))
					<tr>
						<td>Photo</td>
						<td><img src="/images/nutritionist/thumb_{!! $nutritionist->image !!}" class="img-thumbnail"><br/><br/>
						</td>
					</tr>
				@endif

				<tr>
					<td>E-mail</td>
					<td><a href="mailto:{{ $nutritionist->email }}">{{ $nutritionist->email }}</a></td>
				</tr>

				<tr>
					<td>Active</td>
					<td>@if($nutritionist->active == 1) Yes @else No @endif</td>
				</tr>

				</tbody>
			</table>

		</div>
	</div><!--/.module-->
@stop