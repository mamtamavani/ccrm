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

 * Description:  Defines the Account SugarBean Account entity with the necessary
 * methods and variables.
 ********************************************************************************/



require_once('data/SugarBean.php');
require_once('modules/Contacts/Contact.php');
require_once('modules/Opportunities/Opportunity.php');
require_once('modules/Cases/Case.php');
require_once('modules/Calls/Call.php');
require_once('modules/Notes/Note.php');
require_once('modules/Emails/Email.php');
require_once('modules/Leads/Lead.php');

global $app_list_strings;

class ImportLead extends Lead {
	 var $db;

	// these are fields that may be set on import
	// but are to be processed and incorporated
	// into fields of the parent class


	// This is the list of fields that are required.
	var $required_fields =  array("last_name"=>1);
	
	// This is the list of the functions to run when importing
	var $special_functions =  array(
		"get_names_from_full_name"
                ,"add_salutation"
                ,"add_lead_status"
                ,"add_lead_source"
                ,"add_do_not_call"
                ,"add_email_opt_out"
		,"add_primary_address_streets"
		,"add_alt_address_streets"
	 );


		//removed importable_fields, this array is now generated in the import wizard. and The array is based
		//on the meta defined in the vardef file for the leads module.

        function add_salutation()
        {
                global $app_list_strings;
                if ( isset($this->salutation) &&
                        ! isset( $app_list_strings['salutation_dom'][ $this->salutation ]) )
                {
                        $this->salutation = '';
                }
        }

        function add_lead_source()
        {
                global $app_list_strings;
                if ( isset($this->lead_source) &&
                        ! isset( $app_list_strings['lead_source_dom'][ $this->lead_source ]) )
                {
                        $this->lead_source = '';
                }

        }

        function add_lead_status()
        {
                global $app_list_strings;
                if ( isset($this->status) &&
                        ! isset( $app_list_strings['lead_status_dom'][ $this->status ]) )
                {
                        $this->status = '';
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


	//module prefix used by ImportSteplast when calling ListView.php
	var $list_view_prefix = 'LEAD';

	//columns to be displayed in listview for displaying user's last import in ImportSteplast.php
	var $list_fields = Array(
					  'id'
					, 'first_name'
					, 'last_name'
					, 'account_name'
					, 'title'
					, 'phone_work'
					, 'assigned_user_name'
					, 'assigned_user_id'
					, 'lead_source'
					, 'lead_source_description'
					, 'refered_by'
					, 'opportunity_name'
					, 'opportunity_amount'
					, 'date_entered'
					, 'status'
					);

	//this list defines what beans get populated during an import of this leads
	var $related_modules = array("Leads",); 
		

	function ImportLead() {
		parent::Lead();
	}

	function create_list_query($order_by, $where, $show_deleted = 0) {
		global $current_user;
		$query = "SELECT
			leads.*,
			users.user_name as assigned_user_name ";



		$query .= "FROM users_last_import,leads LEFT JOIN users ON leads.assigned_user_id=users.id";



		$query .= " WHERE users_last_import.assigned_user_id='{$current_user->id}'
			AND users_last_import.bean_type='Leads'
			AND users_last_import.bean_id=leads.id
			AND users_last_import.deleted=0
			AND leads.deleted=0 ";

		if(!empty($order_by)) {
			$query .= " ORDER BY {$order_by}";
		}

		return $query;
	}
}



?>
