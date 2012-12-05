{include file=$header1}

{strip}
<!--<meta content="text/html; charset=utf-8" http-equiv="content-type"/>-->
<script language="javascript" src="{$siteroot}/js/email-to-user.js"></script>
<!--<script type="text/javascript" src="{$siteroot}/js/validation/admin/sendnewsletter.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/jquery.jSuggest.1.0.js"></script>
{/strip}
{literal}
<script language="JavaScript">
jQuery(function(){
	
   	    jQuery("#email").jSuggest({
            url: SITEROOT+ "/modules/my-account/ajaxget_useremail.php",
            type: "GET",
            data: "searchQuery",
            autoChange: true
    });
    $('#mg').fadeOut(5000);
});

</script>
{/literal}
{include file=$header2}

<h3>Send Email</h3>
<div id="Content" style="float:left"> 
	  {if $msg}<div align="center" class="red" id="msg">{$msg}<br/><br/></div>{/if}
    <form name="frm_send_news" id="frm_send_news" action = "" method="POST">
      <table width="100%" height="129"  border="0" align="center" cellpadding="2" cellspacing="1" class="brdall" >

	  <tr>
              <td>
                <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="Greenback" >
		
                <tr>
                        <td align="right"><span style="color:red">*</span> Email:&nbsp;&nbsp; </td>
                        <td>
                                <input type="text" name="email" id="email"  style="width:350px;"  autocomplete="off"/>
                        </td>
        
                </tr>
		<Tr><td colspan="2">&nbsp;</td></Tr>
		 <tr>
		    <td width="20%" height="25" align="right" class="fade_back" valign="top"><span style="color:red">*</span> Subject:&nbsp;&nbsp; </td>
		    <td width="100%" height="25"  align="left" class="fade_back_1"><input name="subject" type="text" id="subject" value="" class="text_box4" size="60">&nbsp;</td>
		</tr> 
          <Tr><td colspan="2">&nbsp;</td></Tr>
           <tr>
                <td valign="top" align="right"><span style="color:red">*</span> Message Content:&nbsp;&nbsp; </td>
                <td valign="top">
                  {$oFCKeditor}
                </td>
           </tr>
            <Tr><td colspan="2">&nbsp;</td></Tr>

		<tr>
                        <td width="20%" height="25" align="center" class="fade_back">&nbsp;</td>
			<td height="71%"  align="left" class="fade_back_1">&nbsp;
			<input type="submit" name="submit" value="Send Message"></td>
		</tr>
	 </table>
	    </td>
	  </tr>
      </table>
    </form>
</div>
{include file=$footer} 