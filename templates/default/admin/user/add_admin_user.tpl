{include file=$header1}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$sitejs}/calendarDateInput.js"></script>
<script type="text/javascript">
{literal}
$(document).ready(function(){
  $("#frmRegistration").validate({
    errorElement:'div',
    rules: {
      first_name:{
              required: true,
              minlength: 2,
              maxlength:30
      },
      password:{
              required: true,
              minlength:6,
              maxlength:15
      },
      cpassword: {
              required: true,
              minlength: 6,
              maxlength: 15,
              equalTo:'#password'
      },
      username:{
              required: true,
              minlength: 2,
              maxlength: 15,
              remote: SITEROOT + "/admin/user/ajax_check_user.php"
      },
    },
    messages: {
        first_name:{
                required: "Please enter Real Name",
                minlength:  $.format("Enter at least {0} characters"),
                maxlength: $.format("Enter maximum {0} characters")
        },
        password:{
                required: "Please enter password",
                minlength: $.format("Please enter at least {0} characters"),
                maxlength: $.format("$site_updatesEnter maximum {0} characters")
        },
        cpassword: {
                required: "Please type your password again.",
                minlength: $.format("Enter at least {0} characters"),
                maxlength: $.format("Enter maximum {0} characters"),
                equalTo: "Enter the same password as above"
        },
        username:{
                required: "Please enter username",
                remote: "This username is already in use"
        },
    }
  });
});

{/literal}
</script>
{include file=$header2}
<h3>Add New Admin User</h3>
<input type="hidden" id="siteroot" value="{$siteroot}" />
<div class="holdthisTop">
<div align="center">{$msg}</div>
<form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
    <table width="100%" border="0" cellspacing="2" cellpadding="1">
     <tr>
        <td align="right" valign="top" width="40%">Real Name<span style="color:red">*</span>:</td>
                  <td align="left" width="60%"><input name="first_name" type="text" id="first_name" value="{$user.first_name}"  size="15" class="textbox"/>
        </td>
     </tr>
     <tr>
      <td align="right" valign="top">Username<span style="color:red">*</span>:</td>
      <td><input type="text" value="{$user.username}" name="username" id="username" class="textbox" maxlength="15"/>
      </td>
     </tr>
     <tr><td align="right" valign="top"> Password<span style="color:red">*</span>: </td>
      <td><input type="password" maxlength="15" size="15" name="password" id="password" class="textbox"/>
          <br/>Only enter if you want to reset pass.
          </td>
     </tr>
     <tr>
       <td align="right" valign="top" width="40%">Confirm password<span style="color:red">*</span>: </td>
	<td align="left" width="60%"><input name="cpassword" type="password" id="cpassword" value="{$smarty.post.confirmPassword}" maxlength="15" size="15" class="textbox"/>
          </td>
     </tr>
      <tr> 
        <td align="right" valign="top">User Type :</td>
        <td><select name="access_level" id="access_level">
            <option value="1" {if $user.access_level=="1"} selected="selected"{/if} >Accounts Level 1</option>
            <option value="2"  {if $user.access_level=="2"} selected="selected"{/if}>Marketing Level 2</option>
            <option value="3"  {if $user.access_level=="3"} selected="selected"{/if}>Programmer Level 3</option>
            <option value="4"  {if $user.access_level=="4"} selected="selected"{/if}>Administrator Level 4</option>
            <option value="5"  {if $user.access_level=="5"} selected="selected"{/if}>CEO Level 5</option>
           </select>
        </td>
        </tr>
      <tr> 
        <td align="right" valign="top"><input  name="usertypeid" id="usertypeid" type="hidden" value="1">Status :</td>
        <td><select name="status" id="status">
              <option value="Active" {if $user.status=="Active"} selected="selected"{/if} >Active</option>
              <option value="Suspended"  {if $user.status=="Suspended"} selected="selected"{/if}>Suspended</option>
            </select>
        </td>
        </tr>
	<tr>
        <td align="right" valign="top" width="40%">Note :</td>
	<td align="left" width="60%"><TEXTAREA name="note" id="note" rows="4" cols="40">{$user.note}</TEXTAREA>
          </td>
        </tr>
        <tr><td>&nbsp;</td>
        <td align="left"><label>
          <input type="submit" name="Submit" id="Submit" value="Submit" class="button1" />&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" value="Cancel" onclick="javascript: document.location.href='admin_users_list.php'" class="button1" /></label></td>
      </tr>
    </table>
  </form>
</div>
{include file=$footer}
