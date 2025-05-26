<?php
if (! defined('sugarEntry') || ! sugarEntry)
    die('Not A Valid Entry Point');
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




require_once ('modules/ModuleBuilder/parsers/parser.modifylistview.php');

class ParserModifySearchView extends ParserModifyListView
{

    var $columns = array('LBL_DEFAULT' => 'getDefaultFields', 'LBL_HIDDEN' => 'getAvailableFields');
    var $searchlayout;

    function init ($module_name, $searchlayout)
    {
		global $app_list_strings;

		$this->searchlayout = $searchlayout;
//		$this->mod_strings = return_module_language($GLOBALS['current_language'], $module_name);
		$class = $GLOBALS['beanList'][$module_name];
		require_once($GLOBALS['beanFiles'][$class]);
		$this->module = new $class();

//		$defsFile = 'modules/' . $module_name . '/metadata/searchdefs.php';
//		include($defsFile);

		$loaded = $this->_loadFromFile('SearchView','modules/' . $module_name . '/metadata/searchdefs.php',$module_name);
		$this->originalListViewDefs = $loaded['viewdefs'][$module_name]['layout'][$this->searchlayout];
		$this->_variables = $loaded['variables'];

		$this->customFile = 'custom/modules/' . $module_name . '/metadata/searchdefs.php';
		if (file_exists($this->customFile))
		{
			$loaded = $this->_loadFromFile('SearchView',$this->customFile,$module_name);
			$this->_variables = $loaded['variables'];
		}

		$this->searchViewDefs = $loaded['viewdefs'][$module_name];
		$this->listViewDefs = $loaded['viewdefs'][$module_name]['layout'][$this->searchlayout];
		$this->fixKeys($this->originalListViewDefs);
		$this->fixKeys($this->listViewDefs);

		$this->language_module = $module_name;
    }

	function getDefaultFields ()
	{
		$this->defaults = array();

		foreach ($this->listViewDefs as $key => $value)
		{
			if (! isset($value['label']))
			{
			    $value['label'] = isset($this->module->field_defs[$key]) ? $this->module->field_defs[$key]['vname'] : $key;
			}
			$this->defaults[$key] = $value;
		}
		return $this->defaults;
	}

	function handleSave ()
	{
//		global $mod_strings;
		$module_name = $this->module->module_dir;
		$fields = array();
			foreach ($_POST ['group_0'] as $field)
			{
				if (isset($this->listViewDefs[$field])) // in the default fields list
				{
					$fields[$field] = $this->listViewDefs[$field];
				}
				else if (isset($this->module->field_defs[$field])) // in the available fields list
				{
					$fields[$field] = array('label' => $this->module->field_defs [$field] ['vname']); // note that this is unsafe if the label might have been edited - here we just get the old label...
				}

				if (isset($_REQUEST [strtolower($field) . 'width']))
				{
					$width = substr($_REQUEST [strtolower($field) . 'width'], 6, 3);
					if (strpos($width, "%") != false)
					{
						$width = substr($width, 0, 2);
					}
					if ($width < 101 && $width > 0)
					{
						$fields [$field] ['width'] = $width;
					}
				} else if (isset($this->listViewDefs [$field] ['width']))
				{
					$fields [$field] ['width'] = $this->listViewDefs [$field] ['width'];
				}
				if(!isset($fields[$field]['name']))$fields[$field]['name'] = $field;
				if(substr($field,-2)=="_c") //nsingh: bug#17828 set default value to none
					$fields[$field]['default_value']="";
			}

		$this->searchViewDefs['layout'][$this->searchlayout] = $fields;

//		if (! write_array_to_file("searchdefs['$module_name']", $this->searchViewDefs, $this->customFile))

		$this->_writeToFile($this->customFile,'SearchView',$module_name,$this->searchViewDefs,$this->_variables);

		$GLOBALS ["searchDefs"] [$module_name] = $fields;
        // now clear the cache so that the results are immediately visible
		include_once('include/TemplateHandler/TemplateHandler.php');
		TemplateHandler::clearCache($module_name,"SearchForm_{$this->searchlayout}.tpl");
	}

}

?>
