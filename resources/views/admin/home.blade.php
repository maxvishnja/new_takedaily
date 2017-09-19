@extends('layouts.admin')

@section('content')
	<div class="btn-controls">
		<div class="btn-box-row row-fluid">
			<a href="#" class="btn-box big span3"><i class=" icon-shopping-cart"></i><b>{{ $orders_today }}</b>
				<p class="text-muted">Ordre i dag</p>
			</a>

			<a href="#" class="btn-box big span3"><i class="icon-group"></i><b>{{ $customers_today }}</b>
				<p class="text-muted">Nye kunder i dag</p>
			</a>


			<a href="#" class="btn-box big span3"><i class="icon-thumbs-down"></i><b>{{ $churnDay }}</b>
				<p class="text-muted">kunder i dag</p>
			</a>

			<a href="#" class="btn-box big span3"><i class="icon-money"></i><b>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($money_today, 2) }}</b>
				<p class="text-muted">EUR i dag</p>
			</a>


		</div>
	</div>
	<!--/#btn-controls-->
	<div class="module">
		<div class="module-head">
			<h3>
				Kunder: De sidste 12 måneder</h3>
		</div>
		<div class="module-body">
			<div class="chart inline-legend grid">
				<div id="placeholder2" class="graph" style="height: 300px">
				</div>
			</div>
		</div>
	</div>
	<!--/.module-->
	<div class="module">
		<div class="module-head">
			<h3>
				Salg: De sidste 12 måneder</h3>
		</div>
		<div class="module-body">
			<div class="chart inline-legend grid">
				<div id="placeholder3" class="graph" style="height: 300px">
				</div>
			</div>
		</div>
	</div>
	<!--/.module-->
@stop

@section('scripts')
	<script>
		var d1 = [
			@foreach(range(1,12) as $i)
				[ {{ 12 - $i }} , {{ $sales_year->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first() != null ? number_format($sales_year->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first()->total / 100, 2, '.', '') : 0 }} ],
			@endforeach
		];

		var d2 = [
			@foreach(range(1,12) as $i)
				[ {{ 12 - $i }} , {{ $customers_year->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first() != null ? $customers_year->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first()->total : 0 }} ],
			@endforeach
		];

		var plot = $.plot($('#placeholder2'),
			[{data: d2, label: 'Kunder'}], {
				xaxis: {ticks:
					[
						@for($i = 0; $i <= 12; $i++)
						[{{ 12 - $i }}, "{{ \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('M Y') }}"],
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

					showTooltip(item.pageX, item.pageY, y);
				}
			}
			else
			{
				$('#gridtip').remove();
				previousPoint = null;
			}
		});


		/** DATA 2 **/
		var plot = $.plot($('#placeholder3'),
			[{data: d1, label: 'Salg i kr.'}], {
				xaxis: {ticks:
					[
							@for($i = 0; $i <= 12; $i++)
						[{{ 12 - $i }}, "{{ \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('M Y') }}"],
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
				colors: ['#0db37e', '#55f3c0', '#b4fae3', '#e0d1cb'],
				shadowSize: 0
			});

		function showTooltipTwo(x, y, contents)
		{
			$('<div id="gridtip">' + (contents * 1).toFixed(2) + ' kr.</div>').css({
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5
			}).appendTo('body').fadeIn(300);
		}

		var previousPoint = null;
		$('#placeholder3').bind('plothover', function (event, pos, item)
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

					showTooltipTwo(item.pageX, item.pageY, y);
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