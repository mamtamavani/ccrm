<?php
// created: 2012-09-06 08:54:56
$viewdefs['Documents']['QuickCreate'] = array (
  'templateMeta' => 
  array (
    'form' => 
    array (
      'enctype' => 'multipart/form-data',
      'hidden' => 
      array (
        0 => '<input type="hidden" name="old_id" value="{$fields.document_revision_id.value}">',
        1 => '<input type="hidden" name="parent_id" value="{$smarty.request.parent_id}">',
        2 => '<input type="hidden" name="parent_type" value="{$smarty.request.parent_type}">',
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
    'includes' => 
    array (
      0 => 
      array (
        'file' => 'include/javascript/popup_parent_helper.js',
      ),
      1 => 
      array (
        'file' => 'cache/include/javascript/sugar_grp_jsolait.js',
      ),
      2 => 
      array (
        'file' => 'modules/Documents/documents.js',
      ),
    ),
    'tabDefs' => 
    array (
      'DEFAULT' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'default' => 
    array (
      0 => 
      array (
        0 => 'status_id',
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'filename',
          'displayParams' => 
          array (
            'required' => true,
            'onchangeSetFileNameTo' => 'document_name',
          ),
        ),
      ),
      2 => 
      array (
        0 => 'document_name',
        1 => 
        array (
          'name' => 'revision',
          'customCode' => '<input name="revision" type="text" value="{$fields.revision.value}" {$DISABLED}>',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'active_date',
          'displayParams' => 
          array (
            'required' => true,
          ),
        ),
        1 => 'category_id',
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'description',
          'displayParams' => 
          array (
            'rows' => 10,
            'cols' => 120,
          ),
        ),
      ),
    ),
  ),
);