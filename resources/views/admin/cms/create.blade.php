@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3>Opret ny side</h3>
		</div>

		<div class="module-body">

			<form method="post" class="form-horizontal row-fluid" action="{{ URL::action('Dashboard\PageController@store') }}" enctype="multipart/form-data">
				<div class="clear">

				<ul class="nav nav-tabs" role="tablist">
						<li class="active"><a href="#main" data-toggle="tab">Indhold</a></li>
						<li class=""><a href="#meta" data-toggle="tab">Meta</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="main">
							<div class="control-group">
								<label for="page_title" class="control-label">Sidens titel</label>
								<div class="controls">
									<input type="text" class="form-control span8" name="title" id="page_title" placeholder="Sidens titel"/>
									<p class="help-block">Sidens url bliver:
										<mark id="page_handle_preview">/</mark>
									</p>
								</div>
							</div>

							<div class="control-group">
								<label for="page_title" class="control-label">Sidens undertitel</label>
								<div class="controls">
									<input type="text" class="form-control span8" name="sub_title" id="page_subtitle" placeholder="Sidens undertitel"/>
								</div>
							</div>

							<div class="control-group">
								<label for="page_body" class="control-label">Sidens indhold</label>
								<div class="controls">
									<textarea name="body" class="form-control" rows="10" id="page_body" placeholder="Indhold..."></textarea>
								</div>
							</div>

							<div class="control-group"></div> <!-- To fix :last-child bug -->
						</div>

						<div role="tabpanel" class="tab-pane" id="meta">
							<div class="control-group">
								<label for="meta_title" class="control-label">Meta titel</label>
								<div class="controls">
									<input type="text" class="form-control span8" name="meta_title" id="meta_title" placeholder="Meta titel"/>
								</div>
							</div>

							<div class="control-group">
								<label for="meta_description" class="control-label">Meta beskrivelse</label>
								<div class="controls">
									<textarea class="form-control span8" rows="4" name="meta_description" id="meta_description" placeholder="Meta beskrivelse"></textarea>
								</div>
							</div>

							<div class="control-group">
								<label for="meta_image" class="control-label">Meta billede</label>
								<div class="controls">
									<input type="file" name="meta_image" id="meta_image" class="form-control" />
								</div>
							</div>

							<div class="control-group"></div> <!-- To fix :last-child bug -->
						</div>
					</div>

				</div>

				<div class="control-group">
					<div class="controls clearfix">
						<a href="{{ URL::action('Dashboard\PageController@index') }}" class="btn btn-default pull-right">Annuller</a>
						<button type="submit" class="btn btn-primary btn-large pull-left">Opret</button>
					</div>
				</div>
				{{ csrf_field() }}
			</form>
		</div>
	</div><!--/.module-->
@stop

@section('scripts')
	<script>
		if ($('.datatable-1').length > 0)
		{
			$('.datatable-1').dataTable({
				"columnDefs": [
					{
						"targets": [5],
						"sortable": false,
						"searchable": false
					}
				]
			});
			$('.dataTables_paginate').addClass('btn-group datatable-pagination');
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		}

		$("#page_title").on('input', function ()
		{
			var handle = $(this).val();
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

			$("#page_handle_preview").text('/' + handle);
		});

		CKEDITOR.replace('page_body', {
			height: 300,
			language: "da",
			filebrowserImageUploadUrl: '/dashboard/upload/image' // todo
		});
	</script>
@endsection