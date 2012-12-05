{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}

<div class="holdthisTop">
	<div>
    		<div class="fl width50">
      			<h3>{$sitetitle} users</h3>
    		</div>
   	<div class="clr">
	   </div>
     	{if $msg}<div align="center" id="msg">{$msg}</div>{/if}
  	</div>
    <div align="right">
        <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="add_user.php">Add New User</a>
    </div><br/>
    <div align="right">
        <a href="javascript:history.go(-1);"><!--Back--></a>
    </div><br>

    <div id="UserListDiv" name="UserListDiv">
 <form name="frmAction" id="frmAction" method="post" action="">

	<table cellspacing="2" cellpadding="3" class="listtable">	
		<tr class="headbg">			
			<td width="5%" align="center"><input type="checkbox" id="checkall" style="display:none" /></td>
			<td width="10%" align="left"><!--<a href="javascript: void(0);" onclick="javascript: changeord('name');">-->First&nbsp;Name<!--</a>--></td>
			<td width="10%" align="left"><!--<a href="javascript: void(0);" onclick="javascript: changeord('lname');">-->Last&nbsp;Name<!--</a>--></td>
			<td width="10%" align="left"><!--<a href="javascript: void(0);" onclick="javascript: changeord('signup');">-->Date&nbsp;of Registration<!--</a>--></td>
			<td width="20%" align="left"><!--<a href="javascript: void(0);" onclick="javascript: changeord('email');">-->Email<!--</a>--></td>
			<td width="10%" align="left"><!--<a href="javascript: void(0);" onclick="javascript: changeord('city');">-->City&nbsp;&nbsp;&nbsp;<!--</a>--></td>
			<td width="10%" align="left"><!--<a href="javascript: void(0);" onclick="javascript: changeord('zipcode');">-->Postcode<!--</a>--></td> 
			<td width="10%" align="left"><!--<a href="javascript: void(0);" >-->Status (Active/Inactivated)<!--</a>--></td>			
			<td width="30%" align="left"><div style="width:80px;"><!--<a href="javascript: void(0);" >-->Action<!--</a>--></div></td>
			
		</tr>			
		{section name=i loop=$users}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
			<td><input type="checkbox" value="{$users[i].userid}" name="userid[]"/></td>
			<td valign="top">
			<img src="{$siteimg}/icons/{if $users[i].status  eq
			'inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
				
         <a href="user_information.php?userid={$users[i].userid}" title="Edit User Details">{$users[i].first_name}</a></td>
				<td valign="top"><a href="user_information.php?userid={$users[i].userid}" title="Edit User Details">{$users[i].last_name}</a></td>
				<td valign="top">{$users[i].signup_date|date_format}</td>
				<td valign="top">{$users[i].email}</td>
				<td valign="top">{$users[i].city}</td>
				<td valign="top">{$users[i].postalcode}</td>
				<td valign="top">{if $users[i].status eq 'active'} Active {else} Inactivated {/if}</td>
				<td>
                       
					       <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
						      <a href="user_view.php?userid={$users[i].userid}" title="Show User Details">
							   <strong>View</strong></a>&nbsp;/&nbsp;<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
						<a href="user_information.php?userid={$users[i].userid}" title="Edit User Details">
							   <strong>Edit</strong></a>
  
				</td>
		</tr>
		{sectionelse}
			<tr><td colspan="6" class="error" align="center">No Records Found.</td></tr>
		{/section}			
		{if $users}
		<tr>
			<td align="right">
					<img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
			</td>
			<td align="left" width="30px" colspan="3">
				<select name="action" id="action">
						<option value="">--Action--</option>
						<option value="Active">Active</option>
						<option value="Suspended">Inactivate</option>
						<option value="delete">Delete</option>
				</select>
			<!--</td>
			<td>-->
				<input type="submit" name="submit" id="submit" value="Go"  />
			<div id="acterr" class="error"></div>
			</td>
			<td align="right" colspan="3">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>

</form></div>
</div>
{include file=$footer}