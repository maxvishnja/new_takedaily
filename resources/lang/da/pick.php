<?php
return [
	'title' => 'Vælg selv dine vitaminer',
    'groups' => [
    	'oil' => 'Olier',
        'lifestyle' => 'Helbred',
        'multi' => 'Basic',
        'diet' => 'Kost og vaner'
    ],
    'select-btn' => 'Vælg denne',
    'deselect-btn' => 'Fravælg denne',
    'btn-save' => 'Gem ændringer',
    'btn-order' => 'Gå til bestilling',
    'min-vitamins' => 'Du mangler at vælge mindst @{{ minVitamins - numSelectedVitamins }} vitamin<span v-show="(minVitamins - numSelectedVitamins) > 1">er</span>.',
    'errors' => [
    	'too-many' => 'Du har valgt det maksimale antal vitaminer, fravælg en for at vælge denne.'
    ]
];