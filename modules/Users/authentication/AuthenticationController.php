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



class AuthenticationController
{
	public $loggedIn = false; //if a user has attempted to login
	public $authenticated = false;
	public $loginSuccess = false;// if a user has successfully logged in

	protected static $authcontrollerinstance = null;

    /**
     * @var SugarAuthenticate
     */
    public $authController;

	/**
	 * Creates an instance of the authentication controller and loads it
	 *
	 * @param STRING $type - the authentication Controller
	 * @return AuthenticationController -
	 */
	public function __construct($type = null)
	{
        $this->authController = $this->getAuthController($type);
	}

    /**
     * Get auth controller object
     * @param string $type 
     * @return SugarAuthenticate
     */
    protected function getAuthController($type)
    {
        if (!$type) {
            $type = !empty($GLOBALS['sugar_config']['authenticationClass'])
                ? $GLOBALS['sugar_config']['authenticationClass'] : 'SugarAuthenticate';
        }

        if ($type == 'SugarAuthenticate' && !empty($GLOBALS['system_config']->settings['system_ldap_enabled']) && empty($_SESSION['sugar_user'])) {
            $type = 'LDAPAuthenticate';
        }

        // check in custom dir first, in case someone want's to override an auth controller
		if (file_exists('custom/modules/Users/authentication/'.$type.'/' . $type . '.php')) {
            require_once('custom/modules/Users/authentication/'.$type.'/' . $type . '.php');
        } elseif (file_exists('modules/Users/authentication/'.$type.'/' . $type . '.php')) {
            require_once('modules/Users/authentication/'.$type.'/' . $type . '.php');
        } else {
            require_once('modules/Users/authentication/SugarAuthenticate/SugarAuthenticate.php');
            $type = 'SugarAuthenticate';
        }

        if (!empty($_REQUEST['no_saml']) 
            && (is_subclass_of($type, 'SAMLAuthenticate') || 'SAMLAuthenticate' == $type)) {
            $type = 'SugarAuthenticate';
        }

        return new $type();
    }

	/**
	 * Returns an instance of the authentication controller
	 *
	 * @param string $type this is the type of authetnication you want to use default is SugarAuthenticate
	 * @return an instance of the authetnciation controller
	 */
	public static function getInstance($type = null)
	{
		if (empty(self::$authcontrollerinstance)) {
			self::$authcontrollerinstance = new AuthenticationController($type);
		}

		return self::$authcontrollerinstance;
	}

	/**
	 * This function is called when a user initially tries to login.
	 *
	 * @param string $username
	 * @param string $password
	 * @param array $PARAMS
	 * @return boolean true if the user successfully logs in or false otherwise.
	 */
	public function login($username, $password, $PARAMS = array())
	{
		//kbrill bug #13225
		$_SESSION['loginAttempts'] = (isset($_SESSION['loginAttempts']))? $_SESSION['loginAttempts'] + 1: 1;
		unset($GLOBALS['login_error']);

		if($this->loggedIn)return $this->loginSuccess;
		LogicHook::initialize()->call_custom_logic('Users', 'before_login');

		$this->loginSuccess = $this->authController->loginAuthenticate($username, $password, false, $PARAMS);
		$this->loggedIn = true;

		if($this->loginSuccess){
			//Ensure the user is authorized
			checkAuthUserStatus();

			loginLicense();
			if(!empty($GLOBALS['login_error'])){
				unset($_SESSION['authenticated_user_id']);
				$GLOBALS['log']->fatal('FAILED LOGIN: potential hack attempt:'.$GLOBALS['login_error']);
				$this->loginSuccess = false;
				return false;
			}

			//call business logic hook
			if(isset($GLOBALS['current_user']))
				$GLOBALS['current_user']->call_custom_logic('after_login');

			// Check for running Admin Wizard
			$config = new Administration();
			$config->retrieveSettings();
		    if ( is_admin($GLOBALS['current_user']) && empty($config->settings['system_adminwizard']) && $_REQUEST['action'] != 'AdminWizard' ) {
				$GLOBALS['module'] = 'Configurator';
				$GLOBALS['action'] = 'AdminWizard';
				ob_clean();
				header("Location: index.php?module=Configurator&action=AdminWizard");
				sugar_cleanup(true);
			}

			$ut = $GLOBALS['current_user']->getPreference('ut');
			$checkTimeZone = true;
			if (is_array($PARAMS) && !empty($PARAMS) && isset($PARAMS['passwordEncrypted'])) {
				$checkTimeZone = false;
			} // if
			if(empty($ut) && $checkTimeZone && $_REQUEST['action'] != 'SetTimezone' && $_REQUEST['action'] != 'SaveTimezone' ) {
				$GLOBALS['module'] = 'Users';
				$GLOBALS['action'] = 'Wizard';
				ob_clean();
				header("Location: index.php?module=Users&action=Wizard");
				sugar_cleanup(true);
			}
		}else{
			//kbrill bug #13225
			LogicHook::initialize();
			$GLOBALS['logic_hook']->call_custom_logic('Users', 'login_failed');
			$GLOBALS['log']->fatal('FAILED LOGIN:attempts[' .$_SESSION['loginAttempts'] .'] - '. $username);
		}
		// if password has expired, set a session variable

		return $this->loginSuccess;
	}

	/**
	 * This is called on every page hit.
	 * It returns true if the current session is authenticated or false otherwise
	 *
	 * @return booelan
	 */
	public function sessionAuthenticate()
	{
		if(!$this->authenticated){
			$this->authenticated = $this->authController->sessionAuthenticate();
		}
		if($this->authenticated){
			if(!isset($_SESSION['userStats']['pages'])){
			    $_SESSION['userStats']['loginTime'] = time();
			    $_SESSION['userStats']['pages'] = 0;
			}
			$_SESSION['userStats']['lastTime'] = time();
			$_SESSION['userStats']['pages']++;

		}
		return $this->authenticated;
	}

	/**
	 * Called when a user requests to logout. Should invalidate the session and redirect
	 * to the login page.
	 */
	public function logout()
	{
		$GLOBALS['current_user']->call_custom_logic('before_logout');
		$this->authController->logout();
		LogicHook::initialize();
		$GLOBALS['logic_hook']->call_custom_logic('Users', 'after_logout');
	}


	public function SendEmailLink($email)
	{
		global $sugar_config,$db;
		require_once('modules/Users/language/en_us.lang.php');
		$mod_strings=return_module_language('','Users', true);
		
		require_once("include/SugarPHPMailer.php");
		global $locale;
		$emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();
		$emailVerifyLinkExpireTime=60;
		$notify_mail = new SugarPHPMailer();
		$notify_mail->CharSet = $sugar_config['default_charset'];
		$notify_mail->AddAddress($email);
        $notify_mail->Subject = 'verify your email address for '. $defaults['name'];

		$data['user-name'] = $_SESSION['login_user_name'] ? $_SESSION['login_user_name'] : '';
		$data['companyName'] = "Sugar CRM";
		$data['mod'] = $mod_strings;
		$data['emailVerifyLinkExpireTime'] = $emailVerifyLinkExpireTime;
		$data['emailverifyCode'] = hash("sha256", rand());
		$data['baseUrl'] = ($_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://".$sugar_config['site_url'];
        $notify_mail->isHTML(true);
        $notify_mail->AddEmbeddedImage('custom/themes/default/images/code_banner.png', 'img1', 'code_banner.png', 'base64', 'image/png');
		$notify_mail->AddEmbeddedImage('custom/themes/default/images/company_logo.png', 'img2','company_logo.png','base64', 'image/png');
		$data['verificationlink'] = $data['baseUrl']."/index.php?action=EmailVerificationSend&module=Users&Verification=".$data['emailverifyCode'];
        $notify_mail->Body = render_email('modules/Users/EmailVerification/emailVerificationLink.phtml', $data);
		$notify_mail->Encoding = 'base64';
        $notify_mail->ContentType = 'text/html; charset=UTF-8';
        $notify_mail->setMailerForSystem();
        $notify_mail->From =  $defaults['email'];
        $notify_mail->FromName = 'Sugar Authentication';

        if($notify_mail->Send()) {
			$query = "UPDATE users set 
				emailVerify='N', 
				emailverifyCode='".$data["emailverifyCode"]."', 
				emailverifyCodeExpiredAt='". date('Y-m-d H:i:s', strtotime("+" . $data['emailVerifyLinkExpireTime'] . " minutes", time())) ."' where id=".$_SESSION['login_user_id']."";
			$db->query($query,true,"Error in update emailverifyCode of users");

			$updateEmail = " UPDATE email_addresses ea
				JOIN email_addr_bean_rel eabl 
				ON ea.id = eabl.email_address_id 
				AND eabl.bean_module = 'Users' 
				AND eabl.primary_address = 1 
				AND eabl.deleted = 0
				JOIN users usr 
				ON eabl.bean_id = usr.id
				SET ea.email_address = '$email', ea.email_address_caps = '".strtoupper($email)."'
				WHERE usr.id = ".$_SESSION['login_user_id']."";
			$db->query($updateEmail,true,"Error in update email of email_addresses");
			return true;
        }
		return false;
	}

	function verificationAction($verificationCode) {
		global $db;
		$query = "SELECT us.id, us.emailverifyCodeExpiredAt FROM users us
			WHERE us.emailverifyCode = '$verificationCode'";
		$result = $db->limitQuery($query,0,1,false);
		if(!empty($result)) {
			$data = $db->fetchByAssoc($result);
			if(count($data) != 0) {
				$currentTime = new DateTime(strftime('%Y-%m-%d %H:%M:%S', time()));
				$expriedLinkTime = new DateTime($data['emailverifyCodeExpiredAt']);
				if($currentTime < $expriedLinkTime){ 
					$query = "UPDATE users set 
						emailVerify='Y'
						where id=".$data['id']."";
					if($db->query($query,true,"Error converting lead: ")){
						return 'verified';
					}
					return 'wrong';
				}
				return 'linkexpried';
			}
		}
	}

	function emailMasking($email){
		list($username, $domain) = explode('@', $email);
		list($domain, $domainEntity) = explode('.', $domain);
		$maskedUsername = substr($username, 0, 2);
		$maskedDomain = substr($domain, 0, 2);
		$maskedUsername .= str_repeat('*', strlen($username) - 2);
		$maskedDomain .= str_repeat('*', strlen($domain) - 2);
		$maskedEmail = $maskedUsername . '@' . $maskedDomain.".". $domainEntity;
		return $maskedEmail;
	}


	function getAuthenticationCodeDetails($user_id) {
		global $db;
		$query = "SELECT usr.* FROM users usr WHERE usr.id = '$user_id'";
		$result = $db->limitQuery($query,0,1,false);
		if(!empty($result)) {
			return $db->fetchByAssoc($result);
		}
	}

	function checkVerificationCodeVaildOrNot($UserID, $verificationCode) {
		global $db;
		$query = "SELECT us.id, us.TwoFactorAuthenticationCodeExpiredAt FROM users us
			WHERE us.TwoFactorAuthenticationCode = '$verificationCode'";
			
		$result = $db->limitQuery($query,0,1,false);
		if(!empty($result)) {
			$data = $db->fetchByAssoc($result);
			
			if($data && count($data) != 0) {
				$currentTime = new DateTime(strftime('%Y-%m-%d %H:%M:%S', time()));
				$expriedLinkTime = new DateTime($data['TwoFactorAuthenticationCodeExpiredAt']);
				if($expriedLinkTime >= $currentTime){ 
					$query = "UPDATE users set 
						TwoFactorAuthenticationCodeExpiredAt= '".strftime('%Y-%m-%d %H:%M:%S', time())."'
						where id=".$data['id']."";
					if($db->query($query,true,"Error converting lead: ")){
						return 'vaildCode';
					}
				}
				return 'codeExpired';
			}
			return 'invaildCode';
		}
	}

	function codeSend($user_id, $email){
		global $db, $sugar_config;
		require_once('modules/Users/language/en_us.lang.php');
		$mod_strings=return_module_language('','Users', true);
		$emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();
		$emailVerifyLinkExpireTime=60;
		$notify_mail = new SugarPHPMailer();
		$notify_mail->CharSet = $sugar_config['default_charset'];
		$notify_mail->AddAddress($email);
        $notify_mail->Subject = 'Sugar CRM protect your account with 2fa';
		$data['user-name'] = $_SESSION['login_user_name'] ? $_SESSION['login_user_name'] : '';
		$data['companyTitle'] = "Sugar CRM";
		$data['mod'] = $mod_strings;
		$data['twoFactorAuthenticationCodeExpireTime'] = 6;
		$data['authentication-code'] = rand(100000, 999999);
		$notify_mail->isHTML(true);
		$data['baseUrl'] = ($_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://".$sugar_config['site_url'];
		$notify_mail->AddEmbeddedImage('custom/themes/default/images/code_banner.png', 'img1','code_banner.png','base64', 'image/png');
		$notify_mail->AddEmbeddedImage('custom/themes/default/images/company_logo.png', 'img2','company_logo.png','base64', 'image/png');
        $notify_mail->Body = render_email('modules/Users/EmailVerification/two-factor-authentication.phtml', $data);
        $notify_mail->Encoding = 'base64';
        $notify_mail->ContentType = 'text/html; charset=UTF-8';
        $notify_mail->setMailerForSystem();
		
        $notify_mail->From =  $defaults['email'];
        $notify_mail->FromName = 'Sugar Authentication';

        if($notify_mail->Send()) {
			$query = "UPDATE users set 
				TwoFactorAuthenticationCode = ".$data["authentication-code"].", 
				TwoFactorAuthenticationCodeExpiredAt = '". date('Y-m-d H:i:s', strtotime("+" . $data['twoFactorAuthenticationCodeExpireTime'] . " minutes", time())) ."' 
				where id=".$_SESSION['login_user_id']."";
			$db->query($query,true,"Error in update emailverifyCode of users");
		}
	}
}

function render_email($template, $data) {
		ob_start();
		include $template;
		$var=ob_get_contents(); 
		ob_end_clean();
		return $var;
	}

