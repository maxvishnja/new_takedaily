@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			@if( ! isset( $page ) )
				<h3>Opret ny side</h3>
			@else
				<h3>Rediger side: {{ $page->title }} (/{{ $page->url_identifier }})</h3>
			@endif
		</div>

		<div class="module-body">

			<form id="cms_manage_form" method="POST" class="form-horizontal row-fluid" action="{{ isset( $page ) ? URL::action('Dashboard\PageController@update', [ $page->id ]) : URL::action('Dashboard\PageController@store') }}" enctype="multipart/form-data">
				<div class="clear">

					<ul class="nav nav-tabs" role="tablist">
						<li class="active"><a href="#main" data-toggle="tab">Indhold</a></li>
						<li class=""><a href="#meta" data-toggle="tab">Meta</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="main">
							<div class="control-group">
								<label for="page_title" class="control-label">Sidens layout</label>
								<div class="controls">
									<label style="display: inline-block; border: 1px solid #eee; border-radius: 4px; padding: 10px; margin-right: 10px;">
										<input type="radio" name="layout" id="page_layout" value="plain" @if(Request::old('layout', isset($page) ? $page->layout : 'plain') == 'plain') checked="checked" @endif />
										<img src="{{ asset('admin/images/icons/icon-cms-layout-plain.png') }}" alt="">
									</label>

									<label style="display: inline-block; border: 1px solid #eee; border-radius: 4px; padding: 10px;">
										<input type="radio" name="layout" id="page_layout" value="header" @if(Request::old('layout', isset($page) ? $page->layout : 'plain') == 'header') checked="checked" @endif />
										<img src="{{ asset('admin/images/icons/icon-cms-layout-header.png') }}" alt="">
									</label>
								</div>
							</div>

							<div id="layout_header_only" class="control-group" @if(Request::old('layout', isset($page) ? $page->layout : 'plain') == 'plain') style="display: none" @endif>
								<label for="page_title" class="control-label">Top billede</label>
								<div class="controls">
									<input type="file" name="top_image" id="top_image" accept="image/jpeg,image/jpg,image/png,image/gif" class="form-control"/>
									<p class="help-block">Anbefalet størrelse: 1920x800 pixels</p>
									<p class="help-block">Tilføj et nyt billede for at skifte nuværende, ellers lad
										den feltet være tomt.</p>
									@if( isset($page) ? $page->top_image : '' != '')
										<img src="{{ isset($page) ? $page->top_image : '' }}" class="img-responsive" alt="Meta image" width="480" height="200" style="max-height: 200px; width: auto;"/>
									@endif
								</div>
							</div>

							<div class="control-group">
								<label for="page_title" class="control-label">Sidens titel</label>
								<div class="controls">
									<input type="text" class="form-control span8" name="title" id="page_title" value="{{ Request::old('title', isset($page) ? $page->title : '' ) }}" placeholder="Sidens titel"/>
									<p class="help-block">Sidens url bliver:
										<mark @if(!isset($page) || (isset($page) && !$page->isLocked())) id="page_handle_preview" @endif>
											/{{ isset($page) ? $page->url_identifier : '' }}</mark>
										@if(isset($page))<p><small>Der bliver automatisk oprettet omdirigeringer for at SEO ikke går tabt.</small></p>@endif
									</p>
								</div>
							</div>

							<div class="control-group">
								<label for="page_title" class="control-label">Sidens undertitel</label>
								<div class="controls">
									<input type="text" class="form-control span8" name="sub_title" id="page_subtitle" value="{{ Request::old('sub_title', isset($page) ? $page->sub_title : '' ) }}" placeholder="Sidens undertitel"/>
								</div>
							</div>

							<div class="control-group">
								<label for="page_body" class="control-label">Sidens indhold</label>
								<div class="controls">
									<textarea name="body" class="form-control" rows="10" id="page_body" placeholder="Indhold...">{!! Request::old('body', isset($page) ? $page->body : '' ) !!}</textarea>
								</div>
							</div>

							<div class="control-group"></div> <!-- To fix :last-child bug -->
						</div>

						<div role="tabpanel" class="tab-pane" id="meta">
							<div class="control-group">
								<label for="meta_title" class="control-label">Meta titel</label>
								<div class="controls">
									<input type="text" class="form-control span8" name="meta_title" id="meta_title" value="{{ Request::old('meta_title', isset($page) ? $page->meta_title : '' ) }}" placeholder="Meta titel"/>
								</div>
							</div>

							<div class="control-group">
								<label for="meta_description" class="control-label">Meta beskrivelse</label>
								<div class="controls">
									<textarea class="form-control span8" rows="4" name="meta_description" id="meta_description" placeholder="Meta beskrivelse">{{ Request::old('meta_description', isset($page) ? $page->meta_description : '' ) }}</textarea>
								</div>
							</div>

							<div class="control-group">
								<label for="meta_image" class="control-label">Meta billede</label>
								<div class="controls">
									<input type="file" name="meta_image" id="meta_image" accept="image/jpeg,image/jpg,image/png,image/gif" class="form-control"/>
									@if( isset( $page ) && $page->meta_image )
										<p class="help-block">Tilføj et nyt billede for at skifte nuværende, ellers lad
											den feltet være tomt.</p>
										<img src="{{ $page->meta_image }}" class="img-responsive" alt="Meta image" width="1200" height="630"/>
									@endif
								</div>
							</div>

							<div class="control-group"></div> <!-- To fix :last-child bug -->
						</div>
					</div>

				</div>

				<div class="control-group">
					<div class="controls clearfix">
						<a href="{{ URL::action('Dashboard\PageController@index') }}" class="btn btn-default pull-right">Annuller</a>
						<button type="submit" class="btn btn-primary btn-large pull-left">@if(isset($page)) Gem @else
								Opret @endif</button>
					</div>
				</div>
				{{ csrf_field() }}

				@if(isset($page))
					{{ method_field('PUT') }}
				@endif
			</form>
		</div>
	</div><!--/.module-->
	@if( isset($page) && !$page->isLocked() )
		<div>
			<form method="POST" action="{{ URL::action('Dashboard\PageController@destroy', [ $page->id ]) }}" onsubmit="return confirm('Er du sikker på at du slette denne side?');">
				<button type="submit" class="btn btn-link">Slet siden</button>
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
			</form>
		</div>
	@endif
@stop

@section('scripts')
	<script>
		@if(!isset($page) || (isset($page) && $page->url_identifier != 'home'))
			$("#page_title").on('input', function ()
		{
			generateSlug($(this).val());
		});

		function generateSlug(value)
		{
			var handle = value;
			handle = handle.trim(' ');
			handle = handle.toLowerCase();
			handle = handle.replace(/(å)/g, 'a');
			handle = handle.replace(/(ø)/g, 'o');
			handle = handle.replace(/(æ)/g, 'ae');
			handle = handle.replace(/\s\s+/g, ' ');
			handle = handle.replace(/( )/g, '-');
			handle = handle.replace(/([^a-z0-9-])/g, '');
			handle = handle.replace(/\-\-+/g, '-');
			handle = handle.substr(0, 50);

			$("#page_handle_preview").text('/' + handle);
		}

		generateSlug($("#page_title").val());
		@endif

		CKEDITOR.replace('page_body', {
			height: 300,
			language: "da",
			filebrowserImageUploadUrl: '/dashboard/upload/image' // todo
		});

		$("#cms_manage_form").on('change', function ()
		{
			$("#layout_header_only").css('display', $(this).find('input[name="layout"]:checked').val() == 'header' ? 'block' : 'none');
		});
	</script>

	<style>
		iframe.cke_wysiwyg_frame.cke_reset,
		span#cke_1_top.cke_top.cke_reset_all {
			width:     100%;
			max-width: 1140px;
			height:    100%;
			margin:    0 auto !important;
			display:   block;
		}
	</style>
@endsection