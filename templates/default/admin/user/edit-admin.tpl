{include file=$header1}
 <script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
 <script type="text/javascript" src="{$siteroot}/js/validation/admin/editadmin.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/user/manage_admin.php">Admin User</a>
&gt; Edit Admin</div>
<br />


<div align="center" id="msg">{$msg}</div>
<div class="holdthisTop">
	<h3>Edit Admin Information</h3><br/><br/>
    <form name="frmUserProfile" id="frmUserProfile" action="" method="post" enctype="multipart/form-data">

      <table cellspacing="5" cellpadding="5" width="100%" border="0">
      <tr>
        <td align="right" valign="top" width="40%"><input type="hidden" name="userid" id="userid" value="{$user.userid}" />
        <span style="color:red">*</span> First Name:</td>
        <td align="left" width="60%"><input name="first_name" type="text" id="first_name" value="{$user.first_name}"  size="25" class="textbox"/>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" ><span style="color:red">*</span> Last Name:</td>
        <td align="left" ><input name="last_name" type="text" id="last_name" value="{$user.last_name}"  size="25" class="textbox"/>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" ><span style="color:red">*</span> User Name:</td>
        <td align="left" ><input name="username" type="text" id="username" value="{$user.username}"  size="25" class="textbox"/>
        </td>
      </tr>

      <tr>
          <td align="right" valign="top"> <span style="color:red">*</span> Email Address:</td>
          <td>
            <input type="text" maxlength="50" size="25" value="{$user.email}" name="email" id="email" class="textbox" />
          </td>
      </tr>
      <tr>
          <td align="right" valign="top"> Password: </td>
          <td>
            <input type="password" maxlength="15" size="25" name="password" id="password" class="textbox"/>
            <br/>
            Only enter if you want to reset pass.
          </td>
        </tr>

      <tr>
        <td align="right" valign="top"><span style="color:red">*</span> Postcode:</td>
                  <td align="left" ><input name="zipcode" type="text" id="zipcode" value="{$user.postalcode}" size="25" maxlength="10"  class="textbox"/>
        </td>
      </tr>
      <tr>
	  <td align="right" valign="top" width="40%"><span style="color:red">*</span> Access Level: </td>
	  <td align="left" width="60%">
	    <select name="level" id="level" style="width:150px;">
		<option value="">Select</option>  
		{section name=i loop=$level}<option value="{$level[i].levelid}" {if $level[i].levelid eq $user.access_level} selected="selected"{/if}>{$level[i].name|ucfirst}</option>{/section}
	    </select>
	  </td>
      </tr>

      <tr> 
	<td align="right" valign="top">Status: </td>
	<td><select name="status" id="status">
	      <option value="active" {if $user.status=="Active"} selected="selected"{/if} >Active</option>
	      <option value="inactive"  {if $user.status=="Suspended"} selected="selected"{/if}>Inactivate</option>
	    </select>
	</td></tr>


   <tr> 
	<td align="right" valign="top">Profile summary:</td>
	<td><textarea class="textbox" style="width:300px;height:125px" name="prosummary" id="prosummary">{$user.profile_summary}</textarea>
	</td></tr>	

 <tr> 
	<td align="right" valign="top">Profile Photo:</td>
	<td>
                               <input type="file" name="pimage" id="pimage" class="txtField" contenteditable="false"/>
                               {if $user.pic_image neq ''}
                               <br><img src="{$siteroot}/uploads/profile/thumbnail/{$user.pic_image}">
                               {/if}
	</td></tr>	


      <tr>
        <td></td>
        <td><input type="submit" value="Save" name="Submit"/> &nbsp; &nbsp; <input type="button" value="Cancel" {if $user.userid eq '1'} onclick="javascript: location='manage_admin.php'" {else} onclick="javascript: location='users_list.php'" {/if}/>
        </td>
      </tr>
    </table>
 
  </form>
</div>
{include file=$footer}