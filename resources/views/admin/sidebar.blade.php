<div class="span3">
	<div class="sidebar">
		<ul class="widget widget-menu unstyled">
			<li class="active"><a href="/dashboard"><i class="menu-icon icon-dashboard"></i>Dashboard</a></li>
			<li><a href="/dashboard/customers"><i class="menu-icon icon-group"></i>Kunder</a></li>
			<li><a href="/dashboard/orders"><i class="menu-icon icon-money"></i>Ordre @if($sidebar_numOrders > 0)<b class="label green pull-right">{{ $sidebar_numOrders }}</b>@endif</a></li>
			<li><a href="/dashboard/calls"><i class="menu-icon icon-phone"></i>Opkald @if($sidebar_numCalls > 0)<b class="label orange pull-right">{{ $sidebar_numCalls }}</b>@endif</a></li>
		</ul>
		<!--/.widget-nav-->
		<ul class="widget widget-menu unstyled">
			<li><a href="/dashboard/pages"><i class="menu-icon icon-edit"></i>CMS</a></li>
			<li><a href="/dashboard/faq"><i class="menu-icon icon-question-sign"></i>FAQ</a></li>
			{{--<li><a href="/dashboard/products"><i class="menu-icon icon-list"></i>Produkter</a></li>--}}
			<li><a href="/dashboard/coupons"><i class="menu-icon icon-barcode"></i>Kuponkoder</a></li>
			<li><a href="/dashboard/rewrites"><i class="menu-icon icon-random"></i>Omdirigeringer</a></li>
			<li><a href="/dashboard/settings"><i class="menu-icon icon-cog"></i>Indstillinger</a></li>
		</ul>
	</div>
	<!--/.sidebar-->
</div>