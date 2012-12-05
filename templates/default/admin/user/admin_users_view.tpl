{include file=$header1}
{include file=$header2}


<div class="breadcrumb">
  <a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/user/admin_users_list.php">Manage User </a> &gt; User Details
</div><div class="clr">&nbsp;</div>
<h3>User Information</h3>
<span class="holdthisTop">
   <table width="100%" cellpadding="2" cellspacing="2" border="0">
     <TR><TD>
      <table width="100%" cellpadding="2" cellspacing="2" border="0" class="conttableDkBg conttable">
        {if $cnt} 
        <tr>
          <td></td><td></td>
          <td align="right"><a href="{$siteroot}/admin/user/referral_user_list.php?userid={$smarty.get.userid}"> <strong>{$cnt} Referral User</strong></a></td>
        </tr>
        {/if} 
      <TR><TD valign="top">
        <table width="100%" cellpadding="2" cellspacing="2" border="0">
         <!-- <tr><td colspan="2" align="right"><span style="float:right;"><h3>
	<a href="{$siteroot}/admin/user/admin_user_information.php?userid={$smarty.get.userid}">Edit</a></h3>
 	</span></td>
          </tr>-->
          <tr><td width="25%" align="right"><strong>First Name : </strong></td><TD  align="left"> {$user.first_name|@ucfirst}
            </td>
          </tr>
          <tr><td width="25%" align="right"><strong>Last Name : </strong></td><TD  align="left"> {$user.last_name|@ucfirst}
            </td>
          <tr><td align="right"><strong>Registered Date : </strong></td>
          <td align="left">{$user.signup_date|date_format}</td></tr>
          </tr>
          <tr><td align="right"><strong>Email Address : </strong></td><TD  align="left">{$user.email}</td>      </tr>
            <tr>
                <td   valign="top" align="right"><strong>Address:</strong></td>
                <td align="left" >{$user.address}</td>
            </tr>
            <tr>
                <td   valign="top" align="right"><strong>City:</strong></td>
                <td align="left" >{$user.city}</td>
            </tr>
            <tr>
                <td   valign="top" align="right"><strong>State:</strong></td>
                <td align="left" >{$user.state}</td>
            </tr>
            <tr>
                <td   valign="top" align="right"><strong>Zip Code:</strong></td>
                <td align="left" >{$user.zipcode}</td>
            </tr>
          <tr><td align="right"><strong>CC Info : </strong></td><TD  align="left">{$user.cc_info}</td>      </tr>
          <tr><td align="right" valign="top"><strong>User Type : </strong></td>
             <td>{$user.user_type}</td>
          </tr>
           <tr><td align="right" valign="top"><strong>Status : </strong></td>
             <td>{$user.status}</td>
          </tr> 
            <tr><td align="right" valign="top"></td><td colspan="2" height="15" align="left"><input type="button" name="cancel" id="cancel" value="Back" class="button1" onclick="javascript: document.location.href='admin_users_list.php'"></td></tr>
        </table>
      </TD></TR>
      </table> 
  </TD></TR>
  <TR><TD>&nbsp;</TD></TR>
  </table></span>
</div>
{include file=$footer}