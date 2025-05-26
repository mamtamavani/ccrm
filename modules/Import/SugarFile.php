<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
/*********************************************************************************
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/



require_once('data/SugarBean.php');

// Contact is used to store customer information.
class SugarFile extends SugarBean 
{
	// Stored fields
	var $id;
	var $name;
	var $content;
	var $deleted;
	var $date_entered;
	var $assigned_user_id;

	var $table_name = "files";
	var $object_name = "SugarFile";
	var $module_dir = 'Import';
	var $new_schema = true;

	var $column_fields = Array("id"
		,"name"
		,"content"
                ,"deleted"
                ,"date_entered"
                ,"assigned_user_id"
		);


	function SugarFile() 
	{
		parent::SugarBean();



	}
	
	function delete_file ($owner_id,$name) 
	{
		$fields_arr = array(
				'assigned_user_id'=>$owner_id,
				'name'=>$name
				);

		$where_clause = $this->get_where($fields_arr);

		$query = "delete from ".$this->table_name." $where_clause";

		
			
		$this->db->query($query);

	}

	
	function save_file( $owner_id, $name, $content )
	{
		$this->delete_file( $owner_id, $name);
		$result = 1;
		$this->assigned_user_id = $owner_id;
		$this->name = $name;
		$this->content = $content;
		$this->save();
		return $result;
	}

	function get_file( $owner_id ,$name)
	{
		$fields_array = array(
				'assigned_user_id' => $owner_id
				,'name' => $name
				);
		$this->retrieve_by_string_fields($fields_array, false);
		return $this->content;
	}

        
	
	/**
	* This function retrieves a record of the appropriate type from the DB based on 
	* search criteria 
	* It fills in all of the fields from the DB into the object it was called on.
	* param $fields_array -  associative array:  array( field_name=>"field_value",..);
	*   the field_name is one of the columns in the database you want to match
	*   the field_value is the string you want to match (MUST BE STRING COLUMNS)
	* returns this - The object that it was called apon or null if record was not found.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	*/


	function retrieve_by_string_fields($fields_array, $encode=true) 
	{ 
		$where_clause = $this->get_where($fields_array); 

		$query = "SELECT * FROM $this->table_name $where_clause"; 

		$GLOBALS['log']->debug("Retrieve $this->object_name: ".$query); 

        //requireSingleResult has beeen deprecated.
		//$result =$this->db->requireSingleResult($query,true,"Want only a single row"); 
		$result = $this->db->limitQuery($query,0,1,true, "Want only a single row");

		if(empty($result)) 
		{ 
			
			return null; 
		} 
		$row = $this->db->fetchByAssoc($result,-1, $encode); 
		foreach($this->column_fields as $field) 
		{ 
			if(isset($row[$field])) 
			{ 
				$this->$field = $row[$field]; 
			} 
		} 

		$this->fill_in_additional_detail_fields(); 
		return $this; 
	}
		
}


?>
