{*
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
*}

<form name='relform' onsubmit='return false;'>
<input type='hidden' name='to_pdf' value='1'>
<input type='hidden' name='module' value='ModuleBuilder'>
<input type='hidden' name='action' value='SaveRelationship'>
<input type='hidden' name='view_package' value='{$module->package}'>
<input type='hidden' name='view_module' value='{$module->name}'>
<input type='hidden' name='name' value='{$rel.name}'>
<table >
	<tr>
		<td colspan='2'>
			<input type='button' name='saverelbtn' value='{$mod_strings.LBL_BTN_SAVE}' onclick='if(check_form("relform"))ModuleBuilder.submitForm("relform");' class='button'>

			{literal}
			&nbsp;
			<input type='button' name='deleterelbtn' value='{/literal}{$mod_strings.LBL_BTN_DELETE}{literal}' onclick='if(confirm("{/literal}{$mod_strings.LBL_CONFIRM_RELATIONSHIP_DELETE}{literal}")){this.form.action.value="DeleteRelationship";ModuleBuilder.submitForm("relform");}' class='button'>
			{/literal}

		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<hr/>
		</td>
	</tr>

	<tr>
		<td class='mbLBL'>
			{$mod_strings.LBL_RELATE_TO}:
		</td>
		<td>
			{html_options name="relate" id="relate"  output=$relatable values=$relatable selected=$rel.relate onchange='ModuleBuilder.moduleLoadRelationship(document.relform.name.value, this.options[this.selectedIndex].value);'}
		</td>
	</tr>
			<tr>
		<td class='mbLBL'>
			{$mod_strings.LBL_LABEL}
		</td>
		<td>
			<input type='text' name='label' value='{$rel.label}'>
		</td>
	</tr>
	
	{if !empty($rel.relate)}
		<tr>
			<td class='mbLBL'>
				{$module->name} {$mod_strings.LBL_SUBPANEL}:
			</td>
			<td>
				{html_options name="rsub" id="rsub"  output=$relatablePanels values=$relatablePanels selected=$rel.rsub alt=$mod_strings.LBL_RSUB}
			</td>
		</tr>
		<tr>
			<td class='mbLBL'>
				{$rel.relate} {$mod_strings.LBL_SUBPANEL}:
			</td>
			<td>
				{html_options name="msub" id="msub"  output=$availablePanels values=$availablePanels selected=$rel.msub alt=$mod_strings.LBL_MSUB}
			</td>
		</tr>
	{/if}
</table>
<script>
addForm('relform');
addToValidate('relform', 'name', 'DBName', true, '{$mod_strings.LBL_JS_VALIDATE_REL_NAME}');
addToValidate('relform', 'label', 'varchar', true, '{$mod_strings.LBL_JS_VALIDATE_REL_LABEL}');
</script>
