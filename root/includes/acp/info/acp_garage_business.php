<?php

/***************************************************************************
 *                      includes/acp/info/acp_garage_business.php
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

class acp_garage_business_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_garage_business',
			'title'		=> 'ACP_GARAGE_BUSINESS_MANAGEMENT',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'business'	=> array('title' => 'ACP_GARAGE_BUSINESS', 'auth' => 'acl_a_garage', 'cat' => array('ACP_GARAGE_CONFIGURATION')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>