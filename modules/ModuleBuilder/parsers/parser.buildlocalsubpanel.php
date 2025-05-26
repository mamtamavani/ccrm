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

require_once ('modules/ModuleBuilder/parsers/parser.modifylistview.php');

class ParserBuildLocalSubpanel extends ParserModifyListView
{
    
    var $columns = array ( 'LBL_DEFAULT' => 'getDefaultFields' , 'LBL_AVAILABLE' => 'getAvailableFields' ) ;
	
	function init ($module_name, $subpanelName)
	{
		$this->package = isset($_REQUEST ['package']) ? $_REQUEST ['package'] : '';
		$this->parent_module = $module_name;
		$this->subpanelName = $subpanelName;
		
		//get the bean from ModuleBuilder
		$mb = new ModuleBuilder();
		$this->module = & $mb->getPackageModule($this->package, $module_name);
		$this->module->mbvardefs->updateVardefs();
		$this->module->field_defs = & $this->module->mbvardefs->vardefs ['fields'];
		
		$subpanel_layout = $this->module->getAvailibleSubpanelDef($this->subpanelName);
		$GLOBALS['log']->debug($subpanel_layout);
		$this->listViewDefs = & $subpanel_layout ['list_fields'];
		$this->originalListViewDefs = $this->listViewDefs;
		$this->language_module = '';
		global $mod_strings;
		$mod_strings = array_merge($mod_strings, $this->module->getModStrings());
	}
	
	function getDefaultFields ()
	{
	    return $this->listViewDefs;
	}
	
    function getAvailableFields ()
    {
        $available = array();
        $lowerFieldList = array_change_key_case ( $this->listViewDefs ) ;
        $GLOBALS['log']->debug($lowerFieldList);
        foreach ( $this->module->field_defs as $key => $def )
        {
            $key = strtolower ( $key ) ;
            if (! isset ( $lowerFieldList [ $key ] ))
            {
                $available [ $key ] = $def ;
            }
        }
		return $available ;
    }

	function handleSave ()
	{

        $newFields = array();
        foreach ($this->listViewDefs as $name => $field)
        {
            if (isset($field['usage']) && $field['usage'] == 'query_only')
            {
                $newFields[$name] = $field;
            }
        }
        
        foreach ($_REQUEST['group_0'] as $field)
        {
            if (! empty($this->originalListViewDefs[$field]))
            {
                $newFields[$field] = $this->originalListViewDefs[$field];
            } 
            else
            {
                $newFields[$field] = array('name' => $field, 'vname' => '');
            }
            
            if (isset($_REQUEST[strtolower($field) . 'width']))
            {
                $width = substr($_REQUEST[strtolower($field) . 'width'], 6, 3);
                if (strpos($width, "%") != false)
                {
                    $width = substr($width, 0, 2);
                }
                if ($width < 101 && $width > 0)
                {
                    $newFields[$field]['width'] = $width;
                }
            }
            else if (isset($this->listViewDefs[$field]['width']))
            {
                $newFields[$field]['width'] = $this->listViewDefs[$field]['width'];
            }
        }
	    $layout = $this->module->getAvailibleSubpanelDef($this->subpanelName);
        $layout['list_fields'] = $newFields;
		$GLOBALS['log']->debug("ParserBuildLocalSubpanel: about to save this layout:");
		$GLOBALS['log']->debug($layout);
		$this->module->saveAvailibleSubpanelDef($this->subpanelName,$layout);
	}
}

?>
