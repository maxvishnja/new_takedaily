<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="{{ asset('/public/css/app.css') }}" rel="stylesheet" type="text/css"/>
	<style>
		th, td, p, div, b {
			margin: 0;
			padding: 0;
			page-break-inside: avoid;
		}

		* {
			padding: 0;
			margin: 0;
			page-break-after: avoid;
			page-break-before: avoid;
			page-break-inside: avoid;
		}

		html {
			line-height: 1;
			margin: 0;
			width: 643pt;
			height: 907pt;
			overflow: hidden;
			page-break-inside: avoid;
		}

		@page {
			size: 643pt 907pt;
			margin: 0;
			padding: 0;
		}

		body {
			background: #fff;
			background-size: cover;
			page-break-inside: avoid;
			font-family: 'Montserrat', sans-serif;
			padding: 0 !important;
		}

		table, table tr, table tbody {
			width: 100%;
			page-break-inside: avoid;
			page-break-after: avoid;
			page-break-before: avoid;
		}

		thead:before, thead:after {
			display: none;
			page-break-after: avoid;
			page-break-before: avoid;
			page-break-inside: avoid;
		}

		tbody:before, tbody:after {
			display: none;
			page-break-after: avoid;
			page-break-before: avoid;
			page-break-inside: avoid;
		}
	</style>
</head>
<body>


<table style="width: 100%; margin: 0 auto; padding: 0">
	<tbody style="width: 100%;">
	<tr style="width: 100%;">
		<!-- Main block -->
		<td style="width:100%; padding: 37pt 27pt 36pt; position: relative;">
			<h1 style="margin: 0; font-weight: normal;font-size: 18pt;color: #1A8562;text-align: center;">Produceret og tilpasset til <strong>{{ $customer->getName() }}</strong></h1>
			<p style="text-align: justify; font-weight: 200;font-size: 13pt;color: #1A8562;margin: 23pt 0 20pt;line-height: 20pt;">Hej {{ $customer->getFirstname() }}, her er en lille tekst til dit label. Pt. er der ikke noget rigtigt infromation her, men det kommer der snart. Lige nu tester vi bare for at se hvordan det ser ud. Indholdet vil selvfølgeligt være væsentligt mere spændende, og vitaminerne vil være tilpasset dit behov ligeså.</p>

			<table style="width:100%">
				<tbody>
				<tr>
					<td style="width:50%;">
						<img src="{{ asset('/images/icons/pills/pill-1a@2x.png') }}" alt="Vitamin icon" style="float: right;width:29pt; height: 30pt;">
						<h2 style="font-weight: bold; font-size: 15pt; margin: 0 0 2pt; color: #1A8562">Vitamin 1</h2>
						<p style="margin: 0 0 10pt; line-height: 14pt; font-size: 9pt; color: #1A8562;">Bidrager til den normale funktion af immunforsvaret.</p>

						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 8pt; color: #1A8562;">
								<th style="text-align: left;">Vitaminer</th>
								<th style="text-align: center;">Mængde</th>
								<th style="text-align: right;">Procent</th>
							</tr>
							</thead>
							<tbody style="font-size: 8pt; color:#1A8562;">
							<tr>
								<td style="text-align: left;">Vitamin A</td>
								<td style="text-align: center;">10 mg</td>
								<td style="text-align: right;">50</td>
							</tr>
							</tbody>
						</table>

						<p>Ingredienser: Calcium hydrogen phosphate dihydrate, K-Caps (hydroxypropylmethylcellulose, vand, farvestof (E129, E171), ferrobisglycinate, L-ascorbinsyre, zinkgluconat, DL-alfa-tocopherolacetat, nicotinamid, L-selenmethionin, cholecalciferol, calcium-D-pantothenat, retinylacetat, cyanocobalamin, phylloquinon (phytomenadion), pyridoxin-5’-phosphat, riboflavin, thiaminhydrochlorid, chrompicolinat, pteroylmonoglutaminsyre, kaliumjodid, D-biotin</p>
					</td>

					<td style="width:50%;">
						<img src="{{ asset('/images/icons/pills/pill-1a@2x.png') }}" alt="Vitamin icon" style="float: right;width:29pt; height: 30pt;">
						<h2 style="font-weight: bold; font-size: 15pt; margin: 0 0 2pt; color: #1A8562">Vitamin 1</h2>
						<p style="margin: 0 0 10pt; line-height: 14pt; font-size: 9pt; color: #1A8562;">Bidrager til den normale funktion af immunforsvaret.</p>

						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 8pt; color: #1A8562;">
								<th style="text-align: left;">Vitaminer</th>
								<th style="text-align: center;">Mængde</th>
								<th style="text-align: right;">Procent</th>
							</tr>
							</thead>
							<tbody style="font-size: 8pt; color:#1A8562;">
							<tr>
								<td style="text-align: left;">Vitamin A</td>
								<td style="text-align: center;">10 mg</td>
								<td style="text-align: right;">50</td>
							</tr>
							</tbody>
						</table>

						<p>Ingredienser: Calcium hydrogen phosphate dihydrate, K-Caps (hydroxypropylmethylcellulose, vand, farvestof (E129, E171), ferrobisglycinate, L-ascorbinsyre, zinkgluconat, DL-alfa-tocopherolacetat, nicotinamid, L-selenmethionin, cholecalciferol, calcium-D-pantothenat, retinylacetat, cyanocobalamin, phylloquinon (phytomenadion), pyridoxin-5’-phosphat, riboflavin, thiaminhydrochlorid, chrompicolinat, pteroylmonoglutaminsyre, kaliumjodid, D-biotin</p>
					</td>
				</tr>


				<tr>
					<td style="width:50%;">
						<img src="{{ asset('/images/icons/pills/pill-1a@2x.png') }}" alt="Vitamin icon" style="float: right;width:29pt; height: 30pt;">
						<h2 style="font-weight: bold; font-size: 15pt; margin: 0 0 2pt; color: #1A8562">Vitamin 1</h2>
						<p style="margin: 0 0 10pt; line-height: 14pt; font-size: 9pt; color: #1A8562;">Bidrager til den normale funktion af immunforsvaret.</p>

						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 8pt; color: #1A8562;">
								<th style="text-align: left;">Vitaminer</th>
								<th style="text-align: center;">Mængde</th>
								<th style="text-align: right;">Procent</th>
							</tr>
							</thead>
							<tbody style="font-size: 8pt; color:#1A8562;">
							<tr>
								<td style="text-align: left;">Vitamin A</td>
								<td style="text-align: center;">10 mg</td>
								<td style="text-align: right;">50</td>
							</tr>
							</tbody>
						</table>

						<p>Ingredienser: Calcium hydrogen phosphate dihydrate, K-Caps (hydroxypropylmethylcellulose, vand, farvestof (E129, E171), ferrobisglycinate, L-ascorbinsyre, zinkgluconat, DL-alfa-tocopherolacetat, nicotinamid, L-selenmethionin, cholecalciferol, calcium-D-pantothenat, retinylacetat, cyanocobalamin, phylloquinon (phytomenadion), pyridoxin-5’-phosphat, riboflavin, thiaminhydrochlorid, chrompicolinat, pteroylmonoglutaminsyre, kaliumjodid, D-biotin</p>
					</td>

					<td style="width:50%;">
						<img src="{{ asset('/images/icons/pills/pill-1a@2x.png') }}" alt="Vitamin icon" style="float: right;width:29pt; height: 30pt;">
						<h2 style="font-weight: bold; font-size: 15pt; margin: 0 0 2pt; color: #1A8562">Vitamin 1</h2>
						<p style="margin: 0 0 10pt; line-height: 14pt; font-size: 9pt; color: #1A8562;">Bidrager til den normale funktion af immunforsvaret.</p>

						<table style="width: 100%;">
							<thead>
							<tr style="font-weight: bold;font-size: 8pt; color: #1A8562;">
								<th style="text-align: left;">Vitaminer</th>
								<th style="text-align: center;">Mængde</th>
								<th style="text-align: right;">Procent</th>
							</tr>
							</thead>
							<tbody style="font-size: 8pt; color:#1A8562;">
							<tr>
								<td style="text-align: left;">Vitamin A</td>
								<td style="text-align: center;">10 mg</td>
								<td style="text-align: right;">50</td>
							</tr>
							</tbody>
						</table>

						<p>Ingredienser: Calcium hydrogen phosphate dihydrate, K-Caps (hydroxypropylmethylcellulose, vand, farvestof (E129, E171), ferrobisglycinate, L-ascorbinsyre, zinkgluconat, DL-alfa-tocopherolacetat, nicotinamid, L-selenmethionin, cholecalciferol, calcium-D-pantothenat, retinylacetat, cyanocobalamin, phylloquinon (phytomenadion), pyridoxin-5’-phosphat, riboflavin, thiaminhydrochlorid, chrompicolinat, pteroylmonoglutaminsyre, kaliumjodid, D-biotin</p>
					</td>
				</tr>
				</tbody>
			</table>

			<p style="font-weight: 200;font-size: 9pt;color: #3AAC87;line-height: 14pt;position: absolute; bottom: 36pt; width: 50%; left: 25%; text-align: center">Anbefalet daglig dosis: 1 kapsel taget med vand til et måltid.<br/>
				Næringsindhold pr. anbefalet daglig dosis angivet i mængde og procent af referenceindtag (RI) til vokse samt børn fra 11 år. </p>
		</td>
		<!-- Main block end -->
	</tr>
	</tbody>
</table>
</body>
</html>
{{--<div style="break-after: always;page-break-after: always;"></div>--}}