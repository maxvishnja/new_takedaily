<?php

return array (
  'title' => 'Kies jouw vitamines & mineralen',
  'groups' => 
  array (
    'oil' => 'Omega-3',
    'lifestyle' => 'Leefstijl',
    'multi' => 'Algemeen',
    'diet' => 'Eetpatroon',
  ),
  'select-btn' => 'Selecteer',
  'deselect-btn' => 'Selecteer',
  'btn-save' => 'Wijzigingen opslaan',
  'btn-order' => 'Ga naar de kassa',
  'min-vitamins' => 'Het minimale aantal te bestellen supplementen is {{ minVitamins - numSelectedVitamins }} vitamin<span v-show="(minVitamins - numSelectedVitamins) > 1">er</span> en max 4.',
  'errors' => 
  array (
    'too-many' => 'Je hebt het maximale aantal vitamines en mineralen geselecteerd. Selecteer het product dat je wilt verwijderen.',
    'already-has-multi' => 'Je kan maximaal een multi kiezen',
    'not-enough' => 'Je hebt niet genoeg producten geselecteerd. Je moet minimaal :min selecteren.',
    'too-many-validation' => 'Je hebt te veel producten geselecteerd. Je kan max :max selecteren.',
  ),
  'updated' => 'Jouw supplementepakket is aangepast',
);
