<?php
$listViewDefs ['Tasks'] = 
array (
  'SET_COMPLETE' => 
  array (
    'width' => '1%',
    'label' => 'LBL_LIST_CLOSE',
    'link' => true,
    'sortable' => false,
    'default' => true,
    'related_fields' => 
    array (
      0 => 'status',
    ),
  ),
  'NAME' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_SUBJECT',
    'link' => true,
    'default' => true,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
  ),
  'PARENT_NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_RELATED_TO',
    'dynamic_module' => 'PARENT_TYPE',
    'id' => 'PARENT_ID',
    'link' => true,
    'default' => true,
    'sortable' => false,
    'ACLTag' => 'PARENT',
    'related_fields' => 
    array (
      0 => 'parent_id',
      1 => 'parent_type',
    ),
  ),
  'DATE_DUE' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_DUE_DATE',
    'link' => false,
    'default' => true,
  ),
  'DOCS_C' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_DOCS',
    'width' => '10%',
  ),
  'ITEMS_C' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_ITEMS',
    'width' => '10%',
  ),
  'ACCOUNTING_C' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_ACCOUNTING',
    'width' => '10%',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '2%',
    'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_START' => 
  array (
    'width' => '5%',
    'label' => 'LBL_LIST_START_DATE',
    'link' => false,
    'default' => false,
  ),
  'STATUS' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_STATUS',
    'link' => false,
    'default' => false,
  ),
  'TIME_DUE' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_DUE_TIME',
    'sortable' => false,
    'link' => false,
    'default' => false,
  ),
  'CONTACT_NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_CONTACT',
    'link' => true,
    'id' => 'CONTACT_ID',
    'module' => 'Contacts',
    'default' => false,
    'ACLTag' => 'CONTACT',
    'related_fields' => 
    array (
      0 => 'contact_id',
    ),
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
  ),
  'WHAT_DONE_C' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'label' => 'LBL_WHAT_DONE',
    'width' => '10%',
  ),
  'PRIORITY' => 
  array (
    'type' => 'enum',
    'default' => false,
    'label' => 'LBL_PRIORITY',
    'width' => '10%',
  ),
  'CLIENT_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_CLIENT',
    'width' => '10%',
  ),
);
?>
