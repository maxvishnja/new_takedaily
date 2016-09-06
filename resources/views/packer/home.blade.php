@extends('layouts.packer')

@section('content')
	<div class="btn-controls">
		<div class="btn-box-row row-fluid">
			<a href="#" class="btn-box big span12"><i class=" icon-shopping-cart"></i><b>{{ $orders_today }}</b>
				<p class="text-muted">Orders today</p>
			</a>
		</div>
	</div>
	<!--/#btn-controls-->
@stop