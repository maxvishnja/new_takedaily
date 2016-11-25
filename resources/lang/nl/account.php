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
    'title' => 'Bestelling #:id - TakeDaily',
    'header' => 'Bestelling #:id',
    'title-shipping' => 'Bezorgadres
',
    'table' => 
    array (
      'headers' => 
      array (
        'description' => 'Omschrijving',
        'amount' => 'Bedrag',
        'taxes' => 'BTW',
        'total' => 'Maandelijkse kosten',
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
    'header' => 'Overzicht bestellingen',
    'no-results' => 'Geen bestellingen gevonden',
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
    'title' => 'Klantgegevens - TakeDaily',
    'header' => 'Jouw gegevens',
    'button-save-text' => 'Opslaan',
  ),
  'settings_billing' => 
  array (
    'title' => 'Betaling - TakeDaily',
    'header' => 'Betaalmethode',
    'no-method' => 'Geen betaalmethode gevonden!',
    'button-add-method-text' => 'Voeg nieuwe toe',
    'button-update-text' => 'Aanpassen',
    'card-exp' => 'Vervaldatum:',
    'button-remove-text' => 'Verwijder',
    'add' => 
    array (
      'button-cancel-text' => 'Opzeggen',
      'button-add-text' => 'Voortzetten',
      'title' => 'Voeg betaalmethode toe - Take Daily',
      'header' => 'Nieuwe betaalmethode',
    ),
  ),
  'settings_subscription' => 
  array (
    'title' => 'Abonnement  - TakeDaily',
    'header' => 'Jouw abonnement is <u>:status</u>',
    'total' => '<span>:amount</span><small> / maand</small>',
    'next-date' => 'Volgende levering :date',
    'plan' => 
    array (
      'active' => 'Actief ',
      'cancelled' => 'Voltooid',
    ),
    'button-snooze-text' => 'Volgende levering uitstellen',
    'button-cancel-text' => 'Opzeggen',
    'button-start-text' => 'Start abonnement vanaf nu',
    'snooze_popup' => 
    array (
      'title' => 'Uitstellen abonnement ',
      'text' => 'Hoelang?',
      'option' => ':days dagen',
      'button-snooze-text' => 'Uitstellen',
      'button-close-text' => 'Annuleren',
    ),
    'cant-cancel' => 'Jouw volgende levering is binnen 48 uur. Je kunt de bestelling helaas niet meer uitstellen.',
    'cant-snooze' => 'Jouw volgende levering is binnen 24 uur. Je kunt de bestelling helaas niet meer uitstellen.',
    'new-recommendation' => 
    array (
      'btn' => 'Pas mijn vitamines aan',
      'text' => 'Vanuit jouw profiel, kunnen we zien dat andere vitamines beter aansluiten bij jou behoeften.',
      'title' => 'We hebben een nieuw advies voor je.',
    ),
  ),
  'general' => 
  array (
    'errors' => 
    array (
      'custom-package-cant-change' => 'Het samenstelling van het pakket is helaas niet te veranderen,',
      'max-snooze' => 'Je kunt de levering voor maximaal 28 dagen uitstellen.',
    ),
    'successes' => 
    array (
      'preferences-saved' => 'Jouw voorkeuren zijn opgeslagen!',
      'vitamins-updated' => 'Vitamines zijn bijgewerkt!',
    ),
  ),
);
