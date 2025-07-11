<?php
require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

$module_name = 'asol_Events';
$viewdefs[$module_name] = 
array (
	'DetailView' => 
		array (
		
			'templateMeta' => 
				array (
					'form' => 
						array (
							'buttons' => 
								array (
									0 => 'EDIT',
									1 => 'DUPLICATE',
									2 => 'DELETE',
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
					'useTabs' => false,
				),

			'panels' => 
				array (
				
					'default' => 
						array (
							0 => 
								array (
									0 => 'name',
								),
							1 => 
								array (
									0 => 
										array (
											'name' => 'date_entered',
											'label' => 'LBL_DATE_ENTERED',
											'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
										),
									1 => 
										array (
											'name' => 'date_modified',
											'label' => 'LBL_DATE_MODIFIED',
											'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
										),
								),
							2 => 
								array (
									0 => 
										array (
											'name' => 'trigger_type',
										),
									1 => 
										array (
											'name' => 'type',
											'label' => 'LBL_TYPE',
										),
								),
							3 => 
								array (
									0 => 
										array (
											'name' => 'trigger_event',
										),
									1 => 
										array (
											'name' => 'scheduled_type',
										),
								),
							4 => 
								array (
									0 => 
										array (
											'name' => 'subprocess_type',
										),
									1 => '',
								),
							5 => 
								array (
									0 => 
										array (
											'name' => 'description',
											'customCode' => '
																{php} 
																	require_once("modules/asol_Process/customFields/description.php");
																{/php}
															',
										),
									1 => 
										array (
											'name' => 'asol_process_asol_events_name',
										),
								),
						),
				),
		),
);
?>
