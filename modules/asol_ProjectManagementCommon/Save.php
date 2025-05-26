<?php

global $mod_strings, $sugar_config;

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/asol_Project/asolProjectUtils.php");
require_once('modules/asol_Project/resources/jQueryGantt-master/server/ganttServerUtils.php');

asolProjectUtils::log('debug', "ENTRY", __FILE__);

// Not save

// Redirect
header("Location: index.php?action=ListView&module=asol_ProjectManagementCommon");

?>