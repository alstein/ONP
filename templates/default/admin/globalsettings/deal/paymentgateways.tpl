{include file=$header1}

{literal}
<script type="text/javascript">

function reject()
                {

                var reject=confirm("Are you sure to reject this deal ?");
                if(reject ==true){
                                        return true;
                                }
                else
                                {
                                        return false;
                                }
                
                }
</script>

{/literal}

{include file=$header2}

 		<h3 align="left"><b>Select Payment Method</b></h3>

	{if $smarty.post.city}<br>{/if}
<!--<div align="left">Symbol for recommended deal <img align="absmiddle" src="{$siteimg}/icons/bullet-fingerpoint.gif"/></div>-->
		
		<div align="center" id="msg">{$msg}</div>
	<form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
	<table cellpadding="2" cellspacing="0" border="0" width="79%">


  	
		
		<tr>
		<td colspan="2" valign="top" align="center">
			
     			
			<table cellpadding="2" cellspacing="1" border="0" width="100%" class="listtable">
          		<tr><td><input type="radio" name="paymentmethod[]" id="paymentmethod[]" {if $paymentvalue eq '1'}checked{/if} value="1">Sagepay</td></tr>
              <tr><td><input type="radio" name="paymentmethod[]" id="paymentmethod[]" value="2" {if $paymentvalue eq '2'}checked{/if}>Paypal</td></tr>
              <tr><td><input type="radio" name="paymentmethod[]" id="paymentmethod[]" value="3" {if $paymentvalue eq '3'}checked{/if}>Both</td></tr>
				
			   <tr><td>
				
              		&nbsp;&nbsp;&nbsp;&nbsp;	<input type="submit" name="Save" id="Save" value="Go"/>
</td>
            </tr>
        				
			</table>
      			
			
			</td>
  			</tr>
		</table>
</form>
	<div class="clr">
</div>
{include file=$footer} 
