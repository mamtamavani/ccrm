<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Creates demo data for the team table
 *
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2010 SugarCRM Inc.
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



class TeamDemoData {
	var $_team;
	var $_large_scale_test;
	var $guids = array(
		'jim'	=> 'seed_jim_id',
		'sarah'	=> 'seed_sarah_id',
		'sally'	=> 'seed_sally_id',
		'max'	=> 'seed_max_id',
		'will'	=> 'seed_will_id',
		'chris'	=> 'seed_chris_id',
	/*
	 * Pending fix of demo data mechanism
		'jim'	=> 'jim00000-0000-0000-0000-000000000000',
		'sarah'	=> 'sarah000-0000-0000-0000-000000000000',
		'sally'	=> 'sally000-0000-0000-0000-000000000000',
		'max'	=> 'max00000-0000-0000-0000-000000000000',
		'will'	=> 'will0000-0000-0000-0000-000000000000',
		'chris'	=> 'chris000-0000-0000-0000-000000000000',
	*/
	);

	/**
	 * Constructor for creating demo data for teams
	 */
	function TeamDemoData($seed_team, $large_scale_test = false)
	{
		$this->_team = $seed_team;
		$this->_large_scale_test = $large_scale_test;
	}
	
	/**
	 * 
	 */
	function create_demo_data() {
		global $current_language;
		global $sugar_demodata;
		foreach($sugar_demodata['teams'] as $v)
		{
			if (!$this->_team->retrieve($v['team_id']))
			$this->_team->create_team($v['name'], $v['description'], $v['team_id']);
		}

		if($this->_large_scale_test)
		{
			$team_list = $this->_seed_data_get_team_list();
			foreach($team_list as $team_name)
			{
				$this->_quick_create($team_name);
			}
		}
		
		$this->add_users_to_team();
	}

	function add_users_to_team() {
		// Create the west team memberships
		$this->_team->retrieve("West");
		$this->_team->add_user_to_team($this->guids['sarah']);
		$this->_team->add_user_to_team($this->guids['sally']);
		$this->_team->add_user_to_team($this->guids["max"]);

		// Create the east team memberships
		$this->_team->retrieve("East");
		$this->_team->add_user_to_team($this->guids["will"]);
		$this->_team->add_user_to_team($this->guids['chris']);
	}
	
	/**
	 * 
	 */
	function get_random_team()
	{
		$team_list = $this->_seed_data_get_team_list();
		$team_list_size = count($team_list);
		$random_index = mt_rand(0,$team_list_size-1);
		
		return $team_list[$random_index];
	}
	
	/**
	 * 
	 */
	function _seed_data_get_team_list()
	{
		$teams = Array();
//bug 28138 todo
		$teams[] = "north";
		$teams[] = "south";
		$teams[] = "east";
		$teams[] = "west";
		$teams[] = "left";
		$teams[] = "right";
		$teams[] = "in";
		$teams[] = "out";
		$teams[] = "fly";
		$teams[] = "walk";
		$teams[] = "crawl";
		$teams[] = "pivot";
		$teams[] = "money";
		$teams[] = "dinero";
		$teams[] = "shadow";
		$teams[] = "roof";
		$teams[] = "sales";
		$teams[] = "pillow";
		$teams[] = "feather";

		return $teams;
	}
	
	/**
	 * 
	 */
	function _quick_create($name)
	{
		if (!$this->_team->retrieve($name))
		{
			$this->_team->create_team($name, $name, $name);
		}
	}
	
	
}
?>
