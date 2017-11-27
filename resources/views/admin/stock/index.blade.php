@extends('layouts.admin')

@section('content')

	<div class="clear"></div>

	<div class="module">
		<div class="module-head">
			<h3 class="pull-left"></h3>
			<span style="margin-left: 10px;"
				  class="label pull-left label-{{ $order->stateToColor() }}">{{ $order->state }}</span>

			<div class="btn-group pull-right">
				@if($order->state == 'paid' )
					<a class="btn btn-default"
					   href=""><i
							class="icon-truck"></i>
						Mark as sent</a>
				@endif
			</div>
			<div class="clear"></div>
		</div>

		<div class="module-body">
			<div class="row">
				<div class="span8">
					<h3>Delivery address</h3>
					
				</div>
			</div>
			<hr/>
			<table class="table table-striped">
				<thead>
				
				</thead>

				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>

				<tfoot>
				<tr>
					<td colspan="2" style="border: none;"></td>
					<td style="border: none; text-align: right;">Subtotal</td>
					<td style="border: none;"></td>
				</tr>

				<tr>
					<td colspan="2" style="border: none;"></td>
					<td style="border: none; text-align: right;">Shipping</td>
					<td style="border: none;"></td>
				</tr>

				<tr>
					<td colspan="2" style="border: none;"></td>
					<td style="border: none; text-align: right;">Taxes</td>
					<td style="border: none;"></td>
				</tr>

				<tr>
					<td colspan="2" style="border: none;"></td>
					<td style="border: none; text-align: right; font-weight: bold;">Total</td>
					<td style="border: none; font-weight: bold;"></td>
				</tr>
				</tfoot>
			</table>
		</div>
	</div><!--/.module-->
@stop