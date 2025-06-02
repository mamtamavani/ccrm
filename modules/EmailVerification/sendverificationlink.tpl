<!--
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

 ********************************************************************************/
-->
<script type='text/javascript'>
var LBL_LOGIN_SUBMIT = '{sugar_translate module="Users" label="LBL_LOGIN_SUBMIT"}';
var LBL_REQUEST_SUBMIT = '{sugar_translate module="Users" label="LBL_REQUEST_SUBMIT"}';
var LBL_SHOWOPTIONS = '{sugar_translate module="Users" label="LBL_SHOWOPTIONS"}';
var LBL_HIDEOPTIONS = '{sugar_translate module="Users" label="LBL_HIDEOPTIONS"}';
</script>
<table cellpadding="0" align="center" width="100%" cellspacing="0" border="0" style="margin-top: 100px;">
	<tr>
		<td align="center">
		<div class="loginBoxShadow" style="width: 460px;">
			<div class="loginBox">
			<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
				<tr>
					<td align="left"><b>{sugar_translate module="Users" label="LBL_LOGIN_WELCOME_TO"}</b><br>
					    {$LOGIN_IMAGE}
						 <h2 class="form-title" style="text-align:center;font-size:20px;">
							{$MOD.LBL_EMAILVERIFY}
						</h2>  
					</td>
				</tr>
				<tr>
					<td align="center">
						<div class="login">
							<form action="index.php" method="post" id="form">
								<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
						    	<td scope="row" colspan="2">
						    	    <p class="form-subtitle">{$MOD.LBL_EMAILVERIFY_MESSAGE}</p>
                					<p class="form-countdown"></p>
						    	</td>
						    	
									<tr>
										<td scope="row" colspan="2" width="100%" style="font-size: 12px; font-weight: normal; padding-bottom: 4px;">
										<input type="hidden" name="module" value="Users">
										<input type="hidden" name="action" value="EmailVerificationSend">
										{foreach from=$LOGIN_VARS key=key item=var}
											<input type="hidden" name="{$key}" value="{$var}">
										{/foreach}
										</td>
									</tr>

                                    <tr><td>&nbsp;</td></tr>
									<tr>
										<td>
											<div class="form-code">
												<input type="email" class="email-input" size='35' tabindex="1" id="user_email" name="user_email" required />
											</div>	
										</td>
									</tr>
									<tr>
										<td><button class="back-to-login-btn" type="submit" id="send-verification-link-form"  name="submit">{$MOD.LBL_VERIFICATION_BUTTON}</button><br>&nbsp;</td>
									</tr>
									<tr>
										<td>
											<span class="text-danger error">{$MOD.LBL_EMAILVERIFY_NOTES}</span>  
 										</td>
									</tr>
								</table>
							</form>
							
						</div>


					</td>
				</tr>
			</table>
			</div>
			
		</td>
	</tr>
</table>

<br>
<br>