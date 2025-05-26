<?php
// created: 2013-11-24 13:59:54
$viewdefs['Leads']['EditView'] = array (
  'templateMeta' => 
  array (
    'form' => 
    array (
      'hidden' => 
      array (
        0 => '<input type="hidden" name="prospect_id" value="{if isset($smarty.request.prospect_id)}{$smarty.request.prospect_id}{else}{$bean->prospect_id}{/if}">',
        1 => '<input type="hidden" name="account_id" value="{if isset($smarty.request.account_id)}{$smarty.request.account_id}{else}{$bean->account_id}{/if}">',
        2 => '<input type="hidden" name="contact_id" value="{if isset($smarty.request.contact_id)}{$smarty.request.contact_id}{else}{$bean->contact_id}{/if}">',
        3 => '<input type="hidden" name="opportunity_id" value="{if isset($smarty.request.opportunity_id)}{$smarty.request.opportunity_id}{else}{$bean->opportunity_id}{/if}">',
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
    'javascript' => '<script type="text/javascript" language="Javascript">function copyAddressRight(form)  {ldelim} form.alt_address_street.value = form.primary_address_street.value;form.alt_address_city.value = form.primary_address_city.value;form.alt_address_state.value = form.primary_address_state.value;form.alt_address_postalcode.value = form.primary_address_postalcode.value;form.alt_address_country.value = form.primary_address_country.value;return true; {rdelim} function copyAddressLeft(form)  {ldelim} form.primary_address_street.value =form.alt_address_street.value;form.primary_address_city.value = form.alt_address_city.value;form.primary_address_state.value = form.alt_address_state.value;form.primary_address_postalcode.value =form.alt_address_postalcode.value;form.primary_address_country.value = form.alt_address_country.value;return true; {rdelim} </script>',
    'tabDefs' => 
    array (
      'FLOW LIST' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      'CONTACT INFORMATION' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      'LEAD INFORMATION' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      'LEAD EVALUATION' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      'ADDRESS INFORMATION' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'FLOW LIST' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'lead_relevance_c',
          'label' => 'LBL_LEAD_RELEVANCE',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'account_name',
          'type' => 'varchar',
          'validateDependency' => false,
          'label' => 'LBL_ACCOUNT_NAME',
        ),
        1 => 
        array (
          'name' => 'first_name',
          'customCode' => '{html_options name="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
          'label' => 'LBL_FIRST_NAME',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'duedategeneral_c',
          'label' => 'LBL_DUEDATEGENERAL',
        ),
        1 => 
        array (
          'name' => 'last_name',
          'displayParams' => 
          array (
            'required' => true,
          ),
          'label' => 'LBL_LAST_NAME',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'status_description',
          'displayParams' => 
          array (
            'rows' => 4,
            'cols' => 40,
          ),
          'label' => 'LBL_STATUS_DESCRIPTION',
        ),
        1 => 
        array (
          'name' => 'counter_client_c',
          'label' => 'LBL_COUNTER_CLIENT',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'firstcontactdate_c',
          'label' => 'LBL_FIRSTCONTACTDATE',
        ),
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'demodate_c',
          'label' => 'LBL_DEMODATE',
        ),
        1 => 
        array (
          'name' => 'quotationdate_c',
          'label' => 'LBL_QUOTATIONDATE',
        ),
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'pilotdate_c',
          'label' => 'LBL_PILOTDATE',
        ),
        1 => 
        array (
          'name' => 'currency_id',
          'label' => 'LBL_CURRENCY',
        ),
      ),
    ),
    'CONTACT INFORMATION' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'phone_mobile',
          'label' => 'LBL_MOBILE_PHONE',
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
          'name' => 'title',
          'label' => 'LBL_TITLE',
        ),
        1 => 
        array (
          'name' => 'phone_other',
          'label' => 'LBL_OTHER_PHONE',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'department',
          'label' => 'LBL_DEPARTMENT',
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
          'name' => 'skype_username_c',
          'label' => 'LBL_SKYPE_USERNAME',
        ),
        1 => 
        array (
          'name' => 'email1',
          'label' => 'LBL_EMAIL_ADDRESS',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'refered_by',
          'label' => 'LBL_REFERED_BY',
        ),
        1 => 
        array (
          'name' => 'leadweb_c',
          'label' => 'LBL_LEADWEB',
        ),
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO_NAME',
        ),
        1 => 
        array (
          'name' => 'status',
          'label' => 'LBL_STATUS',
        ),
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'do_not_call',
          'label' => 'LBL_DO_NOT_CALL',
        ),
      ),
    ),
    'LEAD INFORMATION' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'ms_departmentsize_c',
          'label' => 'LBL_MS_DEPARTMENTSIZE',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'needs_pain_points_c',
          'label' => 'LBL_NEEDS_PAIN_POINTS',
        ),
        1 => 
        array (
          'name' => 'homeland_position_c',
          'label' => 'LBL_HOMELAND_POSITION',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'lead_country_c',
          'label' => 'LBL_LEAD_COUNTRY',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'current_tool_c',
          'label' => 'LBL_CURRENT_TOOL',
        ),
        1 => 
        array (
          'name' => 'timezone_c',
          'label' => 'LBL_TIMEZONE',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'quotationtotal_c',
          'label' => 'LBL_QUOTATIONTOTAL',
        ),
        1 => 
        array (
          'name' => 'leadcontinent_c',
          'label' => 'LBL_LEADCONTINENT',
        ),
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'quotationtotal_review_c',
          'label' => 'LBL_QUOTATIONTOTAL_REVIEW',
        ),
        1 => 
        array (
          'name' => 'lead_source',
          'label' => 'LBL_LEAD_SOURCE',
        ),
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'lead_source_description',
          'displayParams' => 
          array (
            'rows' => 4,
            'cols' => 40,
          ),
          'label' => 'LBL_LEAD_SOURCE_DESCRIPTION',
        ),
      ),
    ),
    'LEAD EVALUATION' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'date_entered',
          'label' => 'LBL_DATE_ENTERED',
        ),
        1 => 
        array (
          'name' => 'needs_current_operations_c',
          'label' => 'LBL_NEEDS_CURRENT_OPERATIONS',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'reports_by_c',
          'label' => 'LBL_REPORTS_BY',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'alerts_type_c',
          'label' => 'LBL_ALERTS_TYPE',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'mystery_shopping_c',
          'label' => 'LBL_MYSTERY_SHOPPING',
        ),
        1 => 
        array (
          'name' => 'mystery_shopping_pr_c',
          'label' => 'LBL_MYSTERY_SHOPPING_PR',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'phone_surveys_c',
          'label' => 'LBL_PHONE_SURVEYS',
        ),
        1 => 
        array (
          'name' => 'phone_surveys_pr_c',
          'label' => 'LBL_PHONE_SURVEYS_PR',
        ),
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'field_surveys_c',
          'label' => 'LBL_FIELD_SURVEYS',
        ),
        1 => 
        array (
          'name' => 'field_surveys_pr_c',
          'label' => 'LBL_FIELD_SURVEYS_PR',
        ),
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'shelf_study_c',
          'label' => 'LBL_SHELF_STUDY',
        ),
        1 => 
        array (
          'name' => 'shelf_study_pr_c',
          'label' => 'LBL_SHELF_STUDY_PR',
        ),
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'internet_surveys_c',
          'label' => 'LBL_INTERNET_SURVEYS',
        ),
        1 => 
        array (
          'name' => 'internet_surveys_pr_c',
          'label' => 'LBL_INTERNET_SURVEYS_PR',
        ),
      ),
      8 => 
      array (
        0 => 
        array (
          'name' => 'mail_surveys_c',
          'label' => 'LBL_MAIL_SURVEYS',
        ),
        1 => 
        array (
          'name' => 'mail_surveys_pr_c',
          'label' => 'LBL_MAIL_SURVEYS_PR',
        ),
      ),
      9 => 
      array (
        0 => 
        array (
          'name' => 'clients_type_c',
          'label' => 'LBL_CLIENTS_TYPE',
        ),
        1 => 
        array (
          'name' => 'clients_number_c',
          'label' => 'LBL_CLIENTS_NUMBER',
        ),
      ),
      10 => 
      array (
        0 => 
        array (
          'name' => 'market_share_c',
          'label' => 'LBL_MARKET_SHARE',
        ),
        1 => 
        array (
          'name' => 'shops_per_month_c',
          'label' => 'LBL_SHOPS_PER_MONTH',
        ),
      ),
      11 => 
      array (
        0 => 
        array (
          'name' => 'homeland_market_c',
          'label' => 'LBL_HOMELAND_MARKET',
        ),
        1 => 
        array (
          'name' => 'internet_per_month_c',
          'label' => 'LBL_INTERNET_PER_MONTH',
        ),
      ),
      12 => 
      array (
        0 => 
        array (
          'name' => 'additional_markets_c',
          'label' => 'LBL_ADDITIONAL_MARKETS',
        ),
        1 => 
        array (
          'name' => 'phone_per_month_c',
          'label' => 'LBL_PHONE_PER_MONTH',
        ),
      ),
      13 => 
      array (
        0 => 
        array (
          'name' => 'additional_languages_c',
          'label' => 'LBL_ADDITIONAL_LANGUAGES',
        ),
        1 => 
        array (
          'name' => 'frauds_concern_c',
          'label' => 'LBL_FRAUDS_CONCERN',
        ),
      ),
      14 => 
      array (
        0 => 
        array (
          'name' => 'client_expectancy_c',
          'label' => 'LBL_CLIENT_EXPECTANCY',
        ),
      ),
      15 => 
      array (
        0 => 
        array (
          'name' => 'client_retention_c',
          'label' => 'LBL_CLIENT_RETENTION',
        ),
        1 => 
        array (
          'name' => 'client_retention_reason_c',
          'label' => 'LBL_CLIENT_RETENTION_REASON',
        ),
      ),
      16 => 
      array (
        0 => 
        array (
          'name' => 'shoppers_number_c',
          'label' => 'LBL_SHOPPERS_NUMBER',
        ),
        1 => 
        array (
          'name' => 'attachments_type_c',
          'label' => 'LBL_ATTACHMENTS_TYPE',
        ),
      ),
      17 => 
      array (
        0 => 
        array (
          'name' => 'employees_on_reports_c',
          'label' => 'LBL_EMPLOYEES_ON_REPORTS',
        ),
        1 => 
        array (
          'name' => 'attachment_size_estimate_c',
          'label' => 'LBL_ATTACHMENT_SIZE_ESTIMATE',
        ),
      ),
      18 => 
      array (
        0 => 
        array (
          'name' => 'employess_on_scheduling_c',
          'label' => 'LBL_EMPLOYESS_ON_SCHEDULING',
        ),
        1 => 
        array (
          'name' => 'shoppers_login_c',
          'label' => 'LBL_SHOPPERS_LOGIN',
        ),
      ),
      19 => 
      array (
        0 => 
        array (
          'name' => 'account_managers_number_c',
          'label' => 'LBL_ACCOUNT_MANAGERS_NUMBER',
        ),
        1 => 
        array (
          'name' => 'shoppers_registration_c',
          'label' => 'LBL_SHOPPERS_REGISTRATION',
        ),
      ),
      20 => 
      array (
        0 => 
        array (
          'name' => 'tools_for_better_relations_c',
          'label' => 'LBL_TOOLS_FOR_BETTER_RELATIONS',
        ),
        1 => 
        array (
          'name' => 'client_login_c',
          'label' => 'LBL_CLIENT_LOGIN',
        ),
      ),
      21 => 
      array (
        0 => 
        array (
          'name' => 'question_bank_c',
          'label' => 'LBL_QUESTION_BANK',
        ),
      ),
      22 => 
      array (
        0 => 
        array (
          'name' => 'software_cost_today_c',
          'label' => 'LBL_SOFTWARE_COST_TODAY',
        ),
      ),
      23 => 
      array (
        0 => 
        array (
          'name' => 'software_cost_reduce_c',
          'label' => 'LBL_SOFTWARE_COST_REDUCE',
        ),
      ),
      24 => 
      array (
        0 => 
        array (
          'name' => 'good_today_c',
          'label' => 'LBL_GOOD_TODAY',
        ),
      ),
      25 => 
      array (
        0 => 
        array (
          'name' => 'missing_today_c',
          'label' => 'LBL_MISSING_TODAY',
        ),
      ),
    ),
    'ADDRESS INFORMATION' => 
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
      1 => 
      array (
        0 => 
        array (
          'name' => 'description',
          'label' => 'LBL_DESCRIPTION',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'checker_address_c',
          'label' => 'LBL_CHECKER_ADDRESS',
        ),
      ),
    ),
  ),
);