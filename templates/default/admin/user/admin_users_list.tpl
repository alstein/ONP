{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript">
{literal}
$(document).ready(function(){
	$("#checkall").click(function(){
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function(){
			this.checked = checked_status;
			change(this);	
		});
 	});
	$("input[@type=checkbox]").click(function(){
		change(this);
 	});
	function change(chk){
		var $tr = $(chk).parent().parent();
		if($tr.attr('id'))
		{
			if($tr.attr('class')=='selectedrow' && !chk.checked)
				$tr.removeClass('selectedrow').addClass('grayback');
			else
				$tr.removeClass('grayback').addClass('selectedrow');
		}
	}
	var flag = false;
	$("#frmAction").submit(function(){
		
		if($("#action").attr('value')=='')
		{
			$("#acterr").text("Please Select Action.").show().fadeOut(3000);
			return false;
		}
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
		
		if (flag == false) {
			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });
    $("#msg").fadeOut(5000);
});
</script>
<script type="text/javascript">
	function changeit(val){
		location.href=SITEROOT+"admin/user/admin_users_list.php?usertypeid="+val;
		return false;
	}
</script>
<!--<script type="text/javascript">//searchUser({$smarty.get.page});</script>-->
{/literal}
{include file=$header2}
<div class="holdthisTop">
<div><h3>{$sitetitle} Admin Users</h3>
      <table width="100%" align="right" cellpadding="0" cellspacing="0">
        <tr><td><img src="{$siteroot}/templates/{$templatedir}/images/icons/add.png" align="absmiddle" />
	<a href="add_admin_user.php">Add Admin User</a>
	</td>
            <td align="right">
            <label><!--<form name="frmSubmit" method="post" action="">--><input name="searchuser" type="text" id="searchuser" value="" size="35" class="search"  onkeypress="javascript: return keyCatch(event)" />
                <input type="hidden" id="sorttype" value="" />
                <input type="hidden" id="sortord" value="" />
		<input name="admin_user" id="admin_user" value="1" type="hidden"><!--</form>-->
            </label>
            </td>
            <td width="10%" align="left">
                <input type="submit" name="button" id="button" value="Submit" class="searchbutton" onclick="searchUser();" />
            </td>
       	</tr>
      </table>
  <div class="clr"></div>
{if $msg} 
  <div align="center">{$msg} </div>
  {/if} 
</div>
<br><div id="UserListDiv" name="UserListDiv">
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
			<tr><td colspan="6" class="error" align="center">No Records Found.</td></tr>
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
</form></div>
{include file=$footer}