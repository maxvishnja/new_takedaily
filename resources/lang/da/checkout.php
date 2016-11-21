<?php

return array (
  'wait' => 'Vent...',
  'apply' => 'Anvend',
  'back' => '‹ Gå tilbage til anbefalingen',
  'messages' => 
  array (
    'vitamins-not-selected' => 'Vi skal finde dine vitaminer før du kan handle.',
    'payment-invalid' => 'Betalingen blev ikke godkendt, prøv igen. :error',
    'no-such-coupon' => 'Kuponkoden findes ikke.',
    'coupon-missing' => 'Du skal indtaste en kuponkode.',
    'coupon-added' => 'Kuponkoden blev tilføjet!',
    'card-added' => 'Kortet blev tilføjet!',
  ),
  'mail' => 
  array (
    'subject' => 'Ordrebekræftelse fra TakeDaily',
    'subject-subscription' => 'Vi har trukket penge for dit abonnement',
    'subject-subscription-failed' => 'Vi kunne ikke trække penge for dit abonnement!',
  ),
  'success' => 
  array (
    'page-title' => 'Din ordre blev godkendt! - TakeDaily',
    'title' => 'Din ordre blev oprettet',
    'text' => 'Du vil indenfor 5 minutter modtage en ordrebekræftelse, med information omkring levering og din ordre generelt. Tak for dit køb!',
    'button-text' => 'Gå til dit TakeDaily',
    'giftcard' => 
    array (
      'title' => 'Gavekort koden er:',
      'text' => 'Du vil indenfor 5 minutter modtage en ordrebekræftelse, med information omkring gavekortet, indløsning og din ordre generelt. Tak for dit køb!',
    ),
  ),
  'errors' => 
  array (
    'no-cart-session' => 'Der kunne ikke findes en kurv-session!',
    'payment-error' => 'Der skete en fejl under betalingen, prøv igen.',
  ),
  'index' => 
  array (
    'title' => 'Betaling - TakeDaily',
    'order' => 
    array (
      'title' => 'Bestilling',
      'info' => 
      array (
        'title' => 'Dine oplysninger',
        'name' => 'Dit fulde navn',
        'name-placeholder' => 'Lars Jensen',
        'email' => 'Din e-mail adresse',
        'phone' => 'Dit tlf. nummer',
        'phone-placeholder' => '12345678',
        'email-placeholder' => 'lars-jensen@gmail.com',
        'address' => 
        array (
          'street' => 'Vejnavn og nummer',
          'street-placeholder' => 'Søndre Skovvej 123',
          'zipcode' => 'Postnummer',
          'zipcode-placeholder' => '9940',
          'city' => 'By',
          'city-placeholder' => 'Aalborg',
          'country' => 'Land',
        ),
        'optional' => 'valgfrit',
        'is-company' => 'Jeg handler som en virksomhed',
        'company' => 'Firmanavn',
        'cvr' => 'CVR',
        'cvr-placeholder' => 'DK-12345678',
        'company-placeholder' => 'Virksomhedens navn',
      ),
      'billing' => 
      array (
        'title' => 'Kortoplysninger',
        'secure' => 'Sikret forbindelse',
        'card' => 
        array (
          'name' => 'Navn på kortet',
          'number' => 'Kortnummer',
          'number-placeholder' => '4111 1111 1111 1111',
          'month' => 'Udløbsmåned',
          'year' => 'Udløbsår',
          'cvc' => 'Kontrolnummer',
          'cvc-title' => 'CVV',
          'cvc-placeholder' => '123',
        ),
      ),
      'button-submit-text' => 'Bestil nu',
    ),
    'total' => 
    array (
      'title' => 'Ordreoversigt',
      'shipping' => 'Fragt',
      'free' => 'Gratis',
      'giftcard' => 'Gavekort værdi',
      'taxes' => 'Heraf moms',
      'coupon' => 'Rabatkode',
      'total' => 'Total',
    ),
    'coupon' => 
    array (
      'link' => 'Har du en rabatkode?',
      'input-placeholder' => 'Din rabatkode',
      'button-text' => 'Anvend',
    ),
    'disclaimer' => '<p class="checkout_description">Dette er et abonnement, vi trækker derfor <span v-show="price === total_subscription">{{ total_subscription }}
							DKK</span><strong v-show="price !== total_subscription">{{ total_subscription }} DKK</strong> på dit kort hver måned. </p>

					<p class="checkout_description">Du kan til enhver tid stoppe abonnementet, eller sætte det midlertidligt på pause.</p>',
    'method' => 
    array (
      'title' => 'Betalingsmetode',
      'errors' => 
      array (
        'no-method' => 'Du har ikke valgt en betalingsmetode! Prøv igen.',
      ),
    ),
  ),
);
