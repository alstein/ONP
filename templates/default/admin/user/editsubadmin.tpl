{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></SCRIPT>
{literal}
<script type="text/javascript" language="JavaScript">
$(document).ready(function() {
	jQuery.validator.addMethod("specialchars", function(value, element) {
      var str1 = /\s/;
      var str2 = /([A-Za-z0-9_]+)/;
      if(str1.test(value))
         return false;
      if(!(str2.test(value)))
         return false;
      return true;

        }, "Special characters and space not allowed");
	
	// validate signup form on keyup and submit
	 $("#frmRegister").validate({
		errorElement:'div',
		rules: {
			first_name:{
				required: true,
				minlength: 2,
				maxlength: 20,
            character:true,
            specialchars:true
			},
			last_name:{
				required: true,
				minlength: 2,
             character:true,
				maxlength: 20,
                 specialchars:true
			},
			loginname:{
				required: true,
				minlength: 4,
				maxlength: 20,
				//nospace: true,
				remote: SITEROOT + "/modules/register/admin_ajax_chkemail.php"
			},
			password:{
				required: true,
				minlength: 6,
				maxlength: 20
			},
			cnpassword:{
				required: true,
				minlength: 6,
				equalTo: "#password"
			},
			level:{
				required: true
			}
		},
		messages: {
			first_name:{
				required: "Enter first name",
            character:"Enter only character",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
            specialchars:"Special characters and space not allowed"
			},	
			last_name:{
				required: "Enter last name",
            character:"Enter only character",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
            specialchars:"Special characters and space not allowed"
			},
			loginname:{
				required: "Enter a Login name",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				remote: jQuery.format("{0} is already in use or marked as spam.")
			},
			password:{
				required: "Provide a password",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			cnpassword:{
				required: "Repeat your password",
				minlength: jQuery.format("Enter at least {0} characters"),
				equalTo: "Enter the same password as above"
			},
			level:{
				required: "Please select module access level"
			}

		},
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
	});
	// propose username by combining first- and lastname
	$("#loginname").focus(function() {
		var first_name = $("#first_name").val();
		var last_name = $("#last_name").val();
		if(first_name && last_name && !this.value) {
			this.value = first_name + "_" + last_name;
			this.value = this.value.toLowerCase();
		}
	});
	//accept: (/[a-zA-Z0-9]+_/)
});
</script>
{/literal}
{include file=$header2}

<table width="100%" border="0"><tr><td width="92%"><h3>Add New subadmin</h3></td><td width="8%" >
<!--<a href="{$siteroot}/admin/modulemanagement/subadmin.php"><h3>Back</h3></a>--></td></tr></table>

<table width="100%" border="0" ><tr><td align="right"><a href="javascript:history.go(-1);">Back</a></td></tr></table>
<input type="hidden" id="siteroot" value="{$siteroot}" />
<div class="holdthisTop">
  <form name="frmRegister" id="frmRegister" method="post" action="">
    <table width="100%" border="0" cellspacing="2" cellpadding="6">
        <tr>
              <td colspan="2" id="msg" >{$msg}</td>
        </tr>
        <tr>
            <td align="right" valign="top" style="vertical-align:top; padding-top:10px"><span style="color:red;">*</span> First Name:</td>
            <td align="left"><input name="first_name" id="first_name" type="text" value="{$smarty.post.first_name}" size="30" maxlength="30" /></td>
            </tr>
            <tr>
            <td align="right" valign="top" style="vertical-align:top; padding-top:10px"><span style="color:red">*</span> Last Name:</td>
            <td align="left"><input name="last_name" id="last_name" type="text" value="{$smarty.post.last_name}" size="30" maxlength="30" /></td>
        </tr>

        <tr>
            <td align="right" valign="top" style="vertical-align:top; padding-top:10px"><span style="color:red">*</span> Login Name:</td>
            <td align="left"><input name="loginname" type="text" id="loginname" value="{$smarty.post.loginname}" size="30" maxlength="50"/>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="vertical-align:top; padding-top:10px"><span style="color:red">*</span> Password:</td>
            <td align="left"><input name="password" type="password" id="password" value="{$smarty.post.password}" size="30" maxlength="30"/>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" style="vertical-align:top; padding-top:10px"><span style="color:red">*</span> Confirm Password:</td>
            <td align="left"><input name="cnpassword" type="password" id="cnpassword" value="{$smarty.post.confirmPassword}" size="30" maxlength="30"/>
            </td>
        </tr>

     <tr>
        <td align="right" valign="top" style="vertical-align:top; padding-top:10px"><span style="color:red">*</span> Modules Access Level: </td>
        <td>
          <select name="level" id="level" class="selectbox">
            <option value="">---Please select---</option>
            {section name=i loop=$levels}
             <option value="{$levels[i].levelid}" {if $smarty.post.levelid eq $levels[i].levelid} selected="selected"{/if}>{$levels[i].name}</option>
            {/section}
          </select>
          </td>
      </tr>

      <tr>
        <td>&nbsp;</td>
        <td align="left"><label>
          <input type="submit" name="Submit" id="Submit" value="Save"  class="" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" name="cancel" id="cancel" value="Cancel" onclick="javascript: location='{$siteroot}/admin/user/subadmin.php'" class="" />
          </label></td>
      </tr>
    </table>
  </form>
</div>
{include file=$footer} 