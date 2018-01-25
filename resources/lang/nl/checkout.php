<?php

return array (
  'messages' => 
  array (
    'vitamins-not-selected' => 'Voordat je een bestelling kunt plaatsen, dien je eerst de vragenlijst af te ronden zodat wij jouw supplementen kunnen selecteren.',
    'payment-invalid' => 'De betaling is niet geslaagd, probeer het opnieuw. :error',
    'no-such-coupon' => 'Kortingscode is niet juist of al reeds gebruikt. Probeer het nog eens.',
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
    'title' => 'Jouw bestelling is verwerkt',
    'text' => 'Bedankt voor jouw bestelling bij TakeDaily! Je ontvangt binnen 5 minuten een orderbevestiging met belangrijke informatie over je bestelling en de levering. Heb je geen orderbevestiging van ons ontvangen? Bekijk dan altijd even je spamfilter. Het kan zijn dat de bevestiging daarin terecht is gekomen. Indien dit niet het geval is, dan kan je contact met ons opnemen over de status van jouw bestelling.',
    'button-text' => 'Ga naar Mijn TakeDaily',
    'giftcard' => 
    array (
      'title' => 'Code cadeaubon:',
      'text' => 'Bedankt voor jouw aankoop bij TakeDaily! Je ontvangt binnen 5 minuten een orderbevestiging met de belangrijke informatie over de cadeaubon. ',
    ),
    'upsell' => 
    array (
      'code' => 'Kopieer en deel jouw kortingscode:',
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
          'street' => 'Straat',
          'street-placeholder' => 'Havenstraat',
          'zipcode' => 'Postcode',
          'zipcode-placeholder' => '1000 AA',
          'city' => 'Woonplaats',
          'city-placeholder' => 'Houtdam',
          'country' => 'Land',
          'require' => 'Adres',
          'number' => 'Huisnummer/Toev.',
          'number-placeholder' => '123A',
          'postal' => 
          array (
            'error' => 'Vul hier een geldige postcode in',
          ),
          'number-error' => 'Vul hier een geldig huisnummer in',
        ),
        'optional' => 'Optioneel',
        'company' => 'Bedrijfsnaam (optioneel)',
        'company-placeholder' => 'Naam bedrijf',
        'cvr-placeholder' => 'Nl- 0612345678',
        'phone-placeholder' => '0612345678',
        'phone' => 'Mobiel telefoonnummer',
        'is-company' => 'Bedrijfsnaam (Optioneel)',
        'password' => 'Wachtwoord (kies een wachtwoord)',
        'password-placeholder' => 'Wachtwoord',
        'password_confirmation' => 'Bevestig uw wachtwoord
',
        'password_confirmation-placeholder' => 'Herhaal wachtwoord',
        'cvr' => 'KvK',
        'last_name' => 'Achternaam',
        'first_name' => 'Voornaam',
        'first-name-placeholder' => 'Amy',
        'last-name-placeholder' => 'Visser',
        'repeat-email' => 'Herhaal jouw mailadres',
        'email-check' => 'E-mailadres',
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
<p class="checkout_description">Je kan je abonnement ieder moment pauzeren of opzeggen tot 2 dagen voor de volgende verzenddatum (zie deze datum in jouw persoonlijke TakeDaily account).</p>',
    'method' => 
    array (
      'title' => 'Selecteer betaalmethode',
      'errors' => 
      array (
        'no-method' => 'Je hebt nog geen betaalmethode gekozen! Probeer opnieuw.',
      ),
    ),
    'wait-text' => 'Even geduld aub.',
  ),
  'back' => '‹ Ga terug naar jouw persoonlijk advies',
  'apply' => 'Toepassen',
  'wait' => 'Wacht..',
  'errors' => 
  array (
    'payment-error' => 'Er is een fout opgetreden bij de verwerking van de betaling, probeer het opnieuw.',
    'no-cart-session' => 'Wij kunnen geen inkoop sessie-vinden! Stuur aub. een email naar info@takedaily.nl',
  ),
  'fb-login' => 'Log in met Facebook',
  'back-pick' => '‹ Ga terug naar jouw selectie',
  'terms-agree' => 'Door te betalen ga je akkoord met de<a class="terms"  href="/page/terms"> algemene voorwaarden</a>, de vierwekelijkse automatische incasso van de abonnementskosten en bevestig je dat je ouder bent dan 18 jaar oud.',
  'facebook_disclaimer' => '(Wij posten uiteraard niets op jouw Facebook profiel)',
  'cvv-information' => 'De controle-nummer staat meestal achter op de kaart',
  'success-upsell' => 'Kopieer en deel jouw kortingscode:',
  'terms-agree-gift' => 'Door te betalen ga je akkoord met de<a class="terms"  href="/page/terms"> algemene voorwaarden</a>.',
);
