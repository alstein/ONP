{include file=$header1}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/addadmin.js"></script>
{/strip}

{literal}
<script language="JavaScript">
	$(document).ready(function()
{
   

$('#frmRegistration').submit(function(){
                    if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#Submit').hide(); 
                $('#buttonregister').append("<input type='button' name='Submit' id='Submit' value='Save' />"); 
            }
        });
});
</script>
{/literal}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/user/manage_admin.php">Admin User</a>
&gt; Add Admin</div>
<br />

<div class="holdthisTop">
    <h3>Add New Admin</h3>
    <input type="hidden" id="siteroot" value="{$siteroot}" />
    <div align="center" id="msg">{$msg}</div>
    <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="2" cellpadding="5" align="center">
            <tr>
                <td colspan="2" align="right"><a href="javascript:history.go(-1);"><strong>Back</strong></a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> First Name: </td>
                <td align="left" width="60%"><input name="first_name" type="text" id="first_name" value=""  size="25" class="textbox"/></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Last Name: </td>
                 <td align="left" width="60%"><input name="last_name" type="text" id="last_name" value=""  size="25" class="textbox"/></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Username: </td>
                <td align="left" width="60%"><input name="username" type="text" id="username" value=""  size="25" class="textbox"/></td>
            </tr>
            <tr>
                <td align="right" valign="top"><span style="color:red">*</span> Email Address: </td>
                <td><input type="text" maxlength="70" size="25" value="" name="email" id="email" class="textbox" /></td>
            </tr>
            <tr>
                <td align="right" valign="top"><span style="color:red">*</span> Password: </td>
                <td><input type="password" maxlength="15" size="25" name="password" id="password" class="textbox"/></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Confirm Password: </td>
                <td align="left" width="60%"><input name="cpassword" type="password" id="cpassword" value="" maxlength="15" size="25" class="textbox"/></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Postal Code: </td>
                <td align="left" width="60%"><input name="zipcode" type="text" id="zipcode" value="" size="25" maxlength="15" class="textbox"/>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Access Level: </td>
                <td align="left" width="60%">
                  <select name="level" id="level" style="width:150px;">
                      <option value="">Select</option>  
                      {section name=i loop=$level}<option value="{$level[i].levelid}">{$level[i].name|ucfirst}</option>{/section}
                  </select>
                </td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td align="left">
                   <span id="buttonregister"> <input type="submit" name="Submit" id="Submit" value="Save" class="" /></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" value="Cancel" onclick="javascript: document.location.href='manage_admin.php'" class="" />
                </td>
            </tr>
        </table>
    </form>
</div>
{include file=$footer}