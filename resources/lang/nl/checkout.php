<?php

return array (
  'messages' => 
  array (
    'vitamins-not-selected' => 'Vi skal finde dine vitaminer før du kan handle.',
    'payment-invalid' => 'De betaling is niet geslaagd; probeer het opnieuw. :error',
    'no-such-coupon' => 'Couponcode onjuist. Probeer het nog eens.',
    'coupon-missing' => 'Voer uw couponcode in.',
    'coupon-added' => 'Couponcode toegevoegd!
',
    'card-added' => 'Kaart toegevoegd!',
  ),
  'mail' => 
  array (
    'subject' => 'Orderbevestiging TakeDaily',
    'subject-subscription' => 'Vi har trukket penge for dit abonnement',
    'subject-subscription-failed' => 'Vi kunne ikke trække penge for dit abonnement!',
  ),
  'success' => 
  array (
    'page-title' => 'Jouw bestelling is geslaagd! - TakeDaily',
    'title' => 'Din ordre blev oprettet',
    'text' => 'U ontvangt binnen 5 minuten ontvangt een orderbevestiging met informatie over de levering en de bestelling. Dank je voor jouw aankoop!',
    'button-text' => 'Ga naar Mjn TakeDaily',
    'giftcard' => 
    array (
      'title' => 'Code cadeaubon:',
      'text' => 'Du vil indenfor 5 minutter modtage en ordrebekræftelse, med information omkring gavekortet, indløsning og din ordre generelt. Tak for dit køb!',
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
        'company-placeholder' => 'Nl- 0612345678',
        'cvr-placeholder' => 'Nl- 0612345678',
        'phone-placeholder' => '0612345678',
        'phone' => 'Mobiel telefoonnummer',
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
    'disclaimer' => '<p class="checkout_description">Dette er et abonnement, vi trækker derfor <span v-show="price === total_subscription">€ {{ total_subscription }}</span><strong v-show="price !== total_subscription">€ {{ total_subscription }}</strong> på dit kort hver måned.
					</p>

					<p class="checkout_description">Du kan til enhver tid stoppe abonnementet, eller sætte det midlertidligt på pause.</p>',
    'method' => 
    array (
      'title' => 'Selecteer betaalmethode',
      'errors' => 
      array (
        'no-method' => 'Je hebt nog geen betalingsmethode gekozen! Probeer opnieuw.',
      ),
    ),
  ),
  'back' => '‹ Ga terug naar jouw persoonlijke advies',
);
