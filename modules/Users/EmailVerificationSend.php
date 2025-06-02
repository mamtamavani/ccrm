<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright(C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
if (!defined('SUGAR_PHPUNIT_RUNNER')) {
    session_regenerate_id(false);
}
global $sugar_config,$app_language,$current_language;

require_once('modules/Users/language/en_us.lang.php');
$mod_strings=return_module_language('','Users', true);

$user_email = isset($_REQUEST['user_email'])
    ? $_REQUEST['user_email'] : '';

$verificationCode = isset($_REQUEST['Verification'])
    ? $_REQUEST['Verification'] : '';

$sugar_smarty = new Sugar_Smarty();
echo '<link rel="stylesheet" type="text/css" media="all" href="'.getJSPath('modules/Users/login.css').'">';

if ( sugar_is_file('custom/include/images/sugar_md.png') ) {
    $login_image = '<IMG src="custom/include/images/sugar_md.png" alt="Sugar" width="340" height="25">';
}
else {
    $login_image = '<IMG src="include/images/sugar_md_open.png" alt="Sugar" width="340" height="25" style="margin: 5px 0;">';
}
$sugar_smarty->assign('LOGIN_IMAGE',$login_image);
$sugar_smarty->assign("MOD", $mod_strings);
if($user_email) {
    $authController->SendEmailLink($user_email);
    $sugar_smarty->assign('EMAIL_ADDRESS',$user_email);
    $sugar_smarty->assign('LOGIN_URL', ($_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://".$sugar_config['site_url'].'/index.php?action=Login&module=Users');
    $sugar_smarty->display('modules/Users/EmailVerification/sendverificationlink.tpl');

} elseif ($verificationCode) {
    $verification_status = $authController->verificationAction($verificationCode);
    $sugar_smarty->assign('VERIFICATION_CODE',$verification_status);
    $sugar_smarty->assign('LOGIN_URL', ($_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://".$sugar_config['site_url'].'/index.php?action=Login&module=Users');
    $sugar_smarty->display('modules/Users/EmailVerification/email-verification.tpl'); 
} else {
    $url = "index.php?module=Users&action=Login";
    $url = 'Location: '.$url;

    if(!empty($GLOBALS['app'])) {
        $GLOBALS['app']->headerDisplayed = false;
    }
    if (!defined('SUGAR_PHPUNIT_RUNNER')) {
        sugar_cleanup();
        header($url);
    }
}