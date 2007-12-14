<?php

if (!defined('IN_PHPBB'))
{
	exit;
}

// Set prosilver info with imageset data to update
$prosilver_info = array(
	'css'	=> '
	/* Toggle */
#garage-toggle {
	padding: 0px;
	width: 16%;
	height: 10px;
	left: 16%;
	margin-left: 2px;
}

#garage-toggle-handle {
	display: block;
	width: 18px;
	height: 19px;
	float: right;
	background-image: url("styles/prosilver/imageset/garage_toggle.gif");
}

/* Menu Panel */
#garage-menu {
	float:left;
	width: 19%;
	margin-top: 0em;
}

#garage-main {
	float: left;
	width: 81%;
}

#garage-menu span.corners-top {
	background-image: none;
}

#garage-menu span.corners-top span {
	background-image: none;
}

#garage-menu span.corners-bottom {
	background-image: none;
}

#garage-menu span.corners-bottom span {
	background-image: none;
}

#garage-main span.corners-top, #garage-menu span.corners-top {
	background-image: url("{T_THEME_PATH}/images/corners_left2.gif");
}

#garage-main span.corners-top span, #garage-menu span.corners-top span {
	background-image: url("{T_THEME_PATH}/images/corners_right2.gif");
}

#garage-main span.corners-bottom, #garage-menu span.corners-bottom {
	background-image: url("{T_THEME_PATH}/images/corners_left2.gif");
}

#garage-main span.corners-bottom span, #garage-menu span.corners-bottom span {
	background-image: url("{T_THEME_PATH}/images/corners_right2.gif");
}

.vehicles-mini {
	background-color: #f9f9f9;
	padding: 0 5px;
	margin: 0px 10px 10px 0px;
	width: auto;
	white-space: nowrap;
}

.vehicles-mini span.corners-top, .vehicles-mini span.corners-bottom {
	margin: 0 -5px;
}

.vehicle-mini dl.mini {
	width: auto;
}



/* Icon used in viewtopic_body.html */
.garage-icon, .garage-icon a	{ 
					background: none top left no-repeat;
					background-image: url("{IMG_GARAGE_ICON_GARAGE_SRC}"); 
				}
ul.profile-icons li.garage-icon	{ width: {IMG_GARAGE_ICON_GARAGE_WIDTH}px; height: {IMG_GARAGE_ICON_GARAGE_HEIGHT}px; }

/* Icons used in garage_view_vehicle.html */

/* Poster profile icons
----------------------------------------*/
ul.manage-vehicle-icons {
	padding-top: 5px;
	list-style: none;
}

/* Rollover state */
ul.manage-vehicle-icons li {
	float: left;
	margin: 0 6px 3px 0;
	background-position: 0 100%;
}

.rtl ul.manage-vehicle-icons li {
	margin: 0 0 3px 6px;
}

/* Rolloff state */
ul.manage-vehicle-icons li a {
	display: block;
	width: 100%;
	height: 100%;
	background-position: 0 0;
}

/* Hide <a> text and hide off-state image when rolling over (prevents flicker in IE) */
ul.manage-vehicle-icons li span { display:none; }
ul.manage-vehicle-icons li a:hover { background: none; }

.newvehicle-icon, .newvehicle-icon a { 
	background: transparent none 0 0 no-repeat; 
}

ul.manage-vehicle-icons li.newvehicle-icon {
	width: {IMG_GARAGE_CREATE_VEHICLE_WIDTH}px; height: {IMG_GARAGE_CREATE_VEHICLE_HEIGHT}px; 
}
.viewvehicle-icon, .viewvehicle-icon a { 
	background: transparent none 0 0 no-repeat; 
						}
ul.manage-vehicle-icons li.viewvehicle-icon	{ 
	width: {IMG_GARAGE_VIEW_VEHICLE_WIDTH}px; height: {IMG_GARAGE_VIEW_VEHICLE_HEIGHT}px; 
						}
.editvehicle-icon, .editvehicle-icon a		{ 
	background: transparent none 0 0 no-repeat; 
						}
ul.manage-vehicle-icons li.editvehicle-icon	{ 
	width: {IMG_GARAGE_EDIT_VEHICLE_WIDTH}px; height: {IMG_GARAGE_EDIT_VEHICLE_HEIGHT}px; 
						}
.deletevehicle-icon, .deletevehicle-icon a	{ 
	background: transparent none 0 0 no-repeat; 
						}
ul.manage-vehicle-icons li.deletevehicle-icon	{ 
	width: {IMG_GARAGE_DELETE_VEHICLE_WIDTH}px; height: {IMG_GARAGE_DELETE_VEHICLE_HEIGHT}px; 
						}
.mainvehicle-icon, .mainvehicle-icon a		{ 
	background: transparent none 0 0 no-repeat; 
						}
ul.manage-vehicle-icons li.mainvehicle-icon	{ 
	width: {IMG_GARAGE_MAIN_VEHICLE_WIDTH}px; height: {IMG_GARAGE_MAIN_VEHICLE_HEIGHT}px; 
						}
.newmodification-icon, .newmodification-icon a	{ 
	background: transparent none 0 0 no-repeat; 
						}
ul.manage-vehicle-icons li.newmodification-icon	{ 
	width: {IMG_GARAGE_ADD_MODIFICATION_WIDTH}px; height: {IMG_GARAGE_ADD_MODIFICATION_HEIGHT}px; 
						}
.newpremium-icon, .newpremium-icon a		{ 
	background: transparent none 0 0 no-repeat; 
						}
ul.manage-vehicle-icons li.newpremium-icon	{ 
	width: {IMG_GARAGE_ADD_INSURANCE_WIDTH}px; height: {IMG_GARAGE_ADD_INSURANCE_HEIGHT}px; 
						}
.newquartermile-icon, .newquartermile-icon a	{ 
	background: transparent none 0 0 no-repeat; 
						}
ul.manage-vehicle-icons li.newquartermile-icon	{ 
	width: {IMG_GARAGE_ADD_QUARTERMILE_WIDTH}px; height: {IMG_GARAGE_ADD_QUARTERMILE_HEIGHT}px; 
						}
.newdynorun-icon, .newdynorun-icon a		{ 
	background: transparent none 0 0 no-repeat; 
						}
ul.manage-vehicle-icons li.newdynorun-icon	{ 
	width: {IMG_GARAGE_ADD_DYNORUN_WIDTH}px; height: {IMG_GARAGE_ADD_DYNORUN_HEIGHT}px; 
						}
.newlap-icon, .newlap-icon a			{ 
	background: transparent none 0 0 no-repeat; 
						}
ul.manage-vehicle-icons li.newlap-icon		{ 
	width: {IMG_GARAGE_ADD_LAP_WIDTH}px; height: {IMG_GARAGE_ADD_LAP_HEIGHT}px; 
}
.newservice-icon, .newservice-icon a		{ 
	background: transparent none 0 0 no-repeat; 
}
ul.manage-vehicle-icons li.newservice-icon	{ 
	width: {IMG_GARAGE_ADD_SERVICE_WIDTH}px; height: {IMG_GARAGE_ADD_SERVICE_HEIGHT}px; 
}

.newvehicle-icon, .newvehicle-icon a		{ background-image: url("{IMG_GARAGE_CREATE_VEHICLE_SRC}"); }
.viewvehicle-icon, .viewvehicle-icon a		{ background-image: url("{IMG_GARAGE_VIEW_VEHICLE_SRC}"); }
.editvehicle-icon, .editvehicle-icon a		{ background-image: url("{IMG_GARAGE_EDIT_VEHICLE_SRC}"); }
.deletevehicle-icon, .deletevehicle-icon a	{ background-image: url("{IMG_GARAGE_DELETE_VEHICLE_SRC}"); }
.mainvehicle-icon, .mainvehicle-icon a		{ background-image: url("{IMG_GARAGE_MAIN_VEHICLE_SRC}"); }
.newmodification-icon, .newmodification-icon a	{ background-image: url("{IMG_GARAGE_ADD_MODIFICATION_SRC}"); }
.newpremium-icon, .newpremium-icon a		{ background-image: url("{IMG_GARAGE_ADD_INSURANCE_SRC}"); }
.newquartermile-icon, .newquartermile-icon a	{ background-image: url("{IMG_GARAGE_ADD_QUARTERMILE_SRC}"); }
.newdynorun-icon, .newdynorun-icon a		{ background-image: url("{IMG_GARAGE_ADD_DYNORUN_SRC}"); }
.newlap-icon, .newlap-icon a			{ background-image: url("{IMG_GARAGE_ADD_LAP_SRC}"); }
.newservice-icon, .newservice-icon a		{ background-image: url("{IMG_GARAGE_ADD_SERVICE_SRC}"); }

.garage-mini {
	background-color: #f9f9f9;
	padding: 0 5px;
	margin: 10px 15px 10px 5px;
}

.garage-mini span.corners-top, .garage-mini span.corners-bottom {
	margin: 0 -5px;
}


/* Icons Used In overall_header.html */
.icon-garage, .icon-quartermile, .icon-dynorun{
	background-position: 0 50%;
	background-repeat: no-repeat;
	background-image: none;
	padding: 1px 0 0 17px;
}

.rtl .icon-garage, .rtl icon-quartermile, .rtl .icon-dynorun{
	background-position: 100% 50%;
	padding: 1px 17px 0 0;
}

.icon-garage		{ background-image: url("{T_THEME_PATH}/images/icon_garage.gif"); }
.icon-quartermile	{ background-image: url("{T_THEME_PATH}/images/icon_quartermile.gif"); }
.icon-dynorun		{ background-image: url("{T_THEME_PATH}/images/icon_dynorun.gif"); }

dt.index_block_header, dd.index_block_header {
	width: 33%;
	text-align: center;
	line-height: 2.2em;
	font-size: 1.2em;
}

dt.index_block, dd.index_block {
	width: 33%;
	text-align: center;
	font-size: 1.0em;
}


/* Second Set Of Tabs */
#gtabs {
	line-height: normal;
	margin: 5px 0 -1px 7px;
	min-width: 570px;
}

#gtabs ul {
	margin:0;
	padding: 0;
	list-style: none;
}

#gtabs li {
	display: inline;
	margin: 0;
	padding: 0;
	font-size: 1em;
	font-weight: bold;
}

#gtabs a {
	float: left;
	background: none no-repeat 0% -35px;
	margin: 0 1px 0 0;
	padding: 0 0 0 5px;
	text-decoration: none;
	position: relative;
	cursor: pointer;
}

#gtabs a span {
	float: left;
	display: block;
	background: none no-repeat 100% -35px;
	padding: 6px 10px 6px 5px;
	color: #828282;
	white-space: nowrap;
}

#gtabs a:hover span {
	color: #bcbcbc;
}

#gtabs .activetab a {
	background-position: 0 0;
	border-bottom: 1px solid #ebebeb;
}

#gtabs .activetab a span {
	background-position: 100% 0;
	padding-bottom: 7px;
	color: #333333;
}

#gtabs a:hover {
	background-position: 0 -70px;
}

#gtabs a:hover span {
	background-position:100% -70px;
}

#gtabs .activetab a:hover {
	background-position: 0 0;
}

#gtabs .activetab a:hover span {
	color: #000000;
	background-position: 100% 0;
}

#gtabs a {
	background-image: url("{T_THEME_PATH}/images/bg_tabs1.gif");
}

#gtabs a span {
	background-image: url("{T_THEME_PATH}/images/bg_tabs2.gif");
	color: #536482;
}

#gtabs a:hover span {
	color: #BC2A4D;
}

#gtabs .activetab a {
	border-bottom-color: #CADCEB;
}

#gtabs .activetab a span {
	color: #333333;
}

#gtabs .activetab a:hover span {
	color: #000000;
}

/* Nice method for clearing floated blocks without having to insert any extra markup (like spacer above)
   From http://www.positioniseverything.net/easyclearing.html */
#gtabs:after, .post:after, .navbar:after, fieldset dl:after, ul.garage_list dl:after, ul.linklist:after, dl.polls:after {
	content: "."; 
	display: block; 
	height: 0; 
	clear: both; 
	visibility: hidden;
}

#gtabs, .post, .navbar, fieldset dl, ul.garage_list dl, ul.linklist, dl.polls {
	height: 1%;
}


/* List Styling */
* html ul.garage_list li { position: relative; }

ul.garage_list li {
	color: #4C5D77;
}

ul.garage_list dd {
	border-left-color: #FFFFFF;
}

ul.garage_list {
	display: block;
	list-style-type: none;
	margin: 0;
}

ul.garage_list li {
	display: block;
	list-style-type: none;
	color: #777777;
	margin: 0;
}

ul.garage_list dl {
	position: relative;
}

ul.garage_list li.row dl {
	padding: 2px 0;
}

ul.garage_list dt {
	display: block;
	float: left;
	font-size: 1.1em;
	padding-left: 4px;
}

ul.garage_list dd {
	display: block;
	float: left;
	border-left: 1px solid #FFFFFF;
	padding: 4px 0;
}

ul.garage_list dfn {
	/* Labels for post/view counts */
	display: none;
}

ul.garage_list li.row dt a.subforum {
	background-image: none;
	background-position: 0 50%;
	background-repeat: no-repeat;
	position: relative;
	white-space: nowrap;
	padding: 0 0 0 12px;
}

ul.garage_list dt.image_attached, ul.garage_list dd.image_attached {
	width: 22px;
}


/*Garage Rollover Images For Camera, Edit & Delete */
a.garage-camera-icon, a.garage-delete-icon, a.garage-edit-icon {
	background-image: none;
	width: 20px;
}
a.garage-camera-icon, a.garage-delete-icon, a.garage-edit-icon {
	display: block;
	overflow: hidden;
	height: 20px;
	text-indent: -5000px;
	text-align: left;
	background-repeat: no-repeat;
}
a.garage-camera-icon {
	background-image: url("{IMG_GARAGE_IMG_ATTACHED_SRC}");
}
a.garage-delete-icon { 
	background-image: url("{IMG_GARAGE_DELETE_SRC}"); 
}
a.garage-edit-icon {
	background-image: url("{IMG_GARAGE_EDIT_SRC}"); 
}
a.garage-camera-icon:hover, a.garage-delete-icon:hover, a.garage-edit-icon:hover {
	background-position: 0 -20px;
}

#garage-copyright {
	display: block;
	text-align: center;
	vertical-align: bottom
}

/* Set Width */
.gwidth-5 {
	width: 5%;
}
.gwidth-10 {
	width: 10%;
}

.gwidth-20 {
	width: 20%;
}

.gwidth-30 {
	width: 30%;
}

.gwidth-40 {
	width: 40%;
}

.gwidth-50 {
	width: 50%;
}
'
);

?>

