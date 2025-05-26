<?php

require_once('modules/asol_Project/asolProjectUtils.php');

global $sugar_config, $current_user;

// Mandatory for not-crm access
$PM_absoluteUrlForAjaxRequests = (isset($sugar_config['PM_absoluteUrlForAjaxRequests'])) ? $sugar_config['PM_absoluteUrlForAjaxRequests'] : false;
$PM_absoluteUrlForAjaxRequests = false; // Only relative.
$site_url = (isset($sugar_config['asolProject_site_url'])) ? $sugar_config['asolProject_site_url'] : $sugar_config['site_url'];
$site_url = str_replace(array('https:', 'http:'), array('', ''), $site_url);// Avoid Blocked loading mixed active content
$ganttModule = $_REQUEST['module'];
$asolProjectId = ($ganttModule == 'asol_Project') ?  $_REQUEST['record'] : '';
$asolProjectVersionId = ($ganttModule == 'asol_ProjectVersion') ?  $_REQUEST['record'] : '';

// Not-mandatory for not-crm access
$intervalMinutesAutosave = (isset($sugar_config['intervalMinutesAutosave'])) ? $sugar_config['intervalMinutesAutosave'] : 5;
$intervalMinutesKeepAliveEditMode = (isset($sugar_config['intervalMinutesKeepAliveEditMode'])) ? $sugar_config['intervalMinutesKeepAliveEditMode'] : 1;
//
$PM_defaultFormatIfAutomaticIsEmpty = (isset($sugar_config['PM_defaultFormatIfAutomaticIsEmpty'])) ? $sugar_config['PM_defaultFormatIfAutomaticIsEmpty'] : 'Y-m-d';
$Date_defaultFormat = $current_user->getPreference('datef');
$Date_defaultFormat = (!empty($Date_defaultFormat)) ? $Date_defaultFormat : $PM_defaultFormatIfAutomaticIsEmpty;
$Date_defaultFormat = str_replace(array('Y', 'm', 'd'), array('yyyy', 'MM', 'dd'), $Date_defaultFormat);
//
$PM_firstDayOfWeekIfAutomaticIsEmpty = (isset($sugar_config['PM_firstDayOfWeekIfAutomaticIsEmpty'])) ? $sugar_config['PM_firstDayOfWeekIfAutomaticIsEmpty'] : 0;
$Date_firstDayOfWeek = $current_user->getPreference('fdow');
$Date_firstDayOfWeek = (($Date_firstDayOfWeek !== null) && ($Date_firstDayOfWeek !== '') && (is_numeric($Date_firstDayOfWeek))) ? $Date_firstDayOfWeek : $PM_firstDayOfWeekIfAutomaticIsEmpty;

// Not-mandatory
$adjustParentToChildrenDuration = (isset($sugar_config['adjustParentToChildrenDuration'])) ? $sugar_config['adjustParentToChildrenDuration'] : true;
$isEnterpriseEdition = (asolProjectUtils::hasPremiumFeatures()) ? 'true' : 'false';

// Not needed
$Number_decimalSeparator = $current_user->getPreference('dec_sep');
$Number_groupingSeparator = $current_user->getPreference('num_grp_sep');

// Get javascript language script.
echo asolProjectUtils::_getModLanguageJS('asol_Project');

?>

<script>

document.getElementById("jquery_gantt_label").parentNode.style.display = "none";

// Mandatory for not-crm access
var PM_absoluteUrlForAjaxRequests = <?php echo ($PM_absoluteUrlForAjaxRequests) ? 'true' : 'false'; ?>;
var site_url = '<?php echo $site_url; ?>';
var asolProjectId = '<?php echo $asolProjectId; ?>';
var asolProjectVersionId = '<?php echo $asolProjectVersionId; ?>';

// Not-mandatory for not-crm access
var intervalMinutesAutosave = <?php echo $intervalMinutesAutosave; ?>;
var intervalMinutesKeepAliveEditMode = <?php echo $intervalMinutesKeepAliveEditMode; ?>;
var Date_defaultFormat = '<?php echo $Date_defaultFormat; ?>';
var Date_firstDayOfWeek = <?php echo $Date_firstDayOfWeek; ?>;
var entryPoint = 'ganttServerCanEditMode';

// Not-mandatory
var adjustParentToChildrenDuration = <?php echo (($adjustParentToChildrenDuration) ? 'true' : 'false'); ?>;
var isEnterpriseEdition = <?php echo $isEnterpriseEdition; ?>;
<?php 
	if (isset($sugar_config['PM_holidays'])) {
		echo "
			var PM_holidays = '{$sugar_config['PM_holidays']}';
		";
	}
?>

// Not needed
// var Number_decimalSeparator = '<?php echo $Number_decimalSeparator; ?>';
// var Number_groupingSeparator = '<?php echo $Number_groupingSeparator; ?>';

</script>

<div id="iframe_container">
	<iframe id="myiframe" name="myiframe" src="index.php?entryPoint=gantt"
		height="302px" width="100%" frameborder="0"></iframe>
</div>
