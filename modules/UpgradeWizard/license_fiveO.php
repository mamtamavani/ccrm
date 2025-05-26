<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2009 SugarCRM Inc.
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

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/
logThis('At License_fiveO.php');
$stop = true; // flag to show "next"
$run = isset($_REQUEST['run']) ? $_REQUEST['run'] : '';
$out = '';
$ready = '';

//refreshing mod_strings
global $mod_strings;
$curr_lang = 'en_us';
if(isset($GLOBALS['current_language']) && ($GLOBALS['current_language'] != null)){
	$curr_lang = $GLOBALS['current_language'];
}
return_module_language($curr_lang, 'UpgradeWizard');

set_upgrade_progress('license_fiveO','in_progress');
if(file_exists('ModuleInstall/PackageManager/PackageManagerDisplay.php')) {
	require_once('ModuleInstall/PackageManager/PackageManagerDisplay.php');
}
$ready = '';
	global $sugar_config;

 // Do the prelicense check. Also set the session vars if unzipping files.
  preLicenseCheck();
  if(substr($sugar_version,0,1) < 5){
  	$_SESSION['license_shown'] = true;
  }
//grab the license file contents
$license_file = $_SESSION['unzip_dir'].'/'.$_SESSION['zip_from_dir'].'/LICENSE.txt';
$require_license = false;
if(file_exists($license_file)){
	$require_license = true;
	$stop = false;
	if(function_exists('sugar_fopen')){
		$fh = sugar_fopen($license_file, 'r');
	}
	else{
		$fh = fopen($license_file, 'r');
	}
    $license_contents = fread($fh, filesize($license_file));
    fclose($fh);
}
$license_OS_CE = '';

if($sugar_flavor == 'OS' || $sugar_flavor == 'CE'){
	if(!isset($mod_strings['LBL_UW_SUGAR_COMMUNITY_EDITION_LICENSE']) || $mod_strings['LBL_UW_SUGAR_COMMUNITY_EDITION_LICENSE'] == null){
		$mod_strings['LBL_UW_SUGAR_COMMUNITY_EDITION_LICENSE'] = 'The Sugar Community Edition 5.0 uses GNU General Public License Version 3. This upgrade will convert your existing license to the new license displayed below.';
	}
	$license_OS_CE = $mod_strings['LBL_UW_SUGAR_COMMUNITY_EDITION_LICENSE'];
}


if(!isset($mod_strings['LBL_UPGRADE_TAKES_TIME_HAVE_PATIENCE']) || $mod_strings['LBL_UPGRADE_TAKES_TIME_HAVE_PATIENCE'] == null){
		$mod_strings['LBL_UPGRADE_TAKES_TIME_HAVE_PATIENCE'] = 'Upgrade may take some time';
}
///////////////////////////////////////////////////////////////////////////////
////	LICENSE FORM
$form =<<<eoq
<form name="the_form" id='the_form' enctype="multipart/form-data" action="index.php" method="post">
	<input type="hidden" name="module" value="UpgradeWizard">
	<input type="hidden" name="action" value="index">
	<input type="hidden" name="step" value="{$_REQUEST['step']}">
	<input type="hidden" name="run" value="upload">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabForm">
<tr><td>
	<table width="450" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan='2'>
				 <b>{$license_OS_CE}</b>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				 <textarea cols="100" rows="8" readonly>{$license_contents}</textarea>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top" colspan=2>
			<input type='radio' id='radio_license_agreement_accept' onclick = "license();" name='radio_license_agreement' value='accept'>{$mod_strings['LBL_ACCEPT']}&nbsp;
			<input type='radio' id='radio_license_agreement_reject' onclick = "license();" name='radio_license_agreement' value='reject'>{$mod_strings['LBL_DENY']}
			</td>
       </tr>
	</table>
</td></tr>
</table>
</form>
eoq;
$form5 =<<<eoq5
<br>
<div id="upgradeDiv" style="display:none" class="tabForm">
    <table cellspacing="0" cellpadding="0" border="0">
        <tr><td>
           <p><img src='modules/UpgradeWizard/processing.gif'> <br>{$mod_strings['LBL_UPGRADE_TAKES_TIME_HAVE_PATIENCE']}</p>
        </td></tr>
     </table>
 </div>

eoq5;
echo '<script>' .
      'function validateForm(process){'.
					'return (handleCommit(process));'.
         		'}'.
                'function handleCommit(process){
        if(process == 1) {
            if(document.getElementById("radio_license_agreement_reject") != null && document.getElementById("radio_license_agreement_accept") != null){
                var accept = false;
                if(document.getElementById("radio_license_agreement_accept").checked){
                    accept = true
                }
                if(!accept){
                    //do not allow the form to submit
                    alert("'.$mod_strings['ERR_UW_ACCEPT_LICENSE'].'");
                    return false;
                }
            }
        }
        return true;
    }</script>';

echo '<script>' .
       'function license(){
            if(document.getElementById("radio_license_agreement_reject") != null && document.getElementById("radio_license_agreement_accept") != null){
                var accept = false;
                if(!document.getElementById("radio_license_agreement_accept").checked
                    && !document.getElementById("radio_license_agreement_reject").checked){
                    accept = false
                 }
                if(document.getElementById("radio_license_agreement_accept").checked){
                    accept = true;
                    document.getElementById("next_button").disabled = false;
                }
                if(!accept){
                    document.getElementById("next_button").disabled = true;
                }
        }
    }</script>';


$hidden_fields = "<input type=\"hidden\" name=\"module\" value=\"UpgradeWizard\">";
$hidden_fields .= "<input type=\"hidden\" name=\"action\" value=\"index\">";
$hidden_fields .= "<input type=\"hidden\" name=\"step\" value=\"{$_REQUEST['step']}\">";
$hidden_fields .= "<input type=\"hidden\" name=\"run\" value=\"upload\">";
$form2 = '';
if(class_exists("PackageManagerDisplay")) {
	$form2 = PackageManagerDisplay::buildPatchDisplay($form, $hidden_fields, 'index.php', array('patch', 'module'));
}
$form3 =<<<eoq2
<br>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabForm">
<tr><td>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				{$mod_strings['LBL_UW_FILES_QUEUED']}<br>
				{$ready}
			</td>
		</tr>
	</table>
</td></tr>
</table>
eoq2;

$uwMain = $form.$form5;
////	END UPLOAD FORM
///////////////////////////////////////////////////////////////////////////////

set_upgrade_progress('license_fiveO','done');
$showBack		= false;
$showCancel		= true;
$showRecheck	= true;
$showNext		= ($stop) ? false : true;

$stepBack		= $_REQUEST['step'] - 1;
$stepNext		= $_REQUEST['step'] + 1;
$stepCancel		= -1;
$stepRecheck	= $_REQUEST['step'];


$_SESSION['step'][$steps['files'][$_REQUEST['step']]] = ($stop) ? 'failed' : 'success';

?>
