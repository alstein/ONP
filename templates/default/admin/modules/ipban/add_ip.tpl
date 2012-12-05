{include file=$header1}

{literal}
<script type="text/javascript">
$(document).ready(function(){


$.validator.addMethod('IP4Checker', function(value) {
                var ip = "^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$";
                return value.match(ip);
            }, 'Invalid IP address');
	$("#frm").validate({
		errorElement:'div',
		rules: {
			domain:{
                                required: true,
                                IP4Checker: true
				
			}
		},
		messages: {
			domain:{
				required: "Please enter IP address",
				IP4Checker:"Please enter valid IP address"
			}
		}
	});

});

// function is_validData()
// {
// 
//    
//    if(Trim(document.frm.domain.value)== '')
//    {
//    		alert("Please enter domain name");
// 		document.frm.domain.focus();
// 		return false;
//    }
//    return true;
// }
// function Trim(s) 
// {
// // Remove leading spaces and carriage returns
// while ((s.substring(0,1) == ' ') || (s.substring(0,1) == '\n') || (s.substring(0,1) == '\r'))
//  { s = s.substring(1,s.length); }
//  
// // Remove trailing spaces and carriage returns
// while ((s.substring(s.length-1,s.length) == ' ') || (s.substring(s.length-1,s.length) == '\n') || (s.substring(s.length-1,s.length) == '\r'))
//  { s = s.substring(0,s.length-1); }
//  
// return s;
// }
</script>
{/literal}

{literal}
<script language="JavaScript">
	$(document).ready(function()
{
   

$('#frm').submit(function(){
                    if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#submit').hide(); 
                $('#buttonregister').append("<input type='button' name='submit' id='submit' value='Submit' />"); 
            }
        });
});
</script>
{/literal}
{include file=$header2}

<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin//modules/ipban/ipban.php"> IP Ban</div>
<br />-->



<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/ipban/ipban.php"> IP Ban</a> &gt; 
{if $row_result.ip_id eq ''} Add IP{else} Edit IP{/if}</div>
<br />
{if $row_result.ip_id eq ''}
<h3> &nbsp; Add IP</h3>
{else}
<h3> &nbsp; Edit IP</h3>
{/if}
{if $msg}<div align="center">{$msg}</div>{/if}
<div class="holdthisTop">
  <table width="97%" class="brdall">
    <td>
	 <form name="frm" action="" id="frm"  method="post" enctype="multipart/form-data" class="fvalidator-form" >		
     <table width="100%" border="0" cellspacing="6" cellpadding="0">
	   <tr><td colspan="2"><font color="#FF0000"><center><b>{$message}</b></center></font></td></tr>
	   <tr><td colspan="2"><input type="hidden" value="{$row_result.ip_id}" name="id" /></td></tr>
	   <tr><td colspan="2">&nbsp;</td></tr>	
	  <tr><td colspan="2">&nbsp;</td>
	  <tr><td align="right"  valign="top"><span class="error">*</span> Domain:</td>
	      <td align="left"><input type="text" name="domain" value="{$row_result.domain}"></td>
	  </tr>
	  <tr><td colspan="2">&nbsp;</td></tr>
	  
	<tr>
		<td>&nbsp;</td>
        <td align="left"><span id="buttonregister"><input type="submit" name="submit" id="submit" value="Submit"></span>
        &nbsp; &nbsp; &nbsp;
                <input type="button" name="Cancel" value="Cancel" onclick="javascript: location='{$siteroot}/admin/modules/ipban/ipban.php'" />
        </td>
    </tr>	
</table>

</form>

</td>
    </tr>
  </table>
</div>{include file=$footer}