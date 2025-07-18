<?php
/* * *******************************************************************************
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
 *
 * This Version of the KReporter is licensed software and may only be used in
 * alignment with the License Agreement received with this Software.
 * This Software is copyrighted and may not be further distributed without
 * witten consent of Christian Knoll
 *
 * You can contact us at info@kreporter.org
 * ****************************************************************************** */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$dictionary['KReport'] = array('table' => 'kreports',
    'fields' => array(
        'report_module' => array(
            'name' => 'report_module',
            'type' => 'enum',
            'options' => 'moduleList',
            'len' => '25',
            'vname' => 'LBL_MODULE',
            'massupdate' => false,
        ),
        'report_status' => array(
            'name' => 'report_status',
            'type' => 'enum',
            'options' => 'kreportstatus',
            'len' => '1',
            'vname' => 'LBL_REPORT_STATUS'
        ),
        'union_modules' => array(
            'name' => 'union_modules',
            'type' => 'text',
        ),
        'reportoptions' => array(
            'name' => 'reportoptions',
            'type' => 'text',
            'vname' => 'LBL_REPORTOPTIONS'
        ),
        'listtype' => array(
            'name' => 'listtype',
            'type' => 'varchar',
            'len' => '10',
            'vname' => 'LBL_LISTTYPE',
            'massupdate' => false,
        ),
        'listtypeproperties' => array(
            'name' => 'listtypeproperties',
            'type' => 'text',
        ),
        'selectionlimit' => array(
            'name' => 'selectionlimit',
            'type' => 'varchar',
            'len' => '25',
            'vname' => 'LBL_SELECTIONLIMIT',
            'massupdate' => false,
        ),
        'presentation_params' => array(
            'name' => 'presentation_params',
            'type' => 'text',
            'vname' => 'LBL_PRESENTATION_PARAMS',
        ),   
        'visualization_params' => array(
            'name' => 'visualization_params',
            'type' => 'text',
            'vname' => 'LBL_VISUALIZATION_PARAMS',
        ),
        'integration_params' => array(
            'name' => 'integration_params',
            'type' => 'text',
            'vname' => 'LBL_INTEGRATION_PARAMS',
        ),        
        'wheregroups' => array(
            'name' => 'wheregroups',
            'type' => 'text',
            'vname' => 'LBL_WHEREGROUPS',
            'default' => '[]',
        ),
        'whereconditions' => array(
            'name' => 'whereconditions',
            'type' => 'text',
            'vname' => 'LBL_WHERECONDITION',
            'default' => '[]',
        ),
        'listfields' => array(
            'name' => 'listfields',
            'type' => 'text',
            'vname' => 'LBL_LISTFIELDS'
        ),
        'unionlistfields' => array(
            'name' => 'unionlistfields',
            'type' => 'text',
            'vname' => 'LBL_UNIONLISTFIELDS'
        ),
        'advancedoptions' => array(
            'name' => 'advancedoptions',
            'type' => 'text',
            'vname' => 'LBL_ADVANCEDOPTIONS'
        )
    ),
    'indices' => array(
        array('name' => 'idx_reminder_name', 'type' => 'index', 'fields' => array('name')),
    ),
    'optimistic_locking' => true,
);
if ($GLOBALS['sugar_flavor'] != 'CE')
    VardefManager::createVardef('KReports', 'KReport', array('default', 'assignable', 'team_security'));
else
    VardefManager::createVardef('KReports', 'KReport', array('default', 'assignable'));
