<?php
require_once("include/SugarTinyMCE.php");
$tiny = new SugarTinyMCE();
$tiny->defaultConfig['cleanup_on_startup']=true;
$tinyHtml = $tiny->getInstance('description');

$viewdefs = array (
  'Contacts' => 
  array (
    'EditView' => 
    array (
      'templateMeta' => 
      array (
        'form' => 
        array (
          'hidden' => 
          array (
            0 => '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
            1 => '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
            2 => '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
            3 => '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
            4 => '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
          ),
        ),
        'maxColumns' => '2',
        'widths' => 
        array (
          0 => 
          array (
            'label' => '10',
            'field' => '30',
          ),
          1 => 
          array (
            'label' => '10',
            'field' => '30',
          ),
        ),
      ),
      'panels' => 
      array (
        'Contact Information' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'first_name',
              'customCode' => '{html_options name="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
              'label' => 'LBL_FIRST_NAME',
            ),
            1 => 
            array (
              'name' => 'phone_work',
              'label' => 'LBL_OFFICE_PHONE',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'last_name',
              'displayParams' => 
              array (
                'required' => true,
              ),
              'label' => 'LBL_LAST_NAME',
            ),
            1 => 
            array (
              'name' => 'phone_mobile',
              'label' => 'LBL_MOBILE_PHONE',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'account_name',
              'displayParams' => 
              array (
                'key' => 'billing',
                'copy' => 'primary',
                'billingKey' => 'primary',
                'additionalFields' => 
                array (
                  'phone_office' => 'phone_work',
                ),
              ),
              'label' => 'LBL_ACCOUNT_NAME',
            ),
            1 => 
            array (
              'name' => 'phone_home',
              'label' => 'LBL_HOME_PHONE',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'lead_source',
              'label' => 'LBL_LEAD_SOURCE',
            ),
            1 => 
            array (
              'name' => 'phone_other',
              'label' => 'LBL_OTHER_PHONE',
            ),
          ),
          4 => 
          array (
            0 => 
            array (
              'name' => 'campaign_name',
              'label' => 'LBL_CAMPAIGN',
            ),
            1 => 
            array (
              'name' => 'phone_fax',
              'label' => 'LBL_FAX_PHONE',
            ),
          ),
          5 => 
          array (
            0 => 
            array (
              'name' => 'title',
              'label' => 'LBL_TITLE',
            ),
            1 => 
            array (
              'name' => 'birthdate',
              'label' => 'LBL_BIRTHDATE',
            ),
          ),
          6 => 
          array (
            0 => 
            array (
              'name' => 'department',
              'label' => 'LBL_DEPARTMENT',
            ),
          ),
          7 => 
          array (
            0 => 
            array (
              'name' => 'report_to_name',
              'label' => 'LBL_REPORTS_TO',
            ),
            1 => 
            array (
              'name' => 'assistant',
              'label' => 'LBL_ASSISTANT',
            ),
          ),
          8 => 
          array (
            0 => 
            array (
              'name' => 'sync_contact',
              'label' => 'LBL_SYNC_CONTACT',
            ),
            1 => 
            array (
              'name' => 'assistant_phone',
              'label' => 'LBL_ASSISTANT_PHONE',
            ),
          ),
          9 => 
          array (
            0 => 
            array (
              'name' => 'do_not_call',
              'label' => 'LBL_DO_NOT_CALL',
            ),
          ),
          10 => 
          array (
            0 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO_NAME',
            ),
          ),
        ),
        'Email Address(es)' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'email1',
              'label' => 'LBL_EMAIL_ADDRESS',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'skype_username_c',
              'label' => 'LBL_SKYPE_USERNAME',
            ),
          ),
        ),
        'Address Information' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'primary_address_street',
              'hideLabel' => true,
              'type' => 'address',
              'displayParams' => 
              array (
                'key' => 'primary',
                'rows' => 2,
                'cols' => 30,
                'maxlength' => 150,
              ),
              'label' => 'LBL_PRIMARY_ADDRESS_STREET',
            ),
            1 => 
            array (
              'name' => 'alt_address_street',
              'hideLabel' => true,
              'type' => 'address',
              'displayParams' => 
              array (
                'key' => 'alt',
                'copy' => 'primary',
                'rows' => 2,
                'cols' => 30,
                'maxlength' => 150,
              ),
              'label' => 'LBL_ALT_ADDRESS_STREET',
            ),
          ),
        ),
        'Description Information' => 
        array (
          0 => 
          array (
            0 => 
            array('name'=>'description',
            'customCode'=>'<textarea id="description" name="description">{$fields.description.value}</textarea>{literal}'. $tinyHtml . '<script>focus_obj = document.getElementById("description");</script>{/literal}',
            'displayParams'=>array('required'=>false, 'rows'=>5, 'cols'=>60),
              'label' => 'LBL_DESCRIPTION',
            ),
          ),
        ),
        'Portal Information' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'portal_name',
              'customCode' => '<input id="portal_name" name="portal_name" type="text" size="30" maxlength="30" value="{$fields.portal_name.value}"><input type="hidden" id="portal_name_existing" value="{$fields.portal_name.value}">',
              'label' => 'LBL_PORTAL_NAME',
            ),
            1 => 
            array (
              'name' => 'portal_active',
              'label' => 'LBL_PORTAL_ACTIVE',
            ),
          ),
        ),
      ),
    ),
  ),
);
?>
