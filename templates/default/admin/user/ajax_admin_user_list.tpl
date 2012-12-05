
<form name="frmAction" id="frmAction" method="post" action="">
<table width="100%" cellspacing="2" cellpadding="3" class="listtable">
  <tr class="headbg">
	<td width="3%"><input type="checkbox" id="checkall" style="display:none" /></td>
	<td width="22%"><a href="javascript: void(0);" onclick="javascript: changeord('username');">Username</a></td>
	<td width="25%"><a href="javascript: void(0);" onclick="javascript: changeord('name');">RealName</a></td>
	<td width="15%"><a href="javascript: void(0);" onclick="javascript: changeord('signup');">Created</a></td>
	<td width="25%">Last Login</td>
	<td width="25%">Level</td>
	<td width="10%">Status</td>
  </tr>
  {section name=i loop=$users}
  <tr class="grayback" id="chk{$smarty.section.i.iteration}">
	<td><input type="checkbox" value="{$users[i].userid}" name="userid[]"/></td>
	<td valign="top">
	<img src="{$siteimg}/icons/{if $users[i].status  eq
	'Suspended'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
	<a href="admin_user_view.php?userid={$users[i].userid}" title="Show User Details">
	{$users[i].username}</a></td>
	<td valign="top">{$users[i].first_name} {$users[i].last_name}</td>
	<td valign="top">{$users[i].signup_date|date_format:"%m-%d-%Y"}</td>
	<td valign="top">{$users[i].all_address}</td>
	<td valign="top">{$users[i].access_level}</td>
	<td valign="top">{$users[i].status}</td>
  </tr>
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
</form>