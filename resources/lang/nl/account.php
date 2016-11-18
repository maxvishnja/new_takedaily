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
    'title-shipping' => 'Bezorgadres',
    'table' => 
    array (
      'headers' => 
      array (
        'description' => 'Beschrijving',
        'amount' => 'Bedrag',
        'taxes' => 'BTW',
        'total' => 'Totaal per maand',
      ),
      'totals' => 
      array (
        'subtotal' => 'Subtotaal',
        'shipping' => 'Bezorgkosten',
        'taxes' => 'BTW',
        'total' => 'Totaal',
      ),
    ),
  ),
  'transactions' => 
  array (
    'title' => 'Bestellingen - TakeDaily',
    'header' => 'Jouw levering',
    'no-results' => 'Geen leveringen gevonden',
    'table' => 
    array (
      'date' => 'Datum',
      'amount' => 'Bedrag',
      'status' => 'Status',
    ),
    'button-show-text' => 'Tonen',
  ),
  'settings_basic' => 
  array (
    'title' => 'Instellingen - TakeDaily',
    'header' => 'Bezorgadres',
    'button-save-text' => 'Opslaan',
  ),
  'settings_billing' => 
  array (
    'title' => 'Betaling - TakeDaily',
    'header' => 'Betaalmethode',
    'no-method' => 'Geen betaalmethode gevonden!',
    'button-add-method-text' => 'Voeg nieuwe toe',
    'button-update-text' => 'Verversen',
    'card-exp' => 'Vervaldatum:',
    'button-remove-text' => 'Verwijder',
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
    'title' => 'Abonnement  - TakeDaily',
    'header' => 'Vertalen uit het: Nederlands
Uw abonnement is <u>:Status</u>',
    'total' => '<span>:hoeveelheid</span><small> / maand</small>',
    'next-date' => 'Volgende tekening datum :: datum',
    'plan' => 
    array (
      'active' => 'Actief ',
      'cancelled' => 'Voltooid',
    ),
    'button-snooze-text' => 'Volgende zendig uitstellen',
    'button-cancel-text' => 'Annuleren',
    'button-start-text' => 'Start abonnement vanaf nu',
    'snooze_popup' => 
    array (
      'title' => 'Uitstellen abonnement ',
      'text' => 'Hoelang?',
      'option' => ':days dagen',
      'button-snooze-text' => 'Uitstellen',
      'button-close-text' => 'Annuleren',
    ),
    'cant-cancel' => 'Jouw volgende levering is binnen  uur. Je kunt de bestelling helaas niet meer uitstellen.',
    'cant-snooze' => 'Jouw volgende levering is binnen 24 uur. Je kunt de bestelling helaas niet meer uitstellen.',
    'new-recommendation' => 
    array (
      'btn' => 'Ververs mijn vitamines',
      'text' => 'Vanuit uw profiel, kunnen we zien dat sommige andere vitaminen beter voor u zou kunnen zijn.',
      'title' => 'We hebben een nieuw advies voor je.',
    ),
  ),
  'general' => 
  array (
    'errors' => 
    array (
      'custom-package-cant-change' => 'Je hebt een zelf pakket samengesteld en is daarom niet te veranderen.',
      'max-snooze' => 'Je kunt alleen uitstellen gedurende 28 dagen',
    ),
    'successes' => 
    array (
      'preferences-saved' => 'Jouw voorkeuren zijn opgeslagen!',
      'vitamins-updated' => 'Vitamines zijn bijgewerkt!',
    ),
  ),
);
