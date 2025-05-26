<?php
$searchdefs ['Leads'] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'first_name' => 
      array (
        'name' => 'first_name',
        'default' => true,
      ),
      'last_name' => 
      array (
        'name' => 'last_name',
        'default' => true,
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
      ),
      'lead_source' => 
      array (
        'name' => 'lead_source',
        'default' => true,
      ),
    ),
    'advanced_search' => 
    array (
      'first_name' => 
      array (
        'name' => 'first_name',
        'default' => true,
        'width' => '10%',
      ),
      'phone' => 
      array (
        'name' => 'phone',
        'label' => 'LBL_ANY_PHONE',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'last_name' => 
      array (
        'name' => 'last_name',
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
      'account_name' => 
      array (
        'name' => 'account_name',
        'default' => true,
        'width' => '10%',
      ),
      'address_state' => 
      array (
        'name' => 'address_state',
        'label' => 'LBL_STATE',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'address_postalcode' => 
      array (
        'name' => 'address_postalcode',
        'label' => 'LBL_POSTAL_CODE',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'do_not_call' => 
      array (
        'name' => 'do_not_call',
        'default' => true,
        'width' => '10%',
      ),
      'lead_source' => 
      array (
        'name' => 'lead_source',
        'default' => true,
        'width' => '10%',
      ),
      'status' => 
      array (
        'name' => 'status',
        'default' => true,
        'width' => '10%',
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
      'lead_country_c' => 
      array (
        'label' => 'LBL_LEAD_COUNTRY',
        'width' => '10%',
        'name' => 'lead_country_c',
        'default_value' => '',
        'default' => true,
      ),
      'current_tool_c' => 
      array (
        'label' => 'LBL_CURRENT_TOOL',
        'width' => '10%',
        'name' => 'current_tool_c',
        'default_value' => '',
        'default' => true,
      ),
      'lead_relevance_c' => 
      array (
        'label' => 'LBL_LEAD_RELEVANCE',
        'width' => '10%',
        'name' => 'lead_relevance_c',
        'default_value' => '',
        'default' => true,
      ),
      'leadcontinent_c' => 
      array (
        'label' => 'LBL_LEADCONTINENT',
        'width' => '10%',
        'name' => 'leadcontinent_c',
        'default_value' => '',
        'default' => true,
      ),
      'counter_client_c' => 
      array (
        'label' => 'LBL_COUNTER_CLIENT',
        'width' => '10%',
        'name' => 'counter_client_c',
        'default_value' => '',
        'default' => true,
      ),
      'date_modified' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_modified',
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
