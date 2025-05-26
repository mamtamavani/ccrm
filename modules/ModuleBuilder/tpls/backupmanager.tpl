{*

/**
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
 */



*}

{literal}
<script>
var populatePreview = function(response){
	var div = document.getElementById('preview'+ response.argument);
	
	if(response.status = 0){
		div.innerHTML = 'Server Connection Failed';
	}else{
		div.innerHTML = response.responseText; 
	}
	
	if(response.argument == 1){
		document.getElementById('preview2').innerHTML = '&nbsp';
		if(document.getElementById('comparespan').style.display='none'){
			document.getElementById('comparespan').style.display='inline';
		}
	}
	
	
};
var previewCallback = {
	success: populatePreview ,
  	failure: populatePreview,
  	argument: 1
};
var COBJ = false;
function previewFile(file, id){
	document.getElementById('preview'+ id).innerHTML = '<h2>Loading...</h2>';
	previewCallback['argument'] = id;
	COBJ = Ext.Ajax.request({
		params: 'module=Studio&action=previewfile&to_pdf=true&preview_file=' + file,
		method: 'GET',
		sucess: previewCallback
	});
}
</script>
{/literal}

<form name='StudioWizard'>
<input type='hidden' name='action' value='wizard'>
<input type='hidden' name='module' value='Studio'>
<input type='hidden' name='wizard' value='{$wizard}'>
<table class='tabform' width='100%'>
<tr><td>{$status}</td></tr>
<tr><td colspan='2'>{$welcome}</td></tr>
<tr><td width='1%'><select name='option' size=10 id='option'>{html_options  options=$options}</select></td>
<td>
<input type='button' class='button' name='preview' value='{$MOD.LBL_MB_PREVIEW}' onclick='previewFile(document.getElementById("option").value, 1)'>
<span id='comparespan' style='display:none'>
<br><br>
<input type='button' class='button' name='compare' value='{$MOD.LBL_MB_COMPARE}' onclick='previewFile(document.getElementById("option").value, 2)'>
</span>
<br><br>
<input type='submit' class='button' name='restore' value='{$MOD.LBL_MB_RESTORE}'>
<br><br>
<input type='submit' class='button' name='delete' value='{$MOD.LBL_MB_DELETE}'>
</td></tr>
</table>
</form>

<table width='100%'><tr><td>
<span id='preview1'>&nbsp;</span>
</td>
<td>
<span id='preview2'>&nbsp;</span>
</td>
</tr></table>
