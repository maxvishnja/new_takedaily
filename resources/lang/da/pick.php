<?php

return array (
  'title' => 'Vælg selv dine vitaminer',
  'groups' => 
  array (
    'oil' => 'Omega-3',
    'lifestyle' => 'Livsstil',
    'multi' => 'Generelt',
    'diet' => 'Kostvaner',
  ),
  'select-btn' => 'Vælg denne',
  'deselect-btn' => 'Fravælg denne',
  'btn-save' => 'Gem ændringer',
  'btn-order' => 'Gå til bestilling',
  'min-vitamins' => 'Du mangler at vælge mindst {{ minVitamins - numSelectedVitamins }} produkt<span v-show="(minVitamins - numSelectedVitamins) > 1">er</span> mere, du kan max vælge 4 i alt.',
  'errors' => 
  array (
    'too-many' => 'Du har valgt det maksimale antal vitaminer, fravælg en for at vælge denne.',
    'not-enough' => 'Du har ikke valgt nok vitaminer, du skal mindst vælge :min forskellige.',
    'too-many-validation' => 'Du har valgt for mange vitaminer, du kan maksimalt vælge :max forskellige.',
    'not-found' => 'Du har valgt et vitamin som ikke findes, hvordan ved vi ikke, prøv igen.',
    'already-has-multi' => 'Du har allerede valgt et multi-vitamin',
  ),
  'updated' => 'Dine vitaminer blev opdateret!',
);
