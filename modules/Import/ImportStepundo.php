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

require_once('modules/Import/ImportContact.php');
require_once('modules/Import/ImportAccount.php');
require_once('modules/Import/UsersLastImport.php');
require_once('modules/Import/parse_utils.php');

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;
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


$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
require_once($theme_path.'layout_utils.php');

$GLOBALS['log']->info("Import Undo");
$last_import = new UsersLastImport();
$ret_value = $last_import->undo($current_user->id);
?>

<br>

<table width="100%" border=1>
<tr>
<td>
<br>
<?php 
if ($ret_value) {
?>
<?php echo $mod_strings['LBL_SUCCESS'] ?><BR>
<?php echo $mod_strings['LBL_LAST_IMPORT_UNDONE'] ?>
<?php 
} 
else 
{
?>
<?php echo $mod_strings['LBL_FAIL'] ?><br>
<?php echo $mod_strings['LBL_NO_IMPORT_TO_UNDO'] ?>
<?php
} 
?>
<br>
<br>
</td>
</tr>
</table>
<br>
<form name="Import" method="POST" action="index.php">
<input type="hidden" name="module" value="<?php echo $_REQUEST['module']; ?>">
<input type="hidden" name="action" value="Import">
<input type="hidden" name="step" value="1">
<input type="hidden" name="return_module" value="<?php echo $_REQUEST['return_module'] ?>">
<input type="hidden" name="return_id" value="<?php echo $_REQUEST['return_id'] ?>">
<input type="hidden" name="return_action" value="<?php echo $_REQUEST['return_action'] ?>">

<table width="100%" cellpadding="2" cellspacing="0" border="0"><tr>
        <td align="right"><input title="<?php echo $mod_strings['LBL_TRY_AGAIN'] ?>" accessKey="" class="button" type="submit" name="button" value="  <?php echo $mod_strings['LBL_TRY_AGAIN'] ?>  "></td>
        <td></td>
</tr>
</table>
        </form>
