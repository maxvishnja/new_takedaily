@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			@if( ! isset( $product ) )
				<h3>Opret nyt produkt</h3>
			@else
				<h3>Rediger produkt: {{ $product->name }} ({{ $product->id }})</h3>
			@endif
		</div>

		<div class="module-body">

			<form method="POST" class="form-horizontal row-fluid" action="{{ isset( $product ) ? URL::action('Dashboard\ProductController@update', [ $product->id ]) : URL::action('Dashboard\ProductController@store') }}" enctype="multipart/form-data">
				<div class="clear"></div>

				<div class="control-group">
					<label for="page_title" class="control-label">Navn</label>
					<div class="controls">
						<input type="text" class="form-control span8" name="name" id="product_name" value="{{ Request::old('title', isset($product) ? $product->name : '' ) }}" placeholder="Produktets navn"/>
						<p class="help-block">Produktets url bliver:
							<mark id="slug_preview">
								/product/{{ isset($product) ? $product->slug: '' }}</mark>
						</p>
					</div>
				</div>

				<div class="control-group">
					<label for="page_title" class="control-label">Normalpris</label>
					<div class="controls">
						<input type="text" class="form-control span8" name="price" id="product_price" value="{{ Request::old('price', isset($product) ? \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price_default, true) : '' ) }}" placeholder="Pris (eks.: 399,00)"/>
						kr.
					</div>
				</div>

				<div class="control-group">
					<label for="page_title" class="control-label">Nuværende pris</label>
					<div class="controls">
						<input type="text" class="form-control span8" name="price_special" id="product_price_special" value="{{ Request::old('price_special', isset($product) ? \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price_special, true) : '' ) }}" placeholder="Pris (eks.: 299,00)"/>
						kr.
					</div>
				</div>

				<div class="control-group">
					<label for="page_title" class="control-label">Beskrivelse</label>
					<div class="controls">
						<textarea name="description" id="product_description" class="form-control span8" rows="5">{!! Request::old('description', isset($product) ? $product->description : '' ) !!}</textarea>
					</div>
				</div>

				<div class="control-group">
					<label for="page_title" class="control-label">Billede</label>
					<div class="controls">
						<input type="file" class="form-control span8" name="picture" id="product_picture"/>
						@if( isset( $product ) && $product->image_url)
							<div class="clear"></div>
							<img src="{{ $product->getImageThumb() }}" height="100" width="100"/>
						@endif
					</div>
				</div>

				<div class="control-group">
					<div class="controls clearfix">
						<a href="{{ URL::action('Dashboard\ProductController@index') }}" class="btn btn-default pull-right">Annuller</a>
						<button type="submit" class="btn btn-primary btn-large pull-left">@if(isset($product)) Gem @else
								Opret @endif</button>
					</div>
				</div>
				{{ csrf_field() }}

				@if(isset($product))
					{{ method_field('PUT') }}
				@endif
			</form>
		</div>
	</div><!--/.module-->
	@if( isset($product) )
		<div>
			<form method="POST" action="{{ URL::action('Dashboard\ProductController@destroy', [ $product->id ]) }}" onsubmit="return confirm('Er du sikker på at du slette dette produkt? Alle ordre-linjer og abonnenter med produktet, mister produktet. Dette betyder f.eks. at kundens nuværende ordre, og abonnent, ikke kommer til at indeholde produktet længere');">
				<button type="submit" class="btn btn-link">Slet produktet</button>
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
			</form>
		</div>
	@endif
@stop

@section('scripts')
	<script>
		$("#product_name").on('input', function ()
		{
			generateSlug($(this).val());
		});

		function generateSlug(value)
		{
			var handle = value;
			handle = handle.trim(' ');
			handle = handle.toLowerCase();
			handle = handle.replace(/(å)/g, 'aa');
			handle = handle.replace(/(ø)/g, 'oe');
			handle = handle.replace(/(æ)/g, 'ae');
			handle = handle.replace(/\s\s+/g, ' ');
			handle = handle.replace(/( )/g, '-');
			handle = handle.replace(/([^a-z0-9-])/g, '');
			handle = handle.replace(/\-\-+/g, '-');
			handle = handle.substr(0, 50);

			$("#slug_preview").text('/product/' + handle);
		}

		generateSlug($("#product_name").val());

		CKEDITOR.replace('product_description', {
			height: 300,
			language: "da"
		});
	</script>
@endsection