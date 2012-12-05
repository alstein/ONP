{include file=$lbheader}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.pack.js"></script>
{/strip}
<script type="text/javascript">
{literal}
$(document).ready(function() {
	// validate signup form on keyup and submit
	
	var validator = $("#frmUserProfile").validate({
		errorElement:'div',
		rules: {
        		 usertype:{
				required: true	
			 }
		},
		messages: {
			usertype:{
				required: "Please enter user type"
			}
		},

		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
	});
	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var first_name = $("#first_name").val();
		var last_name = $("#last_name").val();
		if(first_name && last_name && !this.value) {
			this.value = first_name + "." + last_name;
			this.value = this.value.toLowerCase();
		}
	});
});
{/literal}
</script>

<form name="frmUserProfile" id="frmUserProfile" action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="typeid" id="typeid" value="{$smarty.get.typeid}" />
    <table cellspacing="6" cellpadding="2" width="100%" border="0">
    <tr align="center">
        <td align="right" valign="top">User Type: </td>
        <td align="left" valign="top">
        <input type="text" maxlength="15" value="{$usertype.usertype}" name="usertype" id="usertype" class="textbox width60"/>
        </td>
    </tr>
    <tr>
        <td>
        </td>
        <td>
        <input type="submit" name='submit' value="{if $smarty.get.typeid}Update{else}Save{/if}" /> &nbsp; &nbsp; 
        </td>
    </tr>
    </table>
</form>

{include file=$lbfooter}
