<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
$dictionary['tracker'] = array(
    'table' => 'tracker',
    'fields' => array(
        array(
            'name' => 'id',
            'type' => 'int',
            'len' => '11',
            'isnull' => 'false',
            'auto_increment' => true
        ) ,
        array(
            'name' => 'user_id',
            'type' => 'varchar',
            'len' => '36',
            'isnull' => 'false',
        ) ,
        array(
            'name' => 'module_name',
            'type' => 'varchar',
            'len' => '255',
            'isnull' => 'false',
        ) ,
        array(
            'name' => 'item_id',
            'type' => 'varchar',
            'len' => '36',
            'isnull' => 'false',
        ) ,
        array(
            'name' => 'item_summary',
            'type' => 'varchar',
            'len' => '255',
            'isnull' => 'false',
        ) ,
        array(
            'name' => 'date_modified',
            'type' => 'datetime',
            'isnull' => 'false',
        ) ,
        array(
            'name' => 'action',
            'type' => 'varchar',
            'len' => '255',
            'isnull' => 'false',
        ) ,
        array(
            'name' => 'session_id',
            'type' => 'int',
            'len' => '11',
            'isnull' => 'false',
        ) ,
        array(
            'name' => 'visible',
            'type' => 'bool',
            'len' => '1',
            'default' => '0'
        ) ,
    ) ,
    'indices' => array(
        array(
            'name' => 'trackerpk',
            'type' => 'primary',
            'fields' => array(
                'id'
            )
        ) ,
        array(
            'name' => 'idx_tracker_iid',
            'type' => 'index',
            'fields' => array(
                'item_id',
            ),
        ),
        array(
            // shortened name to comply with Oracle length restriction
            'name' => 'idx_tracker_userid_vis_id',
            'type' => 'index',
            'fields' => array(
                'user_id',
                'visible',
                'id',
            ),
        ),
        array(
        	// shortened name to comply with Oracle length restriction
            'name' => 'idx_tracker_userid_itemid_vis',
            'type' => 'index',
            'fields' => array(
                'user_id',
                'item_id',
                'visible'
            ),
        ),
    )
);
