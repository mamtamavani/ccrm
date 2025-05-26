<?php
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

require_once ("modules/ModuleBuilder/parsers/parser.modifylistview.php");
require_once ("data/SugarBean.php");
require_once ('modules/ModuleBuilder/MB/ModuleBuilder.php');

class ParserBuildListView extends ParserModifyListView
{
	
	function init ($module_name, $submodule = '')
	{
		$package_name = $_REQUEST ['package'];
		$this->module_name = $module_name;
		
		//get the bean from ModuleBuilder		$mb = new ModuleBuilder();
		$this->module = & $mb->getPackageModule($package_name, $module_name);
		$this->module->mbvardefs->updateVardefs();
		$this->module->module_dir = $module_name;

		$this->customFile = 'custom/modulebuilder/packages/' . $package_name . '/modules/' . $module_name . '/metadata/listviewdefs.php';
		$loaded = $this->_loadFromFile('ListView',$this->customFile,$module_name);
//		_pp($loaded);
		$this->listViewDefs = $loaded['viewdefs'] [$module_name];
		$this->_variables = $loaded['variables'];
		
		$this->fixKeys($this->listViewDefs);
		$this->originalListViewDefs = $this->listViewDefs;		
		$this->module->field_defs = & $this->module->mbvardefs->vardefs ['fields'];
		
		global $mod_strings;
		$mod_strings = array_merge($mod_strings, $this->module->getModStrings());
		$this->language_module = ''; // set this to empty for utils.php->translate to get the mod_strings from $GLOBALS. If it is set to the modulename as usual translate attempts to load a language file	}
}

?>
