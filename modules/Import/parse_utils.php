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

// takes a string and parses it into one record per line,
// one field per delimiter, to a maximum number of lines
// some files have a header, some dont.
// keeps track of which fields are used
ini_set('auto_detect_line_endings','1');

function parse_import($file_name,$delimiter,$max_lines,$has_header)
{
	global $locale;
	if(empty($locale))
	{
		require_once('include/Localization/Localization.php');
		$locale = new Localization();
	}
	
	$line_count = 0;

	$field_count = 0;

	$rows = array();

	if (! file_exists($file_name))
	{
		return -1;
	}

	$fh = fopen($file_name,"r");

	if (! $fh)
	{
		return -1;
	}

	while ( (( $fields = fgetcsv($fh, 4096, $delimiter) ) !== FALSE) 
		&& ( $max_lines == -1 || $line_count < $max_lines)) 
	{

		if ( count($fields) == 1 && isset($fields[0]) && $fields[0] == '')
		{
			continue;
		}
		$this_field_count = count($fields);

		if ( $this_field_count > $field_count)
		{
			$field_count = $this_field_count;
		}

		array_push($rows,$fields);

		$line_count++;

	}

	// got no rows
	if ( count($rows) == 0)
	{
		return -3;
	}
	else
	{
		//// cn: bug 6712 - need to translate to UTF-8
		foreach($rows as $rowKey => $row)
		{
			foreach($row as $k => $v) {
				$row[$k] = $locale->translateCharset($v, $locale->getExportCharset());
			}
			$rows[$rowKey] = $row;
		}
	}

	$ret_array = array(
		"rows"=>&$rows,
		"field_count"=>$field_count
	);

	return $ret_array;

}


// this parser just splits the string by the delimiter and that's it..
function parse_import_split($file_name,$delimiter,$max_lines,$has_header)
{
	global $locale;
	if(empty($locale))
	{
		require_once('include/Localization/Localization.php');
		$locale = new Localization();
	}

	$line_count = 0;

	$field_count = 0;

	$rows = array();

	if (! file_exists($file_name))
	{
		return -1;
	}

	$fh = fopen($file_name,"r");

	if (! $fh)
	{
		return -1;
	}

	while ( ($line = fgets($fh, 4096))
                && ( $max_lines == -1 || $line_count < $max_lines) )

	{
		
		$line = trim($line);
		$fields = explode($delimiter,$line);

		$this_field_count = count($fields);

		if ( $this_field_count > $field_count)
		{
			$field_count = $this_field_count;
		}

		array_push($rows,$fields);

		$line_count++;

	}

	// got no rows
	if ( count($rows) == 0)
	{
		return -3;
	}
	else
	{
		//// cn: bug 6712 - need to translate to UTF-8
		foreach($rows as $rowKey => $row)
		{
			foreach($row as $k => $v) {
				$row[$k] = $locale->translateCharset($v, $locale->getExportCharset());
			}
			$rows[$rowKey] = $row;
		}
	}
	$ret_array = array(
		"rows"=>&$rows,
		"field_count"=>$field_count
	);

	return $ret_array;

}

function parse_import_act($file_name,$delimiter,$max_lines,$has_header)
{
	global $locale;
	if(empty($locale))
	{
		require_once('include/Localization/Localization.php');
		$locale = new Localization();
	}

	$line_count = 0;

	$field_count = 0;

	$rows = array();

	if (! file_exists($file_name))
	{
		return -1;
	}

	$fh = fopen($file_name,"r");

	if (! $fh)
	{
		return -1;
	}

	while ( ($line = fgets($fh, 4096))
                && ( $max_lines == -1 || $line_count < $max_lines) )

	{
		
		$line = trim($line);
		$line = substr_replace($line,"",0,1);
		$line = substr_replace($line,"",-1);
		$fields = explode("\",\"",$line);

		$this_field_count = count($fields);

		if ( $this_field_count > $field_count)
		{
			$field_count = $this_field_count;
		}

		array_push($rows,$fields);

		$line_count++;

	}

	// got no rows
	if ( count($rows) == 0)
	{
		return -3;
	}
	else
	{
		//// cn: bug 6712 - need to translate to UTF-8
		foreach($rows as $rowKey => $row)
		{
			foreach($row as $k => $v) {
				$row[$k] = $locale->translateCharset($v, $locale->getExportCharset());
			}
			$rows[$rowKey] = $row;
		}
	}
	$ret_array = array(
		"rows"=>&$rows,
		"field_count"=>$field_count
	);

	return $ret_array;

}

//This function will return a list of import enabled fields, and another array of importable fields label translated into logged in 
//user's locale specific string.
//all fields in a module's vardefs file are importable , unless they meet this criteria, 
//             Importable is set to false or type is link.
function get_importable_fields(&$bean, &$importable_fields, &$labels) {
	$my_fielddefs= $bean->getFieldDefinitions();		
	foreach ($my_fielddefs as $key=>$value_array) {		
		if ((array_key_exists('Importable',$value_array) && $value_array['Importable'] == false )
			or ((array_key_exists('type',$value_array) && $value_array['type'] == 'link' ) or $key == 'date_modified')
			) {
				//do not allow import.
			} else {
				$importable_fields[$key]=1; 
				if (!empty ($value_array['vname']))
					$labels[$key]= translate($value_array['vname'] ,$bean->module_dir);
				else
					$labels[$key]= translate($value_array['name'] ,$bean->module_dir);

		}
	}	
}
	
?>
