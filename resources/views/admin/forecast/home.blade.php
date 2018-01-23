@extends('layouts.admin')

@section('content')
<div class="module">
    <div class="module-head">
        <h3>
            Orders within a month</h3>
    </div>
    <div class="module-body">
        <div class="chart inline-legend grid">
            <div id="placeholder10" class="graph" style="height: 300px">
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script>
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


    </script>


@endsection