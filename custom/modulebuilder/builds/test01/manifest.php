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
		  'key'=>'tst01',
		  'author' => 'Dotan',
		  'description' => '',
		  'icon' => '',
		  'is_uninstallable' => true,
		  'name' => 'test01',
		  'published_date' => '2009-01-01 13:08:41',
		  'type' => 'module',
		  'version' => '1230815321',
		  'remove_tables' => 'prompt',
		  );
$installdefs = array (
  'id' => 'test01',
  'beans' => 
  array (
    0 => 
    array (
      'module' => 'tst01_testmodule001',
      'class' => 'tst01_testmodule001',
      'path' => 'modules/tst01_testmodule001/tst01_testmodule001.php',
      'tab' => true,
    ),
  ),
  'layoutdefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/Calls.php',
      'to_module' => 'Calls',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/Meetings.php',
      'to_module' => 'Meetings',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/Notes.php',
      'to_module' => 'Notes',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/Tasks.php',
      'to_module' => 'Tasks',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/Emails.php',
      'to_module' => 'Emails',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/tst01_testmodule001.php',
      'to_module' => 'tst01_testmodule001',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/Accounts.php',
      'to_module' => 'Accounts',
    ),
  ),
  'relationships' => 
  array (
    0 => 
    array (
      'module' => 'Calls',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/Calls.php',
      'meta_data' => '<basepath>/SugarModules/relationships/tst01_testmodule001_callsMetaData.php',
    ),
    1 => 
    array (
      'module' => 'Meetings',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/Meetings.php',
      'meta_data' => '<basepath>/SugarModules/relationships/tst01_testmodule001_meetingsMetaData.php',
    ),
    2 => 
    array (
      'module' => 'Notes',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/Notes.php',
      'meta_data' => '<basepath>/SugarModules/relationships/tst01_testmodule001_notesMetaData.php',
    ),
    3 => 
    array (
      'module' => 'Tasks',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/Tasks.php',
      'meta_data' => '<basepath>/SugarModules/relationships/tst01_testmodule001_tasksMetaData.php',
    ),
    4 => 
    array (
      'module' => 'Emails',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/Emails.php',
      'meta_data' => '<basepath>/SugarModules/relationships/tst01_testmodule001_emailsMetaData.php',
    ),
    5 => 
    array (
      'module' => 'Accounts',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/Accounts.php',
      'meta_data' => '<basepath>/SugarModules/relationships/tst01_testmodule001_accountsMetaData.php',
    ),
  ),
  'image_dir' => '<basepath>/icons',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/modules/tst01_testmodule001',
      'to' => 'modules/tst01_testmodule001',
    ),
  ),
  'vardefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/tst01_testmodule001.php',
      'to_module' => 'tst01_testmodule001',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/tst01_testmodule001.php',
      'to_module' => 'tst01_testmodule001',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/tst01_testmodule001.php',
      'to_module' => 'tst01_testmodule001',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/tst01_testmodule001.php',
      'to_module' => 'tst01_testmodule001',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/tst01_testmodule001.php',
      'to_module' => 'tst01_testmodule001',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/tst01_testmodule001.php',
      'to_module' => 'tst01_testmodule001',
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