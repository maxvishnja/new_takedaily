<!DOCTYPE html>
<html lang="da">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TakeDaily Admin</title>
	<link type="text/css" href="/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="/admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	{{--<link type="text/css" href="/admin/bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">--}}
	<link type="text/css" href="/admin/css/theme.css" rel="stylesheet">
	<link type="text/css" href="/admin/images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
		  rel='stylesheet'>
</head>
<body>
@include('admin.navigation')
<!-- /navbar -->
<div class="wrapper">
	<div class="container">
		<div class="row">
		@include('admin.sidebar')
		<!--/.span3-->
			<div class="span9">
				<div class="content">
					@if( $errors->has() )
						@foreach($errors->all() as $error)
							<div class="alert alert-error">
								{!! $error !!}
							</div>
						@endforeach
					@endif

					@if( session('success') )
						<div class="alert alert-success">
							{!! session('success') !!}
						</div>
					@endif
					@yield('content')
				</div>
				<!--/.content-->
			</div>
			<!--/.span9-->
		</div>
	</div>
	<!--/.container-->
</div>
<!--/.wrapper-->
<script src="/admin/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="/admin/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="/admin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
{{--<script src="/admin/bootstrap/js/bootstrap-datepicker.js" type="text/javascript"></script>--}}
<script src="/admin/js/flot/jquery.flot.js" type="text/javascript"></script>
<script src="/admin/js/flot/jquery.flot.resize.js" type="text/javascript"></script>
<script src="/admin/js/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="/admin/js/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="/admin/js/common.js" type="text/javascript"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

@yield('scripts')

</body>
