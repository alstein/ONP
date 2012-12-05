{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{literal}
<script LANGUAGE="JavaScript">

function confirmSubmit()
{
var agree=confirm("Are you sure you want to delete this record?");
if (agree)
	return true ;
else
	return false ;
}
</script>

{/literal}
{include file=$header2}

<div class="holdthisTop">
	<div>
    		<div class="fl width50">
      			<h3>{$sitetitle} Role Access</h3>
    		</div>
   	<div class="clr">
	   </div>
     	{if $msg}<div align="center" id="msg">{$msg}</div>{/if}
  	</div>
    <div align="right">
        <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="modules.php">Add New Role</a>
    </div><br/>
    <div align="right">
        <a href="javascript:history.go(-1);"><!--Back--></a>
    </div><br>

    <div id="UserListDiv" name="UserListDiv">
 <form name="frmAction" id="frmAction" method="post" action="">
	<table cellspacing="2" cellpadding="3" class="listtable"  width="100%">	
		<tr class="headbg">			
			<td width="2%" align="left"><input type="checkbox" id="checkall" /></td>
			<td width="20%" align="left">User Type</td>
			<td width="50%" align="left">Role Access</td>					
			<td width="30%" align="left"><div style="width:80px;">Action</div></td>
			
		</tr>			
		{section name=i loop=$data}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
			<td><input type="checkbox" value="{$data[i].levelid}" name="level_id[]"/></td>
			
				<td valign="top">{$data[i].name}</td>
				<td valign="top">{$data[i].modules}</td>				
				<td>
   			
                                       {if $SESSIONUSERID eq 1 && ($data[i].levelid !=1 &&  $data[i].levelid!=2 && $data[i].levelid!=3) }

                                       <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
						    
						<a href="modules.php?level={$data[i].levelid}" title="Edit">
							   <strong>Edit</strong></a>
                                       <img src="{$siteroot}/templates/default/images/icons/delpoll.gif" align="absmiddle" />
						    
				        <a href="role_list.php?del_levelid={$data[i].levelid}" title="Delete" onclick="return confirmSubmit();">
					<strong>Delete</strong></a>
                                        {/if}
                      
  
				</td>
		</tr>
		{sectionelse}
			<tr><td colspan="6" class="error" align="center">No Records Found.</td></tr>
		{/section}			
		<tr><td align="left" width="30px" colspan="3">
				<select name="action" id="action">
						<option value="">--Action--</option>
						<!--<option value="Active">Active</option>
						<option value="Suspended">Inactivate</option>-->
						<option value="delete">Delete</option>
				</select>

			<input type="submit" name="submit" id="submit" value="Go"  />
			<div id="acterr" class="error"></div>
</TD></tr>
		<tr>
			
			<td align="right" colspan="3">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		
	</table>

</form></div>
</div>
{include file=$footer}