<?php

global $mod_strings, $sugar_config;

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/asol_Project/asolProjectUtils.php");
require_once('modules/asol_Project/resources/jQueryGantt-master/server/ganttServerUtils.php');

asolProjectUtils::log('debug', "ENTRY", __FILE__);

$focus = new asol_Project();

$isUpdate = (!empty($_REQUEST['record']));

// If update AsolProject
if ($isUpdate) {
	// TODO check if it is needed retrieve the bean for the WFM
	$focus->id = $_REQUEST['record'];
}

// Assign AsolProject values
$focus->name = $_REQUEST['name'];
$focus->assigned_user_id = $_REQUEST['assigned_user_id'];
$focus->description = $_REQUEST['description'];
$focus->date_start = $_REQUEST['date_start'];
$focus->date_end = $_REQUEST['date_end'];
$focus->status = $_REQUEST['status'];
$focus->priority = $_REQUEST['priority'];
$focus->log = $_REQUEST['log'];
$focus->wiki_link = $_REQUEST['wiki_link'];
$focus->wiki_link_alias = $_REQUEST['wiki_link_alias'];
$focus->asol_projectversion_id_c = $_REQUEST['asol_projectversion_id_c']; // working_version
$focus->asol_projectversion_id1_c = $_REQUEST['asol_projectversion_id1_c']; // last_published_version

// Save
$recordId = $focus->save();

// If create AsolProject then create both working_version and last_published_version
if (!$isUpdate) {

	require_once("modules/asol_ProjectManagementCommon/asol_ProjectManagementCommon.php");
	$projectManagementCommon = new asol_ProjectManagementCommon();
	$projectManagementCommon->retrieve("cleanCacheWhenSaveAsolProjectFlag");
	$projectManagementCommon->name = 'cleanCacheWhenSaveAsolProjectFlag';

	if ($projectManagementCommon->value === 'true') {

		//asolProjectUtils::deleteAll(sugar_cached('modules'), true); // Delete cache/modules
		asolProjectUtils::delTree(sugar_cached('modules'));

		$projectManagementCommon->value = 'false';
		$projectManagementCommon->save();
	}

	$ganttProject = Array(
		'tasks' => Array(),
	);

	$workingVersionName = (isset($sugar_config['LBL_WORKING_VERSION_NAME'])) ? $sugar_config['LBL_WORKING_VERSION_NAME'] : $mod_strings['LBL_WORKING_VERSION_NAME'];
	$lastPublishedVersionName = (isset($sugar_config['LBL_LAST_PUBLISHED_VERSION_NAME'])) ? $sugar_config['LBL_LAST_PUBLISHED_VERSION_NAME'] : $mod_strings['LBL_LAST_PUBLISHED_VERSION_NAME'];

	createAsolProjectVersion($focus, $ganttProject, $workingVersionName, '', 'working_version');
	createAsolProjectVersion($focus, $ganttProject, $lastPublishedVersionName, '', 'last_published_version');

	// Second Save in order to save relates
	$focus->save();
}

// Redirect
asolProjectUtils::redirect($recordId);



?>