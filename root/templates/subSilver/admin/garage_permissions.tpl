<h1>{L_GARAGE_PERMISSIONS_TITLE}</h1>

<p>{L_GARAGE_PERMISSIONS_EXPLAIN}</p>

<script language='Javascript1.1'>
<!--
	function handleClick(id) 
	{
		var obj = "";	

		// Check browser compatibility
		if(document.getElementById)
			obj = document.getElementById(id);
		else if(document.all)
			obj = document.all[id];
		else if(document.layers)
			obj = document.layers[id];
		else
			return 1;

		if (!obj) {
			return 1;
		}
		else if (obj.style) 
		{			
			obj.style.display = ( obj.style.display != "none" ) ? "none" : "";
		}
		else 
		{ 
			obj.visibility = "show"; 
		}
	}


	function check_all(str_part) 
	{
		var f = document.permissions;

		//Here We Process And Turn On Admin,Mod,User,Guest Checkboxs In The Same Row.
		for (var i = 0 ; i < f.elements.length; i++)
		{
			var e = f.elements[i];
						
			if ( (e.name != 'UPLOAD_PRIVATE') && (e.name != 'BROWSE_PRIVATE') && (e.name != 'INTERACT_PRIVATE') && (e.name != 'ADD_PRIVATE') && (e.name != 'UPLOAD_ALL') && (e.name != 'BROWSE_ALL') && (e.name != 'INTERACT_ALL') && (e.name != 'ADD_ALL') && (e.type == 'checkbox') && (! e.disabled) )
			{
				s = e.name;
				a = s.substring(0, 4);
				
				if (a == str_part)
				{
					e.checked = true;
				}
			}
		}

		//Here We Make Sure That All Stays Checked If Admin,Mod,User,Guest Are Selected
		totalboxes = 0;
		total_on   = 0;
					
		for (var i = 0 ; i < f.elements.length; i++)
		{
			var e = f.elements[i];
						
			if ( (e.name != 'UPLOAD_PRIVATE') && (e.name != 'BROWSE_PRIVATE') && (e.name != 'INTERACT_PRIVATE') && (e.name != 'ADD_PRIVATE') && (e.name != 'UPLOAD_ALL') && (e.name != 'BROWSE_ALL') && (e.name != 'INTERACT_ALL') && (e.name != 'ADD_ALL') && (e.type == 'checkbox') )
			{
				s = e.name;
				a = s.substring(0, 4);
							
				if (a == str_part)
				{
					totalboxes++;
						
					if (e.checked)
					{
						total_on++;
					}
				}
			}
		}
				
		if (totalboxes == total_on)
		{
			if (str_part == 'BROW') 
			{
				 f.BROWSE_ALL.checked  = true; 
				 f.BROWSE_PRIVATE.checked  = false; 
			}
			if (str_part == 'BROW') 
			{ 
				f.INTERACT_ALL.checked = true; 
				f.INTERACT_PRIVATE.checked = false; 
			}
			if (str_part == 'ADD_') 
			{ 
				f.ADD_ALL.checked = true; 
				f.ADD_PRIVATE.checked = false; 
			}
			if (str_part == 'UPLO') 
			{ 
				f.UPLOAD_ALL.checked = true; 
				f.UPLOAD_PRIVATE.checked = false; 
			}
		}
	}

	function private_checked(str_part) 
	{
		var f = document.permissions;

		//Here We Process And Turn On Admin,Mod,User,Guest Checkboxs In The Same Row.
		for (var i = 0 ; i < f.elements.length; i++)
		{
			var e = f.elements[i];
						
			if ( (e.name != 'UPLOAD_ADMIN') && (e.name != 'BROWSE_ADMIN') && (e.name != 'INTERACT_ADMIN') && (e.name != 'ADD_ADMIN') && (e.name != 'UPLOAD_MOD') && (e.name != 'BROWSE_MOD') && (e.name != 'INTERACT_MOD') && (e.name != 'ADD_MOD') && (e.name != 'UPLOAD_PRIVATE') && (e.name != 'BROWSE_PRIVATE') && (e.name != 'INTERACT_PRIVATE') && (e.name != 'ADD_PRIVATE') && (e.type == 'checkbox') && (! e.disabled) )
			{
				s = e.name;
				a = s.substring(0, 4);
				
				if (a == str_part)
				{
					e.checked = false;
				}
				
			}
		}
	}

	function obj_checked(IDnumber) 
	{
		var f = document.permissions;
					
		str_part = '';
					
		if (IDnumber == 1) { str_part = 'BROW' }
		if (IDnumber == 2) { str_part = 'INTE' }
		if (IDnumber == 3) { str_part = 'ADD_' }
		if (IDnumber == 4) { str_part = 'UPLO' }
					
		totalboxes = 0;
		total_on   = 0;
					
		for (var i = 0 ; i < f.elements.length; i++)
		{
			var e = f.elements[i];
						
			if ( (e.name != 'UPLOAD_PRIVATE') && (e.name != 'BROWSE_PRIVATE') && (e.name != 'INTERACT_PRIVATE') && (e.name != 'ADD_PRIVATE') && (e.name != 'UPLOAD_ALL') && (e.name != 'BROWSE_ALL') && (e.name != 'INTERACT_ALL') && (e.name != 'ADD_ALL') && (e.type == 'checkbox') )
			{
				s = e.name;
				a = s.substring(0, 4);
							
				if (a == str_part)
				{
					totalboxes++;
						
					if (e.checked)
					{
						total_on++;
					}
				}
			}
		}
				
		if (totalboxes == total_on)
		{
			if (IDnumber == 1) 
			{
				 f.BROWSE_ALL.checked  = true; 
				 f.BROWSE_PRIVATE.checked  = false; 
			}
			if (IDnumber == 2) 
			{ 
				f.INTERACT_ALL.checked = true; 
				f.INTERACT_PRIVATE.checked = false; 
			}
			if (IDnumber == 3) 
			{ 
				f.ADD_ALL.checked = true; 
				f.ADD_PRIVATE.checked = false; 
			}
			if (IDnumber == 4) 
			{ 
				f.UPLOAD_ALL.checked = true; 
				f.UPLOAD_PRIVATE.checked = false; 
			}
		}
		else
		{
			if (IDnumber == 1) { f.BROWSE_ALL.checked  = false; }
			if (IDnumber == 2) { f.INTERACT_ALL.checked = false; }
			if (IDnumber == 3) { f.ADD_ALL.checked = false; }
			if (IDnumber == 4) { f.UPLOAD_ALL.checked = false; }
		}
	}
				
//-->
</script>


<form name='permissions' action="{S_GARAGE_ACTION}" method="post">
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thHead" height="25" nowrap="nowrap" colspan="6">{L_PERMISSION_ACCESS_LEVELS}</th>
	</tr>
	<tr>
		<td class="catBottom" width=40% ><span class="gen">{L_NAME}</span></td>
		<td class="catBottom" align ="center" width=12%><span class="gen">{L_DENY}</span></td>
		<td class="catBottom" align ="center" width=12%><span class="gen">{L_BROWSE}</span></td>
		<td class="catBottom" align ="center" width=12%><span class="gen">{L_INTERACT}</span></td>
		<td class="catBottom" align ="center" width=12%><span class="gen">{L_ADD}</span></td>
		<td class="catBottom" align ="center" width=12%><span class="gen">{L_UPLOAD}</span></td>
	</tr>
	<tr>
		<td class="row1" colspan="6"><span class="gen">{L_GLOBAL_ALL_MASKS}</td>
	</tr>
	<tr>
		<td class="row2" width="40%" align="center" valign="middle"><div align="right" style="font-weight:bold">{L_ALL_MASKS}&nbsp;</div></td>
		<td class='row1' width='12%' valign='middle'></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" onClick="check_all('BROW')" name="BROWSE_ALL" value="1" {BROWSE_ALL_CHECKED} /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" onClick="check_all('INTE')" name="INTERACT_ALL" value="1" {INTERACT_ALL_CHECKED} /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" onClick="check_all('ADD_')" name="ADD_ALL" value="1"{ADD_ALL_CHECKED} /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" onClick="check_all('UPLO')" name="UPLOAD_ALL" value="1" {UPLOAD_ALL_CHECKED} /></td>
	</tr>
	<tr>
		<td class="row1" colspan="6"><span class="gen">{L_GRANULAR_PERMISSIONS}</td>
	</tr>
	<tr>
		<td class="row2" width="40%" align="center" valign="middle"><div align="right" style="font-weight:bold">{L_ADMINISTRATORS}&nbsp;</div></td>
		<td class='row1' width='12%' valign='middle'></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="BROWSE_ADMIN" value="1" {BROWSE_ADMIN_CHECKED} onclick="obj_checked(1)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="INTERACT_ADMIN" value="1" {INTERACT_ADMIN_CHECKED} onclick="obj_checked(2)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="ADD_ADMIN" value="1" {ADD_ADMIN_CHECKED} onclick="obj_checked(3)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="UPLOAD_ADMIN" value="1" {UPLOAD_ADMIN_CHECKED} onclick="obj_checked(4)" /></td>
	</tr>
	<tr>
		<td class="row2" width="40%" align="center" valign="middle"><div align="right" style="font-weight:bold">{L_MODERATORS}&nbsp;</div></td>
		<td class='row1' width='12%' valign='middle'></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="BROWSE_MOD" value="1" {BROWSE_MOD_CHECKED} onclick="obj_checked(1)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="INTERACT_MOD" value="1" {INTERACT_MOD_CHECKED} onclick="obj_checked(2)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="ADD_MOD" value="1" {ADD_MOD_CHECKED} onclick="obj_checked(3)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="UPLOAD_MOD" value="1" {UPLOAD_MOD_CHECKED} onclick="obj_checked(4)" /></td>
	</tr>
	<tr>
		<td class="row2" width="40%" align="center" valign="middle"><div align="right" style="font-weight:bold">{L_REGISTERED_USERS}&nbsp;</div></td>
		<td class='row1' width='12%' valign='middle'></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="BROWSE_USER" value="1" {BROWSE_USER_CHECKED} onclick="obj_checked(1)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="INTERACT_USER" value="1" {INTERACT_USER_CHECKED} onclick="obj_checked(2)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="ADD_USER" value="1" {ADD_USER_CHECKED} onclick="obj_checked(3)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="UPLOAD_USER" value="1" {UPLOAD_USER_CHECKED} onclick="obj_checked(4)" /></td>
	</tr>
	<tr>
		<td class="row2" width="40%" align="center" valign="middle"><div align="right" style="font-weight:bold">{L_GUEST_USERS}&nbsp;</div></td>
		<td class='row1' width='12%' valign='middle'></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="BROWSE_GUEST" value="1" {BROWSE_GUEST_CHECKED} onclick="obj_checked(1)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="INTERACT_GUEST" value="1" {INTERACT_GUEST_CHECKED} onclick="obj_checked(2)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="ADD_GUEST" value="1" {ADD_GUEST_CHECKED} onclick="obj_checked(3)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="UPLOAD_GUEST" value="1" {UPLOAD_GUEST_CHECKED} onclick="obj_checked(4)" /></td>
	</tr>
	<tr>
		<td class="row2" width="40%" align="center" valign="middle"><div align="right" style="font-weight:bold">{L_PRIVATE}&nbsp;</div></td>
		<td class='row1' width='12%' valign='middle'></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="BROWSE_PRIVATE" value="1" {BROWSE_PRIVATE_CHECKED} onclick="obj_checked(1)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="INTERACT_PRIVATE" value="1" {INTERACT_PRIVATE_CHECKED} onclick="obj_checked(2)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="ADD_PRIVATE" value="1" {ADD_PRIVATE_CHECKED} onclick="obj_checked(3)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="UPLOAD_PRIVATE" value="1" {UPLOAD_PRIVATE_CHECKED} onclick="obj_checked(4)" /></td>
	</tr>
	<tr>
		<td class="row1" colspan="6"><span class="gen">{L_PRIVATE_PERMISSIONS}</td>
	</tr>
	<!-- BEGIN usergroup -->
	<tr>
		<td class="row2" width="40%" align="center" valign="middle"><div align="right" style="font-weight:bold">{usergroup.GROUP_NAME}&nbsp;</div></td>
		<td class='row1' width='12%'  valign='middle'><center id='mgblue'><input type='checkbox' name='deny[]' value='{usergroup.GROUP_ID}'{usergroup.DENY_CHECKED} ></center></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="browse[]" value="{usergroup.GROUP_ID}" {usergroup.BROWSE_CHECKED} onclick="obj_checked(1)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="interact[]" value="{usergroup.GROUP_ID}" {usergroup.INTERACT_CHECKED} onclick="obj_checked(2)" /></td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="add[]" value="{usergroup.GROUP_ID}" {usergroup.ADD_CHECKED} onclick="javascript:handleClick('add{usergroup.GROUP_ID}')" />
			<table cellpadding="5" cellspacing="1" border="0"> 
				<tr id="add{usergroup.GROUP_ID}" style="display:none;">
					<td>{L_ADD_QUOTA} : <input name="add_quota[]" type="text" class="post" size="3" value="{usergroup.ADD_QUOTA}" /></td>
				</tr>
			</table>
		</td>
		<td class="row1" width="12%" align="center" valign="middle"><input type="checkbox" name="upload[]" value="{usergroup.GROUP_ID}" {usergroup.UPLOAD_CHECKED} onclick="javascript:handleClick('upload{usergroup.GROUP_ID}')" />
			<table cellpadding="5" cellspacing="1" border="0"> 
				<tr id="upload{usergroup.GROUP_ID}" style="display:none;">
					<td>{L_UPLOAD_QUOTA} : <input name="add_quota[]" type="text" class="post" size="3" value="{usergroup.UPLOAD_QUOTA}" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END usergroup -->
	<tr>
		<td class="catBottom" align="center" height="28" colspan="6"><input type="hidden" value="update_permissions" name="mode" /><input name="submit" type="submit" value="{L_SAVE}" class="liteoption" /></td>
	</tr>
</table>
</form>

