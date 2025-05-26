<?php

require_once('modules/asol_Project/asolProjectUtils.php');

$app_list_strings['moduleList']['asol_ProjectManagementCommon'] = 'ProjectManagement Common';
$app_list_strings['moduleList']['asol_Project'] = 'AsolProyectos';
$app_list_strings['moduleList']['asol_ProjectTask'] = 'AsolTareasDeProyecto';
$app_list_strings['moduleList']['asol_ProjectVersion'] = 'AsolVersiónDeProyecto';

if (asolProjectUtils::$edition == 'SRM') {
	$app_list_strings['moduleList']['asol_Release'] = 'Releases';
	$app_list_strings['moduleList']['asol_Feature'] = 'Features';
	$app_list_strings['moduleList']['asol_Domains'] = 'Dominios';
	$app_list_strings['moduleList']['asol_TicketsN2'] = 'TicketsN2';
	$app_list_strings['moduleList']['asol_TicketsN3'] = 'TicketsN3';
	$app_list_strings['moduleList']['asol_Installation'] = 'Instalaciones';
	$app_list_strings['moduleList']['asol_Intervention'] = 'Intervenciones';
}

$app_list_strings['asol_release_status_list']['inactive'] = 'Inactivo';
$app_list_strings['asol_release_status_list']['active'] = 'Activo';
$app_list_strings['asol_release_status_list']['future'] = 'Futuro';

$app_list_strings['asol_release_product_list']['bss'] = 'BSS';
$app_list_strings['asol_release_product_list']['sdp'] = 'SDP';
$app_list_strings['asol_release_product_list']['crm'] = 'CRM';
$app_list_strings['asol_release_product_list']['billing'] = 'Facturación';
$app_list_strings['asol_release_product_list']['campaing_manager'] = 'Gestor Campañas';
$app_list_strings['asol_release_product_list']['data_mining'] = 'Data Mining';
$app_list_strings['asol_release_product_list']['core'] = 'Core';

$app_list_strings['asol_release_scope_list']['generic'] = 'Genérico';
$app_list_strings['asol_release_scope_list']['domain'] = 'Dominio';

$app_list_strings['asol_project_status_list']['draft'] = 'Borrador';
$app_list_strings['asol_project_status_list']['analysing'] = 'En análisis';
$app_list_strings['asol_project_status_list']['estimate'] = 'En estimación';
$app_list_strings['asol_project_status_list']['approved'] = 'Aprobado';
$app_list_strings['asol_project_status_list']['developing'] = 'En desarrollo';
$app_list_strings['asol_project_status_list']['released'] = 'Entregado';
$app_list_strings['asol_project_status_list']['canceled'] = 'Cancelado';
$app_list_strings['asol_project_status_list']['error'] = 'Error';

$app_list_strings['asol_project_priority_list']['1'] = '1';
$app_list_strings['asol_project_priority_list']['2'] = '2';
$app_list_strings['asol_project_priority_list']['3'] = '3';
$app_list_strings['asol_project_priority_list']['4'] = '4';
$app_list_strings['asol_project_priority_list']['5'] = '5';

$app_list_strings['asol_projecttask_status_list']['STATUS_ACTIVE'] = 'Activo';
$app_list_strings['asol_projecttask_status_list']['STATUS_DONE'] = 'Completado';
$app_list_strings['asol_projecttask_status_list']['STATUS_FAILED'] = 'Fallado';
$app_list_strings['asol_projecttask_status_list']['STATUS_SUSPENDED'] = 'Suspendido';
$app_list_strings['asol_projecttask_status_list']['STATUS_UNDEFINED'] = 'Indefinido';

$app_list_strings['asol_installation_type_list']['test'] = 'Test';
$app_list_strings['asol_installation_type_list']['production'] = 'Producción';

$app_list_strings['asol_installation_status_list']['on_hold'] = 'En espera';
$app_list_strings['asol_installation_status_list']['active'] = 'Activo';
$app_list_strings['asol_installation_status_list']['done'] = 'Finalizado';
$app_list_strings['asol_installation_status_list']['canceled'] = 'Cancelado';

$app_list_strings['asol_feature_status_list']['canceled'] = 'Cancelada';
$app_list_strings['asol_feature_status_list']['draft'] = 'Borrador';
$app_list_strings['asol_feature_status_list']['accepted'] = 'Aceptada';
$app_list_strings['asol_feature_status_list']['developing'] = 'En_desarrollo';
$app_list_strings['asol_feature_status_list']['active'] = 'Activa';
$app_list_strings['asol_feature_status_list']['degraded'] = 'Degradada';
$app_list_strings['asol_feature_status_list']['discontinuous'] = 'Discontinuada';

$app_list_strings['asol_feature_product_list']['bsscore'] = 'BSSCore';
$app_list_strings['asol_feature_product_list']['pdv'] = 'PdV';

$app_list_strings['asol_release_type_list']['new_functionality'] = 'Nueva Funcionalidad';
$app_list_strings['asol_release_type_list']['bug'] = 'Bug';
$app_list_strings['asol_release_type_list']['optimization'] = 'Optimización';

$app_list_strings['asol_feature_scope_list']['generic'] = 'Genérico';
$app_list_strings['asol_feature_scope_list']['domain'] = 'Dominio';

$app_list_strings['parent_type_display']['asol_Project'] = 'AsolProyecto';
$app_list_strings['parent_type_display']['asol_ProjectTask'] = 'AsolTareaDeProyecto';
$app_list_strings['record_type_display']['asol_Project'] = 'AsolProyecto';
$app_list_strings['record_type_display']['asol_ProjectTask'] = 'AsolTareaDeProyecto';

$app_list_strings['record_type_display_notes']['asol_Project'] = 'AsolProyecto';
$app_list_strings['record_type_display_notes']['asol_ProjectTask'] = 'AsolTareaDeProyecto';

$app_list_strings['asol_projectversion_type_list']['working_version'] = 'Versión de trabajo';
$app_list_strings['asol_projectversion_type_list']['last_published_version'] = 'Última versión publicada';
asolProjectUtils::addPremiumAppListStrings($app_list_strings, 'sp_ve', 'addAppListStrings_baseline');

// TRICK: DISABLE AJAX-UI
$sugar_config['addAjaxBannedModules'][] = "asol_Release";
$sugar_config['addAjaxBannedModules'][] = "asol_Project";
$sugar_config['addAjaxBannedModules'][] = "asol_ProjectTask";
$sugar_config['addAjaxBannedModules'][] = "asol_ProjectVersion";
$sugar_config['addAjaxBannedModules'][] = "asol_Installation";
$sugar_config['addAjaxBannedModules'][] = "asol_Intervention";
$sugar_config['addAjaxBannedModules'][] = "asol_Feature";
$sugar_config['addAjaxBannedModules'][] = "asol_Domains";
$sugar_config['addAjaxBannedModules'][] = "asol_TicketsN2";
$sugar_config['addAjaxBannedModules'][] = "asol_TicketsN3";
