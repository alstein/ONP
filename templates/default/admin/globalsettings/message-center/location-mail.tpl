{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/location_email.js"></script>
{/strip}

{literal}
<script language="JavaScript">
function change_city(cty_name,dv_id)
{
        $("#show_usr_"+dv_id).slideToggle('fast');

	var page=SITEROOT+'/admin/globalsettings/message-center/get-subscriber.php';		
	$.get(page,{city_name:cty_name,divid:'show_usr_'+dv_id},function(data){$("#show_usr_"+dv_id).html(data)});
}
</script>
{/literal}

{include file=$header2}

<div id="Content" style="float:left"> 
<h3>Location Email</h3>

    {if $msg}<div align="center" class="red" id="msg">{$msg}<br/><br/></div>{/if}

    <form name="frm_send_news" id="frm_send_news" action = "" method="POST">

      <table width="100%" cellpadding="2" cellspacing="2" class="Greenback" align="center">
      <tr><td>&nbsp;</td></tr>
      <tr>
	  <td align="right" style="vertical-align:top"><span style="color:red">*</span>&nbsp;Deal: </td>
	  <td>
		  {section name=i loop=$deal}
		  <input type="checkbox" name="deal_name[]" value="{$deal[i].deal_unique_id}" id="deal_name">{$deal[i].title}<br/>
		  {/section}	
	  </td>
      </tr>	
      <Tr><td colspan="2">&nbsp;</td></Tr>	
      <tr valign="top">
	<td  align="right" valign="top"><span style="color:red">*</span>&nbsp;City: </td>
	<td  valign="top" width="85%">
            <table cellpadding="5" cellspacing="5" width="100%" style="vertical-align:top;margin-top:-5px;">
		<col width="250"/>
		<col width="250"/>
		<col width="250"/>
		{if $city_arr}
		<tr valign="top">
		{section name=i loop=$city_arr}
                      <td valign="top"><a href="javascript:void(0);" onclick="javascript: change_city('{$city_arr[i].city}','{$smarty.section.i.index}'); ">{$city_arr[i].city} ({$city_arr[i].to_sub})</a>
                      <div id="show_usr_{$smarty.section.i.index}" style="display:none;vertical-align:top;"></div>
                      </td>
		      {if $smarty.section.i.iteration mod 3 eq 0}
		      </tr>
		      <tr>
		      {/if}
                {/section}
                </tr>
                {/if}
            </table>
          </td>
      </tr>
      <tr><td colspan="2">&nbsp;</td></tr>
      <tr>
	  <td  align="right" valign="top"><span style="color:red">*</span>&nbsp;Subject: </td>
	  <td  align="left"><input name="subject" type="text" id="subject" value="" class="text_box4" size="60">&nbsp;</td>
      </tr> 
      <Tr><td colspan="2">&nbsp;</td></Tr>
	<tr>
	    <td valign="top" align="right"><span style="color:red">*</span>&nbsp;Message Content: </td>
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


    </form>
</div>
{include file=$footer} 