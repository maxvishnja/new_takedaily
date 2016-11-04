<?php

return array (
  'home' => 
  array (
    'title' => 'Mijn TakeDaily',
    'years' => 'jaar',
    'pick' => '--- kiezen ---',
    'button-save-text' => 'Gegevens opslaan',
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
    'title' => 'Instellingen - TakeDaily',
    'header' => 'Jouw bezorgadres',
    'button-save-text' => 'Opslaan',
  ),
  'settings_billing' => 
  array (
    'title' => 'Fakturering - TakeDaily',
    'header' => 'Betalingsmetode',
    'no-method' => 'Ingen betalingsmetode fundet!',
    'button-add-method-text' => 'Voeg nieuwe toe',
    'button-update-text' => 'Opdater',
    'card-exp' => 'Udløb: ',
    'button-remove-text' => 'Afgelegen',
    'add' => 
    array (
      'button-cancel-text' => 'Annuleren',
      'button-add-text' => 'Voortzetten',
      'title' => 'Voeg betaalmethode toe - Take Daily',
      'header' => 'Nieuwe betaalmethode',
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
  ),
  'general' => 
  array (
    'errors' => 
    array (
      'custom-package-cant-change' => 'Je hebt een zelf pakket samengesteld en is daarom  niet te veranderen.',
      'max-snooze' => 'Je kunt alleen uitstellen gedurende 28 dagen',
    ),
    'successes' => 
    array (
      'preferences-saved' => 'Jouw voorkeuren zijn opgeslagen!',
      'vitamins-updated' => 'Vitamines zijn bijgewerkt!',
    ),
  ),
);
