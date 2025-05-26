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

 ********************************************************************************/

$import_bean_map = array(
 'Contacts' => 'ImportContact'
,'Accounts' => 'ImportAccount'
,'Opportunities' => 'ImportOpportunity' 
,'Leads' => 'ImportLead'
,'Notes' => 'ImportNote'
,'Prospects' => 'ImportProspect'







);


$outlook_contacts_field_map = array(
"Salutation"=>"salutation",
// SPECIAL FIELD:
"Full Name"=>"full_name",
"Company"=>"company",
// END
"First Name"=>"first_name",
"Last Name"=>"last_name",
"Title"=>"title",
"Department"=>"department",
"Birthday"=>"birthdate",
"Home Phone"=>"phone_home",
"Mobile Phone"=>"phone_mobile",
"Business Phone"=>"phone_work",
"Other Phone"=>"phone_other",
"Business Fax"=>"phone_fax",
"E-mail Address"=>"email1",
"E-mail 2"=>"email2",
"Assistant's Name"=>"assistant",
"Assistant's Phone"=>"assistant_phone",
"Business Street"=>"primary_address_street",
"Business City"=>"primary_address_city",
"Business State"=>"primary_address_state",
"Business Postal Code"=>"primary_address_postalcode",
"Business Country/Region"=>"primary_address_country",
"Home Street"=>"alt_address_street",
"Home City"=>"alt_address_city",
"Home State"=>"alt_address_state",
"Home Postal Code"=>"alt_address_postalcode",
"Home Country/Region"=>"alt_address_country",
);


$outlook_accounts_field_map = array(
"Company"=>"name",
"Business Street"=>"billing_address_street",
"Business City"=>"billing_address_city",
"Business State"=>"billing_address_state",
"Business Country"=>"billing_address_country",
"Business Postal Code"=>"billing_address_postalcode",
"Business Fax"=>"phone_fax",
"Company Main Phone"=>"phone_office",
"Web Page"=>"website",
//Government ID Number, 
//Organizational ID Number, 
);

$act_contacts_field_map = array(
"Web Site"=>"website",
"Company"=>"account_name",
"Name Suffix"=>"salutation",
"Title"=>"title",
"First Name"=>"first_name",
"Last Name"=>"last_name",
"Address 1"=>"primary_address_street",
"Address 2"=>"primary_address_street_2",
"Address 3"=>"primary_address_street_3",
"City"=>"primary_address_city",
"State"=>"primary_address_state",
"Zip"=>"primary_address_postalcode",
"Country"=>"primary_address_country",
"Phone"=>"phone_work",
"Phone Ext-"=>"phone_work_ext",
"Mobile Phone"=>"phone_mobile",
"Alt Phone"=>"phone_other",
"Fax"=>"phone_fax",
"E-mail Login"=>"email1",
"E-mail"=>"email1",
"E-Mail 2"=>"email2",
"Assistant"=>"assistant",
"Asst. Phone"=>"assistant_phone",
"Home Address 1"=>"alt_address_street",
"Home Address 2"=>"alt_address_street_2",
"Home Address 3"=>"alt_address_street_3",
"Home City"=>"alt_address_city",
"Home State"=>"alt_address_state",
"Home Zip"=>"alt_address_postalcode",
"Home Country"=>"alt_address_country",
"Home Phone"=>"phone_home",
);


$act_accounts_field_map = array(
"Revenue"=>"annual_revenue",
"Number of Employees"=>"employees",
"Company"=>"name",
"Address 1"=>"billing_address_street",
"City"=>"billing_address_city",
"State"=>"billing_address_state",
"Zip Code"=>"billing_address_postalcode",
"Country"=>"billing_address_country",
"Phone"=>"phone_office",
"Fax Phone"=>"phone_fax",
"Ticker Symbol"=>"ticker_symbol",
"Web Site"=>"website",
);

/*
"Last Activity"=>"",
"Last Modified Date"=>"",
"Created Date"=>"",
"Reports To"=>"",
"Last Stay-in-Touch Request Date"=>"",
"Last Stay-in-Touch Save Date"=>"",
*/
$salesforce_contacts_field_map = array(
"Salutation"=>"salutation",
"Description"=>"description",
"First Name"=>"first_name",
"Last Name"=>"last_name",
"Title"=>"title",
"Department"=>"department",
"Birthdate"=>"birthdate",
"Lead Source"=>"lead_source",
"Assistant"=>"assistant",
"Asst. Phone"=>"assistant_phone",
"Contact ID"=>"id",
"Mailing Street"=>"primary_address_street",
"Mailing Address Line1"=>"primary_address_street_2",
"Mailing Address Line2"=>"primary_address_street_3",
"Mailing Address Line3"=>"primary_address_street_4",
"Mailing City"=>"primary_address_city",
"Mailing State"=>"primary_address_state",
"Mailing Zip/Postal Code"=>"primary_address_postalcode",
"Mailing Country"=>"primary_address_country",
"Other Street"=>"alt_address_street",
"Other Address Line 1"=>"alt_address_street_2",
"Other Address Line 2"=>"alt_address_street_3",
"Other Address Line 3"=>"alt_address_street_4",
"Other City"=>"alt_address_city",
"Other State"=>"alt_address_state",
"Other Zip/Postal Code"=>"alt_address_postalcode",
"Other Country"=>"alt_address_country",
"Phone"=>"phone_work",
"Mobile"=>"phone_mobile",
"Home Phone"=>"phone_home",
"Other Phone"=>"phone_other",
"Fax"=>"phone_fax",
"Email"=>"email1",
"Email Opt Out"=>"email_opt_out",
"Do Not Call"=>"do_not_call",
"Account Name"=>"account_name",
"Account ID"=>"account_id",
);




/*
ommited fields to map:
"Account Number"=>"",
"Account Site"=>"",
"Last Activity"=>"",
"Parent Account"=>"",
"Parent Account ID"=>"",
"Parent Account Site"=>"",
"Created Date"=>"",
"Last Modified Date"=>"",
"Billing Address Line3"=>"",
"Shipping Address Line3"=>"",
*/
$salesforce_accounts_field_map = array(
"Account Name"=>"name",
"Annual Revenue"=>"annual_revenue",
"Type"=>"account_type",
"Ticker Symbol"=>"ticker_symbol",
"Rating"=>"rating",
"Industry"=>"industry",
"SIC Code"=>"sic_code",
"Ownership"=>"ownership",
"Employees"=>"employees",
"Description"=>"description",
"Account ID"=>"id",
"Billing Street"=>"billing_address_street",
"Billing Address Line1"=>"billing_address_street_2",
"Billing Address Line2"=>"billing_address_street_3",
"Billing City"=>"billing_address_city",
"Billing State"=>"billing_address_state",
"Billing Zip/Postal Code"=>"billing_address_postalcode",
"Billing Country"=>"billing_address_country",
"Shipping Street"=>"shipping_address_street",
"Shipping Address Line1"=>"shipping_address_street_2",
"Shipping Address Line2"=>"shipping_address_street_3",
"Shipping City"=>"shipping_address_city",
"Shipping State"=>"shipping_address_state",
"Shipping Zip/Postal Code"=>"shipping_address_postalcode",
"Shipping Country"=>"shipping_address_country",
"Phone"=>"phone_office",
"Fax"=>"phone_fax",
"Website"=>"website"
);

/*
"Fiscal Quarter"=>"",
"Age"=>"",
"Expected Revenue"=>"",
*/
$salesforce_opportunities_field_map = array(

"Opportunity Name"=>"name" ,
"Type"=>"opportunity_type",
"Lead Source"=>"lead_source",
"Amount"=>"amount",
"Created Date"=>"date_entered",
"Close Date"=>"date_closed",
"Next Step"=>"next_step",
"Stage"=>"sales_stage",
"Probability (%)"=>"probability",
"Account Name"=>"account_name"
);































?>
