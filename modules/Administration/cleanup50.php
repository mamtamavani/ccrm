<?php
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2009 SugarCRM Inc.
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
class cleanup50{
	function findAndRemove($file,$path, $contains,$not=array() ){
		$removed = 0;
		$cur = $path . '/' . $file;
		if(file_exists($cur)){
			$del = true;
			$contents = file_get_contents($cur);
			if(!empty($contains)){
				$del = false;
				if(substr_count($contents, $contains) > 0){
					$del = true;
					foreach($not as $str=>$count){
						if(substr_count($contents, $str) >= $count ){
							$del = false;
						}
					}
				}
			}
			if($del){
				unlink($cur);
				$removed++;
			}
		}
		if(!file_exists($path))return $removed;
		$d = dir($path);
		while($e = $d->read()){
			$next = $path . '/'. $e;
			if(substr($e, 0, 1) != '.' && is_dir($next)){
				$removed += cleanup50::findAndRemove($file, $next, $contains, $not);
			}
		}
		return $removed;
	}

	function findAndRename($from, $to, $path){
		$renamed = 0;
		$to_path = $path . '/' . $to;
		foreach($from as $file=>$to_file){
			$cur = $path .'/' . $file;
			if(file_exists($cur) && substr_count($cur, $to) == 0){
				if(!file_exists($to_path))sugar_mkdir($to_path);
				rename($cur, $path . '/' . $to . '/' . $to_file);
				$renamed++;
			}
		}
		if(!file_exists($path))return $renamed;
		$d = dir($path);
		while($e = $d->read()){
			$next = $path . '/'. $e;
			if(substr($e, 0, 1) != '.' && is_dir($next)){
				$renamed += cleanup50::findAndRename($from, $to, $next);
			}
		}
		return $renamed;

	}
	function delete($dir){
		if(is_file($dir)){
			return unlink($dir);
		}
		$d = dir($dir);
		while($e = $d->read()){
			if($e != '.' && $e != '..'){
				$next = $dir . '/' . $e;
				cleanup50::delete($next);
			}
		}
		return rmdir($dir);
	}
	function removeSVN($svn_folder, $path){
		$removed = 0;
		if(!file_exists($path))return $renamed;
		$d = dir($path);
		while($e = $d->read()){
			$next = $path . '/'. $e . '/' . $svn_folder . '/.svn';
			if(substr($e, 0, 1) != '.' && is_dir($next)){
				cleanup50::delete($next);
			}
		}
		return $removed;

	}
}
/*
echo 'Removed ' . cleanup50::findAndRemove('Popup.php', 'modules', ' new Popup_Picker()',array(' new '=>2)) . ' Popup.php files<br>';
echo 'Moved ' . cleanup50::findAndRename(array('layout_defs.php'=>'subpaneldefs.php', 'subpanels'=>'subpanels'), 'metadata', 'modules') . ' layout_defs.php to metadata/subpaneldefs.php AND subpanels to metadata/subpanels <br>';
echo 'Moved  Custom ' . cleanup50::findAndRename(array('layout_defs.php'=>'subpaneldefs.php', 'subpanels'=>'subpanels'), 'metadata', 'custom/modules') . ' layout_defs.php to metadata/subpaneldefs.php AND subpanels to metadata/subpanels<br>';;
*/
//removing echo
cleanup50::findAndRemove('Popup.php', 'modules', ' new Popup_Picker()',array(' new '=>2));
cleanup50::findAndRename(array('layout_defs.php'=>'subpaneldefs.php', 'subpanels'=>'subpanels'), 'metadata', 'modules');
cleanup50::findAndRename(array('layout_defs.php'=>'subpaneldefs.php', 'subpanels'=>'subpanels'), 'metadata', 'custom/modules');
//cleanup50::removeSVN('metadata/subpanels/', 'modules');

?>
