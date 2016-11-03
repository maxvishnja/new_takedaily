<?php

return [
	'messages' =>
		[
			'vitamins-not-selected' => 'Vi skal finde dine vitaminer før du kan handle.',
			'payment-invalid'       => 'De betaling is niet geslaagd; probeer het opnieuw. :error',
			'no-such-coupon'        => 'Couponcode onjuist. Probeer het nog eens.',
			'coupon-missing'        => 'Voer uw couponcode in.',
			'coupon-added'          => 'Couponcode toegevoegd!
',
			'card-added'            => 'Kaart toegevoegd!',
		],
	'mail'     =>
		[
			'subject'                     => 'Orderbevestiging TakeDaily',
			'subject-subscription'        => 'Vi har trukket penge for dit abonnement',
			'subject-subscription-failed' => 'Vi kunne ikke trække penge for dit abonnement!',
		],
	'success'  =>
		[
			'page-title'  => 'Jouw bestelling is geslaagd! - TakeDaily',
			'title'       => 'Din ordre blev oprettet',
			'text'        => 'Du vil indenfor 5 minutter modtage en ordrebekræftelse, med information omkring levering og din ordre generelt. Tak for dit køb!',
			'button-text' => 'Ga naar Mjn TakeDaily',
			'giftcard'    =>
				[
					'title' => 'Code cadeaubon:',
					'text'  => 'Du vil indenfor 5 minutter modtage en ordrebekræftelse, med information omkring gavekortet, indløsning og din ordre generelt. Tak for dit køb!',
				],
		],
	'index'    =>
		[
			'title'      => 'Betaling - TakeDaily',
			'order'      =>
				[
					'title'              => 'Bestelling',
					'info'               =>
						[
							'title'               => 'Jouw informatie',
							'name'                => 'Voor- en achternaam',
							'name-placeholder'    => 'Lars Jensen',
							'email'               => 'Jouw e-mailadres',
							'email-placeholder'   => 'lars-jensen@gmail.com',
							'address'             =>
								[
									'street'              => 'Straat en huisnummer',
									'street-placeholder'  => 'Søndre Skovvej 123',
									'zipcode'             => 'Postcode',
									'zipcode-placeholder' => '1234 AB',
									'city'                => 'Woonplaats',
									'city-placeholder'    => 'Aalborg',
									'country'             => 'Land',
								],
							'optional'            => 'Optioneel',
							'company'             => 'Bedrijfsnaam (optioneel)',
							'company-placeholder' => 'Nl- 0612345678',
						],
					'billing'            =>
						[
							'title'  => 'Kaartinformatie',
							'secure' => 'Beveiligde verbinding',
							'card'   =>
								[
									'name'               => 'Naam op de kaart',
									'number'             => 'Kaartnummer',
									'number-placeholder' => '4111 1111 1111 1111',
									'month'              => 'Maand',
									'year'               => 'Jaar',
									'cvc'                => 'Controlenummer',
									'cvc-title'          => 'CVV',
									'cvc-placeholder'    => '123
',
								],
						],
					'button-submit-text' => 'Bestel nu',
				],
			'total'      =>
				[
					'title'    => 'Orderoverzicht',
					'shipping' => 'Verzendkosten',
					'free'     => 'Gratis',
					'giftcard' => 'Waarde cadeaubon',
					'taxes'    => 'Heraf moms',
					'coupon'   => 'Kortingscode',
					'total'    => 'Totaol',
				],
			'coupon'     =>
				[
					'link'              => 'Heb je een kortingscode?',
					'input-placeholder' => 'Jouw kortingscode',
				],
			'disclaimer' => '<p class="checkout_description">Dette er et abonnement, vi trækker derfor <span v-show="price === total_subscription">€ {{ total_subscription }}</span><strong v-show="price !== total_subscription">€ {{ total_subscription }}</strong> på dit kort hver måned. Første
						trækning er
						d. :date
					</p>

					<p class="checkout_description">Du kan til enhver tid stoppe abonnementet, eller sætte det midlertidligt på pause.</p>',
			'method'     =>
				[
					'title'  => 'Betalingsmethode',
					'errors' =>
						[
							'no-method' => 'Je hebt nog geen betalingsmethode gekozen! Probeer opnieuw.',
						],
				],
		],
];
