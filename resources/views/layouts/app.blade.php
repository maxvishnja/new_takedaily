@include('includes.app.header')

<header class="header--with-bg">
	<div class="header-nav">
		<div class="container-fluid">
			@if(\Cookie::get('campaign')!= null)
				<div class="row">
					<div class="col-md-12 promocode">
						<div class="promo-text">
								{!! \App\Apricot\Helpers\CampaignHelper::getPromoCampaign(\Cookie::get('campaign')) !!}
						</div>
					</div>
				</div>
			@endif
			<div class="header_top_tb">
				<div class="row">
					<div class="col-md-3 col-xs-9">
						<a href="/" class="logo logo-color"></a>
					</div>

					<div class="col-md-9 col-xs-3">
						@include('includes.app.nav')
					</div>
				</div>
			</div>
		</div>
	</div>

	@yield('header_top_additional')
</header>

<main @if(!isset($mainClasses)) class="@yield('mainClasses', 'm-t-50 m-b-50')" @else class="{{ $mainClasses }}" @endif>
	@yield('content')
</main>

@include('includes.app.footer')
