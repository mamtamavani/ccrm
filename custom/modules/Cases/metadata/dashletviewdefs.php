<?php
$dashletData['CasesDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'created_by_name' => 
  array (
    'default' => '',
  ),
  'priority' => 
  array (
    'default' => '',
  ),
  'status' => 
  array (
    'default' => '',
  ),
  'name' => 
  array (
    'default' => '',
  ),
  'type' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'default' => '',
  ),
);
$dashletData['CasesDashlet']['columns'] = array (
  'case_number' => 
  array (
    'width' => '6',
    'label' => 'LBL_NUMBER',
    'default' => true,
  ),
  'name' => 
  array (
    'width' => '40',
    'label' => 'LBL_LIST_SUBJECT',
    'link' => true,
    'default' => true,
  ),
  'account_name' => 
  array (
    'width' => '29',
    'link' => true,
    'module' => 'Accounts',
    'id' => 'ACCOUNT_ID',
    'ACLTag' => 'ACCOUNT',
    'label' => 'LBL_ACCOUNT_NAME',
    'related_fields' => 
    array (
      0 => 'account_id',
    ),
  ),
  'priority' => 
  array (
    'width' => '15',
    'label' => 'LBL_PRIORITY',
    'default' => true,
  ),
  'status' => 
  array (
    'width' => '8',
    'label' => 'LBL_STATUS',
    'default' => true,
  ),
  'resolution' => 
  array (
    'width' => '8',
    'label' => 'LBL_RESOLUTION',
  ),
  'date_entered' => 
  array (
    'width' => '15',
    'label' => 'LBL_DATE_ENTERED',
  ),
  'date_modified' => 
  array (
    'width' => '15',
    'label' => 'LBL_DATE_MODIFIED',
  ),
  'created_by' => 
  array (
    'width' => '8',
    'label' => 'LBL_CREATED',
  ),
  'assigned_user_name' => 
  array (
    'width' => '8',
    'label' => 'LBL_LIST_ASSIGNED_USER',
  ),
);
