
<table cellpadding="0" align="center" width="100%" cellspacing="0" border="0" style="margin-top: 100px;">
	<tr>
        <td align="center">
            <div class="loginBoxShadow" style="width: 460px;">
                <div class="loginBox">
                    {$LOGIN_IMAGE}
                    <div class="container">
                            {if $VERIFICATION_CODE == 'verified'}
                                <h2 class="form-title">
                                    {$MOD.LBL_EMAIL_VERIFIED}
                                </h2><br>
                                <p class="form-subtitle">{$MOD.LBL_EMAIL_VERIFIED_LOGIN}</p>
                                <br>
                                <p class="form-subtitle">
                                    <b>{$MOD.LBL_EMAIL_VERIFIED_THANKYOU}</b>
                                </p>
                                <p class="form-subtitle"><a href="{$LOGIN_URL}" class="back-to-login-btn">{$MOD.LBL_BACK_TO_LOGIN}</a></p>

                            {elseif $VERIFICATION_CODE == 'linkexpried'}
                                <h2 class="form-title">
                                    {$MOD.LBL_EMAIL_EXPIRED}
                                </h2><br>
                                <p class="form-subtitle">
                                    {$MOD.LBL_EMAIL_EXPIRED_APOLOGIZE}
                                </p>
                                <p class="form-subtitle"><a href="{$LOGIN_URL}" class="back-to-login-btn">{$MOD.LBL_BACK_TO_LOGIN}</a></p>
                                <p class="form-subtitle">
                                    {$MOD.LBL_EMAIL_EXPIRED_TROUBLE}
                                </p>
                                
                            {elseif $VERIFICATION_CODE == 'invaildLink'}
                                
                                <h2 class="form-title">
                                    {$MOD.LBL_EMAIL_LINK_INCORRECT}
                                </h2><br>
                                <p class="form-subtitle">
                                    {$MOD.LBL_EMAIL_LINK_INCORRECT_APOLOGIZE}
                                </p>
                                <p class="form-subtitle"><a href="{$LOGIN_URL}" class="back-to-login-btn">{$MOD.LBL_BACK_TO_LOGIN}</a></p>
                                <p class="form-subtitle">
                                    {$MOD.LBL_EMAIL_EXPIRED_TROUBLE}
                                </p>

                            {elseif $VERIFICATION_CODE == 'wrong'}

                                <h2 class="form-title">
                                    {$MOD.LBL_EMAIL_TRY_LATER}
                                </h2>
                                <p class="form-subtitle"><a href="{$LOGIN_URL}" class="back-to-login-btn">{$MOD.LBL_BACK_TO_LOGIN}</a></p>          
                            {/if}       
                    </div>      
                </div>
            </div>
        </td>
    </tr>
</table>