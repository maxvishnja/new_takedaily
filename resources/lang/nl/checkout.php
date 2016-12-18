<?php

return array (
  'messages' => 
  array (
    'vitamins-not-selected' => 'Voordat je een bestelling kunt plaatsen, dien je eerst de vragenlijst af te ronden zodat wij jouw vitamines en mineralen kunnen selecteren.',
    'payment-invalid' => 'De betaling is niet geslaagd, probeer het opnieuw. :error',
    'no-such-coupon' => 'Kortingscode onjuist of al gebruikt. Probeer het nog eens.',
    'coupon-missing' => 'Voer jouw kortingscode in.',
    'coupon-added' => 'Kortingscode toegevoegd!',
    'card-added' => 'Kaart toegevoegd!',
  ),
  'mail' => 
  array (
    'subject' => 'Orderbevestiging TakeDaily',
    'subject-subscription' => 'De automatische afschrijving/betaling is geslaagd',
    'subject-subscription-failed' => 'De automatische afschrijving/betaling is niet geslaagd',
  ),
  'success' => 
  array (
    'page-title' => 'Jouw bestelling is geslaagd! - TakeDaily',
    'title' => 'Jouw bestelling is vewerkt',
    'text' => 'Je ontvangt binnen 5 minuten een orderbevestiging met informatie over je bestelling en de levering van jouw TakeDaily pakket. Bedankt je voor jouw aankoop!',
    'button-text' => 'Ga naar Mjn TakeDaily',
    'giftcard' => 
    array (
      'title' => 'Code cadeaubon:',
      'text' => 'Je ontvangt binnen 5 minuten een orderbevestiging met informatie over jouw cadeaubon. Bedankt voor jouw aankoop!',
    ),
  ),
  'index' => 
  array (
    'title' => 'Betaling - TakeDaily',
    'order' => 
    array (
      'title' => 'Bestelling',
      'info' => 
      array (
        'title' => 'Bezorgadres',
        'name' => 'Voor- en achternaam',
        'name-placeholder' => 'Henk Boom',
        'email' => 'E-mailadres',
        'email-placeholder' => 'henk-boom@gmail.com',
        'address' => 
        array (
          'street' => 'Straat/huisnummer/toevoeging',
          'street-placeholder' => 'Havenstraat 123A',
          'zipcode' => 'Postcode',
          'zipcode-placeholder' => '1234 AB',
          'city' => 'Woonplaats',
          'city-placeholder' => 'Houtdam',
          'country' => 'Land',
        ),
        'optional' => 'Optioneel',
        'company' => 'Bedrijfsnaam (optioneel)',
        'company-placeholder' => 'Naam bedrijf',
        'cvr-placeholder' => 'Nl- 0612345678',
        'phone-placeholder' => '0612345678',
        'phone' => 'Mobiel telefoonnummer',
        'is-company' => 'Bedrijfsnaam (Optioneel)',
        'password' => 'Gewenste wachtwoord',
        'password-placeholder' => 'Wachtwoord',
        'password_confirmation' => 'Bevestig uw wachtwoord
',
        'password_confirmation-placeholder' => 'Herhaal wachtwoord',
        'cvr' => 'KvK',
      ),
      'billing' => 
      array (
        'title' => 'Kaartinformatie',
        'secure' => 'Beveiligde verbinding',
        'card' => 
        array (
          'name' => 'Naam kaarthouder',
          'number' => 'Kaartnummer',
          'number-placeholder' => '4111 1111 1111 1111',
          'month' => 'Maand',
          'year' => 'Jaar',
          'cvc' => 'Controlenummer',
          'cvc-title' => 'CVV',
          'cvc-placeholder' => '123
',
        ),
      ),
      'button-submit-text' => 'Bestel nu',
    ),
    'total' => 
    array (
      'title' => 'Jouw bestelling',
      'shipping' => 'Verzendkosten',
      'free' => 'Gratis',
      'giftcard' => 'Waarde cadeaubon',
      'taxes' => 'BTW',
      'coupon' => 'Kortingscode',
      'total' => 'Totaal',
    ),
    'coupon' => 
    array (
      'link' => 'Heb je een kortingscode?',
      'input-placeholder' => 'Jouw kortingscode',
      'button-text' => 'Toepassen',
    ),
    'disclaimer' => '<p class="checkout_description">Betaling van jouw TakeDaily abonnementskosten van <span v-show="price === total_subscription">€ {{ total_subscription }}</span><span v-show="price !== total_subscription">€ {{ total_subscription }}</span> geschiedt iedere maand per automatische afschrijving.</p>
<p class="checkout_description">Je kan je abonnement ieder moment pauzeren, uitstellen of opzeggen tot 4 dagen voor de  volgende verzendingsdatum.</p>',
    'method' => 
    array (
      'title' => 'Selecteer betaalmethode',
      'errors' => 
      array (
        'no-method' => 'Je hebt nog geen betaalmethode gekozen! Probeer opnieuw.',
      ),
    ),
  ),
  'back' => '‹ Ga terug naar jouw persoonlijk advies',
  'apply' => 'Toepassen',
  'wait' => 'Wacht..',
  'errors' => 
  array (
    'payment-error' => 'Er is een fout opgetreden bij de verwerking van de betaling, probeer het opnieuw.',
    'no-cart-session' => 'Der kunne ikke findes en kurv-session!',
  ),
  'fb-login' => 'Log ind med Facebook',
  'back-pick' => '‹ Ga terug naar jouw selectie',
  'terms-agree' => 'Ved at klikke "Bestil nu" accepterer du vores handelsbetingelser samt bekræfter, at du er over 18.',
  'facebook_disclaimer' => '(Wij posten niets op jou Facebook profiel)',
  'cvv-information' => 'De controle-nummer staat meestal achter op de kaart',
);
