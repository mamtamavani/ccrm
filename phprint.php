<?php
 if(!defined('sugarEntry'))define('sugarEntry', true);
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

 * Description: Main file and starting point for the application.  Calls the
 * theme header and footer files defined for the user as well as the module as
 * defined by the input parameters.
 ********************************************************************************/
require_once('include/entryPoint.php');
$query_string = "";
foreach ($_GET as $key => $val) {
	if ($key != "print") {
		if (is_array($val)) {
			foreach ($val as $k => $v) {
				$query_string .= "{$key}[{$k}]=" . urlencode($v) . "&";
			}
		}
		else {
			$query_string .= "{$key}=" . urlencode($val) . "&";
		}
	}
}

$url = "{$_SERVER['PHP_SELF']}?{$query_string}";

?>
<html>
<head>
<script language="JavaScript">
function doNothing() {return true;}
window.onerror=doNothing;
</script>
<style type="text/css" media="all">
BODY { font-family: Arial, Helvetica, sans-serif; }
</style>
</head>

<body>
<a href="<?php echo $url; ?>"><< <?php echo $app_strings['LBL_BACK']; ?></a><br><br>
<?php
echo $page_arr[1];
?>
<br><br><a href="<?php echo $url; ?>"><< <?php echo $app_strings['LBL_BACK']; ?></a>
</body>
</html>
