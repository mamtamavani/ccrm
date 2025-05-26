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

require_once('modules/ModuleBuilder/parsers/parser.modifysubpanel.php');

class ParserBuildSubPanel extends ParserModifySubPanel {
    
	var $listViewDefs = false;
	var $defaults = array();
	var $additional = array();
	var $available = array();
	var $columns = array('LBL_DEFAULT'=>'getDefaultFields', 'LBL_AVAILABLE'=>'getAvailableFields');

	function init($module_name, $child_module){
		global $focus;
		$package_name =$_REQUEST['package'];
		$this->package = $package_name;
		$this->parent_module = $module_name;
		$this->child_module = $child_module;
		global $beanList, $beanFiles;

		//get the bean from ModuleBuilder
		$mb = new ModuleBuilder();
		$mod =& $mb->getPackageModule($package_name, $module_name);
		$mod->mbvardefs->updateVardefs();

		$this->focus = $mod;

		//load the relationships
		$relations = $mod->mbrelationship->relationships;

		foreach ($relations as $relName=>$relData) {
			if ($relData['relate'] == $this->child_module && file_exists("modules/{$relData['relate']}/metadata/subpanels/{$relData['msub']}.php")){
				$this->rbsub = $relData['rsub'];
				$customFile = "custom/modules/{$relData['relate']}/metadata/subpanels/{$mod->name}{$relData['rsub']}.php";
				if (file_exists($customFile)) {
					include($customFile);
				} else {
					include("modules/{$relData['relate']}/metadata/subpanels/{$relData['rsub']}.php");
				}
				$this->list_fields = $subpanel_layout['list_fields'];
			}
		}
		$this->original_list_fields = $this->list_fields;

		$class = $beanList[$child_module];
		require_once($beanFiles[$class]);
		$subBean = new $class();
		$this->panelFieldDefs = $subBean->field_name_map;

		$this->language_module = $child_module;
	}

	function getAvailableFields(){
		$this->availableFields = array();
		foreach($this->original_list_fields as $key=>$def){
			if(!isset($this->list_fields[$key])){
				if(!empty($def['vname']))$def['label'] = $def['vname'];
				$this->availableFields[$key] = $def;
			}
		}

		foreach($this->panelFieldDefs as $key=>$def){
			if((empty($def['source']) || $def['source'] == 'db' || !empty($def['custom_type'])) && empty($this->list_fields[$key])){
				$this->availableFields[$key] = array('width' => '10', 'label'=> $def['vname'] );
			}
		}
		return $this->availableFields;
	}


	function handleSave(){
		require_once('include/SubPanel/SubPanel.php');

		//_ppd($this->original_list_fields);
		//_ppd($this->panelFieldDefs);
		$newFields = array();
		$existingFields = array();
		foreach($this->list_fields as $name => $field){
			if(!isset($field['usage'])|| $field['usage'] != 'query_only'){
				$existingFields[$name] = $field;

			}else{
				$newFields[$name] = $field;
			}
		}

		global $beanList;
		$cMod = !preg_match("/^[a-z]/", $this->child_module) ? $this->child_module : strtoupper($this->child_module[0]) . substr($this->child_module, 1);
		$class = $beanList[$cMod];
		$mod = new $class();
			
		foreach($_REQUEST['group_0'] as $field){
			if(!empty($this->original_list_fields[$field])){
				$newFields[$field] = $this->original_list_fields[$field];
			}else{
				$vname = '';
				if(isset($this->panelFieldDefs[$field])){
					$vname = $this->panelFieldDefs[$field]['vname'];
				}

				if(isset($mod->field_name_map[$field]) &&
				($mod->field_name_map[$field]['type'] == 'bool' || (isset($mod->field_name_map[$field]['custom_type']) && $mod->field_name_map[$field]['custom_type'] == 'bool'))) {
					$newFields[$field] = array('name'=>$field, 'vname'=>$vname, 'widget_type'=>'checkbox');
				} else {
					$newFields[$field] = array('name'=>$field, 'vname'=>$vname);
				}
			}

			if (isset($_REQUEST[strtolower($field).'width'])) {
				$width = substr($_REQUEST[strtolower($field).'width'], 6, 3);
				if (strpos($width, "%") != false) {
					$width = substr($width, 0, 2);
				}
				if ($width < 101 && $width > 0) {
					$newFields[$field]['width'] = $width;
				}
			} else if (isset($this->panelFieldDefs[$field]['width'])) {
				$newFields[$field]['width'] = $this->panelFieldDefs[$field]['width'];
			} else if (!isset($newFields[$field]['width'])){
				$newFields[$field]['width'] = '10';
			}
		}
		$dirname = "custom/modules/{$this->child_module}/metadata/subpanels/";
		if (!is_dir($dirname)) {
			mkdir_recursive($dirname, true);
		}
		$filename = $dirname.$this->focus->name.$this->rbsub.".php";
		if(!write_array_to_file("subpanel_layout['list_fields']", $newFields, $filename)) {
			$GLOBALS['log']->fatal("Could not write $filename");
		}
	}
}

?>
