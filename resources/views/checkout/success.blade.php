@extends('layouts.app')

@section('pageClass', 'page-checkout-success')

@section('mainClasses', 'm-b-50 m-t-50')
@section('title', 'Din ordre blev godkendt! - Take Daily')

@section('content')
	<div class="container">
		<div class="print_label print_label--shadow hidden-xs">
			<div class="print_label_left">
				<div class="print_label_line">
					<div class="print_label_line_left">Vitamin D</div>
					<div class="print_label_line_right">1.a.6.B.d</div>
					<div class="clear"></div>
				</div>

				<div class="print_label_line">
					<div class="print_label_line_left">Vitamin D</div>
					<div class="print_label_line_right">1.a.6.B.d</div>
					<div class="clear"></div>
				</div>

				<div class="print_label_line">
					<div class="print_label_line_left">Vitamin D</div>
					<div class="print_label_line_right">1.a.6.B.d</div>
					<div class="clear"></div>
				</div>

				<div class="text-center">
					<span class="logo logo-color m-t-50"></span>
				</div>
			</div>
			<div class="print_label_right text-right">
				<div class="print_label_info_line"><strong>{{ Auth::user()->getName() }}</strong></div>
				<div class="print_label_info_line">{{ Auth::user()->getCustomer()->getCustomerAttribute('address_line1') }}</div>
				<div class="print_label_info_line">{{ Auth::user()->getCustomer()->getCustomerAttribute('address_postal') }}, {{ Auth::user()->getCustomer()->getCustomerAttribute('address_city') }}</div>
				<div class="print_label_info_line">{{ Auth::user()->getCustomer()->getCustomerAttribute('address_country') }}</div>
			</div>

			<div class="clear"></div>
		</div>

		<div class="text-center">
			<h1>Din ordre blev oprettet</h1>
			<p>Du vil indenfor 5 minutter modtage en ordrebekræftelse, med information omkring levering og din ordre generelt. Tak for dit køb!</p>

			<a href="/account" class="button button--green button--rounded button--medium">Gå til dit Take Daily</a>
		</div>
	</div>
@endsection
