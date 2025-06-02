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

 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
/** @var AuthenticationController $authController */

global $sugar_config;

require_once('modules/Users/language/en_us.lang.php');
$mod_strings=return_module_language('','Users', true);

$sugar_smarty = new Sugar_Smarty();
$moduleTopMenu = array();
$sugar_smarty->assign("moduleTopMenu",[]);
echo '<link rel="stylesheet" type="text/css" media="all" href="'.getJSPath('modules/Users/login.css').'">';
// Get the login page image

if($_REQUEST && isset($_REQUEST['resend'])) {
    $authController->codeSend($_SESSION['login_user_id'], $_SESSION['verification_email']);
} elseif($_REQUEST && isset($_REQUEST['TwoFactorAuthenticationCode'])) {
    $TwoFactorAuthenticationCode = $_REQUEST['TwoFactorAuthenticationCode'];
    if(count($TwoFactorAuthenticationCode) != 6) {
        $sugar_smarty->assign('LOGIN_ERROR', 'Please enter vaild verification code.');
    } else {
        $AuthenticationCode = implode("",$TwoFactorAuthenticationCode);
        $UserID = $_SESSION['login_user_id'];
        $checkVerificationCodeVaildOrNot = $authController->checkVerificationCodeVaildOrNot($UserID, $AuthenticationCode);
        if($checkVerificationCodeVaildOrNot == 'invaildCode'){
            $sugar_smarty->assign('LOGIN_ERROR', 'The verification code entered is invalid. Please reenter it');
        } elseif($checkVerificationCodeVaildOrNot == 'codeExpired'){
            $sugar_smarty->assign('LOGIN_ERROR', 'Your verification code has expired. Please resend it and try again');
        } else {
            $expireTime = time() + 14 * 24 * 60 * 60;
            $rememberMeHash = password_hash(md5($_SESSION['login_user_id'].$_CompanyID), PASSWORD_DEFAULT);
            $userIdHash = password_hash(md5('user_id_'.$_SESSION['login_user_id'].$_CompanyID), PASSWORD_DEFAULT);

            //�In case we want to apply 2FA based on checkbox values, please remove the following two lines and uncomment the code below them
            setcookie(md5('remember_me_'.$_SESSION['login_user_id']), $rememberMeHash, $expireTime, '/', '', true, true); 
            setcookie(md5('user_id_'.$_SESSION['login_user_id']), $userIdHash, $expireTime, '/', '', true, true); 
            require_once('modules/Users/password_utils.php');
                if(hasPasswordExpired($_SESSION['login_user_name'])) {
                    $_SESSION['hasExpiredPassword'] = '1';
                }
                
                // Reset login failed count
                $usr = new User();
                $usr->retrieve($_SESSION['login_user_id']);
                if ($usr->getPreference('loginfailed') != '' && $usr->getPreference('loginfailed') != 0) {
                    $usr->setPreference('loginfailed','0');
                    $usr->savePreferencesToDB();
                }
                
                // Load user session
                $authController->authController->userAuthenticate->loadUserOnSession($_SESSION['login_user_id']);
                
                // Run post login authentication
                $authController->authController->postLoginAuthenticate();
                
                // Redirect to home page
                header("Location: index.php");
                exit();
        }
    }
}

if ( sugar_is_file('custom/include/images/sugar_md.png') ) {
    $login_image = '<IMG src="custom/include/images/sugar_md.png" alt="Sugar" width="340" height="25">';
}
else {
    $login_image = '<IMG src="include/images/sugar_md_open.png" alt="Sugar" width="340" height="25" style="margin: 5px 0;">';
}

$sugar_smarty->assign('LOGIN_IMAGE',$login_image);
$sugar_smarty->assign("MOD", $mod_strings);
$sugar_smarty->assign('VERIFICATION_EMAIL',$authController->emailMasking($_SESSION['verification_email']));
$sugar_smarty->assign('LOGIN_URL', ($_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://".$sugar_config['site_url'].'/index.php?action=Login&module=Users');
$userData = $authController->getAuthenticationCodeDetails($_SESSION['login_user_id']);

$currentTime = new DateTime(strftime('%Y-%m-%d %H:%M:%S', time()));
$expriedCodtime = new DateTime($userData['TwoFactorAuthenticationCodeExpiredAt']);

$sugar_smarty->assign('currentTime', $currentTime->format('Y-m-d H:i:s')); // Use timestamp for JS comparison
$sugar_smarty->assign('expriedCodtime', $expriedCodtime->format('Y-m-d H:i:s'));

$sugar_smarty->display('modules/EmailVerification/verifyauthenticationcode.tpl'); 


?>
