{include file=$header1}
{include file=$header2}
<h2> &nbsp; Payment Gateway</h2>
            <p>&nbsp;</p>
<div id="msg" align="center">{$msg}</div>
<div class="holdThisTop">
<form name="frmpayment" method="POST" action="">


<table width="100%" cellpadding="6" cellspacing="2" border="0" class="listtable">
<tr><TD colspan="2"><h4>Payment Mode</h4></TD></tr>
<tr><td width="20%" valign="top" align="right"></td>
<td>
<input type="radio" name="paymentmode" value="0" {if $array.paymentmode eq 0} checked="true" {/if}>Test
<input type="radio" name="paymentmode" value="1" {if $array.paymentmode eq 1} checked="true" {/if}>Online
</td>

<tr><TD colspan="2"><h4>Paypal Information </h4></TD></tr>

<tr><td width="20%" valign="top" align="right">Account:</td>
<td><input type="text" name="paypal_account" id="paypal_account" size="60" value="{$array.paypal_account}"></td>
    
</tr>
<tr><TD colspan="2"><h4>Credit Card Information  </h4></TD></tr>
<tr><td valign="top" align="right">Paypal Username :</td>
	<td><input type="text" name="autho_login" id="autho_login" size="60" value="{$array.autho_login}"></td>
</tr>
<tr><td valign="top" align="right">Paypal Password :</td>
	<td><input type="text" name="password" id="password" size="60" value="{$array.password}"></td>
</tr>
<tr><td valign="top" align="right">Paypal Signature :</td>
	<td><input type="text" name="signature" id="first_data_login" size="60" value="{$array.signature}"></td>
</tr>
<tr><td></td><td><input type="submit" name="submit" value="Submit">
</td>
</tr>
 </table>

</form> 
</div>
{include file=$footer}