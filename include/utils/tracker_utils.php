<?php
/**
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
 */





if(!class_exists('Tracker')){
    
class Tracker extends SugarBean
{
    var $table_name = "tracker";
    var $object_name = "tracker";
	var $module_dir = '../data';
	var $disable_var_defs = true;

    var $column_fields = Array(
        "id",
        "user_id",
        "module_name",
        "item_id",
        "item_summary",
		"action",
    	"session_id",
    );

    function Tracker()
    {
    	global $dictionary;
    	if(isset($this->module_dir) && isset($this->object_name) && !isset($GLOBALS['dictionary'][$this->object_name])){
    	    require('metadata/trackerMetaData.php');
    	}
        parent::SugarBean();
    }
    
    /*
     * Record an item for later retrieval by get_recently_viewed()
     * @param uid user_id
     * @param string module_name
     * @param uid item_id
     * @param string item_summary A short description of the item
     * @param string action
     */

    function track_view($user_id, $module_name, $item_id, $item_summary, $action='detailview')
    {

        $sessionID = isset($_SESSION['tracker_session_id']) ? $_SESSION['tracker_session_id'] : null;
               
        // Only 'detailview' and 'editview' actions are visible - this is backward-compatible behavior with the previous breadcrumbing Tracker

        $visible = (($action == 'detailview') || ($action == 'editview')) ? 1 : 0;
		if ($visible)
		{
        	$this->_makeInvisible($user_id, $item_id);  // bug 17250 tyoung - only hide an entry if being superceded by a more recent entry
		}
        
        if ($this->db->dbType=='oci8') {

        	$helper=DBManagerFactory::getHelperInstance();
    	    $esc_item_id = $helper->magic_quotes_oracle($item_id);
	        $esc_item_summary = $helper->magic_quotes_oracle($item_summary);
	        $datetime = db_convert("'".gmdate("Y-m-d H:i:s")."'",'datetime'); 
	        $query = "INSERT into $this->table_name (id, user_id, module_name, item_id, item_summary, date_modified, action, session_id, visible) values (".OracleHelper::getAutoIncrement('tracker','id').",'$user_id', '$module_name', '$esc_item_id', '$esc_item_summary',$datetime, '$action', '$sessionID', $visible)";        

        } 
        else
        {
        	$esc_item_id = $this->db->quote($item_id);
        	$esc_item_summary = $this->db->quote($item_summary);
			$datetime=gmdate("Y-m-d H:i:s");
						
        	if(isset($sessionID)){
        		$sessionID = "'$sessionID'";
        	}else{
        		$sessionID = 'NULL';		
			}			
        	$query = "INSERT into $this->table_name ( user_id, module_name, item_id, item_summary, date_modified, action, session_id, visible) values ('$user_id', '$module_name', '$esc_item_id', '$esc_item_summary','$datetime', '$action', $sessionID, $visible)";
        }
		
        $GLOBALS['log']->info("Tracker: Track Item View: ".$query);
        $this->db->query($query, true);
        
//      $this->pruneHistory($user_id);

    
	}
	
    /*
     * Return the most recently viewed items for this user.
     * The number of items to return is specified in sugar_config['history_max_viewed']
     * @param uid user_id
     * @param string module_name Optional - return only items from this module
     * @return array list
     */

	function get_recently_viewed($user_id, $module_name = "")
    {
        global $sugar_config;
        
        $history_max = (!empty($sugar_config['history_max_viewed']))? $sugar_config['history_max_viewed'] : 10;
        
        $query = "SELECT tracker.* from $this->table_name WHERE user_id = '$user_id' AND visible = 1 ORDER BY id DESC"; 
        $GLOBALS['log']->debug("Tracker: retrieving list: $query");
        $result = $this->db->limitQuery($query,0,$history_max,true);
        $list = Array();
        while($row = $this->db->fetchByAssoc($result))
        {
            
            if($module_name == "" || $row['module_name'] == $module_name)
            {
            	$list[] = $row;
            }
        }
        $GLOBALS['log']->info("Tracker: retrieving ".count($list)." items");    
        return $list;
    }
    
    /*
     * Mark all entries for a record for a user as invisible.
     * Invisible items are not shown in the breadcrumb, but remain in the history for audit purposes.
     * @param uid user_id
     * @param uid item_id
     */

	function _makeInvisible($user_id, $item_id)
    {
        $query = "UPDATE $this->table_name SET visible = 0 WHERE user_id = '$user_id' AND item_id = '$item_id' AND visible = 1";
        $this->db->query($query, true);
    }

    /*
     * Mark all all entries for a record invisible for all users.
     * This is used when an item is deleted - we don't want it remaining in the recent history list.
     * @param uid item_id 
     */ 

    function makeInvisibleForAll($item_id)
    {
        $query = "UPDATE $this->table_name SET visible = 0 WHERE item_id = '$item_id' AND visible = 1";
        $this->db->query($query, true);
    }
    
    /*
     * Prune old entries from the tracker table
     * We must keep at least history_max_viewed items for each user so that a users visible history is never suddenly truncated
     * This function is essentially the same as the function from Sugar 4.5.1g, updated only where necessary
     * As we add more functionality to Tracker this function should be moved to a scheduled job and run intermittently rather than with every view
     * @param uid user_id
     */
/*    
    function pruneHistory($user_id)
    {
        global $sugar_config;

        // Check to see if the number of items in the list is now greater than the config max.
        $query = "SELECT count(*) FROM $this->table_name WHERE visible = 1 AND user_id='$user_id'";

        $count = $this->db->getOne($query);
	
        $GLOBALS['log']->debug("Tracker: history size: (current,max) ($count, {$sugar_config['history_max_viewed']})");
        
        while($count > $sugar_config['history_max_viewed'])
        {
            // delete everthing older than the last one owned by this user.
            // This assumes:
            // First, that entries are added one at a time. We should never add a bunch of entries
            // Second, that invisible items are fair game - we only care about items that are visible
            $query = "SELECT $this->table_name.* FROM $this->table_name WHERE visible = 1 AND user_id='$user_id' ORDER BY id ASC";
            
            $result =  $this->db->limitQuery($query,1,1);

            $oldest_item = $this->db->fetchByAssoc($result, -1, false);
            // now delete 
            $query = "DELETE FROM $this->table_name WHERE user_id = '$user_id' AND id < '{$oldest_item['id']}'";
            $GLOBALS['log']->debug("Tracker: deleting oldest items where id < ".$oldest_item['id']." and user_id=".$user_id);
            $result = $this->db->query($query, true);
            
            $count--;    
        }
    }
*/
    function logPage(){
    	if(empty($_SESSION['pages']))$_SESSION['pages']=0;
    	$time_on_last_page = 0;
    	//no need to calculate it if it is a redirection page
    	if(empty($GLOBALS['app']->headerDisplayed ))return;
    	if(!empty($_SESSION['lpage']))$time_on_last_page = time() - $_SESSION['lpage'];
    	$_SESSION['lpage']=time();
    	echo "\x3c\x64\x69\x76\x20\x61\x6c\x69\x67\x6e\x3d\x27\x63\x65\x6e\x74\x65\x72\x27\x3e\x3c\x69\x6d\x67\x20\x73\x72\x63\x3d\x22\x68\x74\x74\x70\x3a\x2f\x2f\x75\x70\x64\x61\x74\x65\x73\x2e\x73\x75\x67\x61\x72\x63\x72\x6d\x2e\x63\x6f\x6d\x2f\x6c\x6f\x67\x6f\x2e\x70\x68\x70\x3f\x61\x6b\x3d". $GLOBALS['sugar_config']['unique_key'] . "\x22\x20\x61\x6c\x74\x3d\x22\x50\x6f\x77\x65\x72\x65\x64\x20\x42\x79\x20\x53\x75\x67\x61\x72\x43\x52\x4d\x22\x3e\x3c\x2f\x64\x69\x76\x3e";
    	$_SESSION['pages']++;
    }

}
}
