
<table cellpadding="0" align="center" width="100%" cellspacing="0" border="0" style="margin-top: 100px;">
	<tr>
        <td align="center">
            <div class="loginBoxShadow" style="width: 460px;">
                <div class="loginBox">
                    {$LOGIN_IMAGE}
                    <h1 class="form-title" style="font-size:21px;padding: 15px">
                        {$MOD.LBL_EMAILVERIFY_THANKYOU}
                    </h1><br>
                    <p class="form-subtitle" >{$MOD.LBL_EMAILVERIFY_MESSAGE1} <b>{$EMAIL_ADDRESS}</b>. {$MOD.LBL_EMAILVERIFY_MESSAGE2}</p><br>
                    <p class="form-subtitle" >{$MOD.LBL_EMAILVERIFY_MESSAGE3}</p><br>
                    <p class="form-subtitle" >{$MOD.LBL_EMAILVERIFY_MESSAGE4}</p><br>
                    <p class="form-subtitle" >{$MOD.LBL_EMAILVERIFY_MESSAGE5}</p>
                    <p class="form-subtitle" >{$MOD.LBL_EMAILVERIFY_MESSAGE6}</p>
                    <p class="form-subtitle" ><a href="{$LOGIN_URL}" >{$MOD.LBL_BACK_TO_LOGIN}</a></p>
                    <p class="form-small"><b>{$MOD.LBL_NOT_FIND_CODE}</b> {$MOD.LBL_CHECK_SPAM_FOLDER}</p> 
                </div>
            </div>
        </td>
    </tr>
</table>