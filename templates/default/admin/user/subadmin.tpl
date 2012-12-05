{include file=$header1}
{include file=$header2}
{literal}
<script type="text/javascript">
$(document).ready(function()
{
	$("#checkall").click(function()
 	{
		//alert("hi");
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function()
		{
			this.checked = checked_status;
			change(this);	
		});
 	});
	$("input[@type=checkbox]").click(function()
 	{
		//alert("hi");
		change(this);
 	});
	function change(chk)
	{//alert("hi");
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
			$("#acterr").text("Select action").show().fadeOut(3000);
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
			$("#acterr").text("Select record").show().fadeOut(3000);
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
{/literal}

<!--<img src="{$siteroot}/templates/{$templatedir}/images/icons/add.png" align="absmiddle" /> <a href="{$siteroot}/admin/user/editsubadmin.php" rel ="contentarea">Add sub admin</a><br/>-->
<br><img src="{$siteroot}/templates/{$templatedir}/images/icons/add.png" align="absmiddle" /> <a href="{$siteroot}/admin/user/modules.php" rel ="contentarea">Level management</a><br>
<br><h3>Sub Admin</h3>
{if $msg}<div align="center" id="msg">{$msg}</div>{/if}
<table width="100%" border="0" >
		<TR><TD align="right"><A href="javascript:history.go(-1);">Back</A></TD></TR>
</table>

<div class="holdthisTop">

<table width="100%" cellspacing="0" cellpadding="0">
  
<tr><TD colspan="2">&nbsp;</TD></tr>
  <tr>
	<TD colspan="2">
	<div id="UserListDiv">
	<form name="frmAction" id="frmAction" method="post" action="">
		<table width="100%" cellspacing="2" cellpadding="3" class="listtable">
		<tr class="headbg">
		<td width="1%"><input type="checkbox" id="checkall"/></td>
		<!--<td width="*%">Login Name</td>-->
<td width="15%">First Name</td>
<td width="15%">Last Name</td>
		<td width="20%">Signup</td>
		<!--<td width="15%">Last Login</td>-->
		
		</tr>
		{section name=i loop=$users}
		<tr class="grayback" id="tr_{$users[i].userid}">
		<td><input type="checkbox" value="{$users[i].userid}" name="userid[]"/></td>
		<!--<td valign="top"><a href="viewsubadmin.php?userid={$users[i].userid}" title="Show User Details">
		{$users[i].username}</a></td>-->
<td valign="top"><a href="viewsubadmin.php?userid={$users[i].userid}" title="Show User Details">
		{$users[i].first_name|ucfirst}</a></td>
<td valign="top"><a href="viewsubadmin.php?userid={$users[i].userid}" title="Show User Details">
{$users[i].last_name}</a></td>
		<td valign="top">{$users[i].signup_date|date_format}</td>
		<!--<td valign="top">{$users[i].last_login_date|date_format:"%m-%d-%Y"}</td>-->
		
		</tr>
		{sectionelse}
		<tr>
		<td colspan="6"  align="center"><strong>No Records Found.</strong></td>
		</tr>
		{/section}
		
		 <tr><td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td><td align="left" colspan="5"><select name="action" id="action">
		<option value="">--Action--</option>
		<!--<option value="banned">Ban User</option>-->
		<option value="delete">Delete</option></select>
		<input type="submit"  value="Go"  /><span id="acterr" class="error"></span></td>
		</tr> 
		<!--<tr><td align="right" colspan="6">{if $showpgnation eq "yes"}{$pagenation}{/if}</td></tr>-->
		</table>
	</form>
	</div>
	</TD>
	
  </tr>
</table>
<br />

<!--<script type="text/javascript">searchUser({$smarty.get.page});</script>-->
{include file=$footer}