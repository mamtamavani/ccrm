<?php
// created: 2012-09-06 08:54:56
$viewdefs['tst01_testmodule001']['DetailView'] = array (
  'templateMeta' => 
  array (
    'form' => 
    array (
      'buttons' => 
      array (
        0 => 'EDIT',
        1 => 'DUPLICATE',
        2 => 'DELETE',
      ),
    ),
    'maxColumns' => '2',
    'widths' => 
    array (
      0 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
      1 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
    ),
    'tabDefs' => 
    array (
      1 => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      2 => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    0 => 
    array (
      0 => 'name',
      1 => 'assigned_user_name',
    ),
    1 => 
    array (
      0 => 
      array (
        'name' => 'date_entered',
        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
        'label' => 'LBL_DATE_ENTERED',
      ),
      1 => 
      array (
        'name' => 'date_modified',
        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
        'label' => 'LBL_DATE_MODIFIED',
      ),
    ),
    2 => 
    array (
      0 => 'description',
    ),
  ),
);