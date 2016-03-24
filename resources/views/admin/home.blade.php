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
				De sidste 12 måneder</h3>
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
@stop

@section('scripts')
	<script>
		var d1 = [
			@for($i = 0; $i <= 12; $i++)
				[ {{ 12 - $i }} , {{ $sales_year->where('year', date('Y', strtotime("-$i months")) * 1)->where('month', date('n', strtotime("-$i months")) * 1)->first() ? number_format($sales_year->where('year', date('Y', strtotime("-$i months")) * 1)->where('month', date('n', strtotime("-$i months")) * 1)->first()->total / 100 / 100, 2, '.', '') : 0 }} ],
			@endfor
		];

		var d2 = [
			@for($i = 0; $i <= 12; $i++)
				[ {{ 12 - $i }} , {{ $customers_year->where('year', date('Y', strtotime("-$i months")) * 1)->where('month', date('n', strtotime("-$i months")) * 1)->first() ? $customers_year->where('year', date('Y', strtotime("-$i months")) * 1)->where('month', date('n', strtotime("-$i months")) * 1)->first()->total : 0 }} ],
			@endfor
		];

		var plot = $.plot($('#placeholder2'),
			[{data: d1, label: 'Salg i hundrede kr.'}, {data: d2, label: 'Kunder'}], {
				xaxis: {ticks:
					[
						@for($i = 0; $i <= 12; $i++)
						[{{ 12 - $i }}, "{{ date('M Y', strtotime("-$i months")) }}"],
						@endfor
					]
				},
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
				// todo fix tooltips (and rounding!) fixme
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
	</script>
@endsection