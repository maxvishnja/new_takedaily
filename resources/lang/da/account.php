<?php
return [
	'home'                  => [
		'title'            => 'Mit TakeDaily - TakeDaily',
		'years'            => 'år',
		'pick'             => '--- vælg ---',
		'button-save-text' => 'Gem præferencer'
	],
	'transaction'           => [
		'title'          => 'Levering #:id - TakeDaily',
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
		'title'            => 'Leveringer - TakeDaily',
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
		'title'            => 'Indstillinger - TakeDaily',
		'header'           => 'Indstillinger',
		'button-save-text' => 'Gem'
	],
	'settings_billing'      => [
		'title'                  => 'Fakturering - TakeDaily',
		'header'                 => 'Betalingsmetode',
		'no-method'              => 'Ingen betalingsmetode fundet!',
		'button-add-method-text' => 'Tilføj nyt kort',
		'button-update-text'     => 'Opdater',
		'card-exp'               => 'Udløb: ',
		'button-remove-text'     => 'Fjern kort',
		'add' => [
			'button-cancel-text'     => 'Annuller',
			'title'                  => 'Tilføj betalingsmetode - TakeDaily',
			'header'                 => 'Ny betalingsmetode'
		]
	],
	'settings_subscription' => [
		'title'              => 'Abonnement - TakeDaily',
		'header'             => 'Dit abonnement er :status',
		'total'              => '<span class="color--brand">:amount</span><small> / måned</small>',
		'next-date'          => 'Næste trækningsdato: :date',
		'plan'               => [
			'active'    => 'aktivt',
			'cancelled' => 'afsluttet'
		],
		'button-snooze-text' => 'Udskyd næste forsendelse',
		'button-cancel-text' => 'Opsig',
		'button-start-text' => 'Start abonnement fra i dag',
		'snooze_popup'       => [
			'title'              => 'Snooze abonnent',
			'text'               => 'Hvor langt tid?',
			'option'             => ':days dage',
			'button-snooze-text' => 'Udskyd',
			'button-close-text'  => 'Annuller'
		]
	]
];