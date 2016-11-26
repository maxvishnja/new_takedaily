<?php

return array (
  'home' => 
  array (
    'title' => 'Mit TakeDaily - TakeDaily',
    'header' => 'Mit TakeDaily',
    'years' => 'år',
    'pick' => '--- vælg ---',
    'button-save-text' => 'Gem præferencer',
    'button-change' => 'Ændre din profil',
  ),
  'transaction' => 
  array (
    'title' => 'Levering #:id - TakeDaily',
    'header' => 'Levering #:id',
    'title-shipping' => 'Leveringsadresse',
    'table' => 
    array (
      'headers' => 
      array (
        'description' => 'Beskrivelse',
        'amount' => 'Beløb',
        'taxes' => 'Moms',
        'total' => 'Total',
      ),
      'totals' => 
      array (
        'subtotal' => 'Subtotal',
        'shipping' => 'Fragt',
        'taxes' => 'Moms',
        'total' => 'Total',
      ),
    ),
  ),
  'transactions' => 
  array (
    'title' => 'Leveringer - TakeDaily',
    'header' => 'Dine leveringer',
    'no-results' => 'Ingen leveringer fundet',
    'table' => 
    array (
      'date' => 'Dato',
      'amount' => 'Beløb',
      'status' => 'Status',
    ),
    'button-show-text' => 'Vis',
  ),
  'settings_basic' => 
  array (
    'title' => 'Indstillinger - TakeDaily',
    'header' => 'Indstillinger',
    'button-save-text' => 'Gem',
  ),
  'settings_billing' => 
  array (
    'title' => 'Fakturering - TakeDaily',
    'header' => 'Betalingsmetode',
    'no-method' => 'Ingen betalingsmetode fundet!',
    'button-add-method-text' => 'Tilføj ny',
    'button-update-text' => 'Opdater',
    'card-exp' => 'Udløb: ',
    'button-remove-text' => 'Fjern',
    'add' => 
    array (
      'button-cancel-text' => 'Annuller',
      'button-add-text' => 'Fortsæt',
      'title' => 'Tilføj betalingsmetode - TakeDaily',
      'header' => 'Ny betalingsmetode',
    ),
  ),
  'settings_subscription' => 
  array (
    'title' => 'Abonnement - TakeDaily',
    'header' => 'Dit abonnement er <u>:status</u>',
    'total' => '<span>:amount</span><small> / måned</small>',
    'next-date' => 'Næste trækningsdato: :date',
    'plan' => 
    array (
      'active' => 'aktivt',
      'cancelled' => 'afsluttet',
    ),
    'button-snooze-text' => 'Udskyd næste forsendelse',
    'button-cancel-text' => 'Opsig',
    'button-start-text' => 'Start abonnement fra i dag',
    'snooze_popup' => 
    array (
      'title' => 'Snooze abonnent',
      'text' => 'Hvor langt tid?',
      'option' => ':days dage',
      'button-snooze-text' => 'Udskyd',
      'button-close-text' => 'Annuller',
    ),
    'new-recommendation' => 
    array (
      'title' => 'Vi har nye anbefalinger til dig.',
      'text' => 'Ud fra din profil kan vi se at nogle andre vitaminer måske er bedre for dig.',
      'btn' => 'Opdater mine vitaminer',
    ),
    'cant-snooze' => 'Din næste trækning er indenfor 24 timer, du kan derfor ikke udskyde.',
    'cant-cancel' => 'Din næste trækning er indenfor 48 timer, du kan derfor ikke annullere',
  ),
  'general' => 
  array (
    'errors' => 
    array (
      'custom-package-cant-change' => 'Du har en selvvalgt pakke, og kan derfor ikke ændre dette.',
      'max-snooze' => 'Du kan maks udskyde i 28 dage.',
    ),
    'successes' => 
    array (
      'preferences-saved' => 'Dine præferencer blev gemt!',
      'vitamins-updated' => 'Vitaminer blev opdateret!',
    ),
  ),
);
