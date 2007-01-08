<?php
/***************************************************************************
 *                              garage.php
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

define('IN_PHPBB', true);

//Let's Set The Root Dir For phpBB And Load Normal phpBB Required Files
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/bbcode.' . $phpEx);

//Start Session Management
$user->session_begin();
$auth->acl($user->data);

//Setup Lang Files
$user->setup(array('mods/garage'));

//Build All Garage Classes e.g $garage_images->
require($phpbb_root_path . 'includes/mods/class_garage_business.' . $phpEx);
require($phpbb_root_path . 'includes/mods/class_garage_dynorun.' . $phpEx);
require($phpbb_root_path . 'includes/mods/class_garage_image.' . $phpEx);
require($phpbb_root_path . 'includes/mods/class_garage_insurance.' . $phpEx);
require($phpbb_root_path . 'includes/mods/class_garage_modification.' . $phpEx);
require($phpbb_root_path . 'includes/mods/class_garage_quartermile.' . $phpEx);
require($phpbb_root_path . 'includes/mods/class_garage_template.' . $phpEx);
require($phpbb_root_path . 'includes/mods/class_garage_vehicle.' . $phpEx);
require($phpbb_root_path . 'includes/mods/class_garage_guestbook.' . $phpEx);
require($phpbb_root_path . 'includes/mods/class_garage_model.' . $phpEx);

//Set The Page Title
$page_title = $user->lang['GARAGE'];

//Get All String Parameters And Make Safe
$params = array('mode' => 'mode', 'sort' => 'sort', 'start' => 'start', 'order' => 'order');
while(list($var, $param) = @each($params))
{
	$$var = request_var($param, '');
}

//Get All Non-String Parameters
$params = array('cid' => 'CID', 'mid' => 'MID', 'rrid' => 'RRID', 'qmid' => 'QMID', 'ins_id' => 'INS_ID', 'eid' => 'EID', 'image_id' => 'image_id', 'comment_id' => 'CMT_ID', 'bus_id' => 'BUS_ID');
while(list($var, $param) = @each($params))
{
	$$var = request_var($param, '');
}

//Build Inital Navlink...Yes Forum Name!! We Use phpBB3 Standard Navlink Process!!
$template->assign_block_vars('navlinks', array(
	'FORUM_NAME'	=> $user->lang['GARAGE'],
	'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}garage.$phpEx"))
);

//Display MCP Link If Authorised
$template->assign_vars(array(
	'U_MCP'	=> ($auth->acl_get('m_garage')) ? append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=garage', true, $user->session_id) : '')
);

//Decide What Mode The User Is Doing
switch( $mode )
{
	case 'add_insurance':

		//Let Check That Insurance Premiums Are Allowed...If Not Redirect
		if (!$garage_config['enable_insurance'])
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=18"));
		}

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_add_insurance'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Check Vehicle Ownership
		$garage_vehicle->check_ownership($cid);

		//Build Page Header ;)
		page_header($page_title);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.html',
			'body'   => 'garage_insurance.html')
		);

		//Get Data
		$insurance_business 	= $garage_business->get_business_by_type(BUSINESS_INSURANCE);

		//Build All Required HTML Components
		$garage_template->insurance_dropdown($insurance_business);
		$garage_template->cover_dropdown();
		$template->assign_vars(array(
			'L_TITLE' 		=> $user->lang['ADD_PREMIUM'],
			'L_BUTTON' 		=> $user->lang['ADD_PREMIUM'],
			'U_SUBMIT_BUSINESS' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=user_submit_business&amp;CID=$cid&amp;redirect=add_insurance&amp;BUSINESS=" . BUSINESS_INSURANCE),
			'CID' 			=> $cid,
			'S_MODE_ACTION' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=insert_insurance"))
		);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'insert_insurance':

		//Let Check That Insurance Premiums Are Allowed...If Not Redirect
		if (!$garage_config['enable_insurance'])
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=18"));
		}

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_add_insurance'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Check Vehicle Ownership
		$garage_vehicle->check_ownership($cid);

		//Get All Data Posted And Make It Safe To Use
		$params = array('business_id' => '', 'premium' => '', 'cover_type' => '', 'comments' => '');
		$data 	= $garage->process_vars($params);

		//Checks All Required Data Is Present
		$params = array('business_id', 'premium', 'cover_type');
		$garage->check_required_vars($params);

		//Insert The Insurnace Premium
		$garage_insurance->insert_premium($data);

		//Update Timestamp For Vehicle
		$garage_vehicle->update_vehicle_time($cid);

		redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_own_vehicle&amp;CID=$cid"));

	case 'edit_insurance':

		//Check The User Is Logged In...Else Send Them Off To Do So......And Redirect Them Back!!!
		if ($user->data['user_id'] == ANONYMOUS)
		{
			login_box("garage.$phpEx?mode=edit_insurance&amp;INS_ID=$ins_id&amp;CID=$cid");
		}

		//Check Vehicle Ownership
		$garage_vehicle->check_ownership($cid);

		//Build Page Header ;)
		page_header($page_title);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.html',
			'body'   => 'garage_insurance.html')
		);

		//Pull Required Insurance Premium Data From DB
		$data = $garage_insurance->get_premium($ins_id);
		$insurance_business = $garage_business->get_business_by_type(BUSINESS_INSURANCE);

		//Build Required HTML Components
		$garage_template->insurance_dropdown($insurance_business, $data['business_id']);
		$garage_template->cover_dropdown($data['cover_type']);
		$template->assign_vars(array(
			'L_TITLE' 		=> $user->lang['EDIT_PREMIUM'],
			'L_BUTTON' 		=> $user->lang['EDIT_PREMIUM'],
			'INS_ID' 		=> $ins_id,
			'CID' 			=> $cid,
			'PREMIUM' 		=> $data['premium'],
			'COMMENTS' 		=> $data['comments'],
			'S_MODE_ACTION' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=update_insurance"))
		);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'update_insurance':

		//Check Vehicle Ownership
		$garage_vehicle->check_ownership($cid);

		//Get All Data Posted And Make It Safe To Use
		$params = array('business_id' => '', 'premium' => '', 'cover_type' => '', 'comments' => '');
		$data = $garage->process_vars($params);

		//Checks All Required Data Is Present
		$params = array('business_id', 'premium', 'cover_type');
		$garage->check_required_vars($params);

		//Update The Insurance Premium With Data Acquired
		$garage_insurnace->update_premium($data);

		//Update Timestamp For Vehicle
		$garage_vehicle->update_vehicle_time($cid);

		redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_own_vehicle&amp;CID=$cid"));

		break;
	
	case 'delete_insurance':

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_delete_insurance'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Check Vehicle Ownership
		$garage_vehicle->check_ownership($cid);

		//Delete Insurance Premium
		$garage_insurance->delete_premium($ins_id);

		//Update Timestamp For Vehicle
		$garage_vehicle->update_vehicle_time($cid);

		redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_own_vehicle&amp;CID=$cid"));

		break;

	//Display Search Options Page...
	case 'search':

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_search'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=15"));
		}

		//Build Page Header ;)
		page_header($page_title);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' 	=> 'garage_header.html',
			'body'   	=> 'garage_search.html')
		);

		//Build Navlinks
		$template->assign_block_vars('navlinks', array(
			'FORUM_NAME'	=> $user->lang['SEARCH'],
			'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=search"))
		);

		//Get Years As Defined By Admin In ACP
		$years 		= $garage->year_list();
		$manufacturers 	= $garage_business->get_business_by_type(BUSINESS_PRODUCT);
		$makes 		= $garage_model->get_all_makes();
		$categories 	= $garage->get_categories();

		//Build All Required Javascript And Arrays
		$garage_template->category_dropdown($categories);
		$garage_template->year_dropdown($years);
		$garage_template->make_dropdown($makes);
		$garage_template->manufacturer_dropdown($manufacturers);
		$template->assign_vars(array(
			'U_FIND_USERNAME'		=> append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=searchuser&amp;form=search_garage&amp;field=username'),
			'UA_FIND_USERNAME'		=> append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=searchuser&form=search_garage&field=username', false),
			'S_DISPLAY_SEARCH_INSURANCE'	=> $garage_config['enable_insurance'],
			'S_MODE_ACTION_SEARCH' 		=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=search_results"))
		);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;


	// Browse & Quartermile Table & Dynorun Table Are Really Just A Search... ;)
	case 'browse':
	case 'quartermile_table':
	case 'dynorun_table':
	case 'search_results':

		if ($mode == 'browse')
		{
			$default_display = 'vehicles';
		}
		else if ($mode == 'quartermile_table')
		{
			$default_display = 'quartermiles';
		}
		elseif ($mode == 'dynorun_table')
		{
			$default_display = 'dynoruns';
		}

		$default_display = (empty($default_display)) ? '' : $default_display;

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_search'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=15"));
		}

		//Get All Data Posted And Make It Safe To Use
		$params		= array('search_year' => '', 'search_make' => '', 'search_model' => '', 'search_category' => '', 'search_manufacturer' => '', 'search_product' => '', 'search_username' => '', 'display_as' => $default_display, 'made_year' => '', 'make_id' => '', 'model_id' => '', 'category_id' => '', 'manufacturer_id' => '', 'product_id' => '', 'username' => '');
		$data 		= $garage->process_vars($params);

		//Set Required Values To Defaults If They Are Empty
		$start	= (empty($start)) ? '0' : $start;

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.html',
			'body'   => 'garage_search_results.html')
		);

		//Build Page Header ;)
		page_header($page_title);

		$template->assign_block_vars('navlinks', array(
			'FORUM_NAME'	=> $user->lang['SEARCH'],
			'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=search"))
		);

		//Lets Let The Search Function Do The Hard Work & Return Required Data
		$results_data = $garage->perform_search($data);

		//Depending On Search Results Required We Have Different Data To Pass To Template Engine
		if ($data['display_as'] == 'vehicles')
		{
			//Display Results As Vehicle
			$template->assign_vars(array(
				'S_DISPLAY_VEHICLE_RESULTS' 	=> true,
			));
			for ($i = 0, $count = sizeof($results_data); $i < $count; $i++)
			{
				//Provide Results To Template Engine
				$template->assign_block_vars('vehicle', array(
					'U_IMAGE'	=> ($results_data[$i]['attach_id']) ? append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_image&amp;image_id=" . $results_data[$i]['attach_id']) : '',
					'U_VIEW_VEHICLE'=> append_sid("{$phpbb_root_path}garage_vehicle.$phpEx", "mode=view_vehicle&amp;CID=" . $results_data[$i]['id']),
					'U_VIEW_PROFILE'=> append_sid("{$phpbb_root_path}profile.$phpEx", "mode=viewprofile&amp;u=" . $results_data[$i]['user_id']),
					'ROW_NUMBER' 	=> $i + ( $start + 1 ),
					'IMAGE'		=> $user->img('garage_vehicle_img_attached', 'VEHICLE_IMAGE_ATTACHED'),
					'YEAR' 		=> $results_data[$i]['made_year'],
					'MAKE' 		=> $results_data[$i]['make'],
					'COLOUR'	=> $results_data[$i]['colour'],
					'UPDATED'	=> $user->format_date($results_data[$i]['date_updated']),
					'VIEWS'		=> $results_data[$i]['views'],
					'MODS'		=> $results_data[$i]['total_mods'],
					'MODEL'		=> $results_data[$i]['model'],
					'OWNER'		=> $results_data[$i]['username'],
				));
			}
		}
		else if ($data['display_as'] == 'modifications')
		{
			//Display Results As Modifications
			$template->assign_vars(array(
				'S_DISPLAY_MODIFICATION_RESULTS'=> true,
			));
			for ($i = 0, $count = sizeof($results_data); $i < $count; $i++)
			{
				//Provide Results To Template Engine
				$template->assign_block_vars('modification', array(
					'U_IMAGE'		=> ($results_data[$i]['attach_id']) ? append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_image&amp;image_id=" . $results_data[$i]['attach_id']) : '',
					'U_VIEW_VEHICLE'	=> append_sid("{$phpbb_root_path}garage_vehicle.$phpEx", "mode=view_vehicle&amp;CID=" . $results_data[$i]['garage_id']),
					'U_VIEW_PROFILE'	=> append_sid("{$phpbb_root_path}profile.$phpEx", "mode=viewprofile&amp;u=" . $results_data[$i]['user_id']),
					'U_VIEW_MODIFICATION'	=> append_sid("{$phpbb_root_path}garage_modification.$phpEx", "mode=view_modification&amp;CID=" . $results_data[$i]['garage_id'] . "&amp;MID=" . $results_data[$i]['modification_id']),
					'IMAGE'			=> $user->img('garage_vehicle_img_attached', 'MODIFICATION_IMAGE_ATTACHED'),
					'VEHICLE'		=> $results_data[$i]['vehicle'],
					'MODIFICATION'		=> $results_data[$i]['modification_title'],
					'CATEGORY'		=> $results_data[$i]['category_title'],
					'USERNAME'		=> $results_data[$i]['username'],
					'PRICE'			=> $results_data[$i]['price'],
					'RATING'		=> $results_data[$i]['product_rating'],
				));
			}
		}
		else if ($data['display_as'] == 'premiums')
		{
			//Display Results As Premiums
			$template->assign_vars(array(
				'S_DISPLAY_PREMIUM_RESULTS' 	=> true,
			));
			for ($i = 0, $count = sizeof($results_data); $i < $count; $i++)
			{
				//Provide Results To Template Engine
				$template->assign_block_vars('premium', array(
					'U_VIEW_VEHICLE'	=> append_sid("{$phpbb_root_path}garage_vehicle.$phpEx", "mode=view_vehicle&amp;CID=" . $results_data[$i]['id']),
					'U_VIEW_PROFILE' 	=> append_sid("{$phpbb_root_path}profile.$phpEx", "mode=viewprofile&amp;u=" . $results_data[$i]['user_id']),
					'U_VIEW_BUSINESS' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_insurance_business&amp;business_id=" . $results_data[$i]['business_id']),
					'VEHICLE' 		=> $results_data[$i]['vehicle'],
					'USERNAME' 		=> $results_data[$i]['username'],
					'BUSINESS' 		=> $results_data[$i]['title'],
					'PRICE' 		=> $results_data[$i]['price'],
					'MOD_PRICE' 		=> $results_data[$i]['total_spent'],
					'PREMIUM' 		=> $results_data[$i]['premium'],
					'COVER_TYPE' 		=> $results_data[$i]['cover_type'],
				));
			}
		}
		else if ($data['display_as'] == 'quartermiles')
		{
			//Display Results As Quartermiles
			$template->assign_vars(array(
				'S_DISPLAY_QUARTERMILE_RESULTS'	=> true,
			));
			for ($i = 0, $count = sizeof($results_data); $i < $count; $i++)
			{
				//Provide Results To Template Engine
				$template->assign_block_vars('quartermile', array(
					'U_IMAGE'		=> ($results_data[$i]['attach_id']) ? append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_image&amp;image_id=" . $results_data[$i]['attach_id']) : '',
					'U_VIEWPROFILE'		=> append_sid("{$phpbb_root_path}profile.$phpEx", "mode=viewprofile&amp;u=" . $results_data[$i]['user_id']),
					'U_VIEWVEHICLE'		=> append_sid("{$phpbb_root_path}garage_vehicle.$phpEx", "mode=view_vehicle&amp;CID=" . $results_data[$i]['id']),
					'VEHICLE'		=> $results_data[$i]['vehicle'],
					'USERNAME'		=> $results_data[$i]['username'],
					'IMAGE'			=> $user->img('garage_vehicle_img_attached', 'QUARTEMILE_IMAGE_ATTACHED'),
					'RT'			=> $results_data[$i]['rt'],
					'SIXTY'			=> $results_data[$i]['sixty'],
					'THREE'			=> $results_data[$i]['three'],
					'EIGHTH'		=> $results_data[$i]['eighth'],
					'EIGHTHMPH'		=> $results_data[$i]['eighthmph'],
					'THOU'			=> $results_data[$i]['thou'],
					'QUART'			=> $results_data[$i]['quart'],
					'QUARTMPH'		=> $results_data[$i]['quartmph'],
				));
			}
		}
		else if ($data['display_as'] == 'dynoruns')
		{
			//Display Results As Dynoruns
			$template->assign_vars(array(
				'S_DISPLAY_DYNORUN_RESULTS' 	=> true,
			));
			for ($i = 0, $count = sizeof($results_data); $i < $count; $i++)
			{
				//Provide Results To Template Engine
				$template->assign_block_vars('dynorun', array(
					'U_IMAGE'		=> ($results_data[$i]['attach_id']) ? append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_image&amp;image_id=" . $results_data[$i]['attach_id']) : '',
					'U_VIEWPROFILE'		=> append_sid("{$phpbb_root_path}profile.$phpEx", "mode=viewprofile&amp;u=" . $results_data[$i]['user_id']),
					'U_VIEWVEHICLE'		=> append_sid("{$phpbb_root_path}garage_vehicle.$phpEx", "mode=view_vehicle&amp;CID=" . $results_data[$i]['id']),
					'IMAGE'			=> $user->img('garage_vehicle_img_attached', 'QUARTEMILE_IMAGE_ATTACHED'),
					'USERNAME'		=> $results_data[$i]['username'],
					'VEHICLE'		=> $results_data[$i]['vehicle'],
					'DYNOCENTRE'		=> $results_data[$i]['title'],
					'BHP'			=> $results_data[$i]['bhp'],
					'BHP_UNIT'		=> $results_data[$i]['bhp_unit'],
					'TORQUE'		=> $results_data[$i]['torque'],
					'TORQUE_UNIT'		=> $results_data[$i]['torque_unit'],
					'BOOST'			=> $results_data[$i]['boost'],
					'BOOST_UNIT'		=> $results_data[$i]['boost_unit'],
					'NITROUS'		=> $results_data[$i]['nitrous'],
					'PEAKPOINT'		=> $results_data[$i]['peakpoint'],
				));
			}
		}
		else if ($data['display_as'] == 'track_times')
		{
			//Display Results As Track Times
			$template->assign_vars(array(
				'S_DISPLAY_LAP_RESULTS' 	=> true,
			));
			for ($i = 0, $count = sizeof($results_data); $i < $count; $i++)
			{
				//Provide Results To Template Engine
				$template->assign_block_vars('laptime', array(
					''	=> '',
				));
			}
		}
		//Pass Selected Options So On Sort We Now What We Are Sorting ;)
		$template->assign_vars(array(
			'SEARCH_YEAR'		=> $data['search_year'],
			'SEARCH_MAKE'		=> $data['search_make'],
			'SEARCH_MODEL'		=> $data['search_model'],
			'SEARCH_CATEGORY'	=> $data['search_category'],
			'SEARCH_MANUFACTURER'	=> $data['search_manufacturer'],
			'SEARCH_PRODUCT'	=> $data['search_product'],
			'SEARCH_USERNAME'	=> $data['search_username'],
			'DISPLAY_AS'		=> $data['display_as'],
			'MADE_YEAR'		=> $data['made_year'],
			'MAKE_ID'		=> $data['make_id'],
			'MODEL_ID'		=> $data['model_id'],
			'CATEGORY_ID'		=> $data['category_id'],
			'MANUFACTURER_ID'	=> $data['manufacturer_id'],
			'PRODUCT_ID'		=> $data['product_id'],
			'USERNAME'		=> $data['username'],
			'S_MODE_ACTION'		=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=$mode"),
		));

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'view_image':

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_browse'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=15"));
		}

		//Increment View Counter For This Image
		$garage->update_view_count(GARAGE_IMAGES_TABLE, 'attach_hits', 'attach_id', $image_id);

		//Pull Required Image Data From DB
		$data = $garage_image->get_image($image_id);

		//Check To See If This Is A Remote Image
		if (preg_match( "/^http:\/\//i", $data['attach_location']))
		{
			//Redirect Them To The Remote Image
			header("Location: " . $data['attach_location']);
			exit;
		}
		//Looks Like It's A Local Image...So Lets Display It
		else
		{
	       		switch ( $data['attach_ext'] )
			{
				case '.png':
					header('Content-type: image/png');
					break;
				case '.gif':
					header('Content-type: image/gif');
					break;
				case '.jpg':
					header('Content-type: image/jpeg');
					break;
				default:
					trigger_error('UNSUPPORTED_FILE_TYPE');
			}
			readfile($phpbb_root_path . GARAGE_UPLOAD_PATH . $data['attach_location']);
        		exit;
		}

		break;

	case 'view_all_images':

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_browse'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=15"));
		}

		//Set Required Values To Defaults If They Are Empty
		$start = (empty($start)) ? '0' : $start;

		//Build Page Header ;)
		page_header($page_title);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.tpl',
			'body'   => 'garage_view_images.tpl')
		);

		//Pull Required Image Data From DB
		$data = $garage_image->get_all_images($start, '100');

		//Process Each Image
		for ($i = 0, $count = sizeof($data); $i < $count; $i++)
		{
			//Produce Actual Image Thumbnail And Link It To Full Size Version..
			if (($data[$i]['attach_id']) AND ($data[$i]['attach_is_image']) AND (!empty($data[$i]['attach_thumb_location'])) AND (!empty($data[$i]['attach_location'])))
			{
				$template->assign_block_vars('pic_row', array(
					'U_VIEW_PROFILE'=> append_sid("{$phpbb_root_path}profile.$phpEx", "mode=viewprofile&amp;" . POST_USERS_URL . "=" .$data[$i]['user_id']),
					'U_VIEW_VEHICLE'=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_vehicle&amp;CID=" .$data[$i]['garage_id']),
					'U_IMAGE'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_gallery_item&amp;image_id=" . $data[$i]['attach_id']),
					'IMAGE_TITLE'	=> $data[$i]['attach_file'],
					'IMAGE'		=> $phpbb_root_path . GARAGE_UPLOAD_PATH . $data[$i]['attach_thumb_location'],
					'VEHICLE' 	=> $data[$i]['vehicle'],
					'USERNAME' 	=> $data[$i]['username'])
				);
			}
			//Cleanup For Next Image
			$thumb_image = '';
			$image = '';
		}

		//Count Total Returned For Pagination...Notice No $start or $end to get complete count
		$count = sizeof($garage_image->get_all_images());

		//Only Display Pagination If Data Exists
		if ($count >= 1)
		{
			$pagination = generate_pagination("garage.$phpEx?mode=view_all_images", $count, 100, $start);
			$template->assign_vars(array(
				'L_GOTO_PAGE'	=> $user->lang['Goto_page'],
				'PAGINATION' 	=> $pagination,
				'PAGE_NUMBER' 	=> sprintf($user->lang['PAGE_OF'], ( floor( $start / 100 ) + 1 ), ceil( $count / 100 )))
			);
		}

		$template->assign_vars(array(
			'S_MODE_ACTION' => append_sid("garage.$phpEx?mode=view_all_images"))
		);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();		

		break;

	case 'view_insurance_business':

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_browse'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=15"));
		}

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.html',
			'body'   => 'garage_view_insurance_business.html')
		);

		//Get All Data Posted And Make It Safe To Use
		$params		= array('business_id' => '', 'start' => 0);
		$data 		= $garage->process_vars($params);
		$data['where']	= (!empty($data['business_id'])) ? "AND b.id = " . $data['business_id'] : '';

		//Get All Insurance Business Data
		$business = $garage_business->get_insurance_business($data['where'], $data['start']);

		//Build Page Header ;)
		page_header($page_title);

		//Display Correct Breadcrumb Links..
		$template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_insurance_business"),
			'FORUM_NAME' 	=> $user->lang['INSURANCE_SUMMARY'])
		);

		//Display Correct Breadcrumb Links..
		if (!empty($data['business_id']))
		{
			$template->assign_block_vars('navlinks', array(
				'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_insurance_business&amp;business_id=" . $business[0]['id']),
				'FORUM_NAME' 	=> $business[0]['title'])
			);
		}

      		//Loop Processing All Insurance Business's Returned From First Select
		for ($i = 0, $count = sizeof($business);$i < $count; $i++)
      		{
         		$template->assign_block_vars('business_row', array(
            			'U_VIEW_BUSINESS'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_insurance_business&amp;business_id=" . $business[$i]['id']),
            			'TITLE' 		=> $business[$i]['title'],
	            		'ADDRESS' 		=> $business[$i]['address'],
        	    		'TELEPHONE' 		=> $business[$i]['telephone'],
            			'FAX' 			=> $business[$i]['fax'],
            			'WEBSITE' 		=> $business[$i]['website'],
	            		'EMAIL' 		=> $business[$i]['email'],
				'OPENING_HOURS' 	=> $business[$i]['opening_hours'])
			);

			//Setup Template Block For Detail Being Displayed...
			$detail = (empty($data['business_id'])) ? 'business_row.more_detail' : 'business_row.insurance_detail';
        	 	$template->assign_block_vars($detail, array());

			//Now Loop Through All Insurance Cover Types...
			$cover_types = array($user->lang['THIRD_PARTY'], $user->lang['THIRD_PARTY_FIRE_THEFT'], $user->lang['COMPREHENSIVE'], $user->lang['COMPREHENSIVE_CLASSIC'], $user->lang['COMPREHENSIVE_REDUCED']);
			for($j = 0, $count2 = sizeof($cover_types);$j < $count2; $j++)
			{
				//Pull MIN/MAX/AVG Of Specific Cover Type By Business ID
				$premium_data = $garage_insurance->get_premiums_stats_by_business_and_covertype($business[$i]['id'], $cover_types[$j]);
        	    		$template->assign_block_vars('business_row.cover_row', array(
               				'COVER_TYPE'	=> $cover_types[$j],
               				'MINIMUM' 	=> $premium_data['min'],
               				'AVERAGE' 	=> $premium_data['avg'],
               				'MAXIMUM' 	=> $premium_data['max'])
	            		);
			}
			
			//If Display Single Insurance Company We Then Need To Get All Premium Data
			if  (!empty($data['business_id']))
			{
				//Pull All Insurance Premiums Data For Specific Insurance Company
				$insurance_data = $garage_insurance->get_all_premiums_by_business($business[$i]['id']);
				for($k = 0, $count3 = sizeof($insurance_data);$k < $count3; $k++)
				{
					$template->assign_block_vars('business_row.insurance_detail.premiums', array(
						'U_VIEW_PROFILE'=> append_sid("{$phpbb_root_path}profile.$phpEx", "mode=viewprofile&amp;u=" . $insurance_data[$k]['user_id']),
						'U_VIEW_VEHICLE'=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_vehicle&amp;CID=" . $insurance_data[$k]['garage_id']),
						'USERNAME'	=> $insurance_data[$k]['username'],
						'VEHICLE' 	=> $insurance_data[$k]['vehicle'],
						'PREMIUM' 	=> $insurance_data[$k]['premium'],
						'COVER_TYPE' 	=> $insurance_data[$k]['cover_type'])
					);
				}
			}
      		}

		// Get Insurance Business Data For Pagination
		$count = $garage_business->get_insurance_business($data['where']);
		$pagination = generate_pagination("garage.$phpEx?mode=view_insurance_business", $count[0]['total'], 25, $start);

		$template->assign_vars(array(
			'PAGINATION' => $pagination,
			'PAGE_NUMBER' => sprintf($user->lang['PAGE_OF'], (floor( $start / 25) + 1), ceil($count[0]['total'] / 25 )))
            	);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'view_garage_business':

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_browse'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=15"));
		}

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header'=> 'garage_header.html',
			'body' 	=> 'garage_view_garage_business.html')
		);

		//Get All Data Posted And Make It Safe To Use
		$params = array('business_id' => '', 'start' => 0);
		$data = $garage->process_vars($params);
		$data['where'] = (!empty($data['business_id'])) ? "AND b.id = " . $data['business_id'] : '';

		//Get Required Garage Business Data
		$business = $garage_business->get_garage_business($data['where'], $data['start']);

		//If No Business Let The User Know..
		if ( sizeof($business) < 1 )
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=1"));
		}

		//Build Page Header ;)
		page_header($page_title);

		//Display Correct Breadcrumb Links..
		$template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_garage_business"),
			'FORUM_NAME' 	=> $user->lang['GARAGE_REVIEW'])
		);

		//Setup Breadcrumb Trail Correctly...
		if (!empty($data['business_id']))
		{
			$template->assign_block_vars('navlinks', array(
				'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_garage_business&amp;business_id=" . $business[0]['id']),
				'FORUM_NAME' 	=> $business[0]['title'])
			);
		}

      		//Process All Garages......
      		for ($i = 0, $count = sizeof($business);$i < $count; $i++)
      		{
         		$template->assign_block_vars('business_row', array(
				'U_VIEW_BUSINESS'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_garage_business&amp;business_id=" . $business[$i]['id']),
				'RATING' 		=> (empty($business[$i]['rating'])) ? 0 : $business[$i]['rating'],
            			'TITLE' 		=> $business[$i]['title'],
            			'ADDRESS' 		=> $business[$i]['address'],
            			'TELEPHONE' 		=> $business[$i]['telephone'],
            			'FAX' 			=> $business[$i]['fax'],
            			'WEBSITE' 		=> $business[$i]['website'],
            			'EMAIL' 		=> $business[$i]['email'],
				'MAX_RATING' 		=> $business[$i]['total_rating'],
				'OPENING_HOURS' 	=> $business[$i]['opening_hours'])
         		);
			$template->assign_block_vars('business_row.customers', array());

			if (empty($data['business_id']))
			{
         			$template->assign_block_vars('business_row.more_detail', array());
			}

			//Now Lets Go Get Mods Business Has Installed
			$bus_mod_data = $garage_modification->get_modifications_by_install_business($business[$i]['id']);

			$comments = null;
			for($j = 0, $count2 = sizeof($bus_mod_data);$j < $count2; $j++)
			{
				$template->assign_block_vars('business_row.mod_row', array(
					'U_VIEW_PROFILE' 	=> append_sid("{$phpbb_root_path}profile.$phpEx", "mode=viewprofile&amp;u=" . $bus_mod_data[$j]['user_id']),
					'U_VIEW_VEHICLE' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_vehicle&amp;CID=" . $bus_mod_data[$j]['garage_id']),
					'U_VIEW_MODIFICATION'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_modification&amp;CID=" . $bus_mod_data[$j]['garage_id'] . "&amp;MID=" . $bus_mod_data[$j]['id']),
					'USERNAME' 		=> $bus_mod_data[$j]['username'],
					'VEHICLE' 		=> $bus_mod_data[$j]['vehicle'],
					'MODIFICATION' 		=> $bus_mod_data[$j]['mod_title'],
					'INSTALL_RATING' 	=> $bus_mod_data[$j]['install_rating'])
				);

				//Setup Comments For Installation Of Modification...	
				if (!empty($bus_mod_data[$j]['install_comments']))
				{
					if ( $comments != 'SET')
					{
						$template->assign_block_vars('business_row.comments', array());
					}
					$comments = 'SET';
					$template->assign_block_vars('business_row.customer_comments', array(
						'COMMENTS' => $bus_mod_data[$j]['username'] . ' -> ' . $bus_mod_data[$j]['install_comments'])
					);
				}
			}

			//Reset Comments For Next Business..
			$comments = '';
		}

		//Get Count & Perform Pagination...
		$count = $garage_business->count_garage_business_data($data['where']);
		$pagination = generate_pagination("garage.$phpEx?mode=view_garage_business", $count, 25, $start);

		$template->assign_vars(array(
			'PAGINATION'	=> $pagination,
			'PAGE_NUMBER'	=> sprintf($user->lang['PAGE_OF'], (floor($start / 25) + 1), ceil($count / 25)))
            	);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'view_shop_business':

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_browse'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=15"));
		}

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header'=> 'garage_header.html',
			'body' 	=> 'garage_view_shop_business.html')
		);


		//Get All Data Posted And Make It Safe To Use
		$params		= array('business_id' => '', 'start' => 0);
		$data 		= $garage->process_vars($params);
		$data['where']	= (!empty($data['business_id'])) ? "AND b.id = " . $data['business_id'] : '';

		//Get Required Shop Business Data
		$business = $garage_business->get_shop_business($data['where'], $data['start']);

		//If No Business Let The User Know..
		if ( sizeof($business) < 1 )
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=1"));
		}

		//Build Page Header ;)
		page_header($page_title);

		//Display Correct Breadcrumb Links..
		$template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_shop_business"),
			'FORUM_NAME' 	=> $user->lang['SHOP_REVIEW'])
		);

		//Display Correct Breadcrumb Links..
		if (!empty($data['business_id']))
		{
			$template->assign_block_vars('navlinks', array());
			$template->assign_vars(array(
				'U_VIEW_FORUM' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_shop_business&amp;business_id=" . $business[0]['id']),
				'FORUM_NAME'	=> $business[0]['title'])
			);
		}

      		//Process All Shops......
      		for ($i = 0, $count = sizeof($business);$i < $count; $i++)
      		{
         		$template->assign_block_vars('business_row', array(
				'U_VIEW_BUSINESS'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_shop_business&amp;business_id=" . $business[$i]['id']),
				'RATING' 		=> (empty($business[$i]['rating'])) ? 0 : $business[$i]['rating'],
            			'TITLE' 		=> $business[$i]['title'],
            			'ADDRESS' 		=> $business[$i]['address'],
            			'TELEPHONE' 		=> $business[$i]['telephone'],
            			'FAX' 			=> $business[$i]['fax'],
            			'WEBSITE' 		=> $business[$i]['website'],
            			'EMAIL' 		=> $business[$i]['email'],
				'MAX_RATING' 		=> $business[$i]['total_rating'],
				'OPENING_HOURS' 	=> $business[$i]['opening_hours'])
         		);
			$template->assign_block_vars('business_row.customers', array());
			
			if (empty($data['business_id']))
			{
         			$template->assign_block_vars('business_row.more_detail', array());
			}

			//Now Lets Go Get All Mods All Business's Have Sold
			$bus_mod_data = $garage_modification->get_modifications_by_business($business[$i]['id']);

			$comments = null;
			for ($j = 0, $count2 = sizeof($bus_mod_data);$j < $count2; $j++)
			{
				$template->assign_block_vars('business_row.mod_row', array(
					'U_VIEW_PROFILE' 	=> append_sid("{$phpbb_root_path}profile.$phpEx", "mode=viewprofile&amp;u=" . $bus_mod_data[$j]['user_id']),
					'U_VIEW_VEHICLE' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_vehicle&amp;CID=" . $bus_mod_data[$j]['garage_id']),
					'U_VIEW_MODIFICATION'	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_modification&amp;CID=" . $bus_mod_data[$j]['garage_id'] . "&amp;MID=" . $bus_mod_data[$j]['id']),
					'USERNAME' 		=> $bus_mod_data[$j]['username'],
					'VEHICLE' 		=> $bus_mod_data[$j]['vehicle'],
					'MODIFICATION' 		=> $bus_mod_data[$j]['mod_title'],
					'PURCHASE_RATING' 	=> $bus_mod_data[$j]['purchase_rating'],
					'PRODUCT_RATING' 	=> $bus_mod_data[$j]['product_rating'],
					'PRICE' 		=> $bus_mod_data[$j]['price'])
				);
					
				if (!empty($bus_mod_data[$j]['comments']))
				{
					if ( $comments != 'SET')
					{
						$template->assign_block_vars('business_row.comments', array());
					}
					$comments = 'SET';
					$template->assign_block_vars('business_row.customer_comments', array(
						'COMMENTS' => $bus_mod_data[$j]['username'] . ' -> ' . $bus_mod_data[$j]['comments'])
					);
				}
			}

			//Reset Comments For Next Business..
			$comments = '';
		}

		//Get Count & Perform Pagination...
		$count = $garage_business->count_shop_business_data($data['where']);
		$pagination = generate_pagination("garage.$phpEx?mode=view_shop_business", $count, 25, $start);

		$template->assign_vars(array(
			'PAGINATION'	=> $pagination,
			'PAGE_NUMBER' 	=> sprintf($user->lang['PAGE_OF'], (floor($start / 25) + 1), ceil($count / 25)))
            	);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'user_submit_business':

		//Check The User Is Logged In...Else Send Them Off To Do So......And Redirect Them Back!!!
		if ( $user->data['user_id'] == ANONYMOUS )
		{
			login_box("garage.$phpEx?mode=user_submit_business");
		}

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_add_business'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Build Page Header ;)
		page_header($page_title);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.html',
			'body'   => 'garage_user_submit_business.html')
		);

		//Get All Data Posted And Make It Safe To Use
		$params = array('BUSINESS' => '', 'redirect' => '');
		$data = $garage->process_vars($params);

		$template->assign_vars(array(
			'L_TITLE'		=> $user->lang['ADD_NEW_BUSINESS'],
			'L_BUTTON'		=> $user->lang['ADD_NEW_BUSINESS'],
			'CID' 			=> $cid,
			'REDIRECT'		=> $data['redirect'],
			'S_DISPLAY_PENDING' 	=> $garage_config['enable_business_approval'],
			'S_BUSINESS_INSURANCE' 	=> ($data['BUSINESS'] == BUSINESS_INSURANCE) ? true : false,
			'S_BUSINESS_GARAGE' 	=> ($data['BUSINESS'] == BUSINESS_GARAGE) ? true : false,
			'S_BUSINESS_RETAIL' 	=> ($data['BUSINESS'] == BUSINESS_RETAIL) ? true : false,
			'S_BUSINESS_PRODUCT' 	=> ($data['BUSINESS'] == BUSINESS_PRODUCT) ? true : false,
			'S_BUSINESS_DYNOCENTRE' => ($data['BUSINESS'] == BUSINESS_DYNOCENTRE) ? true : false,
			'S_MODE_ACTION' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=insert_business"))
		);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'insert_business':

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_add_business'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Get All Data Posted And Make It Safe To Use
		$params = array('redirect' => '', 'title' => '', 'address' => '', 'telephone' => '', 'fax' => '', 'website' => '', 'email' => '', 'opening_hours' => '', 'product' => '', 'insurance' => '', 'garage' => '', 'retail' => '', 'dynocentre' => '');
		$data 	= $garage->process_vars($params);

		//Check They Entered http:// In The Front Of The Link
		if ((!preg_match( "/^http:\/\//i", $data['website'])) AND (!empty($data['website'])))
		{
			$data['website'] = "http://".$data['website'];
		}

		//Checks All Required Data Is Present
		$params = array('title');
		$garage->check_required_vars($params);

		//If Needed Update Garage Config Telling Us We Have A Pending Item And Perform Notifications If Configured
		if ($garage_config['enable_business_approval'])
		{
			//Perform Any Pending Notifications Requried
			$garage->pending_notification('unapproved_business');
		}

		//Create The Business Now...
		$garage_business->insert_business($data);

		//Send Them Back To Whatever Page Them Came From..Now With Their Required Business :)
		redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=" . $data['redirect'] . "&amp;CID=$cid"));

		break;

	case 'edit_business':

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('m_garage'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Build Page Header ;)
		page_header($page_title);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.html',
			'body'   => 'garage_user_submit_business.html')
		);

		//Pull Required Business Data From DB
		$data = $garage_business->get_business($bus_id);

		$template->assign_vars(array(
			'L_TITLE' 		=> $user->lang['EDIT_BUSINESS'],
			'L_BUTTON' 		=> $user->lang['EDIT_BUSINESS'],
			'TITLE' 		=> $data['title'],
			'ADDRESS'		=> $data['address'],
			'TELEPHONE'		=> $data['telephone'],
			'FAX'			=> $data['fax'],
			'WEBSITE'		=> $data['website'],
			'EMAIL'			=> $data['email'],
			'OPENING_HOURS'		=> $data['opening_hours'],
			'BUSINESS_ID'		=> $data['id'],
			'S_DISPLAY_PENDING' 	=> $garage_config['enable_business_approval'],
			'S_BUSINESS_INSURANCE' 	=> ($data['insurance']) ? true : false,
			'S_BUSINESS_GARAGE' 	=> ($data['garage']) ? true : false,
			'S_BUSINESS_RETAIL' 	=> ($data['retail']) ? true : false,
			'S_BUSINESS_PRODUCT' 	=> ($data['product']) ? true : false,
			'S_BUSINESS_DYNOCENTRE'	=> ($data['dynocentre']) ? true : false,
			'S_MODE_ACTION' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=update_business"))
		);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'update_business':

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('m_garage'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Get All Data Posted And Make It Safe To Use
		$params = array('id' => '', 'title' => '', 'address' => '', 'telephone' => '', 'fax' => '', 'website' => '', 'email' => '', 'opening_hours' => '', 'product' => '', 'insurance' => '', 'garage' => '', 'retail' => '', 'dynocentre' => '');
		$data 	= $garage->process_vars($params);

		//Check They Entered http:// In The Front Of The Link
		if ( (!preg_match( "/^http:\/\//i", $data['website'])) AND (!empty($data['website'])) )
		{
			$data['website'] = "http://" . $data['website'];
		}

		//Checks All Required Data Is Present
		$params = array('title');
		$garage->check_required_vars($params);

		//Update The Business With Data Acquired
		$garage_business->update_business($data);

		redirect(append_sid("{$phpbb_root_path}mcp.$phpEx", "i=garage&amp;mode=unapproved_business"));

		break;

	case 'user_submit_make':

		//Check The User Is Logged In...Else Send Them Off To Do So......And Redirect Them Back!!!
		if ($user->data['user_id'] == ANONYMOUS)
		{
			login_box("garage.$phpEx?mode=user_submit_make");
		}

		//Check This Feature Is Enabled
		if (!$garage_config['enable_user_submit_make'])
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=18"));
		}

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_add_make_model'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Get All Data Posted And Make It Safe To Use
		$params = array('year' => '');
		$data = $garage->process_vars($params);

		//Build Page Header ;)
		page_header($page_title);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.html',
			'body'   => 'garage_user_submit_make.html')
		);

		$template->assign_vars(array(
			'YEAR' 			 => $data['year'],
			'S_GARAGE_MODELS_ACTION' => append_sid("{$phpbb_root_path}admin_garage_models.$phpEx"))
		);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'insert_make':

		//User Is Annoymous...So Not Allowed To Create A Vehicle
		if ($user->data['user_id'] == ANONYMOUS)
		{
			login_box("garage.$phpEx?mode=user_submit_make");
		}

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_add_make_model'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Get All Data Posted And Make It Safe To Use
		$params = array('make' => '', 'year' => '');
		$data = $garage->process_vars($params);

		//Checks All Required Data Is Present
		$params = array('make', 'year');
		$garage->check_required_vars($params);

		//Check Make Does Not Already Exist
		if ($garage_model->count_make($data['make']) > 0)
		{
			redirect(append_sid("garage.$phpEx?mode=error&amp;EID=27", true));
		}

		//Create The Make
		$garage_model->insert_make($data);

		//Perform Any Pending Notifications Requried
		$garage->pending_notification('unapproved_makes');

		redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=create_vehicle&amp;MAKE=" . $data['make']));

		break;

	case 'user_submit_model':

		//Check The User Is Logged In...Else Send Them Off To Do So......And Redirect Them Back!!!
		if ( $user->data['user_id'] == ANONYMOUS )
		{
			login_box("garage.$phpEx?mode=user_submit_model");
		}

		//Check This Feature Is Enabled & User Authorised
		if (!$garage_config['enable_user_submit_model'] || !$auth->acl_get('u_garage_add_make_model'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=18"));
		}

		//Get All Data Posted And Make It Safe To Use
		$params = array('make_id' => '', 'year' => '');
		$data = $garage->process_vars($params);
		$year = $data['year'];

		//Check If User Owns Vehicle
		if (empty($data['make_id']))
		{
			redirect(append_sid("garage.$phpEx?mode=error&amp;EID=23", true));
		}

		//Build Page Header ;)
		page_header($page_title);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.html',
			'body'   => 'garage_user_submit_model.html')
		);

		//Get All Data Posted And Make It Safe To Use
		$params = array('MAKE_ID' => '');
		$data = $garage->process_vars($params);

		//Checks All Required Data Is Present
		$params = array('MAKE_ID');
		$garage->check_required_vars($params);

		//Pull Required Make Data From DB
		$data = $garage_model->get_make($data['make_id']);

		$template->assign_vars(array(
			'YEAR' 		=> $year,
			'MAKE_ID' 	=> $data['id'],
			'MAKE' 		=> $data['make'])
		);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'user_submit_product':

		//Check The User Is Logged In...Else Send Them Off To Do So......And Redirect Them Back!!!
		if ( $user->data['user_id'] == ANONYMOUS )
		{
			login_box("garage.$phpEx?mode=user_submit_product");
		}

		//Check This Feature Is Enabled & User Authorised
		if (!$garage_config['enable_user_submit_product'] || !$auth->acl_get('u_garage_add_product'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=18"));
		}

		//Get All Data Posted And Make It Safe To Use
		$params = array('category_id' => '', 'manufacturer_id' => '', 'CID' => '');
		$data = $garage->process_vars($params);
		$params = array('category_id', 'manufacturer_id', 'CID');
		$garage->check_required_vars($params);

		//Build Page Header ;)
		page_header($page_title);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.html',
			'body'   => 'garage_user_submit_product.html')
		);

		$category = $garage->get_category($data['category_id']);
		$manufacturer = $garage_business->get_business($data['manufacturer_id']);

		$template->assign_vars(array(
			'CID' 			=> $data['CID'],
			'CATEGORY_ID' 		=> $data['category_id'],
			'MANUFACTURER_ID'	=> $data['manufacturer_id'],
			'CATEGORY' 		=> $category['title'],
			'MANUFACTURER' 		=> $manufacturer['title'])
		);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'insert_model':

		//Check The User Is Logged In...Else Send Them Off To Do So......And Redirect Them Back!!!
		if ($user->data['user_id'] == ANONYMOUS)
		{
			login_box("garage.$phpEx?mode=user_submit_model");
		}

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_add_make_model'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Get All Data Posted And Make It Safe To Use
		$params = array('make' => '', 'make_id' => '', 'model' => '', 'year' => '');
		$data = $garage->process_vars($params);

		//Checks All Required Data Is Present
		$params = array('make', 'make_id', 'model');
		$garage->check_required_vars($params);

		//If Needed Update Garage Config Telling Us We Have A Pending Item And Perform Notifications If Configured
		if ( $data['pending'] == 1 )
		{
			$garage->pending_notification('unapproved_models');
		}

		//Create The Model
		$garage_model->insert_model($data);

		redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=create_vehicle&amp;MAKE=" . $data['make'] . "&amp;MODEL=" . $data['model']));

		break;

	case 'insert_product':

		//Check The User Is Logged In...Else Send Them Off To Do So......And Redirect Them Back!!!
		if ($user->data['user_id'] == ANONYMOUS)
		{
			login_box("garage.$phpEx?mode=user_submit_product");
		}

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_add_product'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=14"));
		}

		//Get All Data Posted And Make It Safe To Use
		$params = array('title' => '', 'category_id' => '', 'manufacturer_id' => '', 'vehicle_id' => '');
		$data = $garage->process_vars($params);

		//Checks All Required Data Is Present
		$params = array('title', 'category_id', 'manufacturer_id', 'vehicle_id');
		$garage->check_required_vars($params);

		//If Needed Perform Notifications If Configured
		if ($garage_config['enable_product_approval'])
		{
			$garage->pending_notification('unapproved_products');
		}

		//Create The Product
		$data['product_id'] = $garage_modification->insert_product($data);

		//Head Back To Page Updating Dropdowns With New Item ;)
		redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=add_modification&amp;CID=".$data['vehicle_id']."&amp;category_id=" . $data['category_id'] . "&amp;manufacturer_id=" . $data['manufacturer_id'] ."&amp;product_id=" . $data['product_id']));

		break;

	case 'reassign_business':

		//Check The User Is Logged In...Else Send Them Off To Do So......And Redirect Them Back!!!
		if ( $user->data['user_id'] == ANONYMOUS )
		{
			login_box("garage.$phpEx?mode=pending");
		}

		//Check The User Is Allowed To View This Page...If Not Send Them On There Way Nicely
		if (!$auth->acl_get('m_garage'))
		{
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=13"));
		}

		//Get All Data Posted And Make It Safe To Use
		$params = array('business_id' => '', 'target_id' => '');
		$data = $garage->process_vars($params);

		//Checks All Required Data Is Present
		$params = array('business_id', 'target_id');
		$garage->check_required_vars($params);

		//Lets Update All Possible Business Fields With The Reassigned Business
		$garage->update_single_field(GARAGE_MODIFICATIONS_TABLE, 'business_id', $data['target_id'], 'business_id', $data['business_id']);
		$garage->update_single_field(GARAGE_MODIFICATIONS_TABLE, 'install_business_id', $data['target_id'], 'install_business_id', $data['business_id']);
		$garage->update_single_field(GARAGE_INSURANCE_TABLE, 'business_id', $data['target_id'], 'business_id', $data['business_id']);

		//Since We Have Updated All Item Lets Do The Original Delete Now
		$garage->delete_rows(GARAGE_BUSINESS_TABLE, 'id', $data['business_id']);

		redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=pending"));

		break;

	case 'error':

		//Build Page Header ;)
		page_header($page_title);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header' => 'garage_header.html',
			'body'   => 'garage_error.html')
		);

		$template->assign_vars(array(
			'ERROR_MESSAGE' => $user->lang['GARAGE_ERROR_' . $eid])
		);

		//Display Page...In Order Header->Menu->Body->Footer (Foot Gets Parsed At The Bottom)
		$garage_template->sidemenu();

		break;

	case 'get_model_list':

		//Get All Data Posted And Make It Safe To Use
		$params = array('make_id' => '', 'model_id' => '');
		$data = $garage->process_vars($params);

		echo "obj.options[obj.options.length] = new Option('".$user->lang['SELECT_MODEL']."', '', false, false);\n";
		echo "obj.options[obj.options.length] = new Option('------', '', false, false);\n";

		if (!empty($data['make_id']))
		{
			//Get Models Belonging To This Make
			$models = $garage_model->get_all_models_from_make($data['make_id']);

			//Populate Options For Dropdown
			for ($i = 0, $count = sizeof($models);$i < $count; $i++)
			{
				if ($data['model_id'] == $models[$i]['id'])
				{
					echo "obj.options[obj.options.length] = new Option('".$models[$i]['model']."','".$models[$i]['id']."', true, true);\n";
				}
				else
				{
					echo "obj.options[obj.options.length] = new Option('".$models[$i]['model']."','".$models[$i]['id']."', false, false);\n";
				}
			}
		}

		exit;

	case 'get_product_list':

		//Get All Data Posted And Make It Safe To Use
		$params = array('manufacturer_id' => '' , 'category_id' => '', 'product_id' => '');
		$data = $garage->process_vars($params);

		echo "obj.options[obj.options.length] = new Option('".$user->lang['SELECT_PRODUCT']."', '', false, false);\n";
		echo "obj.options[obj.options.length] = new Option('------', '', false, false);\n";

		if (!empty($data['manufacturer_id']))
		{
			//Get Products Belonging To This Manufacturer With Filtering On Category For Modification Page
			if (!empty($data['category_id']))
				$products = $garage_modification->get_products_by_manufacturer($data['manufacturer_id'], $data['category_id']);
			//Get Products Belonging To This Manufacturer With No Filtering On Category For Search Page
			else
			{
				$products = $garage_modification->get_products_by_manufacturer($data['manufacturer_id']);
			}

			//Populate Options For Dropdown
			for ($i = 0, $count = sizeof($products);$i < $count; $i++)
			{
				if ($data['product_id'] == $products[$i]['id'])
				{
					echo "obj.options[obj.options.length] = new Option('".$products[$i]['title']."','".$products[$i]['id']."', true, true);\n";
				}
				else
				{
					echo "obj.options[obj.options.length] = new Option('".$products[$i]['title']."','".$products[$i]['id']."', false, false);\n";
				}
			}
		}

		exit;

	default:

		//Let Check The User Is Allowed Perform This Action
		if (!$auth->acl_get('u_garage_browse'))
		{
			//If Not Logged In Send Them To Login & Back, Maybe They Have Permission As A User 
			if ( $user->data['user_id'] == ANONYMOUS )
			{
				login_box("garage.$phpEx");
			}
			//They Are Logged In But Not Allowed So Error Nicely Now...
			redirect(append_sid("{$phpbb_root_path}garage.$phpEx", "mode=error&amp;EID=15"));
		}

		//Build Page Header ;)
		page_header($page_title);

		//Display Page...In Order Header->Menu->Body->Footer
		$garage_template->sidemenu();

		//Display If Needed Featured Vehicle
		$garage_vehicle->show_featuredvehicle();
		
		$required_position = 1;
		//Display All Boxes Required
		$garage_vehicle->show_newest_vehicles();
		$garage_vehicle->show_updated_vehicles();
		$garage_modification->show_newest_modifications();
		$garage_modification->show_updated_modifications();
		$garage_modification->show_most_modified();
		$garage_vehicle->show_most_spent();
		$garage_vehicle->show_most_viewed();
		$garage_guestbook->show_lastcommented();
		$garage_quartermile->show_topquartermile();
		$garage_dynorun->show_topdynorun();
		$garage_vehicle->show_toprated();

		$template->assign_vars(array(
			'S_INDEX_COLUMNS' 	=> ($garage_config['enable_user_index_columns'] && ($user->data['user_garage_index_columns'] != $garage_config['index_columns'])) ? $user->data['user_garage_index_columns'] : $garage_config['index_columns'],
			'TOTAL_VEHICLES' 	=> $garage_vehicle->count_total_vehicles(),
			'TOTAL_VIEWS' 		=> $garage->count_total_views(),
			'TOTAL_MODIFICATIONS' 	=> $garage_modification->count_total_modifications(),
			'TOTAL_COMMENTS'  	=> $garage_guestbook->count_total_comments())
		);

		//Set Template Files In Use For This Mode
		$template->set_filenames(array(
			'header'	=> 'garage_header.html',
			'menu' 		=> 'garage_menu.html',
			'body' 		=> 'garage.html')
		);

		break;
}

$garage_template->version_notice();

//Set Template Files In Used For Footer
$template->set_filenames(array(
	'garage_footer' => 'garage_footer.html')
);

//Generate Page Footer
page_footer();

?>
