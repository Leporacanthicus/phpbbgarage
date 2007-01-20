<?php
/***************************************************************************
 *                              class_garage_service.php
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

class garage_service
{
	var $classname = "garage_service";

	/*========================================================================*/
	// Inserts Service Into DB
	// Usage: insert_service(array());
	/*========================================================================*/
	function insert_service($data)
	{
		global $cid, $db;

		$sql = 'INSERT INTO ' . GARAGE_SERVICE_HISTORY_TABLE . ' ' . $db->sql_build_array('INSERT', array(
			'vehicle_id'	=> $cid,
			'garage_id'	=> $data['garage_id'],
			'type_id' 	=> $data['type_id'],
			'price' 	=> $data['price'],
			'rating' 	=> $data['rating'],
		       	'mileage' 	=> $data['mileage'],
			'date_created'	=> time(),
			'date_updated'	=> time(),
		));

		$db->sql_query($sql);

		return $db->sql_nextid();
	}

	/*========================================================================*/
	// Updates Service In DB
	// Usage: update_service(array());
	/*========================================================================*/
	function update_service($data)
	{
		global $db, $cid, $svid;

		$update_sql = array(
			'vehicle_id'	=> $cid,
			'garage_id'	=> $data['garage_id'],
			'type_id' 	=> $data['type_id'],
			'price' 	=> $data['price'],
			'rating' 	=> $data['rating'],
		       	'mileage' 	=> $data['mileage'],
			'date_updated'	=> time()
		);

		$sql = 'UPDATE ' . GARAGE_SERVICE_HISTORY_TABLE . '
			SET ' . $db->sql_build_array('UPDATE', $update_sql) . "
			WHERE id = $svid AND vehicle_id = $cid";

		$db->sql_query($sql);

		return;
	}

	/*========================================================================*/
	// Delete Service Entry Including Image 
	// Usage: delete_service('service id');
	/*========================================================================*/
	function delete_service($qmid)
	{
		global $garage, $garage_image;
	
		$garage->delete_rows(GARAGE_SERVICE_HISTORY_TABLE, 'id', $svid);

		return ;
	}

	/*========================================================================*/
	// Select Service Data By Service ID
	// Usage: get_service('service id');
	/*========================================================================*/
	function get_service($svid)
	{
		global $db;

		$data = null;

		$sql = $db->sql_build_query('SELECT', 
			array(
			'SELECT'	=> 's.*, b.title',
			'FROM'		=> array(
				GARAGE_SERVICE_HISTORY_TABLE	=> 's',
			),
			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array(GARAGE_BUSINESS_TABLE => 'b'),
					'ON'	=> 's.garage_id = b.id'
				)
			),
			'WHERE'		=> 	"s.id = $svid"
		));

      		$result = $db->sql_query($sql);
		$data = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		return $data;
	}

	/*========================================================================*/
	// Select Service Data By Vehicle ID
	// Usage: get_services_by_vehicle('garage id');
	/*========================================================================*/
	function get_services_by_vehicle($cid)
	{
		global $db;

		$data = null;

		$sql = $db->sql_build_query('SELECT', 
			array(
			'SELECT'	=> 's.*, b.title',
			'FROM'		=> array(
				GARAGE_SERVICE_HISTORY_TABLE	=> 's',
			),
			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array(GARAGE_BUSINESS_TABLE => 'b'),
					'ON'	=> 's.garage_id = b.id'
				)
			),
			'WHERE'		=> 	"s.vehicle_id = $cid",
			'ORDER_BY'	=>	's.mileage DESC'
		));
	
	       	$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$data[] = $row;
		}
		$db->sql_freeresult($result);

		return $data;
	}

	/*========================================================================*/
	// Returns Lang String For Service Type
	// Usage: get_service_type();
	/*========================================================================*/
	function get_service_type($id)
	{
		global $user;

		if ($id == SERVICE_MAJOR)
		{
			return $user->lang['SERVICE_MAJOR'];
		}
		else if ($id == SERVICE_MINOR)
		{
			return $user->lang['SERVICE_MINOR'];
		}
	}
}

$garage_service = new garage_service();

?>
