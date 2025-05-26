<?php
// created: 2011-07-31 12:13:42
$listViewDefs['Cases'] = array (
  'CASE_NUMBER' => 
  array (
    'width' => '5',
    'label' => 'LBL_LIST_NUMBER',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '25',
    'label' => 'LBL_LIST_SUBJECT',
    'link' => true,
    'default' => true,
  ),
  'ACCOUNT_NAME' => 
  array (
    'width' => '20',
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'module' => 'Accounts',
    'id' => 'ACCOUNT_ID',
    'link' => true,
    'default' => true,
    'ACLTag' => 'ACCOUNT',
    'related_fields' => 
    array (
      0 => 'account_id',
    ),
  ),
  'PRIORITY' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_PRIORITY',
    'default' => true,
  ),
  'STATUS' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_STATUS',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '10',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'default' => true,
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'link' => true,
    'related_fields' => 
    array (
      0 => 'assigned_user_id',
    ),
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '10',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
  ),
);
?>
