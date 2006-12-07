<?php
/***************************************************************************
 *                              class_garage_template.php
 *                            -------------------
 *   begin                : Friday, 06 May 2005
 *   copyright            : (C) Esmond Poynton
 *   email                : esmond.poynton@gmail.com
 *   description          : Provides Vehicle Garage System For phpBB
 *
 *   $Id: class_garage_template.php 156 2006-06-19 06:51:48Z poyntesm $
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

class garage_template
{
	var $classname = "garage_template";

	/*========================================================================*/
	// Builds HTML Variables For Version & Copywrite Notice
	// Remove This Notice & No Support Is Given
	// Usage: version_notice();
	/*========================================================================*/
	function version_notice()
	{
		global $template, $user, $garage_config, $phpEx;

		// Set Garage Version Messages.....DO NOT REMOVE....No Support For Any Garage Without It
		$template->assign_vars(array(
			'L_GARAGE' 		=> $user->lang['GARAGE'],
			'L_POWERED_BY_GARAGE'	=> 'Powered By phpBB Garage' . $user->lang['Translation_Link'],
			'U_GARAGE' 		=> append_sid("garage.$phpEx"),
			'GARAGE_LINK' 		=> 'http://www.phpbbgarage.com/',
			'GARAGE_VERSION'	=> $garage_config['version'])
		);

		return;
	}

	/*========================================================================*/
	// Builds all required side menus
	// Usage: sidemenu();
	/*========================================================================*/
	function sidemenu()
	{
		global $user, $template, $phpEx, $phpbb_root_path, $garage_config, $garage, $garage_vehicle, $auth;
	
		$template->set_filenames(array(
			'menu' => 'garage_menu.html')
		);

		$template->assign_vars(array(
			'U_GARAGE_MAIN' 		=> append_sid("{$phpbb_root_path}garage.$phpEx"),
			'U_GARAGE_BROWSE' 		=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=browse"),
			'U_GARAGE_SEARCH' 		=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=search"),
			'U_GARAGE_INSURANCE_REVIEW' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_insurance_business"),
			'U_GARAGE_SHOP_REVIEW' 		=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_shop_business"),
			'U_GARAGE_GARAGE_REVIEW' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=view_garage_business"),
			'U_GARAGE_QUARTERMILE_TABLE' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=quartermile"),
			'U_GARAGE_DYNORUN_TABLE' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=dynorun"),
			'U_GARAGE_CREATE_VEHICLE' 	=> append_sid("{$phpbb_root_path}garage.$phpEx", "mode=create_vehicle"),
			'MAIN' 				=> ($garage_config['enable_images']) ? $user->img('garage_main_menu', 'MAIN_MENU') : $user->lang['MAIN_MENU'],
			'BROWSE' 			=> ($garage_config['enable_images']) ? $user->img('garage_browse', 'BROWSE_GARAGE') : $user->lang['BROWSE_GARAGE'],
			'SEARCH' 			=> ($garage_config['enable_images']) ? $user->img('garage_search', 'SEARCH_GARAGE') : $user->lang['SEARCH_GARAGE'],
			'INSURANCE_REVIEW' 		=> ($garage_config['enable_images']) ? $user->img('garage_insurance_review', 'INSURANCE_SUMMARY') : $user->lang['INSURANCE_SUMMARY'],
			'SHOP_REVIEW' 			=> ($garage_config['enable_images']) ? $user->img('garage_shop_review', 'SHOP_REVIEW') : $user->lang['SHOP_REVIEW'],
			'GARAGE_REVIEW' 		=> ($garage_config['enable_images']) ? $user->img('garage_garage_review', 'GARAGE_REVIEW') : $user->lang['GARAGE_REVIEW'],
			'QUARTERMILE_TABLE' 		=> ($garage_config['enable_images']) ? $user->img('garage_quartermile_table', 'QUARTERMILE_TABLE') : $user->lang['QUARTERMILE_TABLE'],
			'DYNORUN_TABLE' 		=> ($garage_config['enable_images']) ? $user->img('garage_dynorun_table', 'DYNORUN_TABLE') : $user->lang['DYNORUN_TABLE'],
			'CREATE_VEHICLE' 		=> ($garage_config['enable_images']) ? $user->img('garage_create_vehicle', 'CREATE_VEHICLE') : $user->lang['CREATE_VEHICLE'],
			'S_GARAGE_DISPLAY_MAIN' 	=> ($garage_config['enable_index_menu']) ? true : false,
			'S_GARAGE_DISPLAY_BROWSE' 	=> ($garage_config['enable_browse_menu']) ? true : false,
			'S_GARAGE_DISPLAY_SEARCH' 	=> ($garage_config['enable_search_menu']) ? true : false,
			'S_GARAGE_DISPLAY_INSURANCE_REVIEW' => ($garage_config['enable_insurance_review_menu']) ? true : false,
			'S_GARAGE_DISPLAY_SHOP_REVIEW' 	=> ($garage_config['enable_shop_review_menu']) ? true : false,
			'S_GARAGE_DISPLAY_GARAGE_REVIEW'=> ($garage_config['enable_garage_review_menu']) ? true : false,
			'S_GARAGE_DISPLAY_QUARTERMILE_TABLE' => ($garage_config['enable_quartermile_menu']) ? true : false,
			'S_GARAGE_DISPLAY_DYNORUN_TABLE' => ($garage_config['enable_dynorun_menu']) ? true : false,
			'S_GARAGE_DISPLAY_CREATE_VEHICLE'=> ($auth->acl_get('u_garage_add_vehicle')) ? true : false)
		);

		//If Not Allowed Browse Stop Here..We Want The Error To Have The Menu..But No More
		if (!$auth->acl_get('u_garage_browse'))
		{
			return ;
		}

		if ( $user->data['user_id'] != ANONYMOUS )
		{
			$template->assign_block_vars('show_vehicles', array());
			$user_vehicles = $garage_vehicle->get_vehicles_by_user($user->data['user_id']);
			for ($i = 0; $i < count($user_vehicles); $i++)
			{
		       		$template->assign_block_vars('show_vehicles.user_vehicles', array(
       					'U_VIEW_VEHICLE'=> append_sid("garage.$phpEx?mode=view_own_vehicle&amp;CID=" . $user_vehicles[$i]['id']),
       					'VEHICLE' 	=> $user_vehicles[$i]['vehicle'])
      				);
			}
		}

		if ( $garage_config['enable_latest_vehicle_index'] == true )
		{
			$template->assign_block_vars('lastupdatedvehiclesmain_on', array());
			$vehicles = $garage_vehicle->get_latest_updated_vehicles($garage_config['latest_vehicle_index_limit']);	
			for ($i = 0; $i < count($vehicles); $i++)
			{
       				$template->assign_block_vars('lastupdatedvehiclesmain_on.updated_vehicles', array(
       					'U_VIEW_VEHICLE'=> append_sid("garage.$phpEx", "mode=view_vehicle&amp;CID=" . $vehicles[$i]['id'], true),
		       			'U_VIEW_PROFILE'=> append_sid("profile.$phpEx", "mode=viewprofile&amp;u=".$vehicles_updated[$i]['user_id'], true),
       					'VEHICLE' 	=> $vehicles[$i]['vehicle'],
       					'UPDATED_TIME' 	=> $user->format_date($vehicles[$i]['date_updated']),
		       			'USERNAME' 	=> $vehicles[$i]['username'])
      				);
			}
		}

		return ;
	}

	/*========================================================================*/
	// Builds The HTML For Selecting Years
	// Usage: year_dropdown('selected year');
	/*========================================================================*/
	function year_dropdown($selected = 0)
	{
		global $garage_config, $template;
	
		// Grab the current year
		$my_array = localtime(time(), 1) ;
		$current_date = $my_array["tm_year"] +1900 ;
	
	        // Calculate end year based on offset configured
	        $end_year = $current_date + $garage_config['year_end'];
	
		// A simple check to prevent infinite loop
		if ( $garage_config['year_start'] > $end_year ) 
		{
			return;
		}	
	
		$year_list = '<select name="year" class="forminput">';
	
		for ( $year = $end_year; $year >= $garage_config['year_start']; $year-- ) 
		{
			if ( $year == $selected ) 
			{
				$year_list .= '<option value="'.$year.'" selected="selected">'.$year.'</option>';
			} 
			else 
			{
				$year_list .= '<option value="'.$year.'">'.$year.'</option>';
			}
		}
	
		$year_list .= "</select>";
	
		$template->assign_vars(array(
			'YEAR_LIST' => $year_list)
		);
	
		return ;
	}
	
	/*========================================================================*/
	// Builds The HTML For A Selecting A Garage
	// Usage: garage_install_dropdown('business id', 'business name');
	/*========================================================================*/
	function garage_install_dropdown($selected = NULL, $selected_name = NULL)
	{
		global $userdata, $template, $db, $SID, $lang, $phpEx, $phpbb_root_path, $garage_config, $board_config;
	
		$garage_install_list = "<select name='install_business_id' class='forminput'>";
	
		if (!empty($selected) )
		{
			$garage_install_list .= "<option value='$selected' selected='selected'>$selected_name</option>";
			$garage_install_list .= "<option value=''>------</option>";
		}
		else
		{
			$garage_install_list .= "<option value=''>".$lang['SELECT_A_BUSINESS']."</option>";
			$garage_install_list .= "<option value=''>------</option>";
		}
	
		$sql = "SELECT id, title 
			FROM " . GARAGE_BUSINESS_TABLE . " 
			WHERE garage = 1 
			ORDER BY title ASC";
	
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query businesses', '', __LINE__, __FILE__, $sql);
		}
	
		while ( $garage_list = $db->sql_fetchrow($result) )
		{
			$garage_install_list .= "<option value='".$garage_list['id']."'>".$garage_list['title']."</option>";
		}
		$db->sql_freeresult($result);
		
		$garage_install_list .= "</select>";
	
		$template->assign_vars(array(
			'GARAGE_INSTALL_LIST' => $garage_install_list)
		);
	
		return ;
	}

	/*========================================================================*/
	// Builds The HTML For A Selecting A Business To Reassign To
	// Usage: reassign_business_dropdown('excluding business id');
	/*========================================================================*/
	function reassign_business_dropdown($exclude)
	{
		global $userdata, $template, $db, $SID, $lang, $phpEx, $phpbb_root_path, $garage_config, $board_config;
	
		$html = '<select name="target_id" class="forminput">';

		$sql = "SELECT id, title	
			FROM " . GARAGE_BUSINESS_TABLE . " 
			WHERE pending = 0 	
				and id NOT IN ($exclude)
			ORDER BY title ASC";
	
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query businesses', '', __LINE__, __FILE__, $sql);
		}
	
		while ( $row = $db->sql_fetchrow($result) )
		{
			$html .= "<option value='".$row['id']."'>".$row['title']."</option>";
		}
		$db->sql_freeresult($result);
		
		$html .= "</select>";
	
		$template->assign_vars(array(
			'BUSINESS_SELECT' => $html)
		);
	
		return ;
	}

	
	/*========================================================================*/
	// Builds The HTML For Selecting Any Business
	// Usage: business_dropdown('business id', 'business name');
	/*========================================================================*/
	function business_dropdown($selected = NULL, $selected_name = NULL)
	{
		global $userdata, $template, $db, $SID, $lang, $phpEx, $phpbb_root_path, $garage_config, $board_config;
	
		$business_list = "<select name='id' class='forminput'>";
	
		if (!empty($selected) )
		{
			$business_list .= "<option value='$selected' selected='selected'>$selected_name</option>";
			$business_list .= "<option value=''>------</option>";
		}
		else
		{
			$business_list .= "<option value=''>".$lang['Select_A_Business']."</option>";
			$business_list .= "<option value=''>------</option>";
		}
	
		$sql = "SELECT id, title 
			FROM " . GARAGE_BUSINESS_TABLE . " 
			ORDER BY title ASC";
	
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query businesses', '', __LINE__, __FILE__, $sql);
		}
	
		while ( $business = $db->sql_fetchrow($result) )
		{
			$business_list .= "<option value='".$business['id']."'>".$business['title']."</option>";
		}
		$db->sql_freeresult($result);
		
		$business_list .= "</select>";
	
		$template->assign_vars(array(
			'BUSINESS_LIST' => $business_list)
		);
	
		return ;
	}
	
	/*========================================================================*/
	// Builds The HTML For Selecting Insurance Business
	// Usage: insurance_dropdown('<business id', 'business name');
	/*========================================================================*/
	function insurance_dropdown($selected = NULL, $selected_name = NULL)
	{
		global $userdata, $template, $db, $SID, $lang, $phpEx, $phpbb_root_path, $garage_config, $board_config;
	
		$insurance_list = "<select name='business_id' class='forminput'>";
	
		if (!empty($selected) )
		{
			$insurance_list .= "<option value='$selected' selected='selected'>$selected_name</option>";
			$insurance_list .= "<option value=''>------</option>";
		}
		else
		{
			$insurance_list .= "<option value=''>".$lang['Select_A_Business']."</option>";
			$insurance_list .= "<option value=''>------</option>";
		}
	
		$sql = "SELECT id, title 
			FROM " . GARAGE_BUSINESS_TABLE . " 
			WHERE insurance = 1 
			ORDER BY title ASC";
	
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query businesses', '', __LINE__, __FILE__, $sql);
		}
	
		while ( $insurance = $db->sql_fetchrow($result) )
		{
			$insurance_list .= "<option value='".$insurance['id']."'>".$insurance['title']."</option>";
		}
		$db->sql_freeresult($result);
		
		$insurance_list .= "</select>";
	
		$template->assign_vars(array(
			'INSURANCE_LIST' => $insurance_list)
		);
	
		return ;
	}
	
	/*========================================================================*/
	// Builds The HTML For Selecting A Shop
	// Usage: shop_dropdown('business id', 'business name');
	/*========================================================================*/
	function shop_dropdown($selected = NULL, $selected_name = NULL)
	{
		global $userdata, $template, $db, $SID, $lang, $phpEx, $phpbb_root_path, $garage_config, $board_config;
	
		$shop_list = "<select name='business_id' class='forminput'>";
	
		if (!empty($selected) )
		{
			$shop_list .= "<option value='$selected' selected='selected'>$selected_name</option>";
			$shop_list .= "<option value=''>------</option>";
		}
		else
		{
			$shop_list .= "<option value=''>".$lang['Select_A_Business']."</option>";
			$shop_list .= "<option value=''>------</option>";
		}
	
		$sql = "SELECT id, title 
	       		FROM " . GARAGE_BUSINESS_TABLE . " WHERE retail_shop = 1 OR web_shop = 1
			ORDER BY title ASC";
	
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query businesses', '', __LINE__, __FILE__, $sql);
		}
	
		while ( $shop = $db->sql_fetchrow($result) )
		{
			$shop_list .= "<option value='".$shop['id']."'>".$shop['title']."</option>";
		}
		$db->sql_freeresult($result);
		
		$shop_list .= "</select>";
	
		$template->assign_vars(array(
			'SHOP_LIST' => $shop_list)
		);
	
		return ;
	}
	
	/*========================================================================*/
	// Builds The HTML For Selecting A Dynorun Entry
	// Usage: dynorun_dropdown('dynorun id', 'bhp @ bhp_type', 'vehicle id');
	/*========================================================================*/
	function dynorun_dropdown($selected, $selected_name, $cid)
	{
		global $userdata, $template, $db, $SID, $lang, $phpEx, $phpbb_root_path, $garage_config, $board_config;
	
		$rr_list = "<select name='rr_id' class='forminput'>";
	
		if (!empty($selected) )
		{
			$rr_list .= "<option value='$selected' selected='selected'>$selected_name</option>";
			$rr_list .= "<option value=''>------</option>";
		}
		else
		{
			$rr_list .= "<option value=''>".$lang['Select_A_Option']."</option>";
			$shop_list .= "<option value=''>------</option>";
		}
	
		$sql = "SELECT id, bhp, bhp_unit 
			FROM " . GARAGE_DYNORUN_TABLE . " 
			WHERE garage_id = $cid";
	
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query dynorun', '', __LINE__, __FILE__, $sql);
		}
	
		while ( $dynorun = $db->sql_fetchrow($result) )
		{
			$rr_list .= "<option value='".$dynorun['id']."'>".$dynorun['bhp']." BHP @ ".$dynorun['bhp_unit']."</option>";
		}
		$db->sql_freeresult($result);
		
		$rr_list .= "</select>";
	
		$template->assign_vars(array(
			'RR_LIST' => $rr_list)
		);
	
		return;
	}
	
	/*========================================================================*/
	// Builds The HTML For Selecting Category Type Of Modification
	// Usage: category_dropdown('category id');
	/*========================================================================*/
	function category_dropdown($selected = NULL)
	{
		global $template, $db;

	        $html = '<select name="category_id" class="forminput">';
	
		$sql = "SELECT id, title
			FROM " . GARAGE_CATEGORIES_TABLE . " ORDER BY field_order ASC";
	
	     	if ( !($result = $db->sql_query($sql)) )
	      	{
	        	message_die(GENERAL_ERROR, 'Could not category of mods for vehicle', '', __LINE__, __FILE__, $sql);
	      	}
	
	        while ( $row = $db->sql_fetchrow($result) ) 
		{
			$select = ( $selected == $row['id'] ) ? ' selected="selected"' : '';
			$html .= '<option value="' . $row['id'] . '"' . $select . '>' . $row['title'] . '</option>';
	        }
	
	        $html .= '</select>';
	
		$template->assign_vars(array(
			'CATEGORY_LIST' => $html)
		);
	
		return ;
	}
	
	/*========================================================================*/
	// Builds The HTML For Selection Box
	// Usage: dropdown('select name', 'options text', 'options values', 'selected option');
	/*========================================================================*/
	function dropdown($select_name, $select_text, $select_types, $selected_option = NULL)
	{
		global $template, $user;
	
		$select = "<select name='".$select_name."'>";
		if (empty($selected_option))
		{
			$select .= '<option value="">'.$user->lang['SELECT_A_OPTION'].'</option>';
			$select .= '<option value="">------</option>';
		}
	
		for($i = 0; $i < count($select_text); $i++)
		{
			$selected = ( $selected_option == $select_types[$i] ) ? ' selected="selected"' : '';
			$select .= '<option value="' . $select_types[$i] . '"' . $selected . '>' . $select_text[$i] . '</option>';
		}
	
		$select .= '</select>';
	
		return $select;
	}
	
	/*========================================================================*/
	// Builds the HTML for attaching a image to entries
	// Usage: attach_image('modification'|'vehicle'|'quartermile'|'dynorun');
	/*========================================================================*/
	function attach_image($type)
	{
		global $template, $garage_config, $auth;

		//If No Premissions To Attach An Image Our Job Here Is Done ;)
		if ( (!$auth->acl_get('u_garage_upload_image')) OR (!$auth->acl_get('u_garage_remote_image')) )
		{
			return ;
		}

		//If Images For Mode Are Enabled Then Show Methods Enabled	
		if ( $garage_config['enable_'.$type.'_images'] ) 
		{
			//Setup Parent Template Block For Image Attachment
			$template->assign_block_vars('allow_images', array());

			//Define Image Limits
			$template->assign_vars(array(
				'MAXIMUM_IMAGE_FILE_SIZE'	=> $garage_config['max_image_kbytes'],
				'MAXIMUM_IMAGE_RESOLUTION'	=> $garage_config['max_image_resolution'])
			);

			//Show Upload Image Controls If Enabled
			if ( $garage_config['enable_uploaded_images'] )
			{
	      			$template->assign_block_vars('allow_images.upload_images', array());
		
			}
			//Show Remote Image Link If Enabled
			if ( $garage_config['enable_remote_images'] )
			{
	      			$template->assign_block_vars('allow_images.remote_images', array());
			}
		}
	
		return;
	}
	
	/*========================================================================*/
	// Builds The HTML For Editting Already Attached Images
	// Usage: edit_image('modification'|'vehicle'|'quartermile'|'dynorun', 'image id', 'image name')
	/*========================================================================*/
	function edit_image($type, $image_id, $image_name)
	{
		global $template, $garage_config, $auth;
	
		//If No Premissions To Attach An Image Our Job Here Is Done ;)
		if ( (!$auth->acl_get('u_garage_upload_image')) OR (!$auth->acl_get('u_garage_remote_image')) )
		{
			return ;
		}

		//If Images For Mode Are Enabled Then Show Methods Enabled	
		if ( $garage_config['enable_'.$type.'_images'] ) 
		{
			//Setup Parent Template Block For Image Attachment
			$template->assign_block_vars('allow_images', array());

			//Define Image Limits
			$template->assign_vars(array(
				'MAXIMUM_IMAGE_FILE_SIZE' => $garage_config['max_image_kbytes'],
				'MAXIMUM_IMAGE_RESOLUTION' => $garage_config['max_image_resolution'])
			);

			if ( !empty($image_id) )
			{
				//Display Option To Keep Image
	      			$template->assign_block_vars('allow_images.keep_image', array(
					'CURRENT_IMAGE' => $image_name)
				);
	
				//Display Option To Delete Image
	      			$template->assign_block_vars('allow_images.remove_image', array(
					'IMAGE_ID' => $image_id)
				);
				
				//Show Upload Image Controls If Enabled
				if  ($garage_config['enable_uploaded_images'] )
				{
	      				$template->assign_block_vars('allow_images.replace_image_upload', array());
				}
				//Show Remote Image Link If Enabled
				if ( ($garage_config['enable_remote_images'] ) AND (empty($image_id) == FALSE))
				{
	      				$template->assign_block_vars('allow_images.replace_remote_image', array());
				}
			}
			elseif (empty($image_id) )
			{
				//Show Upload Image Controls If Enabled
				if ( $garage_config['enable_uploaded_images'] )
				{
	      				$template->assign_block_vars('allow_images.upload_images', array());
				}
				//Show Remote Image Link If Enabled
				if ( $garage_config['enable_remote_images'] )
				{
	      				$template->assign_block_vars('allow_images.remote_images', array());
				}
			}

		}
		return;
	}
	
	/*========================================================================*/
	// Build Order HTML
	// Usage: order('selected');
	/*========================================================================*/
	function order($order)
	{
		global $template, $user;
	
		$order_html = '<select name="order">';
		if($order == 'ASC')
		{
			$order_html .= '<option value="ASC" selected="selected">' . $user->lang['ASCENDING_ORDER'] . '</option><option value="DESC">' . $user->lang['DESCENDING_ORDER'] . '</option>';
		}
		else
		{
			$order_html .= '<option value="ASC">' . $user->lang['ASCENDING_ORDER'] . '</option><option value="DESC" selected="selected">' . $user->lang['DESCENDING_ORDER'] . '</option>';
		}
		$order_html .= '</select>';

		$template->assign_vars(array(
			'S_ORDER_SELECT' => $order_html)
		);
		return;
	}

	/*========================================================================*/
	// Builds the array for a selecting for models
	// Usage:  vehicle_array();
	/*========================================================================*/
	function vehicle_array()
	{
		global $db;

		$make_q_id = "SELECT id, make FROM " . GARAGE_MAKES_TABLE . " ORDER BY make ASC";
	
		if( !($make_result = $db->sql_query($make_q_id)) )
		{
			message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
		}

		while ( $make_row = $db->sql_fetchrow($make_result) )
		{
			// Start this makes row in the output, this is where it gets confusing!
			$return .= 'cars["'.$make_row['make'].'"] = new Array("'.$make_row['id'].'", new Array(';

			$make_row_id = $make_row['id'];
        		$model_q_id = "SELECT id, model FROM " . GARAGE_MODELS_TABLE . " 
                		       WHERE make_id = $make_row_id ORDER BY model ASC";

			if( !($model_result = $db->sql_query($model_q_id)) )
			{
				message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
			} 

	        	$model_string = '';
			$model_id_string = '';

			// Loop through all the models of this make
			while ( $model_row = $db->sql_fetchrow($model_result) )
			{
				// Create the arrays that we will use in the output
				$model_string    .= '"'.$model_row['model'].'",';
				$model_id_string .= '"'.$model_row['id']   .'",';
			}
			$db->sql_freeresult($model_result);

			// Strip off the last comma
			$model_string    = substr($model_string,    0, -1);
			$model_id_string = substr($model_id_string, 0, -1);

			// Finish off this makes' row in the output
			$return .= $model_string ."), new Array(". $model_id_string ."));\n";
	        }
		$db->sql_freeresult($make_result);

	        return $return;
	}
}

$garage_template = new garage_template();

?>
