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
 ********************************************************************************/

require_once('XTemplate/xtpl.php');

require_once('modules/Import/UsersLastImport.php');
require_once('modules/Import/parse_utils.php');
require_once('include/ListView/ListView.php');
require_once('modules/Import/config.php');

require_once('include/ListView/ListViewSmarty.php');
require_once('modules/SavedSearch/SavedSearch.php');
require_once('modules/MySettings/StoreQuery.php');

global $mod_strings, $app_list_strings, $app_strings, $current_user, $import_bean_map;
global $theme;
if (! isset( $_REQUEST['module']))
{
	$_REQUEST['module'] = 'Home';
}

if (! isset( $_REQUEST['return_id']))
{
	$_REQUEST['return_id'] = '';
}
if (! isset( $_REQUEST['return_module']))
{
	$_REQUEST['return_module'] = '';
}

if (! isset( $_REQUEST['return_action']))
{
	$_REQUEST['return_action'] = '';
}
echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME']." ".$mod_strings['LBL_RESULTS'], true);
echo "\n</p>\n";

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
require_once($theme_path.'layout_utils.php');

$GLOBALS['log']->info("Upload Step 2");

function add_to_prospect_list_button($lastimportbean,$where="",$order_by="") {
	
	global $app_strings;
	global $sugar_version, $sugar_config;
	
	$popup_request_data = array(
		'call_back_function' => 'set_return_and_save_background',
		'form_name' => 'DetailView',
		'field_to_name_array' => array(
			'id' => 'subpanel_id',
		),
		'passthru_data' => array(
			'child_field' => 'notused',
			'return_url' => 'notused',
			'link_field_name' => 'notused',
			'module_name' => 'notused',
			'refresh_page'=>'1',
			'return_type'=>'addtoprospectlist',
			'parent_module'=>'ProspectLists',
			'parent_type'=>'ProspectList',
			'child_id'=>'id',
			'link_attribute'=>'prospects',
			'link_type'=>'default',	 //polymorphic or default
		)				
	);

	$query=$lastimportbean->create_list_query($order_by,$where);	
	$popup_request_data['passthru_data']['query']=urlencode($query);

	$json = getJSONobj();
	$encoded_popup_request_data = $json->encode($popup_request_data);	

	$title = $app_strings['LBL_ADD_TO_PROSPECT_LIST_BUTTON_LABEL'];
	$accesskey = $app_strings['LBL_ADD_TO_PROSPECT_LIST_BUTTON_KEY'];
	$value = $app_strings['LBL_ADD_TO_PROSPECT_LIST_BUTTON_LABEL'];
	$initial_filter='';
	
	
	return  '<script type="text/javascript" src="include/SubPanel/SubPanelTiles.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script> '. "\n"	
			. '<form name="DetailView">' 
			. '<input type="hidden" name="module" value="Prospects"><input type="hidden" name="record" value="id">' . "\n"
			. '</form>' 					
			. '<form action="index.php">' . "\n" 
			. '<table width="100%" cellpadding="0" cellspacing="0" border="0">' 
			. '<tr><td align="right" style="padding-bottom: 2px;">'

			. ' <input align=right" type="button" name="select_button" id="select_button" class="button"' . "\n"
				. ' title="' . $title . '"'
			. ' accesskey="' . $accesskey . '"'
			. ' value="' . $value . "\"\n"
			. " onclick='open_popup(\"ProspectLists\",600,400,\"$initial_filter\",true,true,$encoded_popup_request_data,\"Single\",\"true\");' /></form>\n"
			. '</td></tr></table> ';

}

if ( isset($_REQUEST['message']))
{
?>




<span class="body">
<?php 

function unhtmlentities($string)
{
   $trans_tbl = get_html_translation_table(HTML_ENTITIES);
   $trans_tbl = array_flip($trans_tbl);
   return strtr($string, $trans_tbl);
}

echo unhtmlentities($_REQUEST['message']);
if (isset($_REQUEST['duplink'])) {
	$link = trim($_REQUEST['duplink']); 
	if(!empty($link) ){
    echo "<br><a href =". $_REQUEST['duplink'] . " target='_blank'>" . $mod_strings['LBL_DUPLICATE_LIST'] . "</a><br>";	
	}
}
?>


<?php 
}
?>
</span>

<form name="Import" method="POST" action="index.php">
	<input type="hidden" name="module" value="<?php echo $_REQUEST['module']; ?>">
	<input type="hidden" name="action" value="Import">
	<input type="hidden" name="step" value="undo">
	<input type="hidden" name="return_module" value="<?php echo $_REQUEST['return_module']; ?>">
	<input type="hidden" name="return_id" value="<?php echo $_REQUEST['return_id']; ?>">
	<input type="hidden" name="return_action" value="<?php echo $_REQUEST['return_action']; ?>">

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td align="right" style="padding-bottom: 2px;">&nbsp;</td>
        	<td align="right" style="padding-bottom: 2px;"><input title="<?php echo $mod_strings['LBL_UNDO_LAST_IMPORT']; ?>" accessKey="" class="button" type="submit" name="button" value="  <?php echo $mod_strings['LBL_UNDO_LAST_IMPORT'] ?>  "></td>
		</tr>
	</table>
</form>

<form enctype="multipart/form-data" name="Import" method="POST" action="index.php">
   	<input type="hidden" name="module" value="<?php echo $_REQUEST['module']; ?>">
    <input type="hidden" name="action" value="Import">
    <input type="hidden" name="step" value="1">
    <input type="hidden" name="return_id" value="<?php echo $_REQUEST['return_id']; ?>">
    <input type="hidden" name="return_module" value="<?php echo $_REQUEST['return_module']; ?>">
    <input type="hidden" name="return_action" value="<?php echo $_REQUEST['return_action']; ?>">
		
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr align="right">
		<td align="right" style="padding-bottom: 2px;">
			<input title="<?php echo $mod_strings['LBL_IMPORT_MORE'] ?>" accessKey="" class="button" type="submit" name="button" value="  <?php echo $mod_strings['LBL_IMPORT_MORE'] ?>  "  onclick="return true;">
			<input title="<?php echo $mod_strings['LBL_FINISHED'] ?>" accessKey="" class="button" type="submit" name="button" value="  <?php echo $mod_strings['LBL_FINISHED'] ?>  "  onclick="this.form.action.value=this.form.return_action.value;this.form.return_module.value=this.form.return_module.value;return true;">
		</td>
	</tr>
	</table>		
</form>
<?php

$currentModule = "Import";
$last_imported_title = $mod_strings['LBL_LAST_IMPORTED'];
global $limit, $current_language;

if (isset($import_bean_map[$_REQUEST['module']]))
{
	$currentModule = $_REQUEST['module'];
	$bean = $import_bean_map[$currentModule];
	require_once("modules/Import/$bean.php");
	$focus = new $bean();
}
else
{
 echo "Imports aren't set up for this module type\n";
 exit;
}

//because some imports also populate data in related modules, we sometimes need to 
//step through multiple modules

// set $currentModule to something other than $related_module
// or else return_module_language will not work
global $currentModule;
$currentModule = 'import';

foreach ($focus->related_modules as $related_module)
{
	$new_bean = $import_bean_map[$related_module];

	require_once("modules/Import/{$new_bean}.php");
	$new_focus = new $new_bean();

	$current_module_strings = return_module_language($current_language, $related_module);
	$where = "users_last_import.assigned_user_id='{$current_user->id}' AND users_last_import.bean_type='$related_module' and users_last_import.bean_id={$new_focus->table_name}.id AND users_last_import.deleted=0";
	//adds button that allows users to link imported prospects with a prospect list..
	if ($focus->object_name =="Prospect" && $related_module=='Prospects') {
		echo add_to_prospect_list_button($new_focus,$new_focus->create_list_query("",$where),'');
	}

	echo "<BR>";
	require_once('include/ListView/ListViewFacade.php');
	$lvf = new ListViewFacade($new_focus, $related_module, 0);
	
	if(!empty($_REQUEST['orderBy'])) {
		$params['orderBy'] = $_REQUEST['orderBy'];
		$params['overrideOrder'] = true;
		if(!empty($_REQUEST['sortOrder'])) $params['sortOrder'] = $_REQUEST['sortOrder'];
	}
		
	$params['custom_from'] = ', users_last_import';
	$params['custom_where'] = " AND users_last_import.assigned_user_id = '{$GLOBALS['current_user']->id}' AND users_last_import.bean_type='{$module}' AND users_last_import.bean_id=$new_focus->table_name.id AND users_last_import.deleted=0 AND $new_focus->table_name.deleted=0";
	$lvf->setup('', $where, $params, $current_module_strings, 0, -1, '', '', array(), 'id');
	$lvf->display($last_imported_title." ".$related_module);
	//$_SESSION[$new_focus->list_view_prefix."_FROM_LIST_VIEW"] = $ListView->unique_id();
}
?>
