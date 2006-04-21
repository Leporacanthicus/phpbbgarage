<?php
/***************************************************************************
 *                              functions_garage.php
 *                            -------------------
 *   begin                : Friday, 06 May 2005
 *   copyright            : (C) Esmond Poynton
 *   email                : esmond.poynton@gmail.com
 *   description          : Provides Vehicle Garage System For phpBB
 *
 *   $Id$
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

// Build Up Garage Config...We Will Use These Values Many A Time
$sql = "SELECT config_name, config_value FROM ". GARAGE_CONFIG_TABLE;

if(!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, "Could not query Garage config information", "", __LINE__, __FILE__, $sql);
}

while( $row = $db->sql_fetchrow($result) )
{
	$garage_config_name = $row['config_name'];
	$garage_config_value = $row['config_value'];
	$garage_config[$garage_config_name] = $garage_config_value;
}

//Setup Arrays Used To Build Drop Down Selection Boxes
$currency_types = array('GBP', 'USD', 'EUR', 'CAD', 'YEN');
$mileage_unit_types = array($lang['Miles'], $lang['Kilometers']);
$boost_types = array('PSI', 'BAR');
$power_types = array($lang['Wheel'], $lang['Hub'], $lang['Flywheel']);
$cover_types = array($lang['Third_Party'], $lang['Third_Party_Fire_Theft'], $lang['Comprehensive'], $lang['Comprehensive_Classic'], $lang['Comprehensive_Reduced']);
$rating_types = array( '10', '9', '8', '7', '6', '5', '4', '3', '2', '1');
$rating_text = array( '10', '9', '8', '7', '6', '5', '4', '3', '2', '1');
$nitrous_types = array('0', '25', '50', '75', '100');
$nitrous_types_text = array($lang['No_Nitrous'], $lang['25_BHP_Shot'], $lang['50_BHP_Shot'], $lang['75_BHP_Shot'], $lang['100_BHP_Shot']);

class garage 
{

	var $classname = "garage";

	/*========================================================================*/
	// Makes Safe Any Posted Variables
	// Usage: process_post_vars(array());
	/*========================================================================*/
	function process_post_vars($params = array())
	{
		global $HTTP_POST_VARS, $HTTP_GET_VARS;

		while( list($var, $param) = @each($params) )
		{
			if (!empty($HTTP_POST_VARS[$param]))
			{
				$data[$param] = str_replace("\'", "''", trim(htmlspecialchars($HTTP_POST_VARS[$param])));
			}
			else if (!empty($HTTP_GET_VARS[$param]))
			{
				$data[$param] = str_replace("\'", "''", trim(htmlspecialchars($HTTP_GET_VARS[$param])));
			}
		}

		return $data;
	}

	/*========================================================================*/
	// Makes Safe Any Posted Int Variables
	// Usage: process_int_vars(array());
	/*========================================================================*/
	function process_int_vars($params = array())
	{
		global $HTTP_POST_VARS, $HTTP_GET_VARS;

		while( list($var, $param) = @each($params) )
		{
			if (!empty($HTTP_POST_VARS[$param]))
			{
				$data[$param] = intval($HTTP_POST_VARS[$param]);
			}
			else if (!empty($HTTP_GET_VARS[$param]))
			{
				$data[$param] = intval($HTTP_GET_VARS[$param]);
			}
		}

		return $data;
	}

	/*========================================================================*/
	// Makes Safe Any Posted String Variables
	// Usage: process_str_vars(array());
	/*========================================================================*/
	function process_str_vars($params = array())
	{
		global $HTTP_POST_VARS, $HTTP_GET_VARS;

		while( list($var, $param) = @each($params) )
		{
			if (!empty($HTTP_POST_VARS[$param]))
			{
				$data[$param] = str_replace("\'", "''", trim(htmlspecialchars($HTTP_POST_VARS[$param])));
			}
			else if (!empty($HTTP_GET_VARS[$param]))
			{
				$data[$param] = str_replace("\'", "''", trim(htmlspecialchars($HTTP_GET_VARS[$param])));
			}
		}

		return $data;
	}

	/*========================================================================*/
	// Check All Required Variables Have Data
	// Usage: check_required_vars(array());
	/*========================================================================*/
	function check_required_vars($params = array())
	{
		global $SID, $phpEx, $data;

		while( list($var, $param) = @each($params) )
		{
			if (empty($data[$param]))
			{
				redirect(append_sid("garage.$phpEx?mode=error&EID=3", true));
			}
		}

		return ;
	}

	/*========================================================================*/
	// Check All Required Variables Have Data Within The ACP
	// Usage: check_acp_required_vars(array(), message);
	/*========================================================================*/
	function check_acp_required_vars($params = array(), $message)
	{
		global $data;

		while( list($var, $param) = @each($params) )
		{
			if (empty($data[$param]))
			{
				message_die(GENERAL_MESSAGE, $message);
			}
		}

		return ;
	}

	/*========================================================================*/
	// Count The Total Views The Garage Has Recieved
	// Usage: count_total_views();
	/*========================================================================*/
	function count_total_views()
	{
		global $db;

		// Get the total count of vehicles and views in the garage
        	$sql ="SELECT SUM(views) AS total_views FROM " . GARAGE_TABLE;
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error Counting Views', '', __LINE__, __FILE__, $sql);
		}
	        $row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		return $row['total_views'];
	}

	/*========================================================================*/
	// Update A Single Field For A Single Entry
	// Usage:  update_single_field('table name', 'set field' 'set value', 'where field', 'where value');
	/*========================================================================*/
	function update_single_field($table,$set_field,$set_value,$where_field,$where_value)
	{
		global $db;

		$sql = "UPDATE $table SET $set_field = '$set_value' WHERE $where_field = '$where_value'";

		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could Not Update Garage DB', '', __LINE__, __FILE__, $sql);
		}
	
		return;
	}

	/*========================================================================*/
	// Increment A Count Field In DB
	// Usage:  build_selection_box('table name', 'field to increment', 'where field' ,'where value');
	/*========================================================================*/
	function update_view_count($table, $set_field, $where_field, $where_value)
	{
		global $db;

		$sql = "UPDATE $table SET $set_field = $set_field + 1 WHERE $where_field = $where_value";

		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Could Not Update Count", '', __LINE__, __FILE__, $sql);
		}

		return;
	}

	/*========================================================================*/
	// Delete Row/Rows From DB
	// Usage:  build_selection_box('table name', 'where field', 'where value');
	/*========================================================================*/
	function delete_rows($table,$where_field,$where_value)
	{
		global $db;

		$sql = "DELETE FROM $table WHERE $where_field = '$where_value'";

		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could Not Update Garage DB', '', __LINE__, __FILE__, $sql);
		}

		return;
	}

	/*========================================================================*/
	// Checks A User Is Allowed Perform An Action
	// Usage: check_permissions('required permission'>, 'redirect url on failure');
	/*========================================================================*/
	function check_permissions($required_permission,$redirect_url)
	{
		global $userdata, $template, $db, $SID, $lang, $phpEx, $phpbb_root_path, $garage_config, $board_config;
	
		$required_permission = strtolower($required_permission);
	
		//Right Lets Start And Work Out Your User Level
		if ( $userdata['user_id'] == ANONYMOUS )
		{
			$your_level = 'GUEST';
		}
		else if ( $userdata['user_level'] == ADMIN )
		{
			$your_level = 'ADMIN';
		}
		else if ( $userdata['user_level'] == MOD )
		{
			$your_level = 'MOD';
		}
		else
		{
			$your_level = 'USER';
		}		
	
		if ($garage_config[$required_permission."_perms"] == '*')
		{
			//Looks Like Everyone Is Allowed Do This...So On Your Way
			return (TRUE);
		}	
		//Since Not Globally Allowed Lets See If Your Level Is Allowed For The Permission You Are Requesting
		else if (preg_match( "/$your_level/", $garage_config[$required_permission."_perms"]))
		{
			//Good News Your User Level Is Allowed
			return (TRUE);
		}
		//Right We Need To Resort And See If Private Is Set For This Required Permission And See If You Qualify
		else if (preg_match( "/PRIVATE/", $garage_config[$required_permission."_perms"]))
		{
			//Right We Need To See If You Are In Any User Group Granted This Permission
			$sql = "SELECT ug.group_id, g.group_name
	              		FROM " . USER_GROUP_TABLE . " AS ug, " . GROUPS_TABLE ." g
	                        WHERE ug.user_id = " . $userdata['user_id'] . "
					and ug.group_id = g.group_id and g.group_single_user <> " . TRUE ."
				ORDER BY g.group_name ASC";
	              	if( !($result = $db->sql_query($sql)) )
	       		{
	          		message_die(GENERAL_ERROR, 'Could Not Select Groups', '', __LINE__, __FILE__, $sql);
	       		}
	
			//Lets Populate An Array With All The Groups You Are Part Of
			while( $grouprow = $db->sql_fetchrow($result) )
			{
				$groupdata[] = $grouprow;
			}
	
			//Lets Get All Private Groups Granted This Permission
			$sql = "SELECT config_value as private_groups
				FROM ". GARAGE_CONFIG_TABLE ."
				WHERE config_name = 'private_".$required_permission."_perms'";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not get permissions', '', __LINE__, __FILE__, $sql);
			}
			$private_perms = $db->sql_fetchrow($result);
			$private_groups = @explode(',', $private_perms['private_groups']);
	
			for ($i = 0; $i < count($groupdata); $i++)
			{
				if (in_array($groupdata[$i]['group_id'], $private_groups))
				{
					return (TRUE);
				}
			}
		}
		//Looks Like You Are Out Of Look...You Are Not Allowed Perform The Action You Requested...
		if (!empty($redirect_url))
		{
			redirect(append_sid("$redirect_url", true));
		}
		//No URL To Redirect So We Will Just Return FALSE
		else
		{
			return (FALSE);
		}
	}

	/*========================================================================*/
	// Select All Category Data
	// Usage: select_category_data('vehicle id');
	/*========================================================================*/
	function select_category_data()
	{
		global $db;

		$sql = "SELECT *
			FROM " . GARAGE_CATEGORIES_TABLE . "
			ORDER BY field_order";

      		if ( !($result = $db->sql_query($sql)) )
      		{
         		message_die(GENERAL_ERROR, 'Could Not Select Category Data', '', __LINE__, __FILE__, $sql);
      		}

		while ($row = $db->sql_fetchrow($result) )
		{
			$data[] = $row;
		}
		$db->sql_freeresult($result);
	
		return $data;
	}

	/*========================================================================*/
	// Seed Random Number Generator
	// Usage: make_seed();
	/*========================================================================*/
	function make_seed()
	{
	   list($usec, $sec) = explode(' ', microtime());
	   return (float) $sec + ((float) $usec * 100000);
	}
	
}

$garage = new garage();

?>