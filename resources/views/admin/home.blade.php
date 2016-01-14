@extends('layouts.admin')

@section('content')
	<div class="btn-controls">
		<div class="btn-box-row row-fluid">
			<a href="#" class="btn-box big span4"><i class=" icon-shopping-cart"></i><b>{{ $orders_today }}</b>
				<p class="text-muted">Ordre i dag</p>
			</a>

			<a href="#" class="btn-box big span4"><i class="icon-group"></i><b>{{ $customers_today }}</b>
				<p class="text-muted">Nye kunder i dag</p>
			</a>

			<a href="#" class="btn-box big span4"><i class="icon-money"></i><b>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($money_today, 2) }}</b>
				<p class="text-muted">DKK i dag</p>
			</a>
		</div>
	</div>
	<!--/#btn-controls-->
	<div class="module">
		<div class="module-head">
			<h3>
				Profit Chart</h3>
		</div>
		<div class="module-body">
			<div class="chart inline-legend grid">
				<div id="placeholder2" class="graph" style="height: 500px">
				</div>
			</div>
		</div>
	</div>
	<!--/.module-->
	<div class="module hide">
		<div class="module-head">
			<h3>
				Adjust Budget Range</h3>
		</div>
		<div class="module-body">
			<div class="form-inline clearfix">
				<a href="#" class="btn pull-right">Update</a>
				<label for="amount">
					Price range:</label>
				&nbsp;
				<input type="text" id="amount" class="input-"/>
			</div>
			<hr/>
			<div class="slider-range">
			</div>
		</div>
	</div>
	<div class="module">
		<div class="module-head">
			<h3>Kunder</h3>
		</div>
		<div class="module-body table">
			<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display"
				   width="100%">
				<thead>
				<tr>
					<th>Navn</th>
					<th>Oprettet d.</th>
					<th>Betalt i alt</th>
					<th>Mnd. pris</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Firefox 1.0
					</td>
					<td>
						Win 98+ / OSX.2+
					</td>
					<td class="center">
						1.7
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Firefox 1.5
					</td>
					<td>
						Win 98+ / OSX.2+
					</td>
					<td class="center">
						1.8
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Firefox 2.0
					</td>
					<td>
						Win 98+ / OSX.2+
					</td>
					<td class="center">
						1.8
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Firefox 3.0
					</td>
					<td>
						Win 2k+ / OSX.3+
					</td>
					<td class="center">
						1.9
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Camino 1.0
					</td>
					<td>
						OSX.2+
					</td>
					<td class="center">
						1.8
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Camino 1.5
					</td>
					<td>
						OSX.3+
					</td>
					<td class="center">
						1.8
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Netscape 7.2
					</td>
					<td>
						Win 95+ / Mac OS 8.6-9.2
					</td>
					<td class="center">
						1.7
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Netscape Browser 8
					</td>
					<td>
						Win 98SE+
					</td>
					<td class="center">
						1.7
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Netscape Navigator 9
					</td>
					<td>
						Win 98+ / OSX.2+
					</td>
					<td class="center">
						1.8
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Mozilla 1.0
					</td>
					<td>
						Win 95+ / OSX.1+
					</td>
					<td class="center">
						1
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Mozilla 1.1
					</td>
					<td>
						Win 95+ / OSX.1+
					</td>
					<td class="center">
						1.1
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Mozilla 1.2
					</td>
					<td>
						Win 95+ / OSX.1+
					</td>
					<td class="center">
						1.2
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Mozilla 1.3
					</td>
					<td>
						Win 95+ / OSX.1+
					</td>
					<td class="center">
						1.3
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Mozilla 1.4
					</td>
					<td>
						Win 95+ / OSX.1+
					</td>
					<td class="center">
						1.4
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Mozilla 1.5
					</td>
					<td>
						Win 95+ / OSX.1+
					</td>
					<td class="center">
						1.5
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Mozilla 1.6
					</td>
					<td>
						Win 95+ / OSX.1+
					</td>
					<td class="center">
						1.6
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Mozilla 1.7
					</td>
					<td>
						Win 98+ / OSX.1+
					</td>
					<td class="center">
						1.7
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Mozilla 1.8
					</td>
					<td>
						Win 98+ / OSX.1+
					</td>
					<td class="center">
						1.8
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Seamonkey 1.1
					</td>
					<td>
						Win 98+ / OSX.2+
					</td>
					<td class="center">
						1.8
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Gecko
					</td>
					<td>
						Epiphany 2.20
					</td>
					<td>
						Gnome
					</td>
					<td class="center">
						1.8
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Webkit
					</td>
					<td>
						Safari 1.2
					</td>
					<td>
						OSX.3
					</td>
					<td class="center">
						125.5
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Webkit
					</td>
					<td>
						Safari 1.3
					</td>
					<td>
						OSX.3
					</td>
					<td class="center">
						312.8
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Webkit
					</td>
					<td>
						Safari 2.0
					</td>
					<td>
						OSX.4+
					</td>
					<td class="center">
						419.3
					</td>
					<td class="center">
						A
					</td>
				</tr>
				<tr class="gradeA">
					<td>
						Webkit
					</td>
					<td>
						Safari 3.0
					</td>
					<td>
						OSX.4+
					</td>
					<td class="center">
						522.1
					</td>
					<td class="center">
						A
					</td>
				</tr>
				</tbody>
				<tfoot>
				<tr>
					<th>Navn</th>
					<th>Oprettet d.</th>
					<th>Betalt i alt</th>
					<th>Mnd. pris</th>
					<th></th>
				</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<!--/.module-->
@stop

@section('scripts')
	<script>
		var d1 = [[0, 1], [1, 14], [2, 5], [3, 4], [4, 5], [5, 1], [6, 14], [7, 5], [8, 5]];
		var d2 = [[0, 5], [1, 2], [2, 10], [3, 1], [4, 9], [5, 5], [6, 2], [7, 10], [8, 8]];

		var plot = $.plot($('#placeholder2'),
			[{data: d1, label: 'Profits'}, {data: d2, label: 'Expenses'}], {
				lines: {
					show: true,
					fill: true, /*SWITCHED*/
					lineWidth: 2
				},
				points: {
					show: true,
					lineWidth: 5
				},
				grid: {
					clickable: true,
					hoverable: true,
					autoHighlight: true,
					mouseActiveRadius: 10,
					aboveData: true,
					backgroundColor: '#fff',
					borderWidth: 0,
					minBorderMargin: 25,
				},
				colors: ['#55f3c0', '#0db37e', '#b4fae3', '#e0d1cb'],
				shadowSize: 0
			});

		function showTooltip(x, y, contents)
		{
			$('<div id="gridtip">' + contents + '</div>').css({
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5
			}).appendTo('body').fadeIn(300);
		}

		var previousPoint = null;
		$('#placeholder2').bind('plothover', function (event, pos, item)
		{
			$('#x').text(pos.x.toFixed(2));
			$('#y').text(pos.y.toFixed(2));

			if (item)
			{
				if (previousPoint != item.dataIndex)
				{
					previousPoint = item.dataIndex;

					$('#gridtip').remove();
					var x = item.datapoint[0].toFixed(0),
						y = item.datapoint[1].toFixed(0);

					showTooltip(item.pageX, item.pageY,
						'x : ' + x + '&nbsp;&nbsp;&nbsp; y : ' + y);
				}
			}
			else
			{
				$('#gridtip').remove();
				previousPoint = null;
			}
		});

		if($('.datatable-1').length>0)
		{
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass('btn-group datatable-pagination');
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		}
	</script>
@endsection