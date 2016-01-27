@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			@if( ! isset( $coupon ) )
				<h3>Opret ny kupon</h3>
			@else
				<h3>Rediger kupon: {{ $coupon->code }} ({{ $coupon->id }})</h3>
			@endif
		</div>

		<div class="module-body">

			<form method="POST" class="form-horizontal row-fluid" action="{{ isset( $coupon ) ? URL::action('Dashboard\CouponController@update', [ $coupon->id ]) : URL::action('Dashboard\CouponController@store') }}">
				<div class="clear"></div>

				<div class="control-group">
					<label for="code" class="control-label">Kode</label>
					<div class="controls">
						<input type="text" class="form-control span8" name="code" id="code" value="{{ Request::old('code', isset($coupon) ? $coupon->code : '' ) }}" placeholder="Kuponkode (eks.: GRATIS-FRAGT)"/>
					</div>
				</div>

				<div class="control-group">
					<label for="description" class="control-label">Beskrivelse</label>
					<div class="controls">
						<textarea name="description" id="description" class="form-control span8" rows="5">{!! Request::old('description', isset($coupon) ? $coupon->description : '' ) !!}</textarea>
					</div>
				</div>

				<div class="control-group">
					<label for="type" class="control-label">Type</label>
					<div class="controls">
						<select name="type" id="type" onchange="if($(this).val() == 'free_shipping') { $('#discount_element').hide(); } else { $('#discount_element').show(); if( $(this).val() == 'percentage' ) { $('#discount_text').text('%') } else { $('#discount_text').text('kr.') } }">
							@foreach(['percentage', 'amount', 'free_shipping'] as $option)
								<option value="{{ $option }}" @if(isset($coupon) && $coupon->discount_type == $option) selected="selected" @endif>{{ $option }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="control-group" id="discount_element">
					<label for="discount" class="control-label">Værdi</label>
					<div class="controls">
						<input type="text" class="form-control span8" name="discount" id="discount" value="{{ Request::old('discount', isset($coupon) ? $coupon->discount : '' ) }}" placeholder="Eks.: 80 for 80 kr./procent rabat"/>
						<span id="discount_text">kr. / procent</span>
					</div>
				</div>

				<div class="control-group" id="uses_left_element">
					<label for="uses_left" class="control-label">Antal brug tilbage</label>
					<div class="controls">
						<input type="text" class="form-control span8" name="uses_left" id="uses_left" value="{{ Request::old('uses_left', isset($coupon) ? $coupon->uses_left : '' ) }}" placeholder="Eks.: 100"/>
						<p class="help-block">For uendeligt antal brug, <a href="#uses_left_element" title="Uendeligt antal brug = -1" onclick="$('#uses_left').val(-1);">tryk her</a>.</p>
					</div>
				</div>

				<div class="control-group">
					<label for="applies_to" class="control-label">Gyldig på</label>
					<div class="controls">
						<select name="applies_to" id="applies_to">
							@foreach(['order', 'plan'] as $option)
								<option value="{{ $option }}" @if(isset($coupon) && $coupon->applies_to == $option) selected="selected" @endif>{{ $option }}</option>
							@endforeach
						</select>
						<p class="help-block"><strong>Abonnent:</strong> hele abonnentet og alle fremtidige betalinger<br/>
							<strong>Ordre:</strong> kun denne ordre.</p>
					</div>
				</div>

				<div class="control-group" id="uses_left_element">
					<label for="valid_to" class="control-label">Gyldig fra</label>
					<div class="controls">
						<input type="text" class="form-control span8 datepicker" name="valid_to" id="valid_to" value="{{ Request::old('valid_to', isset($coupon) ? $coupon->valid_to : '' ) }}"/>
					</div>
					<br/>
					<label for="valid_from" class="control-label">Gyldig til</label>
					<div class="controls">
						<input type="text" class="form-control span8 datepicker" name="valid_from" id="valid_from" value="{{ Request::old('valid_from', isset($coupon) ? $coupon->valid_from : '' ) }}"/>
					</div>
				</div>

				<div class="control-group">
					<div class="controls clearfix">
						<a href="{{ URL::action('Dashboard\CouponController@index') }}" class="btn btn-default pull-right">Annuller</a>
						<button type="submit" class="btn btn-primary btn-large pull-left">@if(isset($coupon)) Gem @else
								Opret @endif</button>
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
			<form method="POST" action="{{ URL::action('Dashboard\CouponController@destroy', [ $coupon->id ]) }}" onsubmit="return confirm('Er du sikker på at du slette denne kupon?');">
				<button type="submit" class="btn btn-link">Slet kuponnen</button>
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
			</form>
		</div>
	@endif
@stop

@section('scripts')
	<script>
		$(function() {
			$( ".datepicker" ).datepicker();
		});
	</script>
@endsection