<?php
$searchdefs ['Accounts'] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'billing_address_city' => 
      array (
        'name' => 'billing_address_city',
        'default' => true,
      ),
      'phone_office' => 
      array (
        'name' => 'phone_office',
        'default' => true,
      ),
      'address_street' => 
      array (
        'name' => 'address_street',
        'label' => 'LBL_BILLING_ADDRESS',
        'type' => 'name',
        'group' => 'billing_address_street',
        'default' => true,
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'address_city' => 
      array (
        'name' => 'address_city',
        'label' => 'LBL_CITY',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'email' => 
      array (
        'name' => 'email',
        'label' => 'LBL_ANY_EMAIL',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'rating' => 
      array (
        'name' => 'rating',
        'default' => true,
      ),
      'assigned_user_id' => 
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
        'default' => true,
        'width' => '10%',
      ),
      'account_type' => 
      array (
        'name' => 'account_type',
        'default' => true,
        'width' => '10%',
      ),
      'accountstatus_c' => 
      array (
        'label' => 'LBL_ACCOUNTSTATUS',
        'width' => '10',
        'name' => 'accountstatus_c',
        'default_value' => '',
        'default' => true,
      ),
      'industry' => 
      array (
        'name' => 'industry',
        'default' => true,
        'width' => '10%',
      ),
      'lead_country_c' => 
      array (
        'label' => 'LBL_LEAD_COUNTRY',
        'width' => '10',
        'name' => 'lead_country_c',
        'default_value' => '',
        'default' => true,
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
    'maxColumnsBasic' => '3',
  ),
);
?>
