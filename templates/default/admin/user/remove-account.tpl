<script type="text/javascript" src="{$siteroot}/js/common1.js"></script>
{literal}
<script type="text/javascript">
function chkvali()
{
	var frm=document.frm;
	if(frm.reason.value.length < 1)
	{
		alert("Please enter message.");
		frm.reason.focus();
		return false;
	}
        
	return true;
}
</script>
{/literal}

<form name ="frm" id="frm" action = "" method="post" onSubmit="return chkvali();">
  <input type="hidden" name="id" id="id" value="{$row.id}">
  <table width="100%" border="0" cellpadding="6" cellspacing="2">
      <tr class="tblRowBkClr_1">
      <td valign="top" colspan="2" style="padding:10px;">You are approving account removal request of user.
	Enter your message to the user.
	</td>
      
    </tr>	
     <tr class="tblRowBkClr_1">
      <td align="right" valign="top"> Name:</td>
      <td align="left" >
                <strong>{$user_rs.first_name} {$user_rs.last_name}</strong>
      </td>
    </tr>   
    <tr class="tblRowBkClr_1">
      <td align="right" valign="top">Message:</td>
      <td align="left" >
                <textarea  name="reason" id="reason" rows="14" cols="60"></textarea>
      </td>
    </tr>
    <tr  class="tblRowBkClr_1">
      <td></td>
      <td align="left"><input type="submit" value="Send" name="submit"/>
        </td>
    </tr>
  </table>
</form>
