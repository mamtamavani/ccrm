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

<table class='relTable' id='relTable' >
	<tr><td colspan='9'><input type='button' name='addrelbtn' value='{$mod_strings.LBL_BTN_ADD_RELATIONSHIP}' class='button' onclick='ModuleBuilder.moduleLoadRelationship("");'></td></tr>
	<tr><td colspan='9'><hr> <h1>{$mod_strings.LBL_RELATIONSHIPS}</h1></td></tr>
	<tr>
	{if empty($module->mbrelationship->relationships)}
		<td class='mbLBLL'>{$mod_strings.LBL_NONE}</td>
	{/if}
	{foreach from=$module->mbrelationship->relationships item='rel' key='name'}

	{if $counter % 3 == 0 && $counter != 0}
	</tr><tr>
	{/if}
	<td align='center' class='button' onmouseout='ModuleBuilder.buttonOut(this)' onmouseover='ModuleBuilder.buttonOver(this, "{$name}", "rel")'  onclick='ModuleBuilder.buttonDown(this, "{$name}", "rel");ModuleBuilder.moduleLoadRelationship("{$name}");'>{sugar_image name=$rel.relate height=40 width=40}</td><td><table><tr><td class='mbLBLL'>{$mod_strings.LBL_LABEL}</td><td><a href='javascript:void(0)' onclick='ModuleBuilder.moduleLoadRelationship("{$name}");'>{$rel.label}</a></td></tr><tr><td class='mbLBLL'>{$mod_strings.LBL_NAME}:</td><td>{$name}</td></tr><tr><td class='mbLBLL'>{$mod_strings.LBL_SUBPANEL}:</td><td>{$rel.rsub}</td></tr></table></td>
	{counter var='counter' assign='counter'}
	{/foreach}
	<tr>
	
</table>


<script>
ModuleBuilder.module = '{$module->name}';
ModuleBuilder.MBpackage = '{$module->package}';
ModuleBuilder.helpRegisterByID('relTable');
ModuleBuilder.helpSetup('studioWizard','relationshipsHelp');
</script>
{include file='modules/ModuleBuilder/tpls/assistantJavascript.tpl'}
