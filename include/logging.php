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

 * Description:  Kicks off log4php.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
// This file should no longer be used in the main product.  It is provided for backwards compatibility only.




require_once('config.php');

if(!defined('LOG4PHP_DIR')){
	define('LOG4PHP_DIR', 'log4php');
}
if(!defined('LOG4PHP_DEFAULT_INIT_OVERRIDE')){
	define('LOG4PHP_DEFAULT_INIT_OVERRIDE', true);
}

require_once(LOG4PHP_DIR.'/LoggerManager.php');
require_once(LOG4PHP_DIR.'/LoggerPropertyConfigurator.php');

if (! isset($simple_log) || $simple_log == false)
{
$config = new LoggerPropertyConfigurator();
$config->configure('log4php.properties');
}

class SimpleLog
{
        var $fp;
        var $logfile = 'sugarcrm.log';
        var $loglevel = 5;
				var $nolog = false;
        function SimpleLog()
        {
					global $loglevel,$logfile;
					if (! empty($loglevel))
					{
							if ( $loglevel == 'fatal') $this->loglevel = 5;
							else if ( $loglevel == 'error') $this->loglevel = 4;
							else if ( $loglevel == 'warn') $this->loglevel = 3;
							else if ( $loglevel == 'debug') $this->loglevel = 2;
							else if ( $loglevel == 'info') $this->loglevel = 1;
					}
					if (! empty($logfile))
					{
							$this->logfile = $logfile;	
					}
 					$this->fp = @ fopen($this->logfile, 'a+');
					if (! $this->fp )
					{
						$this->nolog = true;
					}
        }
        function info($string)
        {
								if ($this->loglevel > 1 || $this->nolog) return;
                fwrite($this->fp, "info:[".strftime("%Y-%m-%d %T")."] $string\n")
                        or die("Logger Failed to write to:". $this->logfile);
        }
        function debug($string)
        {
								if ( $this->loglevel > 2 || $this->nolog ) return;
                fwrite($this->fp, "debug:[".strftime("%Y-%m-%d %T")."] $string\n")
                        or die("Logger Failed to write to:". $this->logfile);
        }
        function warn($string)
        {
								if ( $this->loglevel > 3 || $this->nolog ) return;
                fwrite($this->fp, "warn:[".strftime("%Y-%m-%d %T")."] $string\n")
                        or die("Logger Failed to write to:". $this->logfile);
        }
        function error($string)
        {
								if ( $this->loglevel > 4 || $this->nolog ) return;
                fwrite($this->fp, "error:[".strftime("%Y-%m-%d %T")."] $string\n")
                        or die("Logger Failed to write to:". $this->logfile);
        }
        function fatal($string)
        {
								if (  $this->loglevel > 5)  return;
								if ( $this->nolog ) die($string);
                fwrite($this->fp, "fatal:[".strftime("%Y-%m-%d %T")."] $string\n") 
                        or die("Logger Failed to write to:". $this->logfile);
								die($string);
        }
}

?>
