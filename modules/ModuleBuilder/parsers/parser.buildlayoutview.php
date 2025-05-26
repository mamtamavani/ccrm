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

require_once ('modules/ModuleBuilder/parsers/parser.modifylayoutview.php');
require_once ('modules/ModuleBuilder/MB/ModuleBuilder.php');

class ParserBuildLayoutView extends ParserModifyLayoutView
{

    /**
     * Constructor
     */
    function init ($module, $view, $submittedLayout = false)
    {

        $this->_package = $_REQUEST ['package'];
        
       
        $this->_view = ucfirst($view);
        
        $mb = new ModuleBuilder();
        $mbmodule = & $mb->getPackageModule($this->_package, $module);
   		$this->_module = $mbmodule->key_name;
        $file = $mbmodule->getModuleDir() . "/metadata/" . strtolower($view) . "defs.php";
        $this->_customFile = $file;
        $this->_originalFile = $file;
        $this->_sourceFile = $file;
        $this->_sourceView = $this->_view; // bug 18062 - sourceView required
        
        //add in the modules strings to the global set
//        $GLOBAL['mod_strings'][$module] = $mbmodule->getModStrings();
		global $mod_strings;
		$mod_strings = array_merge($mod_strings, $mbmodule->getModStrings());
		$this->language_module = ''; // set to empty so that sugar_translate in the smarty template uses the $GLOBAL modstrings and not a non-existent language file for this new package

        //get the fieldDefs from ModuleBuilder
        $fields = $mbmodule->getVardefs();
        $this->_fieldDefs = & $fields ['fields'];

        $this->loadModule($this->_module, $this->_view);
        $this->_viewdefs ['panels'] = $this->_parseData($this->_viewdefs['panels']); // put into a canonical format
		$this->maxColumns = $this->_viewdefs ['templateMeta'] ['maxColumns'];
	
        if ($submittedLayout)
        {
            // replace the definitions with the new submitted layout
            $this->_loadLayoutFromRequest();
        } else
        {
            $this->_padFields(); // destined for a View, so we want to add in (empty) fields
        }
    }
    
    /*
     * Nothing to do for ModuleBuilder created layouts
     */
    function writeWorkingFile ()
    {
    }
    

}

?>
