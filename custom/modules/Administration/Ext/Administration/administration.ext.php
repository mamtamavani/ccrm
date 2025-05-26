<?php 
 //WARNING: The contents of this file are auto-generated


/*********************************************************************************
 * This file is part of QuickCRM Mobile Pro.
 * QuickCRM Mobile Pro is a mobile client for SugarCRM
 * 
 * Author : NS-Team (http://www.quickcrm.fr/mobile)
 * All rights (c) 2011 by NS-Team
 *
 * This Version of the QuickCRM Mobile Pro is licensed software and may only be used in 
 * alignment with the License Agreement received with this Software.
 * This Software is copyrighted and may not be further distributed without
 * witten consent of NS-Team
 * 
 * You can contact NS-Team at NS-Team - 55 Chemin de Mervilla - 31320 Auzeville - France
 * or via email at quickcrm@ns-team.fr
 * 
 ********************************************************************************/

$admin_option_defs=array();
$admin_option_defs['Administration']['quickcrm_update']= array('Administration','LBL_UPDATE_QUICKCRM_TITLE','LBL_UPDATE_QUICKCRM','./index.php?module=Administration&action=updatequickcrm');
$admin_group_header[]= array('LBL_QUICKCRM','',false,$admin_option_defs, '');





$admin_option_defs=array();
$admin_option_defs['Administration']['asol_reports_validations']= array('asol_Reports',translate('LBL_REPORT_CHECK_ACTION', 'asol_Reports'),translate('LBL_REPORT_CHECK_ACTION', 'asol_Reports'),'./index.php?module=asol_Reports&action=CheckConfigurationDefs');
$admin_group_header[]= array(translate('LBL_ASOL_REPORTS_TITLE', 'asol_Reports'),'',false,$admin_option_defs, translate('LBL_ASOL_REPORTS_PANEL_DESC', 'asol_Reports'));




$admin_option_defs=array();
$admin_option_defs['Administration']['asol_config']= array('asolAdministration','LBL_ASOL_CONFIG_TITLE','LBL_ASOL_CONFIG_DESC','./index.php?module=Administration&action=asolConfig');
$admin_option_defs['Administration']['asol_repair']= array('asolAdministration','LBL_ASOL_REPAIR_TITLE','LBL_ASOL_REPAIR_DESC','./index.php?module=Administration&action=asolRepair');

$admin_group_header[]= array('LBL_ASOL_CONFIG_TITLE','',false,$admin_option_defs, 'LBL_ASOL_ADMIN_PANEL_DESC');




//global $mod_strings;

$admin_option_defs=array();
$admin_option_defs['Administration']['asol_wfm'] = array('asolAdministration','LBL_ASOL_WORKFLOWMANAGER','LBL_ASOL_WORKFLOWMANAGER_DESC','./index.php?module=asol_Process&action=index');
$admin_option_defs['Administration']['asol_wfm_2'] = array('asolAdministration','LBL_ASOL_CLEANUP','LBL_ASOL_CLEANUP_DESC','./index.php?module=asol_Process&action=cleanup');
$admin_option_defs['Administration']['asol_wfm_3'] = array('asolAdministration','LBL_ASOL_MONITOR','LBL_ASOL_MONITOR_DESC','./index.php?module=asol_WorkingNodes&action=index');
$admin_option_defs['Administration']['asol_wfm_4'] = array('asolAdministration','LBL_ASOL_REBUILD','LBL_ASOL_REBUILD_DESC','./index.php?module=asol_Process&action=rebuild');
$admin_option_defs['Administration']['asol_wfm_5'] = array('asolAdministration','LBL_ASOL_CHECKCONFIGURATIONDEFS','LBL_ASOL_CHECKCONFIGURATIONDEFS_DESC','./index.php?module=asol_Process&action=CheckConfigurationDefs');
$admin_option_defs['Administration']['asol_wfm_6'] = array('asolAdministration','LBL_ABOUT_WFM','LBL_ABOUT_WFM_DESC','./index.php?module=asol_Process&action=About');

$admin_group_header[]= array('LBL_ASOL_WFM_PANEL','',false,$admin_option_defs, 'LBL_ASOL_WFM_PANEL_DESC');


?>