{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist1.js"></script>

{include file=$header2}
{literal}
<script type="text/javascript">
function sort_all(s_name,s_type)
{
    var str_url = SITEROOT+"/admin/user/manage_admin.php?sortby="+s_name+"&sorttype="+s_type;

//     var srch=document.getElementById('searchuser').value;
// 
//     if(srch)
//         str_url = str_url+"&searchuser="+srch;
    var pg=document.getElementById('pg').value;
    if(pg)
        str_url = str_url+"&page="+pg;

    window.location=str_url;
}
</script>
{/literal}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Admin User</div>
<br />

<div class="holdthisTop">
    <div>
	<div class="fl width50">
		<h3>{$sitetitle} Admin</h3>
	</div>
{*
<!--         <div align="right"><p align="right" style="width:400px;float:right;">
		{if $mnt eq "mnt"}
				<a href="manage_admin.php?mnt_flag={$mnt}" style="color:red">Move Site To Maintenance Status</a>
		{else}
				<a href="manage_admin.php?mnt_flag={$mnt}" style="color:green">Move Site To Live Status</a>
		{/if}
		 </p></div>-->
*}




	<div class="clr">&nbsp;</div>
	  <div class="fl width50">
	   <!--  <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="add-admin.php">Add New Admin</a>-->
          </div>
	<div class="clr">&nbsp;</div>
	  <div class="fl width50">
	    <!-- <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="modules.php">Level Management</a>-->
          </div>
	<div class="clr">&nbsp;</div>
	{if $msg}<div align="center" id="msg">{$msg}</div>{/if}
    </div>
    <div class="clr">&nbsp;</div>
    <div id="UserListDiv" name="UserListDiv">
      <form name="frmAction" id="frmAction" method="post" action="">
<input type="hidden" id="pg" name="pg" value="{if $smarty.get.page}{$smarty.get.page}{else}1{/if}">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
		<tr class="headbg">			
		  <td width="1%" align="center"><!--<input type="checkbox" id="checkall"/>--></td>
		  <td width="13%" align="left">Username</td>
		  <td width="10%" align="left"><a href="javascript:void(0)" onclick="sort_all('fullname',document.getElementById('sorttype_name').value);">Full Name</a><input type="hidden" name="sorttype_name" id="sorttype_name" value="{if $sorttype_name}{$sorttype_name}{else}ASC{/if}"/></td>
		  <td width="15%" align="left"><a href="javascript:void(0)" onclick="sort_all('email',document.getElementById('sorttype_email').value);">Email</a>
			 <input type="hidden" name="sorttype_email" id="sorttype_email" value="{if $sorttype_email}{$sorttype_email}{else}ASC{/if}"/></td>
		  <td width="4%" align="left"><a href="javascript:void(0)" onclick="sort_all('usertypeid',document.getElementById('sorttype_usertypeid').value);">Membership</a>
			 <input type="hidden" name="sorttype_usertypeid" id="sorttype_usertypeid" value="{if $sorttype_usertypeid}{$sorttype_usertypeid}{else}ASC{/if}"/></td>
		  <!--<td width="10%" align="left">City</td>-->
		 
		  <td width="12%" align="left"><a href="javascript:void(0)" onclick="sort_all('signup_date',document.getElementById('sorttype_signup').value);">Date of Registration</a>
		<input type="hidden" name="sorttype_signup" id="sorttype_signup" value="{if $sorttype_signup}{$sorttype_signup}{else}ASC{/if}"/></td>
		  <td width="12%" align="left"><a href="javascript:void(0)" onclick="sort_all('last_login',document.getElementById('sorttype_logout').value);">Last Login</a>
			<input type="hidden" name="sorttype_logout" id="sorttype_logout" value="{if $sorttype_logout}{$sorttype_logout}{else}ASC{/if}"/></td>
		  <td width="18%" align="center">Action</td>
		</tr>
		{section name=i loop=$users}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		  <td>{if $users[i].userid eq 1}#{else}<input type="checkbox" value="{$users[i].userid}" name="userid[]" id="userid"/>{/if}</td>
		  <td valign="top">
                      <img src="{$siteimg}/icons/{if $users[i].status  eq 'inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
                      <a href="user_view.php?userid={$users[i].userid}" title="Show Admin Details">{$users[i].username}</a>
		  </td>
		  <td valign="top">{$users[i].first_name}&nbsp;{$users[i].last_name}</a> </td>
		  <td valign="top">{$users[i].email}</td>
		  <td valign="top" align="center">{$users[i].usertypeid}</td>
		  <!--<td valign="top">{$users[i].city|ucfirst}</td>-->
		 
		  <td valign="top">{$users[i].signup_date|date_format:$smarty_date_format} {*$users[i].signup_date|date_format:"%I:%M %p"*}</td>
		  <td valign="top">{$users[i].last_login|date_format:$smarty_date_format} {*$users[i].last_login|date_format:"%I:%M %p"*}</td>
		  <td align="center">
		      <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
		      <a href="view-admin.php?userid={$users[i].userid}" title="Show Admin Details"><strong>View</strong></a>&nbsp;|&nbsp;
                      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
		      <a href="edit-admin.php?id={$users[i].userid}" title="Edit Admin Details"><strong>Edit</strong></a>
		  </td>
		</tr>
		{sectionelse}
			<tr><td colspan="6" class="error" align="center">No Records Found.</td></tr>
		{/section}			
		{if $users}
<!--		<tr>
		    <td align="left"> <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /> </td>
		    <td align="left" colspan="3">
			<select name="action" id="action">
			    <option value="">--Action--</option>
			    <option value="Active">Active</option>
			    <option value="inactivate">Inactive</option>
			    <option value="delete">Delete</option>
			</select>
			<input type="submit" name="submit" id="submit" value="Go"  />
			<div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="6">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>-->
		{/if}
	</table>

</form></div>
</div>
{include file=$footer}
