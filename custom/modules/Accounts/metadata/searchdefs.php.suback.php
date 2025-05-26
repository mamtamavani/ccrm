<?php
// created: 2011-01-19 09:02:57
$searchdefs['Accounts'] = array (
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
  'layout' => 
  array (
    'basic_search' => 
    array (
      0 => 
      array (
        'name' => 'name',
        'default' => 'n',
        'width' => '10%',
      ),
      1 => 'billing_address_city',
      2 => 'phone_office',
      3 => 
      array (
        'name' => 'address_street',
        'label' => 'LBL_BILLING_ADDRESS',
        'type' => 'name',
        'group' => 'billing_address_street',
      ),
      4 => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => false,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      0 => 
      array (
        'name' => 'name',
        'default' => NULL,
        'width' => '10%',
      ),
      1 => 
      array (
        'name' => 'address_city',
        'label' => 'LBL_CITY',
        'type' => 'name',
        'default' => false,
        'width' => '10%',
      ),
      2 => 
      array (
        'name' => 'email',
        'label' => 'LBL_ANY_EMAIL',
        'type' => 'name',
        'default' => false,
        'width' => '10%',
      ),
      3 => 
      array (
        'name' => 'rating',
      ),
      4 => 
      array (
        'name' => 'assigned_user_id',
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_TO',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'default' => false,
        'width' => '10%',
      ),
      5 => 
      array (
        'name' => 'account_type',
        'default' => NULL,
        'width' => '10%',
      ),
      6 => 
      array (
        'label' => 'LBL_ACCOUNTSTATUS',
        'width' => '10',
        'name' => 'accountstatus_c',
        'default_value' => '',
      ),
      7 => 
      array (
        'name' => 'industry',
        'default' => NULL,
        'width' => '10%',
      ),
      8 => 
      array (
        'label' => 'LBL_LEAD_COUNTRY',
        'width' => '10',
        'name' => 'lead_country_c',
        'default_value' => '',
      ),
    ),
  ),
);
?>
