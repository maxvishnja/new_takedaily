<?php
return [
	'home'                  => [
		'title'            => 'Mit Take Daily - Take Daily',
		'years'            => 'år',
		'pick'             => '--- vælg ---',
		'button-save-text' => 'Gem præferencer'
	],
	'transaction'           => [
		'title'          => 'Levering #:id - Take Daily',
		'header'         => 'Levering #:id',
		'title-shipping' => 'Leveringsadresse',
		'table'          => [
			'headers' => [
				'description' => 'Beskrivelse',
				'amount'      => 'Beløb',
				'taxes'       => 'Moms',
				'total'       => 'Total'
			],
			'totals'  => [
				'subtotal' => 'Subtotal',
				'shipping' => 'Fragt',
				'taxes'    => 'Moms',
				'total'    => 'Total'
			]
		]
	],
	'transactions'          => [
		'title'            => 'Leveringer - Take Daily',
		'header'           => 'Dine leveringer',
		'no-results'       => 'Ingen leveringer fundet',
		'table'            => [
			'date'   => 'Dato',
			'amount' => 'Beløb',
			'status' => 'Status'
		],
		'button-show-text' => 'Vis'
	],
	'settings_basic'        => [
		'title'            => 'Indstillinger - Take Daily',
		'header'           => 'Indstillinger',
		'button-save-text' => 'Gem'
	],
	'settings_billing'      => [
		'title'                  => 'Fakturering - Take Daily',
		'header'                 => 'Betalingsmetode',
		'no-method'              => 'Ingen betalingsmetode fundet!',
		'button-add-method-text' => 'Tilføj nyt kort',
		'button-update-text'     => 'Opdater',
		'card-exp'               => 'Udløb: ',
		'button-remove-text'     => 'Fjern kort'
	],
	'settings_subscription' => [
		'title'              => 'Abonnement - Take Daily',
		'header'             => 'Dit abonnement er :status',
		'total'              => '<span class="color--brand">:amount</span><small> / måned</small>',
		'next-date'          => 'Næste trækningsdato: :date',
		'plan'               => [
			'active'    => 'aktivt',
			'cancelled' => 'afsluttet'
		],
		'button-snooze-text' => 'Udskyd næste forsendelse',
		'button-cancel-text' => 'Opsig',
		'snooze_popup'       => [
			'title'              => 'Snooze abonnent',
			'text'               => 'Hvor langt tid?',
			'option'             => ':days dage',
			'button-snooze-text' => 'Udskyd',
			'button-close-text'  => 'Annuller'
		]
	]
];