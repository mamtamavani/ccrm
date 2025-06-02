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
							{$MOD.LBL_TWO_FACTOR_AUTHENATICATION}
						</h2>  
					</td>
				</tr>
				<tr>
					<td align="center">
						<div class="login">
							<form action="index.php" method="post" id="form">
								<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
						    	<td scope="row" colspan="2">
						    	    <p class="form-subtitle">{$MOD.LBL_TWO_FACTOR_AUTHENATICATION_MAIL} {$VERIFICATION_EMAIL} .{$MOD.LBL_TWO_FACTOR_AUTHENATICATION_CODE_EXPIRES}</p>
                					<p class="form-countdown" id="time"></p>
						    	</td>
						    		{if $LOGIN_ERROR !=''}
									<tr>
										<td scope="row" colspan="2">
											<p class="form-subtitle"><span class="error">{$LOGIN_ERROR}</span></p></td>
 									</tr>
									{/if}
									<tr>
										<td scope="row" colspan="2" width="100%" style="font-size: 12px; font-weight: normal; padding-bottom: 4px;">
										<input type="hidden" name="module" value="Users">
										<input type="hidden" name="action" value="verifyauthenticationcode">
										{foreach from=$LOGIN_VARS key=key item=var}
											<input type="hidden" name="{$key}" value="{$var}">
										{/foreach}
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-code">
												<input type="text" class="digit-input" maxlength="1" name="TwoFactorAuthenticationCode[]">
												<input type="text" class="digit-input" maxlength="1" name="TwoFactorAuthenticationCode[]">
												<input type="text" class="digit-input" maxlength="1" name="TwoFactorAuthenticationCode[]">
												<input type="text" class="digit-input" maxlength="1" name="TwoFactorAuthenticationCode[]">
												<input type="text" class="digit-input" maxlength="1" name="TwoFactorAuthenticationCode[]">
												<input type="text" class="digit-input" maxlength="1" name="TwoFactorAuthenticationCode[]">
											</div>	
											<span class="text-danger error" id="two-factor-authentication-code-error"></span><br>
										</td>
									</tr>
									<tr>
										<td><button class="back-to-login-btn" type="submit" id="two-factor-authentication-form"  name="submit">{$MOD.LBL_TWO_FACTOR_CONFIRM_CODE}</button><br>&nbsp;</td>
									</tr>
									<tr>
										<td>
											<a href="javascript:;" class="form-resend {if ($currentTime < $expriedCodtime)}resend-btn-disabled{/if}" id="resend-btn">{$MOD.LBL_TWO_FACTOR_RESEND_CODE}</a><br>
											<a href="{$LOGIN_URL}">{$MOD.LBL_BACK_TO_LOGIN}</a>
											<p class="form-small"><b>{$MOD.LBL_NOT_FIND_CODE}</b> {$MOD.LBL_CHECK_SPAM_FOLDER}</p>
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
{literal}
<script>
jQuery(document).ready(function () {
    var TwoFactorModule = (function () {
        var Twofactor = function(remainingTime){
            // Resend click handler
            $('body').on('click', '.form-resend', function(){
                $(this).addClass('resend-btn-disabled');
                var url = 'index.php?module=Users&action=verifyauthenticationcode&resend=1';
                window.location = url;
            });

            // Form submit validation
            $('body').on('click', '#two-factor-authentication-form', function(event){
                var customValid = true;
                $('.digit-input').each(function(){
                    if ($(this).is(':visible') && $(this).val() == '') {
                        customValid = false;
                    }
                });

                if(!customValid){
                    event.preventDefault();
                    $("#two-factor-authentication-code-error").text(validCode); // make sure validCode is defined
                } else {
                    $("#two-factor-authentication-code-error").text('');
                }
            });

            // Countdown timer
            function startTimer(duration) {
                var display = document.querySelector('#time');
                var timer = duration, minutes, seconds;
                var timInt = setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display.textContent = minutes + ":" + seconds;

                    if (--timer < 0) {
                        clearInterval(timInt);
                        display.textContent = "00:00";
                        $('#resend-btn').removeClass('resend-btn-disabled');
                    }
                }, 1000);
            }

            // Start timer with passed remaining time
            startTimer(remainingTime);
        }

        return {
            init: function(remainingTime){
                Twofactor(remainingTime);
            }
        }
    })();

    // Call it here with your desired remaining time (e.g., 60 seconds)
    TwoFactorModule.init(60);

	const digitInputs = document.querySelectorAll(".digit-input");
	digitInputs.forEach(function (input, index) {
		input.addEventListener("input", function (e) {
			const currentValue = e.target.value;

			if (currentValue.match(/\d/)) {
				// If a digit is entered, move focus to the next input
				if (index < digitInputs.length - 1) {
					digitInputs[index + 1].focus();
				}
			}

			// Clear the input if it's not a digit
			e.target.value = currentValue.replace(/\D/g, "");
		});

		input.addEventListener("paste", function (e) {
			e.preventDefault();
			const pasteData = (e.clipboardData || window.clipboardData).getData("text");

			// Split the pasted content into individual digits
			const digits = pasteData.split("").filter(char => /\d/.test(char));

			// Distribute the digits into input fields
			for (let i = 0; i < digitInputs.length; i++) {
				if (digits.length > 0) {
					digitInputs[i].value = digits.shift();
				} else {
					digitInputs[i].value = "";
				}
			}
		});
	});

	function startTimer(duration) {
		var display = document.querySelector('#time')
		var timer = duration, minutes, seconds;
		setInterval(function () {
			minutes = parseInt(timer / 60, 10)
			seconds = parseInt(timer % 60, 10);

			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			display.textContent = minutes + ":" + seconds;

			if (--timer < 0) {
				timer = duration;
			}
		}, 1000);
	}

	startTimer(60 * 5);
});
</script>
{/literal}