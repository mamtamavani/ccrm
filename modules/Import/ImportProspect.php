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
 ********************************************************************************/


require_once('modules/Prospects/Prospect.php');

global $app_list_strings;

// Prospect is used to store customer information.
class ImportProspect extends Prospect {
	// these are fields that may be set on import
	// but are to be processed and incorporated
	// into fields of the parent class
	var $db;
	var $full_name;
	var $primary_address_street_2;
	var $primary_address_street_3;
	var $alt_address_street_2;
	var $alt_address_street_3;

       // This is the list of the functions to run when importing
        var $special_functions =  array(
		"get_names_from_full_name"
		,"add_created_modified_dates"
		,"add_salutation"
		,"add_birthdate"
		,"add_do_not_call"
		,"add_email_opt_out"
		,"add_primary_address_streets"
		,"add_alt_address_streets"
		);

	
	function add_salutation()
	{
                global $app_list_strings;

		if ( isset($this->salutation) &&
			! isset( $app_list_strings['salutation_dom'][ $this->salutation ]) )
		{
			$this->salutation = '';
		}
	}

	function add_birthdate()
	{
		if ( isset($this->birthdate))
		{
			if (! preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/',$this->birthdate))
			{
				$this->birthdate = '';
			}
		}

	}

	function add_do_not_call()
	{
		if ( isset($this->do_not_call) && strtoupper($this->do_not_call) == 'ON')
		{
			$this->do_not_call = 1;
		}
		else {
			$this->do_not_call=0;
		}
	}

	function add_email_opt_out()
	{
		if ( isset($this->email_opt_out) && ($this->email_opt_out != 1 ))
		{
			$this->email_opt_out = '';
		}
	}

	function add_primary_address_streets()
	{
		if ( isset($this->primary_address_street_2))
		{
			$this->primary_address_street .= " ". $this->primary_address_street_2;
		}

		if ( isset($this->primary_address_street_3))
		{
			$this->primary_address_street .= " ". $this->primary_address_street_3;
		}
	}

	function add_alt_address_streets()
	{
		if ( isset($this->alt_address_street_2))
		{
			$this->alt_address_street .= " ". $this->alt_address_street_2;
		}

		if ( isset($this->alt_address_street_3))
		{
			$this->alt_address_street .= " ". $this->alt_address_street_3;
		}

	}

        function get_names_from_full_name()
        {
		if ( ! isset($this->full_name))
		{
			return;
		}
                $arr = array();

                $name_arr = preg_split('/\s+/',$this->full_name);

                if ( count($name_arr) == 1)
                {
                        $this->last_name = $this->full_name;
                }
		else
		{
                	$this->first_name = array_shift($name_arr);

                	$this->last_name = join(' ',$name_arr);
		}

        }


	//module prefix used by ImportSteplast when calling ListView.php
	var $list_view_prefix = 'PROSPECT';

	//columns to be displayed in listview for displaying user's last import in ImportSteplast.php
	var $list_fields = Array(
	  		'id', 
			'first_name', 
			'last_name', 
			'title', 
			'email1', 
			'phone_work', 
			'assigned_user_name', 
			'assigned_user_id');

	//this list defines what beans get populated during an import of contacts
	var $related_modules = array("Prospects",); 
		
	function ImportProspect() {
		parent::Prospect();
	}

	function create_list_query($order_by, $where, $show_deleted = 0)
	{
		global $current_user;
		$query = '';

			$query = "SELECT distinct
				prospects.id,
				prospects.assigned_user_id,
				prospects.first_name,
				prospects.last_name,
				prospects.phone_work,
				prospects.title,
				email_addresses.email_address email1,
                                users.user_name as assigned_user_name
				FROM users_last_import,prospects
                                LEFT JOIN users
                                ON prospects.assigned_user_id=users.id
				LEFT JOIN email_addr_bean_rel on prospects.id = email_addr_bean_rel.bean_id and email_addr_bean_rel.bean_module='Prospects' and email_addr_bean_rel.primary_address=1 and email_addr_bean_rel.deleted=0
				LEFT JOIN email_addresses on email_addresses.id = email_addr_bean_rel.email_address_id 
										
				WHERE
				users_last_import.assigned_user_id=
					'{$current_user->id}'
				AND users_last_import.bean_type='Prospects'
				AND users_last_import.bean_id=prospects.id
				AND users_last_import.deleted=0
				AND prospects.deleted=0
			";
		if(! empty($order_by))
		{
			$query .= " ORDER BY $order_by";
		}

		return $query;


	}

}



?>
