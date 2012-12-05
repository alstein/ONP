{include file=$header1}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/user/manage_admin.php">Admin User</a>
&gt; View Admin</div>
<br />

<h3>Admin information</h3>

<div class="holdthisTop">
      <span style="float:right;"> <h3><a href="javascript:void(0);" onclick="javascipt:history.go(-1);">Back</a> </h3> </span>

      <table width="100%" cellpadding="2" cellspacing="5" border="0" class="conttableDkBg conttable">
      <tr><td >
        <table width="100%" cellpadding="4" cellspacing="5" border="0">
          <tr><td width="25%" align="right"><strong>Member Type:</strong> </td><TD  align="left"> {if $user.usertypeid eq 1}Admin{/if}</td></tr>
          <tr><td width="25%" align="right"><strong>Username: </strong></td><TD  align="left"> {$user.username}</td></tr>
          <tr><td width="25%" align="right"><strong>First Name:</strong> </td><td  align="left"> {$user.first_name|@ucfirst}</td></tr>
          <tr><td width="25%" align="right"><strong>Last Name: </strong></td><TD  align="left"> {$user.last_name|@ucfirst}</td></tr>
          <tr><td align="right"><strong>Email Address: </strong></td><TD  align="left">{$user.email}</td> </tr>
          <!--<tr><td align="right"><strong>City: </strong></td><TD  align="left">{$user.city}</td> </tr>-->
          <tr><td align="right"><strong>Postal Code: </strong></td><TD  align="left">{$user.postalcode}</td> </tr>
          <tr><td align="right"><strong>Registered Date:</strong> </td> <td align="left">{$user.signup_date|date_format:$smarty_date_format}</td></tr>
          <tr><td align="right"><strong>IP Address:</strong> </td> <td align="left">{$user.ipaddress}</td></tr>
          <tr><td align="right"><strong>Last Login:</strong> </td> <td align="left">{$user.last_login|date_format:"%d/%m/%Y"}</td></tr>
	 <!-- <tr>
	    <td align="right" valign="top"><strong>Access Level: </strong></td>
	    <td>
		{section name=i loop=$modules}
		  {if $modules[i]}
		    <table>
			<tr><td><strong>{$modules[i].module_name}</strong></td></tr>
			{section name=j loop=$modules[i].sub_m}
			<tr><td>&nbsp;<input type="checkbox" name="m_id[]"  id="m_id" value="{$modules[i].sub_m[j].id}" 
			{if in_array($modules[i].sub_m[j].id,$level1)==true} 
			    checked="true"{/if}  >{$modules[i].sub_m[j].module_name}</td></tr>
			{/section}
		    </table>
		  {/if}
		{/section}
	    <td>
	  </tr>-->
        </table>
      </TD></TR>
      </table> 

</div>
{include file=$footer}