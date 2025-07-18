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
global $sugar_config;
if (isset($sugar_config['import_max_execution_time']))
{
    ini_set("max_execution_time", $sugar_config['import_max_execution_time']);
}
else
{
    ini_set("max_execution_time", 3600);
}
require_once ('modules/Import/ImportMap.php');
require_once ('modules/Import/UsersLastImport.php');
require_once ('modules/Import/parse_utils.php');
require_once ('include/ListView/ListView.php');
require_once ('modules/Import/config.php');
require_once ('include/utils.php');



require_once ('modules/Users/User.php');

global $mod_strings, $app_list_strings, $app_strings, $current_user, $import_bean_map;
global $import_file_name;
global $theme;
$theme_path = "themes/".$theme."/";
$image_path = $theme_path."images/";
require_once ($theme_path.'layout_utils.php');

function implode_assoc($inner_delim, $outer_delim, $array) {
	$output = array ();
	foreach ($array as $key => $item) {
		$output[] = $key.$inner_delim.$item;
	}
	return implode($outer_delim, $output);
}

//Begin logging.
$GLOBALS['log']->info("Upload Step 4");
//Initialize
if (isset($_REQUEST['custom_delimiter']) && $_REQUEST['custom_delimiter'] != "")
{
    $delimiter = $_REQUEST['custom_delimiter'];
}
//set the default delimiter. //<-- delimeter
else
{
    $delimiter = ',';
}
$count = 0;
$error = "";
$col_pos_to_field = array ();
$header_to_field = array ();
$field_to_pos = array ();
$focus = 0;
$id_exists_count = 0;
$broken_ids = 0;
$has_header = 0;

if (isset ($_REQUEST['has_header']) && $_REQUEST['has_header'] == 'on') {
	$has_header = 1;
}

if (isset ($import_bean_map[$_REQUEST['module']])) {
	$currentModule = $_REQUEST['module'];
	$bean = $import_bean_map[$_REQUEST['module']];
	require_once ("modules/Import/$bean.php");
	$focus = new $bean ();
} else {
	echo "Imports aren't set up for this module type\n";
	exit;
}

//name of duplicate import log file, append it with module and date stamp to insure unique name
$today = getdate();
$timeOfDay = $today['mon'] . $today['mday'] .$today['hours'] . $today['seconds'];
$myFile = "cache/import/ImportErrorFile_" . $focus->module_dir ."_". $timeOfDay . ".csv";


//setup the importable fields array.
$importable_fields = array ();
$translated_column_fields = array ();
get_importable_fields($focus, $importable_fields, $translated_column_fields);

global $current_language;
$mod_strings = return_module_language($current_language, $currentModule);
// loop through all request variables
foreach ($_REQUEST as $name => $value) {
	// only look for var names that start with "colnum"
	if (strncasecmp($name, "colnum", 6) != 0) {
		continue;
	}
	if ($value == "-1") {
		continue;
	}

	// this value is a user defined field name
	$user_field = $value;

	// pull out the column position for this field name
	$pos = substr($name, 6);

	// make sure we haven't seen this field defined yet
	if (isset ($field_to_pos[$user_field])) {
		show_error_import($mod_strings['LBL_ERROR_MULTIPLE']);
		exit;
	}
	// match up the "official" field to the user 
	// defined one, and map to columm position: 
	//$translated_column_fields = $mod_list_strings[$list_string_key];

	$module_custom_fields_def = $focus->custom_fields->avail_fields;
	foreach ($module_custom_fields_def as $name => $field_def) {
		if ($name != 'id_c')
			$importable_fields[$field_def['name']] = 1;
	}

	if (isset ($importable_fields[$user_field])) {
		// now mark that we've seen this field
		$field_to_pos[$user_field] = $pos;
		$col_pos_to_field[$pos] = $user_field;
	}
}

$max_lines = -1;
$ret_value = 0;

if ($_REQUEST['source'] == 'act') {
	$ret_value = parse_import_act($_REQUEST['tmp_file'], $delimiter, $max_lines, $has_header);
} else
	if ($_REQUEST['source'] == 'other_tab') {
		$ret_value = parse_import_split($_REQUEST['tmp_file'], "\t", $max_lines, $has_header);
	}
    else if ($_REQUEST['source'] == 'custom_delimited')
    {
        $ret_value = parse_import_split($_REQUEST['tmp_file'],$delimiter,$max_lines,$has_header);
    }  
    else {
		$ret_value = parse_import($_REQUEST['tmp_file'], $delimiter, $max_lines, $has_header);
	}

if (file_exists($_REQUEST['tmp_file'])) {
	unlink($_REQUEST['tmp_file']);
}

$rows = $ret_value['rows'];
$ret_field_count = $ret_value['field_count'];
$saved_ids = array ();
$firstrow = array();

if (!isset ($rows)) {
	$error = $mod_strings['LBL_FILE_ALREADY_BEEN_OR'];
	$rows = array ();
}

if ($has_header == 1) {
	$firstrow = array_shift($rows);   
}

$seedUsersLastImport = & new UsersLastImport();
$seedUsersLastImport->mark_deleted_by_user_id($current_user->id);

$skip_required_count = 0;

$not_imported_str = '';

$firstline = implode("\t", $firstrow);
$first_line_str = "$firstline\n";
$GLOBALS['log']->info("[IMPORT]".$first_line_str);



$fieldDefs = $focus->getFieldDefinitions();

// go thru each row, process and save()
$dupe_rows = array();
foreach ($rows as $row) {
	//$count = count($row);
	//$not_imported_str = 'id_exists,'.implode(",",$row)."\n";
	$focus = & new $bean ();
	$focus->save_from_post = false;

	$do_save = 1;
	
	for ($field_count = 0; $field_count < $ret_field_count; $field_count ++) {
		if (isset ($col_pos_to_field[$field_count])) {
			if (!isset ($row[$field_count])) {
				continue;
			}

			// TODO: add check for user input
			// addslashes, striptags, etc..
			$field = $col_pos_to_field[$field_count];
			
			// handle _dom based values
			if($fieldDefs[$field]['type'] == 'enum') {
				// we found a _dom type value - compare and assign, or drop if not found
				foreach($app_list_strings[ $fieldDefs[$field]['options'] ] as $key => $value) {
					if( (strtolower($row[$field_count]) == strtolower($value)) && ($value != "") ) {
						$row[$field_count] = $value;
					}
				}
			}
			
			$focus-> $field = str_replace('"', "", $row[$field_count]);
		}
	}


	
	$var_def_indexes = $dictionary[$focus->object_name]['indices'];

    // check to see that the indexes being entered are unique.
	$isUnique = checkForDupes($focus, $var_def_indexes, $row);
	if(!$isUnique){
		//if row is not unique (searched on by index), then push onto array, break out and continue with original loop
		array_push($dupe_rows, $row);
		continue;
	}
	
	// if the id was specified	
	if (isset ($focus->id)) {
		$focus->id = convert_id($focus->id);

		// check if it already exists
		$check_bean = & new $bean ();

		$query = "select * from {$check_bean->table_name} WHERE id='{$focus->id}'";

		$GLOBALS['log']->info($query);

		$result = $check_bean->db->query($query) or sugar_die("Error selecting sugarbean: ");

		$dbrow = $check_bean->db->fetchByAssoc($result);

		if (isset ($dbrow['id']) && $dbrow['id'] != -1) {
			// if it exists but was deleted, just remove it
			if (isset ($dbrow['deleted']) && $dbrow['deleted'] == 1) {
				$query2 = "delete from {$check_bean->table_name} WHERE id='{$focus->id}'";
				$GLOBALS['log']->info($query2);
				$result2 = $check_bean->db->query($query2) or sugar_die("Error deleting existing sugarbean: ");
			} else {
				$id_exists_count ++;
				$do_save = 0;
				$badline = implode("\t", $row);
				$not_imported_str = "$badline\n";
				$GLOBALS['log']->info("[IMPORT][ID EXISTS ALREADY]:[".$not_imported_str."]");
				continue;
			}
		}
		// check if the id is too long
		else
			if (strlen($focus->id) > 36) {
				$broken_ids ++;
				$do_save = 0;
				$badline = implode("\t", $row);
				$not_imported_str = "$badline\n";
				$GLOBALS['log']->info("[IMPORT][ID TOO LONG]:[".$not_imported_str."]");
				continue;
			}

		if ($do_save != 0) {
			// set the flag to force an insert
			$focus->new_with_id = true;
		}
	}
    
    // handle filling in IDs in any linked fields
    $relatedFields = $focus->get_related_fields();
    if ( count($relatedFields) > 0 ) {
        foreach ($relatedFields as $field => $defintion ) {
            if ( isset($defintion['id_name']) && in_array($field,$col_pos_to_field) ) {
                $idField = $defintion['id_name'];
                // be sure that the id isn't already set for this row
                if ( isset($focus->$field) && !isset($this->$idField) ) {
                    // and be sure that a rname is defined
                    if (isset($defintion['rname']) && !empty($defintion['rname'])){
                        // lookup first record that matches in linked table
                        $query = "SELECT id FROM {$defintion['table']} WHERE {$defintion['rname']} = '{$focus->$field}'";
                        
                        $result = $focus->db->limitQuery($query,0,1,true, "Want only a single row");
                        if(!empty($result)){
                            $row = $focus->db->fetchByAssoc($result);
                            $focus->$idField = $row['id'];
                        }
                    }
                }
            }
        }
    }

	// now do any special processing
	$focus->process_special_fields();
	$no_required = 0;
	if(isset($focus->required_fields)){
		foreach ($focus->required_fields as $field => $notused) {
			if (!isset ($focus-> $field) || $focus-> $field == '') {
				$do_save = 0;
				$skip_required_count ++;
				$badline = implode("\t", $row);
				$not_imported_str = "$badline\n";
				$GLOBALS['log']->info("[IMPORT][NOT IMPORTED]:[".$not_imported_str."]");
				$no_required = 1;
				break;
			}
		}
	}
	if ($no_required == 1) {
		continue;
	}

	if ($do_save) {
		if (!isset ($focus->assigned_user_id) || $focus->assigned_user_id == '') {
			$focus->assigned_user_id = $current_user->id;
		}
		if (!isset ($focus->modified_user_id) || $focus->modified_user_id == '') {
			$focus->modified_user_id = $current_user->id;
		}
		$focus->assigned_user_id = add_assigned_user_name($focus);





		// turn off this flag, because our dates and times are already in the db format
		$focus->process_save_dates = false;
		
		$focus->save();
		$last_import = & new UsersLastImport();
		$last_import->assigned_user_id = $current_user->id;
		$last_import->bean_type = $_REQUEST['module'];
		$last_import->bean_id = $focus->id;
		$last_import->save();
		array_push($saved_ids, $focus->id);
		$count ++;
	}

}
//write out duplicate entries to file system.  Function will return number of duplicates
$dup_count = write_out_dupes($dupe_rows, $myFile, $firstrow);
$dup_link = '';
//if duplicates exist, then set dup_link parameter to file path and name
if($dup_count > 0){
	$dup_link = $myFile;
}

// SAVE MAPPING IF REQUESTED
if (isset ($_REQUEST['save_map']) && $_REQUEST['save_map'] == 'on' && isset ($_REQUEST['save_map_as']) && $_REQUEST['save_map_as'] != '') {
	$serialized_mapping = '';

	if ($has_header) {
		foreach ($col_pos_to_field as $pos => $field_name) {

			if (isset ($firstrow[$pos]) && isset ($field_name)) {
				$header_to_field[$firstrow[$pos]] = $field_name;
			}
		}
        if (isset($_REQUEST['custom_delimiter']) && $_REQUEST['custom_delimiter'] != "")
            $header_to_field['delimiter'] = $delimiter;
		$serialized_mapping = implode_assoc("=", "&", $header_to_field);
	} else {
	    if (isset($_REQUEST['custom_delimiter']) && $_REQUEST['custom_delimiter'] != "")
            $header_to_field['delimiter'] = $delimiter;
		$serialized_mapping = implode_assoc("=", "&", $col_pos_to_field);
	}
	$mapping_file_name = $_REQUEST['save_map_as'];

	$mapping_file = & new ImportMap();

	$query_arr = array ('assigned_user_id' => $current_user->id, 'name' => $mapping_file_name);

	$mapping_file->retrieve_by_string_fields($query_arr, false);

	$result = $mapping_file->save_map($current_user->id, $mapping_file_name, $_REQUEST['module'], $_REQUEST['source'], $has_header, $serialized_mapping);
}

$mod_strings = return_module_language($current_language, "Import");
$currentModule = "Import";

if ($error != "") {
	show_error_import($mod_strings['LBL_ERROR']." ".$error);
	exit;
} else {
	$message = urlencode($mod_strings['LBL_SUCCESS']."<BR><b>$count</b>  ".$mod_strings['LBL_SUCCESSFULLY']."<br><b>". ($broken_ids + $id_exists_count)."</b> ".$mod_strings['LBL_IDS_EXISTED_OR_LONGER']."<br><b>$skip_required_count</b> ".$mod_strings['LBL_RECORDS_SKIPPED']);
	//_if duplicates exist, then add informational string to message 
	if($dup_count>0){
		$message .=urlencode("<BR><b>$dup_count</b>  ".$mod_strings['LBL_DUPLICATES']);
	}

	if (empty ($_REQUEST['return_action'])) {
		$_REQUEST['return_action'] = 'index';
	}
    
    $json = getJSONobj();
    echo 'result = ' . $json->encode(array('module' => $_REQUEST['module'], 
                                    'return_action' => $_REQUEST['return_action'],
                                    'message' => $message,
                                    'dup_link' => $dup_link,
                                    'return_module' => $_REQUEST['return_module']));           
    
    //header("Location: index.php?module={$_REQUEST['module']}&action=Import&step=last&return_module={$_REQUEST['return_module']}&return_action={$_REQUEST['return_action']}&message=$message&duplink=$dup_link");
	exit;
}

/*
 * This function will take list of duplicates and write them out to a file.  It will also return the count of duplicate entries
 * */
function write_out_dupes($dupe_rows, $myFile, $firstrow){
    $dup_count = count($dupe_rows);
	//proceed only if count of duplicates is more than 0
	if($dup_count>0){
	    $row_array = array();

	    //create string to write file to.  Loop through each duplicate row and process
	    foreach ($dupe_rows as $dup){
	    	//for each duplicate row, get string representation of array and add carriage return
    		$rows_str = implode(",",$dup);
		    $rows_str .= "\n";
		    //push string to an array for further processing 
		    array_push($row_array, $rows_str);
	    }
    	//create string of array that holds all the duplicate row entries
    	//$rows_str = implode(",",$row_array);
    	$processed_rows_str = "";
    	foreach($row_array as $string_row){
    		$processed_rows_str .= $string_row;
    		
    	}
    	//add header row if it exists
    	if(is_array($firstrow)&& !empty($firstrow)){
    		$first_row_string = implode(",",$firstrow);
    	    $processed_rows_str = $first_row_string . "\n" . $processed_rows_str; 
    	} 
    	//Open file, write out string to it, and close it
    	$fh = fopen($myFile, 'w');
    	fwrite($fh, $processed_rows_str);
    	fclose($fh);
    }
    //return the duplicate entry count
	return $dup_count;
	
}

/*
 * This function will search import file for duplicate rows.  It will search the database based on the 
 * indexes selected by the user.  If no entries are selected, then no search is made and all
 * rows are created.
 * */
function checkForDupes(&$focus, $indexes){
	$dupe_found = false;
    if (!isset($_REQUEST['display_tabs_def']) || $_REQUEST['display_tabs_def'] == ""){
        //since no indexes were selected, return true.  This will treat all rows as unique entries
        return true;
    }
    else // Construct the index array
    {
        $selected_indexes = explode('&', $_REQUEST['display_tabs_def']);
    }
/*    
	//check to see if indexes were selected
	if (!isset($_REQUEST['choose_index'])){
		//since no indexes were higlighted, return true.  This will treat all rows as unique entries
		return true;
	}
*/	
	//loop through var def indexes and compare with selected indexes 
	foreach($indexes as $index){
		if (!$dupe_found){
    		//if vardef index is in selected index array, then assign ithe match to temp array
		    if (in_array($index['name'],$selected_indexes)){
		        $temp_index_array = array();
		        $temp_index_array = $index['fields'];
		    
	    	    //call new function to return sql
    	        $dupe_sql = create_dupe_check_SQL($temp_index_array, $focus);
            	
				$res_count = 0;
		        //now that the sql has been created, let's run the query
	            if ($dupe_sql != '') {
					$result_count = $focus->db->query($dupe_sql); 
	
					//While there are entries in the resultset, and while the count is less than 3 (max of 2), then grab the row
					//we don't need a definite count, just need to know there are more than 1
					while($dbrow = $focus->db->fetchByAssoc($result_count) && $res_count<2){
						//increase the res_count, this tells us there are duplicates
						$res_count++;	
					}
				}
				else {
					$GLOBALS['log']->info("No data match to dup check indices");
				}
	
            	//if duplicates exist, set dupe_found boolean.
            	if($res_count>0)
            	{
            		$dupe_found = true;
            	}

            }
	    }
	}
	if ($dupe_found){
        //duplicate found, return false, row is not unique
	    return false;
    }else{
	    //No duplicates, return true, row is unique
	    return true;
	}
	

} 

function create_dupe_check_SQL($temp_index_array, &$focus){
    $GLOBALS['log']->debug("Begin creating dupe check sql");
	$index_fields = array();
	//begin sql string
	$sql = "select * from ".$focus->table_name;
	$GLOBALS['log']->debug("SQL, at this point is: ".$sql);
    //iterate through the matched temp field array and add it's array of fields to index_fields array
    foreach($temp_index_array as $fields){
    	//check to see if field has already been added as part of another index, no need to search for "last_name" 5 times
    	if (in_array($fields,$index_fields)){
    		//already exists as part of another index, no need to add param again
    	}else
    	{	//add field name to array
    		array_push($index_fields,$fields);
    	}
		    
    }

	//add where clause if there are fields to process 
	if(count($index_fields)>0){
		$and_count = 0;
		$sql .= " WHERE ";
		
        //now lets populate the "WHERE" clause of sql.  For each field in the index_fields array,
        //let's add it as a paramater to the sql statement
		foreach($index_fields as $search_param){
			//let's make sure that the field being searched on is populated, if not then skip
			if (isset($focus->$search_param) && $focus->$search_param != ''){
			    //Prefix string with "AND" after the second time in this condition, 
			    if($and_count > 0){
  				    $sql .= " AND ";
				}		
				//(finally) lets add the search param from the bean itself
				//Bug fix #16506 change to double quotes so that apostraphe (O'Brian) doesn't cause SQL error
			    $sql .=" $search_param = \"". $focus->$search_param . "\" ";
			    //increase and_count, so we know we have been here already, and need "AND" prefixed to the sql
			    $and_count++;

			}
		}
	}
	$GLOBALS['log']->debug("SQL returned is: ".$sql);

	//Bug fix #16856 don't check against deleted records
	if ($and_count > 0) {
		$sql .= " AND deleted=0 ";
	}
	else {
		$sql = '';
	}
	return $sql;

}

 
function add_assigned_user_name(&$bean){
 	global $current_user;

	$focus = new User();
	//Import mapping screen passes in assigned_user_name as assigned_user_id
	
	// awu: if assigned_user_name is not defined, must set the id, otherwise retrieve_user_id fails
	if (isset($bean->assigned_user_name)){
		$id = $focus->retrieve_user_id($bean->assigned_user_name);	
	}
	else{
		$id = $current_user->id;
	}
	return $id;			
}




























?>
