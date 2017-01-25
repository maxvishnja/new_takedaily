<?php

return array (
  'messages' => 
  array (
    'vitamins-not-selected' => 'Voordat je een bestelling kunt plaatsen, dien je eerst de vragenlijst af te ronden zodat wij jouw supplementen kunnen selecteren.',
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
    'text' => 'Bedankt je voor jouw bestelling bij TakeDaily! Je ontvangt binnen 5 minuten een orderbevestiging met belangrijke informatie over je bestelling en de levering. ',
    'button-text' => 'Ga naar Mjn TakeDaily',
    'giftcard' => 
    array (
      'title' => 'Code cadeaubon:',
      'text' => 'Bedankt voor jouw aankoop bij TakeDaily! Je ontvangt binnen 5 minuten een orderbevestiging met de belangrijke informatie over de cadeaubon. ',
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
        'email-placeholder' => 'voorbeeld@gmail.com',
        'address' => 
        array (
          'street' => 'Straat/huisnummer/toevoeging',
          'street-placeholder' => 'Havenstraat 123A',
          'zipcode' => 'Postcode',
          'zipcode-placeholder' => '1000 AA',
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
        'last_name' => 'Last name',
        'first_name' => 'First name',
        'first-name-placeholder' => 'Amy',
        'last-name-placeholder' => 'Visser',
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
      'button-submit-text' => 'Betalen',
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
    'disclaimer' => '<p class="checkout_description">Betaling van jouw TakeDaily abonnementskosten van <span v-show="price === total_subscription">€ {{ total_subscription }}</span><span v-show="price !== total_subscription">€ {{ total_subscription }}</span> geschiedt iedere vier weken per automatische afschrijving.</p>
<p class="checkout_description">Je kan je abonnement ieder moment pauzeren, uitstellen of opzeggen tot 4 dagen voor de volgende verzenddatum.</p>',
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
  'fb-login' => 'Log in met Facebook',
  'back-pick' => '‹ Ga terug naar jouw selectie',
  'terms-agree' => 'Door te betalen ga je akkoord met de<a href="/page/terms"> algemene voorwaarden</a>, de vierwekelijkse automatische incasso van de abonnementskosten en bevestig je dat je ouder bent dan 18 jaar oud.',
  'facebook_disclaimer' => '(Wij posten niets op jou Facebook profiel)',
  'cvv-information' => 'De controle-nummer staat meestal achter op de kaart',
);
