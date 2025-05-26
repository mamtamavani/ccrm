<?php

global $mod_strings, $sugar_config;

if (isset($sugar_config['PM_useTinyMCE']) && $sugar_config['PM_useTinyMCE']) {
	require_once("modules/asol_Project/customFields/description.tinymce.php");
} else {
	
	$bean = $GLOBALS['FOCUS'];
	
	switch ($_REQUEST['action']) {
		case 'EditView':
			echo "<textarea cols='200' rows='6' name='description' id='description'>{$bean->description}</textarea>";
			break;
		case 'DetailView':
			echo "<span name='description' id='description'>".nl2br($bean->description)."</span>";
			break;
	}
}