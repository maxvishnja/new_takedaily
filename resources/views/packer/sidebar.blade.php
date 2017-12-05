<div class="span3">
	<div class="sidebar">
		<ul class="widget widget-menu unstyled">
			<li class="active"><a href="/packaging"><i class="menu-icon icon-dashboard"></i>Home</a></li>
			<li><a href="/packaging/orders"><i class="menu-icon icon-money"></i>Pending orders @if($sidebar_numOrders > 0)<b class="label green pull-right">{{ $sidebar_numOrders }}</b>@endif</a></li>
			<li><a href="/packaging/printed-orders"><i class="menu-icon icon-download"></i>Printed orders @if($printed_numOrders > 0)<b class="label green pull-right">{{ $printed_numOrders }}</b>@endif</a></li>
			<li><a href="/packaging/shipped-orders"><i class="menu-icon icon-truck"></i>Sent orders</a></li>
			<li><a href="/packaging/stock"><i class="menu-icon icon-exchange"></i>Stock</a></li>
		</ul>
		<!--/.widget-nav-->
	</div>
	<!--/.sidebar-->
</div>