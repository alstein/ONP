{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}

<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Buyers</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	  <div class="fl width50">
	     <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="add_user.php">Add New Buyer</a>
          </div>
  	</div>

	<div class="fr">
	   <form name="frmSearch" action="" method="get">
		  <table width="50%" align="right" cellpadding="0" cellspacing="0" border="0">
		    <tr>
		      <td align="right">
			<label>
			    <input name="searchuser" type="text" id="searchuser" value="{$smarty.get.searchuser}" size="35" class="search"/> 
			</label>
		      </td>
		      <td width="20%" align="left">
			<input type="submit" name="button" id="button" value="Search" class="searchbutton" />
		    </td>
		  </tr>
	      </table>
	    </form>
      </div>

      <div class="clr">&nbsp;</div>
    <div id="UserListDiv" name="UserListDiv">
       <form name="frmAction" id="frmAction" method="post" action="">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		<td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
		  <td width="13%" align="left">Username</td>
		  <td width="10%" align="left">Full Name</td>
		  <td width="15%" align="left">Email</td>
		  <td width="4%" align="left">Membership</td>
		  <td width="8%" align="left">City</td>
		  <td width="5%" align="left">Postcode</td> 
		  <td width="12%" align="left">Date of Registration</td>
		  <td width="12%" align="left">Last Login</td>
		  <td width="20%" align="left">Action</td>
	    </tr>
		{section name=i loop=$users}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		  <td><input type="checkbox" value="{$users[i].userid}" name="userid[]"/></td>
		  <td valign="top">
                      <img src="{$siteimg}/icons/{if $users[i].status  eq 'inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
                     <a href="user_view.php?userid={$users[i].userid}" title="Show Buyers Details">{$users[i].username}</a><span style="font-weight:bold"> {if $users[i].isverified eq 'yes'}(v){else}(n/v){/if}</span>
		  </td>
		  <td valign="top">{$users[i].first_name}&nbsp;{$users[i].last_name}</a> </td>
		  <td valign="top">{$users[i].email}</td>
		  <td valign="top" align="center">{$users[i].usertypeid}</td>
		  <td valign="top">{$users[i].city|ucfirst}</td>
		  <td valign="top">{$users[i].postalcode}</td>
		  <td valign="top">{$users[i].signup_date|date_format} {$users[i].signup_date|date_format:"%I:%M %p"}</td>
		  <td valign="top">{$users[i].last_login|date_format} {$users[i].last_login|date_format:"%I:%M %p"}</td>
		  <td align="left" valign="top">
		      <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
		      <a href="user_view.php?userid={$users[i].userid}" title="Show Buyers Details">
		      <strong>View</strong></a>&nbsp;|
                      {if $users[i].isverified eq 'yes'}
                      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
		      <a href="edit-user.php?userid={$users[i].userid}" title="Edit Buyers Details"> <strong>Edit</strong></a>
                      {else}
                      <a href="{$siteroot}/admin/user/users_list.php?userid={$users[i].userid}&act=verify" style="text-decoration: none;">
		      <img align="absmiddle" src="{$siteroot}/templates/default/images/icons/icons/delete.png"/><strong>Verify Email</strong></a>
                      {/if}
		  </td>
		</tr>
		{sectionelse}
			<tr><td colspan="6" class="error" align="center">No Records Found.</td></tr>
		{/section}			
		{if $users}
		<tr>
		    <td align="left">
		        <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
		    </td>
		    <td align="left" colspan="3">
			<select name="action" id="action">
			<option value="">--Action--</option>
			<option value="Active">Active</option>
			<option value="Suspended">Inactivate</option>
			<option value="delete">Delete</option>
			</select>
			<input type="submit" name="submit" id="submit" value="Go"  />
		        <div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="6">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>

</form></div>
</div>
{include file=$footer}