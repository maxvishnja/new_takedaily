<?php

return array (
  'wait' => 'Vent...',
  'apply' => 'Anvend',
  'back' => '‹ Gå tilbage til din anbefaling',
  'messages' => 
  array (
    'vitamins-not-selected' => 'Vi skal finde dine vitaminer før du kan handle.',
    'payment-invalid' => 'Betalingen blev ikke godkendt, prøv igen. :error',
    'no-such-coupon' => 'Rabatkoden findes ikke, eller brugt i forvejen.',
    'coupon-missing' => 'Du skal indtaste en kuponkode.',
    'coupon-added' => 'Rabatkoden blev tilføjet!',
    'card-added' => 'Kortet blev tilføjet!',
  ),
  'mail' => 
  array (
    'subject' => 'Ordrebekræftelse og TakeDaily til dig',
    'subject-subscription' => 'Vi har trukket penge for dit medlemskab hos TakeDaily.',
    'subject-subscription-failed' => 'Vi kunne ikke trække penge for dit TakeDaily medlemskab!',
  ),
  'success' => 
  array (
    'page-title' => 'Din ordre blev godkendt! - TakeDaily',
    'title' => 'Din ordre er blevet oprettet!',
    'text' => 'Du vil indenfor 5 minutter modtage en ordrebekræftelse, med information omkring levering og din ordre generelt. Vi forventer at levere din skræddersyet TakeDaily i din postkasse indenfor 4-5 hverdage. Har du købt et gavekort, vil du modtage dette i en separat mail. Tak for dit køb! Tjek altid dit spamfilter. Det kan være, at din ordrebekræftelse er endt deri. Hvis dette ikke er tilfældet, kan du kontakte os om status på din ordre.',
    'button-text' => 'Gå til dit TakeDaily',
    'giftcard' => 
    array (
      'title' => 'Gavekort koden er:',
      'text' => 'Du vil indenfor 5 minutter modtage en ordrebekræftelse, med information omkring gavekortet, indløsning og din ordre generelt. Tak for dit køb!',
    ),
    'upsell' => 
    array (
      'code' => 'Kopier din rabatkode:',
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
        'name' => 'Navn',
        'name-placeholder' => 'Lars Jensen',
        'email' => 'Din e-mail adresse',
        'phone' => 'Dit tlf. nummer',
        'phone-placeholder' => '12345678',
        'email-placeholder' => 'lars-jensen@gmail.com',
        'address' => 
        array (
          'street' => 'Vejnavn',
          'street-placeholder' => 'Søndre Skovvej',
          'zipcode' => 'Postnummer',
          'zipcode-placeholder' => '9940',
          'city' => 'By',
          'city-placeholder' => 'Aalborg',
          'country' => 'Land',
          'number' => 'Husnummer/Etage',
          'number-placeholder' => '123, 4 TV.',
          'postal' => 
          array (
            'error' => 'Du mangler at udfylde postnummer!',
          ),
          'number-error' => 'Du mangler at udfylde husnummer!',
        ),
        'optional' => 'valgfrit',
        'is-company' => 'Evt. c/o navn/firmanavn',
        'company' => 'C/o Navn/Firmanavn',
        'cvr' => 'CVR',
        'cvr-placeholder' => 'DK-12345678',
        'company-placeholder' => 'c/o Peter Eriksen',
        'password' => 'Ønsket kodeord',
        'password_confirmation' => 'Gentag kodeord',
        'password_confirmation-placeholder' => 'Gentagelse af kodeord',
        'password-placeholder' => 'Kodeord',
        'first_name' => 'Fornavn',
        'first-name-placeholder' => 'John',
        'last_name' => 'Efternavn',
        'last-name-placeholder' => 'Madsen',
        'repeat-email' => 'Gentag e-mail adresse',
        'email-check' => 'Din e-mail adresse',
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
      'input-placeholder' => 'Indtast rabatkode',
      'button-text' => 'Anvend',
    ),
    'disclaimer' => '<p class="checkout_description">Du vil blive trukket <span v-show="price === total_subscription">{{ total_subscription }} DKK</span><span v-show="price !== total_subscription">{{ total_subscription }} DKK</span> på dit kort hver 4 uge. Du kan både udskyde næste levering, sætte på pause, eller opsige dit medlemskab til enhver tid. Dog senest 5 dage inden næste afsendelsesdato.</p>',
    'method' => 
    array (
      'title' => 'Vælg betalingsmetode',
      'errors' => 
      array (
        'no-method' => 'Du har ikke valgt en betalingsmetode! Prøv igen.',
      ),
    ),
    'wait-text' => 'Vent et øjeblik',
  ),
  'fb-login' => 'Log ind med Facebook',
  'cvv-information' => 'Kontrolnummeret står typisk bag på kortet',
  'back-pick' => '‹ Gå tilbage til dine valg',
  'terms-agree' => 'Ved at klikke "Bestil nu" accepterer du vores <a class="terms" href="/page/terms">handelsbetingelser</a> samt bekræfter, at du er over 18 år.',
  'facebook_disclaimer' => '(Vi slår ingenting op på din Facebook profil)',
  'success-upsell' => 'Kopier din rabatkode:',
);
