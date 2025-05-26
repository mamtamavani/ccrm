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

require_once('modules/Import/Forms.php');
require_once('modules/Import/ImportMap.php');
require_once('modules/Import/config.php');

global $mod_strings, $app_list_strings, $app_strings, $current_user, $import_bean_map;
global $import_mod_strings;

$focus = 0;
echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']." ".$mod_strings['LBL_STEP_2_TITLE'], true);
echo "\n</p>\n";
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
require_once($theme_path.'layout_utils.php');

$GLOBALS['log']->info($mod_strings['LBL_MODULE_NAME'] . " Upload Step 2");

$xtpl=new XTemplate ('modules/Import/ImportStep2.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("IMP", $import_mod_strings);
if (isset($_REQUEST['custom_delimiter']) && ($_REQUEST['custom_delimiter'] != ""))
{
    $xtpl->assign("CUSTOM_DELIMITER", $_REQUEST['custom_delimiter']);
}

if (isset($import_bean_map[$_REQUEST['module']]))
{
	$bean = $import_bean_map[$_REQUEST['module']];
	require_once("modules/Import/$bean.php");
	$focus = new $bean();
}
else
{
 echo "Imports aren't set up for this module type\n";
 exit;
}

if (isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);

if (isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);

$xtpl->assign("THEME", $theme);

$xtpl->assign("IMAGE_PATH", $image_path);$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);

$xtpl->assign("HEADER", $app_strings['LBL_IMPORT']." ". $mod_strings['LBL_MODULE_NAME']);

$xtpl->assign("MODULE", $_REQUEST['module']);

// see if the source starts with 'custom'
// if so, pull off the id, load that map, and get the name
if ($_REQUEST['source'] == "outlook")
{
	$xtpl->assign("SOURCE", $_REQUEST['source']);
	$xtpl->assign("SOURCE_NAME","Outlook ");
	$xtpl->assign("HAS_HEADER_CHECKED"," CHECKED");
}
else if ( strncasecmp("custom:",$_REQUEST['source'],7) == 0)
{
	$id = substr($_REQUEST['source'],7);
	$import_map_seed = new ImportMap();

	$import_map_seed->retrieve($id, false);

	$xtpl->assign("SOURCE_ID", $import_map_seed->id);
	$xtpl->assign("SOURCE_NAME", $import_map_seed->name);
	$xtpl->assign("SOURCE", $import_map_seed->source);

    $mapping_content = $import_map_seed->content;
    if ( isset($mapping_content) && $mapping_content != "")
    {
        $pairs = split("&",$mapping_content);
        foreach ($pairs as $pair){
            list($name,$value) = split("=",$pair);
            $mapping_arr["$name"] = $value;
        }
    }
    if (isset($mapping_arr["delimiter"])) {
        $_REQUEST['custom_delimiter'] = $mapping_arr["delimiter"];
        $xtpl->assign("CUSTOM_DELIMITER", $mapping_arr["delimiter"]);
    }


	if ($import_map_seed->has_header)
	{
		$xtpl->assign("HAS_HEADER_CHECKED"," CHECKED");
	}
}
else
{
	$xtpl->assign("HAS_HEADER_CHECKED"," CHECKED");
	$xtpl->assign("SOURCE", $_REQUEST['source']);
}

$xtpl->assign("JAVASCRIPT", get_validate_upload_js());

$lang_key = '';

if ($_REQUEST['source'] == "outlook")
{
	$lang_key = "OUTLOOK";
}
else if ($_REQUEST['source'] == "act")
{
	$lang_key = "ACT";
}
else if ($_REQUEST['source'] == "salesforce")
{
	$lang_key = "SF";
}
else if ($_REQUEST['source'] == "other_tab")
{
	$lang_key = "TAB";
}
else
{
	$lang_key = "CUSTOM";
}

$xtpl->assign("INSTRUCTIONS_TITLE",$mod_strings["LBL_IMPORT_{$lang_key}_TITLE"]);

if ($_REQUEST['source'] != 'custom_delimeted')
{
    for ($i = 1; isset($mod_strings["LBL_{$lang_key}_NUM_$i"]);$i++)
    {
        $xtpl->assign("STEP_NUM",$mod_strings["LBL_NUM_$i"]);
        $xtpl->assign("INSTRUCTION_STEP",$mod_strings["LBL_{$lang_key}_NUM_$i"]);
        $xtpl->parse("main.instructions.step");
    }
    $xtpl->parse("main.instructions");
}
    $xtpl->parse("main");
    $xtpl->out("main");

?>
