<?php
$viewdefs ['ProjectTask'] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
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
          'file' => 'modules/ProjectTask/ProjectTask.js',
        ),
      ),
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
        ),
        'hideAudit' => true,
      ),
      'useTabs' => false,
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
          0 => 'name',
          1 => 
          array (
            'name' => 'project_task_id',
            'label' => 'LBL_TASK_ID',
          ),
        ),
        1 => 
        array (
          0 => 'date_start',
          1 => 'date_finish',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_USER_ID',
          ),
          1 => '',
        ),
        3 => 
        array (
          0 => 'status',
          1 => 'priority',
        ),
        4 => 
        array (
          0 => 'percent_complete',
          1 => 
          array (
            'name' => 'milestone_flag',
            'label' => 'LBL_MILESTONE_FLAG',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'project_name',
            'customCode' => '<a href="index.php?module=Project&action=DetailView&record={$fields.project_id.value}">{$fields.project_name.value}&nbsp;</a>',
            'label' => 'LBL_PARENT_ID',
          ),
          1 => 
          array (
            'name' => 'date_due',
            'label' => 'LBL_DATE_DUE',
          ),
        ),
        6 => 
        array (
          0 => 'task_number',
          1 => 'order_number',
        ),
        7 => 
        array (
          0 => 'estimated_effort',
          1 => 'utilization',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'description',
          ),
        ),
      ),
    ),
  ),
);
?>
