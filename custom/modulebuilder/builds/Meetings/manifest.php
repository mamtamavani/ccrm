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

	$manifest = array (
		 'acceptable_sugar_versions' => 
		  array (
	     	
		  ),
		  'acceptable_sugar_flavors' =>
		  array(
		  	'CE', 'PRO','ENT'
		  ),
		  'readme'=>'',
		  'key'=>'mtngs',
		  'author' => 'Dotan',
		  'description' => 'This module is supposed to contain the company meetings summary, and perhaps even follow ups.',
		  'icon' => '',
		  'is_uninstallable' => true,
		  'name' => 'Meetings',
		  'published_date' => '2009-01-01 11:56:21',
		  'type' => 'module',
		  'version' => '1230810981',
		  'remove_tables' => 'prompt',
		  );
$installdefs = array (
  'id' => 'Meetings',
  'beans' => 
  array (
    0 => 
    array (
      'module' => 'mtngs_Meeting_Summary',
      'class' => 'mtngs_Meeting_Summary',
      'path' => 'modules/mtngs_Meeting_Summary/mtngs_Meeting_Summary.php',
      'tab' => true,
    ),
  ),
  'layoutdefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/Accounts.php',
      'to_module' => 'Accounts',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/mtngs_Meeting_Summary.php',
      'to_module' => 'mtngs_Meeting_Summary',
    ),
  ),
  'relationships' => 
  array (
    0 => 
    array (
      'module' => 'Accounts',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/Accounts.php',
      'meta_data' => '<basepath>/SugarModules/relationships/mtngs_Meeting_Summary_accountsMetaData.php',
    ),
  ),
  'image_dir' => '<basepath>/icons',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/modules/mtngs_Meeting_Summary',
      'to' => 'modules/mtngs_Meeting_Summary',
    ),
  ),
  'vardefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/mtngs_Meeting_Summary.php',
      'to_module' => 'mtngs_Meeting_Summary',
    ),
  ),
  'language' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
  ),
);