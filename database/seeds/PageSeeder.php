<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Home
		\App\Page::create([
			'url_identifier'   => 'home',
			'title'            => 'Opret et abonnent på vitaminer',
			'sub_title'        => '',
			'body'             => '<strong>Not changeable.</strong>',
			'meta_title'       => 'Opret et abonnent på vitaminer',
			'meta_description' => 'Opret et abonnent på vitaminer hos TakeDaily',
			'meta_image'       => '',
			'is_locked'        => 1,
			'layout'           => 'plain'
		]);

		// About
		\App\Page::create([
			'url_identifier'   => 'about',
			'title'            => 'Om TakeDaily',
			'sub_title'        => 'Information og hjælp',
			'body'             => '<p>TakeDaily er en virksomhed, som ...</p>',
			'meta_title'       => 'Om TakeDaily',
			'meta_description' => 'Om TakeDaily og vores firma',
			'meta_image'       => '',
			'is_locked'        => 0,
			'layout'           => 'plain'
		]);

		// Terms
		\App\Page::create([
			'url_identifier'   => 'terms',
			'title'            => 'Vores betingelser',
			'sub_title'        => 'Retningslinjer',
			'body'             => '<h3>1.1 Returpolitik</h3><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam, at atque beatae dicta eligendi explicabo facere, facilis hic mollitia nostrum quasi qui quo tempore, unde velit? Mollitia ullam vero voluptas.</p>',
			'meta_title'       => 'Vores betingelser',
			'meta_description' => 'Handelsbetingelser',
			'meta_image'       => '',
			'is_locked'        => 0,
			'layout'           => 'plain'
		]);

		// Contact
		\App\Page::create([
			'url_identifier'   => 'contact',
			'title'            => 'Kontakt os',
			'sub_title'        => 'Få hjælp og svar',
			'body'             => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam atque beatae consequuntur cum cumque doloremque exercitationem expedita facilis iusto magnam neque perferendis quae quam quisquam ratione, sapiente veniam, veritatis voluptate?</p>',
			'meta_title'       => 'Kontakt os',
			'meta_description' => 'Hjælp',
			'meta_image'       => '',
			'is_locked'        => 1,
			'layout'           => 'plain'
		]);

		// Contact
		\App\Page::create([
			'url_identifier'   => 'privacy',
			'title'            => 'Fortrolighed & Cookies',
			'sub_title'        => 'Privatlivspolitik',
			'body'             => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam atque beatae consequuntur cum cumque doloremque exercitationem expedita facilis iusto magnam neque perferendis quae quam quisquam ratione, sapiente veniam, veritatis voluptate?</p>',
			'meta_title'       => 'Fortrolighed & Cookies',
			'meta_description' => 'Privatlivspolitik',
			'meta_image'       => '',
			'is_locked'        => 0,
			'layout'           => 'plain'
		]);

		// Fra A til Zink
		\App\Page::create([
			'url_identifier'   => 'fra-a-til-zink',
			'title'            => 'Fra A til Zink',
			'sub_title'        => 'Vores kilder til vitaminer og mineraler',
			'body'             => '<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-a.jpg" style="height:260px; width:585px" /></div>

<div class="col-md-6">
<h2>A-vitamin</h2>

<ul>
	<li>Bidrager til immunforsvarets normale funktion</li>
	<li>Beskytter mod infektioner ved at styrke hud og slimhinder</li>
	<li>Essentiel for synet og &oslash;jets evne til at se i m&oslash;rke</li>
</ul>

<p>A-vitamin findes i en lang r&aelig;kke f&oslash;devarer, dog er indholdet specielt h&oslash;jt i guler&oslash;dder og lever.</p>

<p><strong>Anbefalet dagligt tilf&oslash;rsel:</strong><br />
Kvinder: 700 RE<br />
M&aelig;nd: 900 RE<br />
<br />
<em>RE= retinol &aelig;kvivalenter</em> &nbsp;</p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-b1.jpg" style="height:260px; width:585px" /></div>

<div class="col-md-6">
<h2>B1-vitamin(Tiamin)</h2>

<ul>
	<li>Essentiel for kroppens oms&aelig;tning kulhydrater til energi</li>
	<li>Stabiliserer nervesystemets normale funktion</li>
</ul>

<p>B1-vitamin findes j&aelig;vnt fordelt i n&aelig;sten alle f&oslash;devarer, men specielt fuldkornsprodukter, b&aelig;lgfrugter, linser og magert svinek&oslash;d er gode kilder.</p>

<p><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder: 1,1 mg<br />
M&aelig;nd: 1,4 mg</p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-b2.jpg" style="height:260px; width:585px" /></div>

<div class="col-md-6">
<h2>B2-vitamin (Riboflavin)</h2>

<ul>
	<li>Essentiel for kroppens energioms&aelig;tning af fedt, protein og kulhydrat</li>
	<li>Indg&aring;r i mange af kroppens stofskifteprocessor blandt andet optagelse af andre vitaminer og mineraler</li>
	<li>Vigtig for hud, h&aring;r og negle</li>
</ul>

<p>B2-vitamin findes hovedsageligt i k&oslash;d, fjerkr&aelig;, &aelig;g, lever og magre mejeriprodukter.</p>

<p><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder: 1,3 mg<br />
M&aelig;nd: 1,7 mg</p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-b3.jpg" /></div>

<div class="col-md-6">
<h2>B3-vitamin (Niacin)</h2>

<ul>
	<li>Essentiel for kroppens energioms&aelig;tning af fedt, protein og kulhydrat</li>
	<li>Indg&aring;r i kroppens produktion af hormonerne adrenalin og noradrenalin</li>
	<li>Indg&aring;r i kroppens dannelse af serotonin, der blandt andet modvirker depression</li>
</ul>

<p>&nbsp;</p>

<p>B3-vitamin findes hovedsageligt i proteinrige f&oslash;devarer som k&oslash;d, fisk, fjerkr&aelig; og b&aelig;lgfrugter.</p>

<p><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder: 15 NE<br />
M&aelig;nd: 18 NE<br />
<br />
<em>NE = niacin &aelig;kvivalenter</em></p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-b5.jpg" /></div>

<div class="col-md-6">
<h2>B5-vitamin (Pantotensyre)</h2>

<ul>
	<li>Essentiel for kroppens energioms&aelig;tning af fedt, protein og kulhydrat</li>
	<li>Indg&aring;r i kroppens produktion af hormonerne</li>
	<li>Har betydning for centralnervesystemets funktion</li>
</ul>

<p>Patontensyre findes i de fleste f&oslash;devarer i varierende m&aelig;ngder, dog er indholdet s&aelig;rligt h&oslash;jt i lever og torskerogn samt mejeriprodukter.</p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-b6.jpg" /></div>

<div class="col-md-6">
<h2>B6-vitamin (Pyridoxin)</h2>

<ul>
	<li>Essential for kroppens oms&aelig;tning af protein og dannelse af steroidhormoner</li>
	<li>Sikrer nervesystemets normale funktion</li>
	<li>Indg&aring;r i opbygningen af DNA</li>
</ul>

<p>&nbsp;</p>

<p><em>B6-vitamin findes i de fleste f&oslash;devarer i varierende m&aelig;ngder, dog er er indholdet i fisk, magert k&oslash;d, lever, kartofler og bananer h&oslash;jest.</em></p>

<p><em><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder: 1,2<br />
M&aelig;nd: 1,5</em></p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-b8.jpg" /></div>

<div class="col-md-6">
<h2>B8-vitamin (Biotin)</h2>

<ul>
	<li>Indg&aring;r i kroppens stofskifte</li>
	<li>Indg&aring;r i kroppens energioms&aelig;tning af fedt og kulhydrat</li>
</ul>

<p>&nbsp;</p>

<p>Biotin findes i de fleste f&oslash;devarer, men indholdet er h&oslash;jt i lever, peanuts, sojab&oslash;nner og &aelig;ggeblommer.</p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-b9.jpg" /></div>

<div class="col-md-6">
<h2>B9-vitamin (Folat/Folsyre)</h2>

<ul>
	<li>Indg&aring;r i kroppens stofskifteprocessor</li>
	<li>Essentiel i kroppens opbygning af DNA</li>
	<li>N&oslash;dvendig for kroppens evne til at danne r&oslash;de blodlegemer</li>
	<li>Essentiel for fosterudviklingen hos gravide</li>
</ul>

<p>&nbsp;</p>

<p><em>Folat findes i de fleste f&oslash;devarer i varierende m&aelig;ngder. Folsyre, som er den form for folat, der findes i vitaminpiller, optages bedre end folat fra kosten.</em></p>

<p><em><strong>Anbefalet daglig tilf&oslash;rsel</strong><br />
Kvinder: 300 &micro;g / 400 &micro;g i den fertile alder<br />
M&aelig;nd: 300 &micro;g</em></p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-b12.jpg" /></div>

<div class="col-md-6">
<h2>B12-vitamin (Kobalamin)</h2>

<ul>
	<li>Spiller en essentiel rolle i kroppens oms&aelig;tning af fedt</li>
	<li>Har stor betydning for kroppens celledeling og opbygning af blodlegemer</li>
	<li>Vedligeholder nervesystemets normale funktion</li>
	<li>Bevarer den psykiske sundhed og er god for hukommelsen</li>
</ul>

<p>&nbsp;</p>

<p>B12-vitamin findes udelukkende i animalske f&oslash;devarer, som lever, k&oslash;d, &aelig;g og m&aelig;lk. Derfor skal is&aelig;r veganere v&aelig;re ekstra opm&aelig;rksomme p&aring; deres indtag af dette vitamin.&nbsp;</p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-c.jpg" /></div>

<div class="col-md-6">
<h2>C-vitamin</h2>

<ul>
	<li>Fungerer som et effektivt antioxidant</li>
	<li>Indg&aring;r i opbygningen af bindev&aelig;vsproteinet kollagen</li>
	<li>Essentiel for immunforsvarets funktion</li>
	<li>Indg&aring;r i dannelsen af hormoner</li>
	<li>Neds&aelig;tter risikoen for at udvikle cancer</li>
	<li>Fremmer kroppens optag af jern</li>
</ul>

<p>&nbsp;</p>

<p><em>Frugter og gr&oslash;ntsager er gode kilder til C-vitamin. Indholdet er specielt h&oslash;jt i hyben, r&oslash;d peberfrugt, solb&aelig;r gr&oslash;nk&aring;l, broccoli.</em></p>

<p><em><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder og m&aelig;nd: 75 mg</em></p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-d3.jpg" /></div>

<div class="col-md-6">
<h2>D3-vitamin</h2>

<ul>
	<li>&Oslash;ger kroppens evne til at optage calcium og stimulerer dermed nydannelsen af knoglev&aelig;v</li>
	<li>Forbedre muskelfunktionen i det tv&aelig;rstribede muskulatur</li>
	<li>Neds&aelig;tter blodtrykket og styrker metabolismen</li>
	<li>Neds&aelig;tter risikoen for at udvikle cancer</li>
</ul>

<p>&nbsp;</p>

<p>D-vitamin findes naturligt i fede fisk, &aelig;g og m&aelig;lkeprodukter. Desuden absorbere huden D-vitamin fra solen str&aring;ler.</p>

<p><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder og m&aelig;nd: 10 &micro;g<br />
Kvinder og m&aelig;nd over 70 &aring;r: 20 &micro;g</p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-e.jpg" /></div>

<div class="col-md-6">
<h2>E-vitamin</h2>

<ul>
	<li>En effektiv fedtopl&oslash;selig antioxidant</li>
	<li>Beskytter kroppens celler, nervesystem, muskulatur og &oslash;jne mod frie radikaler</li>
</ul>

<p>&nbsp;</p>

<p><em>E-vitamin findes blandt andet i vegetabilske olier, fisk, &aelig;g, n&oslash;dder og fedtrige fr&oslash;. Desuden findes vitaminet ogs&aring; i frugt og gr&oslash;nt.&nbsp;</em></p>

<p><em><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder: 8 &alpha;-TE<br />
M&aelig;nd: 10 &alpha;-TE<br />
<br />
<em>(&alpha;-TE = &alpha;-tokoferol&aelig;kvivalenter)</em></em></p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="/images/vitamins/vitamine-k.jpg" /></div>

<div class="col-md-6">
<h2>K-vitamin</h2>

<ul>
	<li>Vigtig for blodets evne til at st&oslash;rkne</li>
	<li>Betydning for kroppens evne til at bevare knoglemassen</li>
</ul>

<p>K-vitamin findes hovedsageligt i gr&oslash;nne bladgr&oslash;ntsager som spinat, broccoli, rosenk&aring;l og salat.</p>

<p><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
1 &micro;g per kilogram kropsv&aelig;gt per dag, for eksempel er anbefalingen 65 &micro;g/dag hos en person der vejer 65 kg.</p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" style="height:260px; width:585px" /></div>

<div class="col-md-6">
<h2>Calcium</h2>

<ul>
	<li>Essentiel for kroppens opbygning og bevaring af knoglemasse</li>
	<li>Vigtig for musklernes evne til at tr&aelig;kke sig sammen og fungere normalt</li>
	<li>Indg&aring;r i nervecellefunktioner</li>
	<li>Regulerer blodtrykket</li>
	<li>Essentiel for blodets evne til at st&oslash;rkne</li>
</ul>

<p>&nbsp;</p>

<p><em><em>Calcium findes hovedsageligt i mejeriprodukter, fx m&aelig;lk, ost og yoghurt. Kroppens evne til at optage calcium forbedres, hvis det indtages sammen med D-vitamin.</em></em></p>

<p><em><em><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder: 800 mg&nbsp;<br />
M&aelig;nd: 800 mg</em></em></p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" style="height:260px; width:585px" /></div>

<div class="col-md-6">
<h2>Fosfor</h2>

<ul>
	<li>Essentiel for kroppens opbygning og vedligehold af knogler</li>
	<li>Indg&aring;r i kroppens oms&aelig;tning af fedt, kulhydrat og protein</li>
	<li>Vigtig for kroppens energioms&aelig;tning</li>
	<li>Indg&aring;r i kroppens opbygning af DNA</li>
	<li>Stabiliserer kroppens pH-v&aelig;rdi</li>
</ul>

<p>&nbsp;</p>

<p>Fosfor findes i alle f&oslash;devarer, der indeholder protein. Indholdet er h&oslash;jt i eksempelvis ost, b&oslash;nner, havregryn, hasseln&oslash;dder og lever.</p>

<p><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder og m&aelig;nd: 600 mg</p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" /></div>

<div class="col-md-6">
<h2>Jern</h2>

<ul>
	<li>Indg&aring;r i de r&oslash;de blodlegemer</li>
	<li>Essentiel for kroppens binding og optagelse af ilt</li>
</ul>

<p>&nbsp;</p>

<p><em><em>Jern findes i en lang r&aelig;kke f&oslash;devarer, blandt andet frugt og gr&oslash;nt, b&oslash;nner, k&oslash;d og lever. Kroppen har dog nemmest ved at optage den type af jern, som findes i de animalske produkter. Jern optages bedst, hvis der samtidig indtages C-vitamin.</em></em></p>

<p><em><em><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder: 15 mg / 9 mg efter overgangsalderen<br />
M&aelig;nd: 9 mg&nbsp;</em></em></p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" /></div>

<div class="col-md-6">
<h2>Jod</h2>

<ul>
	<li>Essentiel for kroppens regulering af stofskiftet</li>
</ul>

<p>&nbsp;</p>

<p>Jod findes naturligt i fisk, skaldyr og tang. Desuden er st&oslash;rstedelen af dansk bordsalt tilsat jod.</p>

<p><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder og m&aelig;nd: 150 &micro;g</p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" /></div>

<div class="col-md-6">
<h2>Kalium</h2>

<ul>
	<li>Essentiel for musklernes oms&aelig;tning af energi</li>
	<li>Stabiliserer blodtrykket</li>
	<li>Indg&aring;r i kroppens syre-base-balance</li>
</ul>

<p>&nbsp;</p>

<p><em><em>Kalium findes i et bredt udvalg af f&oslash;devarer. Indholdet er h&oslash;jt i bananer, kartofler, fuldkornsmel og sild.</em></em></p>

<p><em><em><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder: 3,1 g<br />
M&aelig;nd: 3,5 g</em></em></p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" /></div>

<div class="col-md-6">
<h2>Kobber</h2>

<ul>
	<li>Essentielt for kroppens enzymprocessor</li>
	<li>Indg&aring;r i dannelsen af hormoner og signalstoffer</li>
	<li>Fungerer som antioxidant og beskytter kroppen mod frie radikaler</li>
	<li>Indg&aring;r i dannelsen af kroppen bindev&aelig;v</li>
	<li>
	<p>Kobber findes i varierende m&aelig;ngder i de fleste f&oslash;devarer. Indholdet er s&aelig;rligt h&oslash;jt i indmad, eksempelvis lever, og i skaldyr.</p>

	<p><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
	Kvinder og m&aelig;nd: 0,9 mg</p>
	</li>
</ul>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" /></div>

<div class="col-md-6">
<h2>Krom</h2>

<ul>
	<li>Indg&aring;r i kroppens optagelse af kulhydrat</li>
</ul>

<p>&nbsp;</p>

<p><em><em>Krom findes i sm&aring; m&aelig;ngder i en lang r&aelig;kke f&oslash;devarer, for eksempel k&oslash;d, ost, n&oslash;dder, m&oslash;rk chokolade, fuldkornsprodukter og skaldyr.</em></em></p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" /></div>

<div class="col-md-6">
<h2>Magnesium</h2>

<ul>
	<li>Indg&aring;r i kroppens stofskifteprocessor</li>
	<li>Sikrer musklernes evne til at tr&aelig;kke sig sammen</li>
	<li>Essentiel for hjertets evne til at tr&aelig;kke sig sammen og sl&aring; normalt</li>
	<li>
	<p>Magnesium findes hovedsageligt i grove kornprodukter, som havregryn eller fuldkornsrugbr&oslash;d, og i m&oslash;rkegr&oslash;nne gr&oslash;ntsager som broccoli og spinat. Desuden har mandler et h&oslash;jt indhold af magnesium.</p>

	<p><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
	Kvinder: 280 mg<br />
	M&aelig;nd: 350 mg</p>
	</li>
</ul>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" /></div>

<div class="col-md-6">
<h2>Mangan</h2>

<ul>
	<li>Indg&aring;r i kroppens oms&aelig;tning af kulhydrat og fedt</li>
</ul>

<p>&nbsp;</p>

<p><em><em>Mangan findes hovedsageligt i fuldkornsprodukter, n&oslash;dder, gr&oslash;ntsager, frugt samt te og kaffe.</em></em></p>
</div>
</div>

<div class="row m-b-50">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" /></div>

<div class="col-md-6">
<h2>Selen</h2>

<ul>
	<li>Har antioxidativ virkning</li>
	<li>Indg&aring;r i kroppens regulering af stofskiftet</li>
	<li>
	<p>Is&aelig;r fisk og fiskeprodukter har et h&oslash;jt indhold af selen, for eksempel er indholdet h&oslash;jt i rejer og tun. Desuden er indholdet i indmad, som lever, ogs&aring; h&oslash;jt.</p>

	<p><strong>Anbefalet dagligt indtag:</strong><br />
	Kvinder: 50 &micro;g<br />
	M&aelig;nd: 60 &micro;g</p>
	</li>
</ul>
</div>
</div>

<div class="row">
<div class="col-md-6"><img alt="" class="img-responsive" src="http://placehold.it/585x260" /></div>

<div class="col-md-6">
<h2>Zink</h2>

<ul>
	<li>Indg&aring;r i en lang r&aelig;kke af kroppens stofskifteprocessor</li>
	<li>Essentiel for kroppens oms&aelig;tning af protein og opbygning af DNA</li>
	<li>Indg&aring;r i kroppens nedbrydning og energioptag af kulhydrat</li>
	<li>Essentiel for immunforsvarets normale funktion</li>
	<li>Beskytter kroppen med oxidativt stress</li>
</ul>

<p>&nbsp;</p>

<p><em><em>Zink findes i mange forskellige f&oslash;devarer, blandt andet er indholdet h&oslash;jt i b&aelig;lgfrugter og grove kornprodukter. Desuden er magert k&oslash;d og m&aelig;lkeprodukter gode kilder til zink.</em></em></p>

<p><em><em><strong>Anbefalet daglig tilf&oslash;rsel:</strong><br />
Kvinder: 7 mg<br />
M&aelig;nd: 9 mg</em></em></p>
</div>
</div>
',
			'meta_title'       => 'Vores kilder til vitaminer og mineraler',
			'meta_description' => 'Fra A til Zink',
			'meta_image'       => '',
			'is_locked'        => 0,
			'layout'           => 'plain'
		]);
	}
}
