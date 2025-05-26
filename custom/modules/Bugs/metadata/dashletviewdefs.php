<?php
$dashletData['BugsDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'assigned_user_name' => 
  array (
    'default' => '',
  ),
  'created_by_name' => 
  array (
    'default' => '',
  ),
  'client_c' => 
  array (
    'default' => '',
  ),
  '' => 
  array (
    'default' => '',
  ),
  'priority' => 
  array (
    'default' => '',
  ),
  'type' => 
  array (
    'default' => '',
  ),
  'name' => 
  array (
    'default' => '',
  ),
  'due_date_c' => 
  array (
    'default' => '',
  ),
  'status' => 
  array (
    'default' => '',
  ),
  'resolution' => 
  array (
    'default' => '',
  ),
  'close_date_c' => 
  array (
    'default' => '',
  ),
  'dev_duration_c' => 
  array (
    'default' => '',
  ),
  'promised_date_c' => 
  array (
    'default' => '',
  ),
);
$dashletData['BugsDashlet']['columns'] = array (
  'bug_number' => 
  array (
    'width' => '5%',
    'label' => 'LBL_NUMBER',
    'default' => true,
    'name' => 'bug_number',
  ),
  'name' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_SUBJECT',
    'link' => '1',
    'default' => true,
    'name' => 'name',
  ),
  'client_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_CLIENT',
    'width' => '10%',
    'name' => 'client_c',
  ),
  'priority' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIORITY',
    'default' => true,
    'name' => 'priority',
  ),
  'due_date_c' => 
  array (
    'type' => 'date',
    'default' => true,
    'label' => 'LBL_DUE_DATE',
    'width' => '10%',
    'name' => 'due_date_c',
  ),
  'resolution' => 
  array (
    'width' => '15%',
    'label' => 'LBL_RESOLUTION',
    'name' => 'resolution',
    'default' => false,
  ),
  'release_name' => 
  array (
    'width' => '15%',
    'label' => 'LBL_FOUND_IN_RELEASE',
    'related_fields' => 
    array (
      0 => 'found_in_release',
    ),
    'name' => 'release_name',
    'default' => false,
  ),
  'type' => 
  array (
    'width' => '15%',
    'label' => 'LBL_TYPE',
    'name' => 'type',
    'default' => false,
  ),
  'fixed_in_release_name' => 
  array (
    'width' => '15%',
    'label' => 'LBL_FIXED_IN_RELEASE',
    'name' => 'fixed_in_release_name',
    'default' => false,
  ),
  'source' => 
  array (
    'width' => '15%',
    'label' => 'LBL_SOURCE',
    'name' => 'source',
    'default' => false,
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'name' => 'date_entered',
    'default' => false,
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => false,
  ),
  'status' => 
  array (
    'width' => '10%',
    'label' => 'LBL_STATUS',
    'default' => false,
    'name' => 'status',
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
    'name' => 'description',
  ),
  'product_category' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_PRODUCT_CATEGORY',
    'width' => '10%',
    'default' => false,
    'name' => 'product_category',
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => 'modified_user_link',
    'label' => 'LBL_MODIFIED_NAME',
    'width' => '10%',
    'default' => false,
    'name' => 'modified_by_name',
  ),
  'bug_user_creator_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_BUG_USER_CREATOR',
    'width' => '10%',
    'name' => 'bug_user_creator_c',
  ),
  'dev_duration_c' => 
  array (
    'type' => 'decimal',
    'default' => false,
    'label' => 'LBL_DEV_DURATION',
    'width' => '10%',
    'name' => 'dev_duration_c',
  ),
  'dev_work_batch_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_DEV_WORK_BATCH',
    'width' => '10%',
    'name' => 'dev_work_batch_c',
  ),
  'promised_date_c' => 
  array (
    'type' => 'date',
    'default' => false,
    'label' => 'LBL_PROMISED_DATE',
    'width' => '10%',
    'name' => 'promised_date_c',
  ),
  'communicatetoclients_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_COMMUNICATETOCLIENTS',
    'width' => '10%',
  ),
  'update_to_client_c' => 
  array (
    'type' => 'text',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_UPDATE_TO_CLIENT',
    'sortable' => false,
    'width' => '10%',
  ),
);
