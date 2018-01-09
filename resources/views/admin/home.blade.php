@extends('layouts.admin')

@section('content')
	<div class="btn-controls">
		<div class="btn-box-row row-fluid">
			<a href="#" class="btn-box big span3"><i class="icon-shopping-cart"></i><b>{{ $orders_today }}</b>
				<p class="text-muted">Ordre i dag</p>

				<div class="col-6">
					<p class="text-muted">Test</p>
					<b>{{$orders_today - $orders_pick_today}}</b>
				</div>
				<div class="col-6">
					<p class="text-muted">PicknMix</p>
					<b>{{$orders_pick_today}}</b>
				</div>

			</a>



			<a href="#" class="btn-box big span3"><i class="icon-group"></i><b>{{ $customers_today }}</b>
				<p class="text-muted">Nye kunder i dag</p>
				<div class="col-6">
					<p class="text-muted">Test</p>
					<b>{{$customers_today - $customers_pick_today}}</b>
				</div>
				<div class="col-6">
					<p class="text-muted">PicknMix</p>
					<b>{{$customers_pick_today}}</b>
				</div>

			</a>


			<a href="#" class="btn-box big span3"><i class="icon-thumbs-down"></i><b>{{ $churnDay }}</b>
				<p class="text-muted">kunder i dag</p>
				<div class="col-6">
					<p class="text-muted">Test</p>
					<b>{{$churnDay - $churnPickDay}}</b>
				</div>
				<div class="col-6">
					<p class="text-muted">PicknMix</p>
					<b>{{$churnPickDay}}</b>
				</div>
			</a>

			<a href="#" class="btn-box big span3"><i class="icon-money"></i><b>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($money_today, 2) }}</b>
				<p class="text-muted">EUR i dag</p>
			</a>

		</div>

		<div class="btn-box-row row-fluid">
			<a href="#" class="btn-box big span3">
				<img src="/images/holland.png" style="height:50px">
				<b>{{ $activeNL }}</b>
				<p class="text-muted">Active customers</p>
				<div class="col-6">
					<p class="text-muted">Test</p>
					<b>{{$activeNL - $activePickNL}}</b>
				</div>
				<div class="col-6">
					<p class="text-muted">PicknMix</p>
					<b>{{$activePickNL}}</b>
				</div>
			</a>

			<a href="#" class="btn-box big span3">
				<img src="/images/denmark.gif" style="height:50px">
				<b>{{ $activeDK }}</b>
				<p class="text-muted">Active customers</p>
				<div class="col-6">
					<p class="text-muted">Test</p>
					<b>{{$activeDK - $activePickDK}}</b>
				</div>
				<div class="col-6">
					<p class="text-muted">PicknMix</p>
					<b>{{$activePickDK}}</b>
				</div>
			</a>

		</div>
	</div>
	<!--/#btn-controls-->

	<div class="module">
		<div class="module-head">
			<h3>

				Customers of month  {{ \Jenssegers\Date\Date::now()->format('M Y') }}</h3>
		</div>
		<div class="module-body">
			<div class="chart inline-legend grid">
				<div id="placeholder4" class="graph" style="height: 300px">
				</div>
			</div>
		</div>
	</div>

	<div class="module">
		<div class="module-head">
			<h3>

				Orders of rebill {{ \Jenssegers\Date\Date::now()->format('M Y') }}</h3>
		</div>
		<div class="module-body">
			<div class="chart inline-legend grid">
				<div id="placeholder10" class="graph" style="height: 300px">
				</div>
			</div>
		</div>
	</div>

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



	<div class="module">
		<div class="module-head">
			<h3>
				Sendt: De sidste 12 måneder</h3>
		</div>
		<div class="module-body">
			<div class="chart inline-legend grid">
				<div id="placeholder5" class="graph" style="height: 300px">
				</div>
			</div>
		</div>
	</div>


	<div class="module">
		<div class="module-head">
			<h3>
				Betalt Salg: De sidste 12 måneder</h3>
		</div>
		<div class="module-body">
			<div class="chart inline-legend grid">
				<div id="placeholder7" class="graph" style="height: 300px">
				</div>
			</div>
		</div>
	</div>
	<!--/.module-->

	<div class="module">
	<!--/.module-->
	<div class="module-head">
		<h3>
			Kundebase: De sidste 12 måneder</h3>
	</div>
	<div class="module-body">
		<div class="chart inline-legend grid">
			<div id="placeholder6" class="graph" style="height: 300px">
			</div>
		</div>
	</div>
	</div>
	<!--/.module-->
@stop

@section('scripts')
	<script>
		{{--var d11 = [--}}
			{{--@foreach(range(0,12) as $i)--}}
				{{--[ {{ 12 - $i }} , {{ $sales_year->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first() != null ? number_format($sales_year->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first()->total / 100, 2, '.', '') : 0 }} ],--}}
			{{--@endforeach--}}
		{{--];--}}

		var d2 = [
			@foreach(range(0,12) as $i)
				[ {{ 12 - $i }} , {{ $customers_year->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first() != null ? $customers_year->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first()->total : 0 }} ],
			@endforeach
		];

		var d3 = [
				@foreach(range(0,date('t')-1) as $i)
			[ {{  $i+1 }} , {{ $customers_day->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('n') * 1)->where('day', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('d') * 1)->first() != null ? $customers_day->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('n') * 1)->where('day', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('d') * 1)->first()->total : 0 }} ],
			@endforeach
		];

		var d4 = [
				@foreach(range(0,date('t')-1) as $i)
			[ {{  $i+1 }} , {{ $customers_unsub->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('n') * 1)->where('day', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('d') * 1)->first() != null ? $customers_unsub->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('n') * 1)->where('day', \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('d') * 1)->first()->total * -1: 0 }} ],
			@endforeach
		];

        var d5 = [
				@foreach(range(0,12) as $i)
            [ {{ 12 - $i }} , {{ $orderYear->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first() != null ? $orderYear->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first()->total : 0 }} ],

			@endforeach
        ];

        var d8 = [
				@foreach(range(0,12) as $i)
            [ {{ 12 - $i }} , {{ $orderMoneyYear->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first() != null ? $orderMoneyYear->where('year', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') * 1)->where('month', \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1)->first()->total : 0 }} ],

			@endforeach
        ];

        var d6 = [
			@foreach(range(0,12) as $i)
            [ {{ 12 - $i }} , {{ \App\Apricot\Repositories\CustomerRepository::getMonthlyFinish(\Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i-1)->format('Y-n-d') , \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1) }} ],
			@endforeach
        ];
        var d1 = [
				@foreach(range(0,12) as $i)
            [ {{ 12 - $i }} , {{ \App\Apricot\Repositories\OrderRepository::getPaidOrder(\Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('Y') , \Jenssegers\Date\Date::now()->firstOfMonth()->subMonths($i)->format('n') * 1) }} ],
			@endforeach
        ];
        var d10 = [
				@foreach(range(0,date('t')-1) as $i)
            [ {{  $i+1 }} , {{ \App\Apricot\Repositories\CustomerRepository::getFutureOrders(\Jenssegers\Date\Date::now()->addDays($i+1)->format('Y-m-d') ) }} ],
			@endforeach
        ];

        var plot = $.plot($('#placeholder10'),
            [
                {
                    data: d10,
                    label: 'Future orders'
                }

            ],
            {
                xaxis: {ticks:
                    [
							@for($i = 0; $i <= date('t'); $i++)
                        [{{  $i+1 }}, "{{ \Jenssegers\Date\Date::now()->addDays($i)->format('d M') }}"],
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
                    minBorderMargin: 25
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
        $('#placeholder10').bind('plothover', function (event, pos, item)
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






		var plot = $.plot($('#placeholder4'),
				[
					{
						data: d3,
						label: 'New customers'
					},
					{
						data: d4,
						label: 'Unsubscribed customers',
						color: "#ff0000"
					}
				],
				{
					xaxis: {ticks:
							[
								@for($i = 0; $i <= date('t'); $i++)
									[{{  $i+1 }}, "{{ \Jenssegers\Date\Date::now()->firstOfMonth()->addDays($i)->format('d') }}"],
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
						minBorderMargin: 25
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
		$('#placeholder4').bind('plothover', function (event, pos, item)
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


        /** DATA 3 **/
        var plot = $.plot($('#placeholder5'),
            [{data: d5, label: 'Orders.'}], {
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
            $('<div id="gridtip">' + contents + '</div>').css({
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 5
            }).appendTo('body').fadeIn(300);
        }

        var previousPoint = null;
        $('#placeholder5').bind('plothover', function (event, pos, item)
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



        /** DATA 3 **/
        var plot = $.plot($('#placeholder7'),
            [{data: d8, label: 'Orders with paid'}], {
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
            $('<div id="gridtip">' + contents + '</div>').css({
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 5
            }).appendTo('body').fadeIn(300);
        }

        var previousPoint = null;
        $('#placeholder7').bind('plothover', function (event, pos, item)
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


        /** DATA 4 **/
        var plot = $.plot($('#placeholder6'),
            [{data: d6, label: 'Kunder'}], {
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
            $('<div id="gridtip">' + contents + '</div>').css({
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 5
            }).appendTo('body').fadeIn(300);
        }

        var previousPoint = null;
        $('#placeholder6').bind('plothover', function (event, pos, item)
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