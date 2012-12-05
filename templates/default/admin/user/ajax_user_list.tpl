
<form name="frmAction" id="frmAction" method="post" action="">
<div style="overflow:auto; width:100%; height: 100%;"> 
<table width="100%" cellspacing="2" cellpadding="3" class="listtable">
	<tr class="headbg">
			
			<td><input type="checkbox" id="checkall" style="display:none" /></td>
			<td><a href="javascript: void(0);" onclick="javascript: changeord('name');">First Name</a></td>
			<td><a href="javascript: void(0);" onclick="javascript: changeord('lname');">Last Name</a></td>
			<td><a href="javascript: void(0);" onclick="javascript: changeord('signup');">Date of Registered</a></td>
			<td><a href="javascript: void(0);" onclick="javascript: changeord('email');">Email</a></td>
			<!--<td width="23%"><a href="javascript: void(0);" onclick="javascript: changeord('email');">Password</a></td>-->
			<td style="width:50px"><a href="javascript: void(0);" >Address</a></td>
			<td><a href="javascript: void(0);" onclick="javascript: changeord('city');">City</a></td>
			<td><a href="javascript: void(0);" onclick="javascript: changeord('state');" >State</a></td>
			<td><a href="javascript: void(0);" >Zip code</a></td> <!--onclick="javascript: changeord('zipcode');"-->
			<td><a href="javascript: void(0);" >CC Info :</a></td><!--onclick="javascript: changeord('ccinfo');"-->

			<td><a href="javascript: void(0);" onclick="javascript: changeord('gift_card_purchased');" >List of Gift Cards Purchased :</a></td>
			<td><a href="javascript: void(0);" onclick="javascript: changeord('gift_card_spent');">List of Gift Cards Spent :</a></td>
			<td><a href="javascript: void(0);" onclick="javascript: changeord('total_gift_card_bought');">Total Gift Card Bought :</a></td>
			<td><a href="javascript: void(0);" onclick="javascript: changeord('total_gift_card_spent');">Total Gift Card Spent : </a></td>
			<td><a href="javascript: void(0);" >Status</a></td>
			<td><a href="javascript: void(0);" >Action</a></td>
			
		</tr>			
 <!-- <tr class="headbg">
		<td width="3%"><input type="checkbox" id="checkall" style="display:none" /></td>
		<td width="22%"><a href="javascript: void(0);" onclick="javascript: changeord('email');">Email</a></td>
		<td width="25%"><a href="javascript: void(0);" onclick="javascript: changeord('name');">Name</a></td>
		<td width="15%"><a href="javascript: void(0);" onclick="javascript: changeord('signup');">Date of Registered</a></td>
		<td width="25%"><a href="javascript: void(0);" >Address</a></td>
		<td width="10%"><a href="javascript: void(0);" >Status</a></td>
  </tr>-->
  {section name=i loop=$users}
	<tr class="grayback" id="chk{$smarty.section.i.iteration}">
			<td><input type="checkbox" value="{$users[i].userid}" name="userid[]"/></td>
			<td valign="top">
			<img src="{$siteimg}/icons/{if $users[i].status  eq
			'Suspended'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
				
						{$users[i].first_name}</td>
				<td valign="top">{$users[i].last_name}</td>
				<td valign="top">{$users[i].signup_date|date_format:"%m-%d-%Y"}</td>
				<td valign="top">{$users[i].email}</td>
				<!--<td valign="top">{$users[i].pass}</td>-->
				<td valign="top">{$users[i].address}</td>
				<td valign="top">{$users[i].city}</td>
				<td valign="top">{$users[i].state_name}</td>
				<td valign="top">{$users[i].zipcode}</td>
				<td valign="top">{$users[i].cc_info}</td>

				<td valign="top">{$users[i].tot_gift_card_bought}</td>
				<td valign="top">{$users[i].tot_gift_card_spent}</td>
				<td valign="top">{$users[i].tot_gift_card_bought}</td>
				<td valign="top">{$users[i].tot_gift_card_spent}</td>
				<td valign="top">{$users[i].status}</td>
				<td valign="top"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href="user_view.php?userid={$users[i].userid}" title="Show User Details"><u>View</u></a> | <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" /><a href="user_information.php?userid={$users[i].userid}" title="Edit User Details"><u>Edit</u></a></td>
		</tr>
 <!-- <tr class="grayback" id="chk{$smarty.section.i.iteration}">
		<td><input type="checkbox" value="{$users[i].userid}" name="userid[]"/></td>
		<td valign="top"><img src="{$siteimg}/icons/{if $users[i].status  eq
	'Suspended'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
		<a href="user_view.php?userid={$users[i].userid}" title="Show User Details">
		{$users[i].email}</a></td>
		<td valign="top">{$users[i].first_name} {$users[i].last_name}</td>
		<td valign="top">{$users[i].signup_date|date_format:"%m-%d-%Y"}</td>
		<td valign="top">{$users[i].all_address}</td>
		<td valign="top">{$users[i].status}</td>
  </tr>-->
  {sectionelse}
    <tr>
      <td colspan="6" class="error" align="center">No Records Found.</td>
    </tr>
  {/section}
  {if $users}
  <tr>
	<td align="right">
			<img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
	</td>
	<td align="left">
		<select name="action" id="action">
				<option value="">--Action--</option>
				<option value="Active">Activate</option>
				<option value="Suspended">Suspended</option>
				<option value="delete">Delete</option>
		</select>
		<input type="submit" name="submit" id="submit" value="Go" class="button1" />
	<span id="acterr" class="error"></span>
	</td>
			<td align="right" colspan="3">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
</tr>
	{/if}
</table>
</div>
</form>