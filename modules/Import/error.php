<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2007 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('XTemplate/xtpl.php');

function show_error_import($message) {
$_SESSION['import_error'] = $message;
	header("Location: index.php?module={$_REQUEST['module']}&action=Import&step=Error");
}

//if (isset($step) && $step == 'Error') {

function display_error_import()
{
	$message = $_SESSION['import_error'];
	global $import_mod_strings;

	global $theme;

	global $mod_strings;
	global $app_strings;
	$theme_path="themes/".$theme."/";

	$image_path=$theme_path."images/";

	require_once($theme_path.'layout_utils.php');

	$GLOBALS['log']->info("Upload Error");

	$xtpl=new XTemplate ('modules/Import/error.html');
	$xtpl->assign("MOD", $mod_strings);
	$xtpl->assign("APP", $app_strings);
	echo "\n<p>\n";
	echo get_module_title($mod_strings['LBL_MODULE_NAME'],$mod_strings['LBL_MODULE_NAME'] , true); 
	echo "\n</p>\n";

	if (isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);

	if (isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);

	$xtpl->assign("THEME", $theme);

	$xtpl->assign("IMAGE_PATH", $image_path);$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);

	$xtpl->assign("MODULE", $_REQUEST['module']);
	$xtpl->assign("MESSAGE", $message);

	$xtpl->parse("main");

	$xtpl->out("main");
}
?>
