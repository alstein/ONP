{include file=$header1}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}

{literal}
<script type="text/javascript">
$(document).ready(function(){

   	$.validator.addMethod("alphaOnly", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z -]/;
                temp = !str.test(value);
                return temp;
         }, "Only a to z, A to Z and - is allowed.");

     $.validator.addMethod("email",
        function(value, element)
        {
        return this.optional(element) ||/^([\w])(([\-.]|[_]+)?([\w]+))*@([\w-]+\.)+[\w-]{2,4}?$/i.test(value);
 
        }, "Please enter valid paypal account email");

	$("#frmpayment").validate({
		errorElement:'div',
		rules: {
			paypal_account:{
				required: true,
				minlength: 10,
				maxlength:80,
				email:true
			},
			autho_login:{
				required: true,
				minlength: 4,
				maxlength:50
			},
			password:{
				required: true,
				minlength: 4,
				maxlength:50
			},
			signature:{
				required: true,
				minlength: 4,
				maxlength:100
			}
		},
		messages: {
			paypal_account:{
				required: "Please enter paypal account email",
				minlength:  $.format("Please enter at least {0} characters"),
				maxlength: $.format("Please enter maximum {0} characters")
			},
			autho_login:{
				required: "Please enter paypal account username",
				minlength:  $.format("Please enter at least {0} characters"),
				maxlength: $.format("Please enter maximum {0} characters")
			},
			password:{
				required: "Please enter paypal account password",
				minlength:  $.format("Please enter at least {0} characters"),
				maxlength: $.format("Please enter maximum {0} characters")
			},
			signature:{
				required: "Please enter paypal account signature",
				minlength:  $.format("Please enter at least {0} characters"),
				maxlength: $.format("Please enter maximum {0} characters")
			}
		}
	});
});
</script>
{/literal}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;   Payment Gateway
</div>
<br />
<h2> &nbsp; Payment Gateway</h2>
            <p>&nbsp;</p>
<div id="msg" align="center">{$msg}</div>
<div class="holdThisTop">
<form name="frmpayment" id="frmpayment" method="POST" action="">


<table width="80%" cellpadding="6" cellspacing="2" border="0" class="listtable">
<tr><TD colspan="2"><h4>Payment Mode</h4></TD></tr>
<tr><td width="20%" valign="top" align="right"></td>
<td>
<input type="radio" name="paymentmode" value="0" {if $array.paymentmode eq 0} checked="true" {/if}>Test
<input type="radio" name="paymentmode" value="1" {if $array.paymentmode eq 1} checked="true" {/if}>Online
</td>

<tr><TD colspan="2"><h4>Paypal Information </h4></TD></tr>

<tr><td width="20%" valign="top" align="right"><span style="color:red">*</span> Account:</td>
<td><input type="text" name="paypal_account" id="paypal_account" size="60" value="{$array.paypal_account}"></td>
    
</tr>
<!--<tr><TD colspan="2"><h4>Credit Card Information  </h4></TD></tr>
<tr><td valign="top" align="right"><span style="color:red">*</span> Paypal Username :</td>
	<td><input type="text" name="autho_login" id="autho_login" size="60" value="{$array.autho_login}"></td>
</tr>
<tr><td valign="top" align="right"><span style="color:red">*</span> Paypal Password :</td>
	<td><input type="text" name="password" id="password" size="60" value="{$array.password}"></td>
</tr>
<tr><td valign="top" align="right"><span style="color:red">*</span> Paypal Signature :</td>
	<td><input type="text" name="signature" id="first_data_login" size="60" value="{$array.signature}"></td>
</tr>-->
<tr><td></td><td><input type="submit" name="submit" value="Submit">
</td>
</tr>
 </table>

</form> 
</div>
{include file=$footer}