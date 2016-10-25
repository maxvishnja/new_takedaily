<?php
return [
	'messages' => [
		'vitamins-not-selected' => 'Vi skal finde dine vitaminer før du kan handle.',
		//'email-taken'           => 'E-mail adressen er allerede taget.',
		//'email-invalid'         => 'E-mail adressen er ikke gyldig.',
		'payment-invalid'       => 'Betalingen blev ikke godkendt, prøv igen. :error',
		'no-such-coupon'        => 'Kuponkoden findes ikke.',
		'coupon-missing'        => 'Du skal indtaste en kuponkode.',
		'coupon-added'          => 'Kuponkoden blev tilføjet!',
		'card-added'            => 'Kortet blev tilføjet!'
	],
	'mail'     => [
		'subject'              => 'Ordrebekræftelse fra TakeDaily',
		'subject-subscription' => 'Vi har trukket penge for dit abonnement',
		'subject-subscription-failed' => 'Vi kunne ikke trække penge for dit abonnement!'
	],
	'success'  => [
		'page-title'  => 'Din ordre blev godkendt! - TakeDaily',
		'title'       => 'Din ordre blev oprettet',
		'text'        => 'Du vil indenfor 5 minutter modtage en ordrebekræftelse, med information omkring levering og din ordre generelt. Tak for dit køb!',
		'button-text' => 'Gå til dit TakeDaily',
		'giftcard'    => [
			'title' => 'Gavekort koden er:',
			'text'  => 'Du vil indenfor 5 minutter modtage en ordrebekræftelse, med information omkring gavekortet, indløsning og din ordre generelt. Tak for dit køb!'
		]
	],
	'index'    => [
		'title'      => 'Betaling - TakeDaily',
		'order'      => [
			'title'              => 'Bestilling',
			'info'               => [
				'title'               => 'Dine oplysninger',
				'name'                => 'Dit fulde navn',
				'name-placeholder'    => 'Lars Jensen',
				'email'               => 'Din e-mail adresse',
				'email-placeholder'   => 'lars-jensen@gmail.com',
				'address'             => [
					'street'              => 'Vejnavn og nummer',
					'street-placeholder'  => 'Søndre Skovvej 123',
					'zipcode'             => 'Postnummer',
					'zipcode-placeholder' => '9940',
					'city'                => 'By',
					'city-placeholder'    => 'Aalborg',
					'country'             => 'Land'
				],
				'optional'            => 'valgfrit',
				'company'             => 'CVR / Firma',
				'company-placeholder' => 'DK-12345678'
			],
			'billing'            => [
				'title'  => 'Kortoplysninger',
				'secure' => 'Sikret forbindelse',
				'card'   => [
					'name'               => 'Navn på kortet',
					'number'             => 'Kortnummer',
					'number-placeholder' => '4111 1111 1111 1111',
					'month'              => 'Måned',
					'year'               => 'År',
					'cvc'                => 'Kontrolnummer',
					'cvc-title'          => 'CVV',
					'cvc-placeholder'    => '123'
				]
			],
			'button-submit-text' => 'Bestil nu'
		],
		'total'      => [
			'title'    => 'Ordreoversigt',
			'shipping' => 'Fragt',
			'free'     => 'Gratis',
			'giftcard' => 'Gavekort værdi',
			'taxes'    => 'Heraf moms',
			'coupon'   => 'Rabatkode',
			'total'    => 'Total'
		],
		'coupon'     => [
			'link'              => 'Har du en rabatkode?',
			'input-placeholder' => 'Din rabatkode',
			'button-text'       => 'Anvend'
		],
		'disclaimer' => '<p class="checkout_description">Dette er et abonnement, vi trækker derfor <span v-show="price === total_subscription">{{ total_subscription }}
							DKK</span><strong v-show="price !== total_subscription">{{ total_subscription }} DKK</strong> på dit kort hver måned. Første
						trækning er
						d. :date
					</p>

					<p class="checkout_description">Du kan til enhver tid stoppe abonnementet, eller sætte det midlertidligt på pause.</p>',
	    'method' => [
			'title' => 'Betalingsmetode',
			'errors' => [
				'no-method' => 'Du har ikke valgt en betalingsmetode! Prøv igen.'
			]
	    ]
	]
];