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
require_once('modules/Accounts/Account.php');

global $app_list_strings;

// Account is used to store account information.
class ImportOpportunity extends Opportunity {
	 var $db;

	// these are fields that may be set on import
	// but are to be processed and incorporated
	// into fields of the parent class


	// This is the list of fields that are required.
	var $required_fields =  array(
				"name"=>1,
				"account_name"=>1,
				"date_closed"=>1,
				"sales_stage"=>1
);
	
	// This is the list of the functions to run when importing
	var $special_functions =  array(
		"add_create_account",
		"add_lead_source",
		"add_opportunity_type",
        	"add_date_closed",
        	"add_sales_stage"
	 );

        function add_lead_source()
        {
		global $app_list_strings;
                if ( isset($this->lead_source) &&
                        ! isset( $app_list_strings['lead_source_dom'][ $this->lead_source ]) )
                {
                        $this->lead_source = '';
                }

        }

        function add_sales_stage()
        {
                global $app_list_strings;

                if ( isset($this->sales_stage) &&
                        ! isset( $app_list_strings['sales_stage_dom'][ $this->sales_stage ]) )
                {
                        $this->sales_stage = 'Prospecting';
                }


	}

        function add_opportunity_type()
        {
                global $app_list_strings;

                if ( isset($this->opportunity_type) &&
                        ! isset( $app_list_strings['opportunity_type_dom'][ $this->opportunity_type ]) )
                {
                        $this->opportunity_type = '';
                }

        }

        function add_date_closed()
        {
                if ( isset($this->date_closed))
                {
					global $timedate;
					// TimeDate doesn't have a get_db_date_format and i'm too scared to write it :-)
					$test_datetime = $this->date_closed;
                   if ( ! $timedate->check_matching_format($test_datetime, $timedate->get_date_format()) ) 
					{
						$GLOBALS['log']->debug("Date format incorrect.");
						$this->date_closed = '';
					}
					
				}

        }


	//exactly the same function from ImportAccount.php
	// lets put this in one place.. 

        function add_create_account()
        {
                // global is defined in UsersLastImport.php
                global $imported_ids;
                global $current_user;

                if ( (! isset($this->account_name) || $this->account_name == '') &&
                        (! isset($this->account_id) || $this->account_id == '') )
                {
                        return;
                }

                $arr = array();

                // check if it already exists
                $focus = new Account();

                $query = '';

                // if user is defining the account id to be associated with this contact..
                if ( isset($this->account_id) && $this->account_id != '')
                {
                		$this->account_id = convert_id($this->account_id);
                        $query = "select * from {$focus->table_name} WHERE id='".  PearDatabase::quote($this->account_id)."'";
                }
                // else user is defining the account name to be associated with this contact..
                else
                {
                        $query = "select * from {$focus->table_name} WHERE name='".  PearDatabase::quote($this->account_name)."'";
                }

                $GLOBALS['log']->info($query);

                $result = $this->db->query($query)
                       or sugar_die("Error selecting sugarbean: ");

                $row = $this->db->fetchByAssoc($result, -1, false);
                // if we found a row with that id
                if (isset($row['id']) && $row['id'] != -1)
                {
                        // if it exists but was deleted, just remove it entirely
                        if ( isset($row['deleted']) && $row['deleted'] == 1)
                        {
                                $query2 = "delete from {$focus->table_name} WHERE id='".  PearDatabase::quote($row['id']) ."'";

                                $GLOBALS['log']->info($query2);

                                $result2 = $this->db->query($query2)
                                        or sugar_die("Error deleting existing sugarbean: ");

                        }
                        // else just use this id to link the contact to the account
                        else
                        {
                                $focus->id = $row['id'];
                        }
                }

                // we didnt find the account, so create it
                if (! isset($focus->id) || $focus->id == '')
                {
                        $focus->name = $this->account_name;
                        $focus->assigned_user_id = $current_user->id;
                        $focus->modified_user_id = $current_user->id;

                        if ( isset($this->account_id)  &&
                                $this->account_id != '')
                        {
                                $focus->new_with_id = true;
                                $focus->id = $this->account_id;
                        }

                        $focus->save();
                        // avoid duplicate mappings:
                        if (! isset( $imported_ids[$focus->id]) )
                        {
                                // save the new account as a users_last_import
                                $last_import = new UsersLastImport();
                                $last_import->assigned_user_id = $current_user->id;
                                $last_import->bean_type = "Accounts";
                                $last_import->bean_id = $focus->id;
                                $last_import->save();
                                $imported_ids[$focus->id] = 1;
                        }
                }

                $this->account_id = $focus->id;

	}



	function fix_website()
	{
		if ( isset($this->website) &&
			preg_match("/^http:\/\//",$this->website) )
		{
			$this->website = substr($this->website,7);
		}	
	}

	
	//module prefix used by ImportSteplast when calling ListView.php
	var $list_view_prefix = 'OPPORTUNITY';
		
	//columns to be displayed in listview for displaying user's last import in ImportSteplast.php
	var $list_fields = Array(
						'id' 
						,'name'
						,'account_id'
						,'account_name'
						,'amount'
						,'date_closed'
						,'assigned_user_name'
						,'assigned_user_id'
						);
						
	//this list defines what beans get populated during an import of opportunities
	var $related_modules = array("Opportunities","Accounts"); 

function ImportOpportunity() {
		parent::Opportunity();
	}
	
	function create_list_query($order_by, $where, $show_deleted = 0)
	{
		global $current_user;
		$query = '';
		$query = "SELECT 
                                accounts.id as account_id,
                                accounts.name as account_name,
                                users.user_name as assigned_user_name,
                                opportunities.* ";



			
			$query .= " FROM users_last_import,opportunities
                                LEFT JOIN users
                                ON opportunities.assigned_user_id=users.id
                                LEFT JOIN accounts_opportunities
                                ON opportunities.id=accounts_opportunities.opportunity_id
                                LEFT JOIN accounts
                                ON accounts_opportunities.account_id=accounts.id ";




                                
			$query .= " WHERE
				users_last_import.assigned_user_id=
					'{$current_user->id}'
				AND users_last_import.bean_type='Opportunities'
				AND users_last_import.bean_id=opportunities.id
				AND users_last_import.deleted=0
				AND accounts_opportunities.deleted=0
				AND accounts.deleted=0
				AND opportunities.deleted=0
			";
			if(! empty($order_by))
		{
			$query .= " ORDER BY $order_by";
		}

		return $query;

	
	}
}



?>
