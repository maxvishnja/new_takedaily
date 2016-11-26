@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			@if( ! isset( $coupon ) )
				<h3>Add new coupon</h3>
			@else
				<h3>Edit coupon: {{ $coupon->code }} ({{ $coupon->id }})</h3>
			@endif
		</div>

		<div class="module-body">

			<form method="POST" class="form-horizontal row-fluid" action="{{ isset( $coupon ) ? URL::action('Dashboard\CouponController@update', [ $coupon->id ]) : URL::action('Dashboard\CouponController@store') }}">
				<div class="clear"></div>

				<div class="control-group">
					<label for="code" class="control-label">Code</label>
					<div class="controls">
						<input type="text" class="form-control span8" name="code" id="code" value="{{ Request::old('code', isset($coupon) ? $coupon->code : '' ) }}" placeholder="Couponcode (example.: HALF-OFF-2016)" style="text-transform: uppercase"/>
					</div>
				</div>

				<div class="control-group">
					<label for="description" class="control-label">Description</label>
					<div class="controls">
						<textarea name="description" id="description" class="form-control span8" rows="5" placeholder="This will be shown to the user! - Example: Spring promo 2016">{!! Request::old('description', isset($coupon) ? $coupon->description : '' ) !!}</textarea>
					</div>
				</div>

				<div class="control-group">
					<label for="currency" class="control-label">Currency</label>
					<div class="controls">
						<select name="currency" id="currency" onchange="if( $('#type').val() != 'percentage' ) { $('#discount_text').text($(this).val()) }">
							@foreach(['DKK','EUR','USD','SEK','NOK','GBP'] as $option)
								<option value="{{ $option }}" @if(isset($coupon) && $coupon->currency == $option) selected="selected" @endif>{{ $option }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="control-group">
					<label for="type" class="control-label">Type</label>
					<div class="controls">
						<select name="type" id="type" onchange="if($(this).val() == 'free_shipping') { $('#discount_element').hide(); } else { $('#discount_element').show(); if( $(this).val() == 'percentage' ) { $('#discount_text').text('%') } else { $('#discount_text').text($('#currency').val()) } }">
							@foreach(['percentage', 'amount'] as $option)
								<option value="{{ $option }}" @if(isset($coupon) && $coupon->discount_type == $option) selected="selected" @endif>{{ trans("coupons.type.$option") }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="control-group" id="discount_element">
					<label for="discount" class="control-label">Worth</label>
					<div class="controls">
						<input type="text" class="form-control span8" name="discount" id="discount" value="{{ Request::old('discount', isset($coupon) ? ($coupon->discount_type == 'amount' ? \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($coupon->discount) : $coupon->discount_type) : '' ) }}" placeholder="Eks.: 80 for 80 DKK or percentage discount"/>
						<span id="discount_text">kr. / procent</span>
					</div>
				</div>

				<div class="control-group" id="uses_left_element">
					<label for="uses_left" class="control-label">Uses left</label>
					<div class="controls">
						<input type="text" class="form-control span8" name="uses_left" id="uses_left" value="{{ Request::old('uses_left', isset($coupon) ? $coupon->uses_left : '' ) }}" placeholder="Example.: 100"/>
						<p class="help-block">For unlimited uses, <a href="#uses_left_element" title="Unlimited = -1" onclick="$('#uses_left').val(-1);">click here</a>.</p>
					</div>
				</div>

				<div class="control-group">
					<label for="applies_to" class="control-label">Can be used on</label>
					<div class="controls">
						<select name="applies_to" id="applies_to">
							@foreach(['order', 'plan'] as $option)
								<option value="{{ $option }}" @if(isset($coupon) && $coupon->applies_to == $option) selected="selected" @endif>{{ trans("coupons.applies.$option") }}</option>
							@endforeach
						</select>
						<p class="help-block"><strong>Subscription:</strong> the initial order and any future rebills on this subscription.<br/>
							<strong>Order:</strong> only the order its applied to.</p>
					</div>
				</div>

				<div class="control-group" id="uses_left_element">
					<label for="valid_from" class="control-label">Enabled from</label>
					<div class="controls">
						<input type="text" class="form-control span8 datepicker" name="valid_from" id="valid_from" value="{{ Request::old('valid_from', isset($coupon) ? $coupon->valid_from : '' ) }}"/>
					</div>
					<br/>
					<label for="valid_to" class="control-label">Enabled to</label>
					<div class="controls">
						<input type="text" class="form-control span8 datepicker" name="valid_to" id="valid_to" value="{{ Request::old('valid_to', isset($coupon) ? $coupon->valid_to : '' ) }}"/>
					</div>
				</div>

				<div class="control-group">
					<div class="controls clearfix">
						<a href="{{ URL::action('Dashboard\CouponController@index') }}" class="btn btn-default pull-right">Annuller</a>
						<button type="submit" class="btn btn-primary btn-large pull-left">@if(isset($coupon)) Save @else
								Create @endif</button>
					</div>
				</div>
				{{ csrf_field() }}

				@if(isset($coupon))
					{{ method_field('PUT') }}
				@endif
			</form>
		</div>
	</div><!--/.module-->
	@if( isset($coupon) )
		<div>
			<form method="POST" action="{{ URL::action('Dashboard\CouponController@destroy', [ $coupon->id ]) }}" onsubmit="return confirm('Are you sure?');">
				<button type="submit" class="btn btn-link">Delete coupon</button>
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
			</form>
		</div>
	@endif
@stop

@section('scripts')
	<script>
		$(function() {
			$( ".datepicker" ).datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
	</script>
@endsection