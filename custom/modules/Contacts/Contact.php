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

require_once('include/SugarObjects/templates/person/Person.php');
require_once('include/utils.php');
require_once('modules/Opportunities/Opportunity.php');
require_once('modules/Cases/Case.php');
require_once('modules/Tasks/Task.php');
require_once('modules/Notes/Note.php');
require_once('modules/Leads/Lead.php');
require_once('modules/Meetings/Meeting.php');
require_once('modules/Calls/Call.php');
require_once('modules/Emails/Email.php');
require_once('modules/Bugs/Bug.php');
require_once('modules/Users/User.php');
require_once('modules/Campaigns/Campaign.php');
require_once('include/SugarObjects/templates/person/Person.php');
// Contact is used to store customer information.
class Contact extends Person {
    var $field_name_map;
	// Stored fields
	var $id;
	var $name = '';
	var $lead_source;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $assigned_user_id;
	var $created_by;
	var $created_by_name;
	var $modified_by_name;




	var $description;
	var $salutation;
	var $first_name;
	var $last_name;
	var $title;
	var $department;
	var $birthdate;
	var $reports_to_id;
	var $do_not_call;
	var $phone_home;
	var $phone_mobile;
	var $phone_work;
	var $phone_other;
	var $phone_fax;
	var $email1;
	var $email_and_name1;
	var $email_and_name2;
	var $email2;
	var $assistant;
	var $assistant_phone;
	var $email_opt_out;
	var $primary_address_street;
	var $primary_address_city;
	var $primary_address_state;
	var $primary_address_postalcode;
	var $primary_address_country;
	var $alt_address_street;
	var $alt_address_city;
	var $alt_address_state;
	var $alt_address_postalcode;
	var $alt_address_country;
	var $portal_name;
	var $portal_app;
	var $portal_active;
	var $contacts_users_id;
	// These are for related fields
	var $bug_id;
	var $account_name;
	var $account_id;
	var $report_to_name;
	var $opportunity_role;
	var $opportunity_rel_id;
	var $opportunity_id;
	var $case_role;
	var $case_rel_id;
	var $case_id;
	var $task_id;
	var $note_id;
	var $meeting_id;
	var $call_id;
	var $email_id;
	var $assigned_user_name;
	var $accept_status;
    var $accept_status_id;
    var $accept_status_name;
    var $alt_address_street_2;
    var $alt_address_street_3;
    var $opportunity_role_id;
    var $portal_password;
    var $primary_address_street_2;
    var $primary_address_street_3;
    var $campaign_id;
    var $sync_contact;






	var $full_name; // l10n localized name
	var $invalid_email;
	var $table_name = "contacts";
	var $rel_account_table = "accounts_contacts";
	//This is needed for upgrade.  This table definition moved to Opportunity module.
	var $rel_opportunity_table = "opportunities_contacts";




	var $object_name = "Contact";
	var $module_dir = 'Contacts';
	var $emailAddress;
	var $new_schema = true;


	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array('bug_id', 'assigned_user_name', 'account_name', 'account_id', 'opportunity_id', 'case_id', 'task_id', 'note_id', 'meeting_id', 'call_id', 'email_id'



	);

	var $relationship_fields = Array('account_id'=> 'accounts','bug_id' => 'bugs', 'call_id'=>'calls','case_id'=>'cases','email_id'=>'emails',
								'meeting_id'=>'meetings','note_id'=>'notes','task_id'=>'tasks', 'opportunity_id'=>'opportunities', 'contacts_users_id' => 'user_sync'
								);

	function Contact() {
		parent::Person();
		global $current_user;







	}









































	function add_list_count_joins(&$query, $where)
	{
		// accounts.name
		if(eregi("accounts.name", $where))
		{
			// add a join to the accounts table.
			$query .= "
	            LEFT JOIN accounts_contacts
	            ON contacts.id=accounts_contacts.contact_id
	            LEFT JOIN accounts
	            ON accounts_contacts.account_id=accounts.id
			";
		}
		$custom_join = $this->custom_fields->getJOIN();
		if($custom_join){
  				$query .= $custom_join['join'];
		}


	}

	function listviewACLHelper(){
		$array_assign = parent::listviewACLHelper();
		$is_owner = false;
		//MFH BUG 18281
		if(!empty($this->account_id)){
			global $current_user;
			require_once('modules/Accounts/Account.php');
			$account = new Account();
			$account->retrieve($this->account_id);
		
			if($current_user->id == $account->assigned_user_id){
				$is_owner = true;
			}
		}
			if(!ACLController::moduleSupportsACL('Accounts') || ACLController::checkAccess('Accounts', 'view', $is_owner)){
				$array_assign['ACCOUNT'] = 'a';
			}else{
				$array_assign['ACCOUNT'] = 'span';

			}
		return $array_assign;
	}

	function create_list_query($order_by, $where, $show_deleted = 0)
	{
		$custom_join = $this->custom_fields->getJOIN();
		// MFH - BUG #14208 creates alias name for select
		$query = "SELECT ";
		$query .= db_concat($this->table_name,array('first_name','last_name')) . " name, ";
		$query .= "
				$this->table_name.*,
                accounts.name as account_name,
                accounts.id as account_id,
                accounts.assigned_user_id account_id_owner,
                users.user_name as assigned_user_name ";



		if($custom_join){
   				$query .= $custom_join['select'];
 		}
        $query .= "
                FROM contacts ";





		$query .=		"LEFT JOIN users
	                    ON contacts.assigned_user_id=users.id
	                    LEFT JOIN accounts_contacts
	                    ON contacts.id=accounts_contacts.contact_id  and accounts_contacts.deleted = 0
	                    LEFT JOIN accounts
	                    ON accounts_contacts.account_id=accounts.id AND accounts.deleted=0 ";



		$query .= "LEFT JOIN email_addr_bean_rel eabl  ON eabl.bean_id = contacts.id AND eabl.bean_module = 'Contacts' and eabl.primary_address = 1 and eabl.deleted=0 ";
        $query .= "LEFT JOIN email_addresses ea ON (ea.id = eabl.email_address_id) ";
		if($custom_join){
  				$query .= $custom_join['join'];
		}
		$where_auto = '1=1';
		if($show_deleted == 0){
            	$where_auto = " $this->table_name.deleted=0 ";
            	//$where_auto .= " AND accounts.deleted=0  ";
		}else if($show_deleted == 1){
				$where_auto = " $this->table_name.deleted=1 ";
		}


		if($where != "")
			$query .= "where ($where) AND ".$where_auto;
		else
			$query .= "where ".$where_auto;

		if(!empty($order_by))
		    $query .=  " ORDER BY ". $this->process_order_by($order_by, null);
		return $query;
	}



        function create_export_query(&$order_by, &$where)
        {
        		$custom_join = $this->custom_fields->getJOIN();
                         $query = "SELECT
                                contacts.*,email_addresses.email_address,
                                accounts.name as account_name,
                                users.user_name as assigned_user_name ";



						if($custom_join){
   							$query .= $custom_join['select'];
 						}
						 $query .= " FROM contacts ";




                         $query .= "LEFT JOIN users
	                                ON contacts.assigned_user_id=users.id ";



	                     $query .= "LEFT JOIN accounts_contacts
	                                ON contacts.id=accounts_contacts.contact_id
	                                LEFT JOIN accounts
	                                ON accounts_contacts.account_id=accounts.id ";
						
						//join email address table too.
						$query .=  ' LEFT JOIN  email_addr_bean_rel on contacts.id = email_addr_bean_rel.bean_id and email_addr_bean_rel.bean_module=\'Contacts\' and email_addr_bean_rel.primary_address=1 ';
						$query .=  ' LEFT JOIN email_addresses on email_addresses.id = email_addr_bean_rel.email_address_id ' ;
						
						if($custom_join){
  							$query .= $custom_join['join'];
						}

		$where_auto = "( accounts.deleted IS NULL OR accounts.deleted=0 )
                      AND contacts.deleted=0 AND (accounts_contacts.deleted IS NULL OR accounts_contacts.deleted=0) ";

                if($where != "")
                        $query .= "where ($where) AND ".$where_auto;
                else
                        $query .= "where ".$where_auto;

                if(!empty($order_by))
                        $query .=  " ORDER BY ". $this->process_order_by($order_by, null);

                return $query;
        }

	function fill_in_additional_list_fields() {	
		parent::fill_in_additional_list_fields();
		// cn: bug 8586 - l10n names for Contacts in Email TO: field
		$this->_create_proper_name_field();
		$this->email_and_name1 = "{$this->full_name} &lt;".$this->email1."&gt;";
		$this->email_and_name2 = "{$this->full_name} &lt;".$this->email2."&gt;";
		
		if($this->force_load_details == true) {
			$this->fill_in_additional_detail_fields();
		}
	}

	function fill_in_additional_detail_fields() {
		parent::fill_in_additional_detail_fields();
		global $locale, $app_list_strings, $current_user;
		

		// retrieve the account information and the information about the person the contact reports to.
		$query = "SELECT acc.id, acc.name, con_reports_to.first_name, con_reports_to.last_name
		from contacts
		left join accounts_contacts a_c on a_c.contact_id = '".$this->id."' and a_c.deleted=0
		left join accounts acc on a_c.account_id = acc.id and acc.deleted=0
		left join contacts con_reports_to on con_reports_to.id = contacts.reports_to_id
		where contacts.id = '".$this->id."'";

		$result = $this->db->query($query,true," Error filling in additional detail fields: ");

		// Get the id and the name.
		$row = $this->db->fetchByAssoc($result);

		if($row != null)
		{
			$this->account_name = $row['name'];
			$this->account_id = $row['id'];
			$this->report_to_name = $row['first_name'].' '.$row['last_name'];
		}
		else
		{
			$this->account_name = '';
			$this->account_id = '';
			$this->report_to_name = '';
		}
		$this->load_contacts_users_relationship();
		/** concating this here because newly created Contacts do not have a
		 * 'name' attribute constructed to pass onto related items, such as Tasks
		 * Notes, etc.
		 */
		$this->name = $locale->getLocaleFormattedName($this->first_name, $this->last_name);
        if(!empty($this->contacts_users_id)) {
		   $this->sync_contact = true;
		}

		if(!empty($this->portal_active) && $this->portal_active == 1) {
		   $this->portal_active = true;
		}

        // Set campaign name if there is a campaign id
		if(isset($this->campaign_id) && !empty($this->campaign_id)){
			require_once('modules/Campaigns/Campaign.php');
			$camp = new Campaign();
		    $where = "campaigns.id='{$this->campaign_id}'";
		    $campaign_list = $camp->get_full_list("campaigns.name", $where, true);
		    $this->campaign_name = $campaign_list[0]->name;	
		}
	}

		/**
		loads the contacts_users relationship to populate a checkbox
		where a user can select if they would like to sync a particular
		contact to Outlook
	*/
	function load_contacts_users_relationship(){
		global $current_user;

		$this->load_relationship("user_sync");
		$query_array=$this->user_sync->getQuery(true);

		$query_array['where'] .= " AND users.id = '$current_user->id'";

		$query='';
		foreach ($query_array as $qstring) {
			$query.=' '.$qstring;
		}

		$list = $this->build_related_list($query, new User());
		if(!empty($list)){
			//this should only return one possible value so set it
			$this->contacts_users_id = $list[0]->id;
		}
	}

	function get_list_view_data() {
		global $system_config;
		global $current_user;

		$this->_create_proper_name_field();
		$temp_array = $this->get_list_view_array();
		$array = parent::get_list_view_array();
$array['DESCRIPTION'] = from_html($array['DESCRIPTION']);
return $array;
		$temp_array['NAME'] = $this->name;
		$temp_array['ENCODED_NAME'] = $this->name;

		if(isset($system_config->settings['system_skypeout_on'])
			&& $system_config->settings['system_skypeout_on'] == 1)
		{
			if(!empty($temp_array['PHONE_WORK'])
				&& skype_formatted($temp_array['PHONE_WORK']))
			{
				$temp_array['PHONE_WORK'] = '<a href="callto://'
					. $temp_array['PHONE_WORK']. '">'
					. $temp_array['PHONE_WORK']. '</a>' ;
			}
		}
		$temp_array['EMAIL1'] = $this->emailAddress->getPrimaryAddress($this);
		$temp_array['EMAIL1_LINK'] = $current_user->getEmailLink('email1', $this, '', '', 'ListView');
		return $temp_array;
	}

	/**
		builds a generic search based on the query string using or
		do not include any $this-> because this is called on without having the class instantiated
	*/
	function build_generic_where_clause ($the_query_string)
	{
		$where_clauses = Array();
		$the_query_string = PearDatabase::quote(from_html($the_query_string));

		array_push($where_clauses, "contacts.last_name like '$the_query_string%'");
		array_push($where_clauses, "contacts.first_name like '$the_query_string%'");
		array_push($where_clauses, "accounts.name like '$the_query_string%'");
		array_push($where_clauses, "contacts.assistant like '$the_query_string%'");
		array_push($where_clauses, "ea.email_address like '$the_query_string%'");

		if (is_numeric($the_query_string))
		{
			array_push($where_clauses, "contacts.phone_home like '%$the_query_string%'");
			array_push($where_clauses, "contacts.phone_mobile like '%$the_query_string%'");
			array_push($where_clauses, "contacts.phone_work like '%$the_query_string%'");
			array_push($where_clauses, "contacts.phone_other like '%$the_query_string%'");
			array_push($where_clauses, "contacts.phone_fax like '%$the_query_string%'");
			array_push($where_clauses, "contacts.assistant_phone like '%$the_query_string%'");
		}

		$the_where = "";
		foreach($where_clauses as $clause)
		{
			if($the_where != "") $the_where .= " or ";
			$the_where .= $clause;
		}


		return $the_where;
	}

	function set_notification_body($xtpl, $contact)
	{
		$xtpl->assign("CONTACT_NAME", trim($contact->first_name . " " . $contact->last_name));
		$xtpl->assign("CONTACT_DESCRIPTION", $contact->description);

		return $xtpl;
	}

	function get_contact_id_by_email($email)
	{
		$email = trim($email);
		if(empty($email)){
			//email is empty, no need to query, return null
			return null;
		}

		$where_clause = "(email1='$email' OR email2='$email') AND deleted=0";

                $query = "SELECT * FROM $this->table_name WHERE $where_clause";
                $GLOBALS['log']->debug("Retrieve $this->object_name: ".$query);
		        //requireSingleResult has beeen deprecated.
                //$result = $this->db->requireSingleResult($query, true, "Retrieving record $where_clause:");
				$result = $this->db->limitQuery($query,0,1,true, "Retrieving record $where_clause:");

                if( empty($result))
                {
                        return null;
                }

                $row = $this->db->fetchByAssoc($result, -1, true);
		return $row['id'];

	}

	function save_relationship_changes($is_update) {

		//if account_id was replaced unlink the previous account_id.
		//this rel_fields_before_value is populated by sugarbean during the retrieve call.
		if (!empty($this->account_id) and !empty($this->rel_fields_before_value['account_id']) and
				(trim($this->account_id) != trim($this->rel_fields_before_value['account_id']))) {
				//unlink the old record.
				$this->load_relationship('accounts');
				$this->accounts->delete($this->id,$this->rel_fields_before_value['account_id']);
		}
		parent::save_relationship_changes($is_update);
	}

	function bean_implements($interface){
		switch($interface){
			case 'ACL':return true;
		}
		return false;
	}
	function get_unlinked_email_query($type=array()) {
		require_once('include/utils.php');
		return get_unlinked_email_query($type, $this);
	}
	

}



?>
