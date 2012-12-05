{include file=$header1}

{strip}
<!--<meta content="text/html; charset=utf-8" http-equiv="content-type"/>-->
<script language="javascript" src="{$siteroot}/js/news_letter.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/sendnewsletter.js"></script>
{/strip}
{literal}
<script language="JavaScript" type="text/javascript">
function change_city()
{
       
	var city=document.getElementById('city_name').value;
        var radius=document.getElementById('radius').value;
	//var user=document.getElementById('user_list').value;
	var page=SITEROOT+'/admin/globalsettings/message-center/post-city-users.php';		
	$.get(page,{city_name:city, radius:radius},function(data){ $("#userlist").html(data)});

	$("#userlist").show("slow");
        $("#userlist").show("slow");
        $('#userlist :input').attr('disabled', false);
	
}
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
		
	<!--	 <tr>
		    <td  height="25" align="right" class="fade_back"><span style="color:red">*</span>&nbsp;Message: </td>
		    <td  height="25" align="left" class="fade_back_1">
		    <select name="newsletter" id="newsletter" onChange="selectpagecontent();" style="width:200px;">
		    <option value="">-Select-</option>
		    {section name=sec1 loop=$title}
		    <option value="{$title[sec1].nl_id}" {if $nlid eq $title[sec1].nl_id} selected="selected"{/if}>{$title[sec1].nl_title}</option>
		    {/section}
		    </select></td>
  		 </tr>-->
		<Tr><td colspan="2">&nbsp;</td></Tr>
		<tr>
			<td  height="25" align="right" style="vertical-align:top">Deals:&nbsp;</td>
			<td valign="top">
				{section name=i loop=$deal}
				<input type="checkbox" name="deal_name[]" value="{$deal[i].deal_unique_id}">{$deal[i].title}<br>
				{/section}	
			</td>
			<td>&nbsp;</td>
		</tr>	
		<Tr><td colspan="2">&nbsp;</td></Tr>	
		<tr>
		  <td width="20%" height="25" align="right" valign="top" class="fade_back"><span style="color:red">*</span>&nbsp;City / Postcode: &nbsp;</td>
		  <td height="71%" class="fade_back_1" valign="top" style="vertical-align:top;" >
		<!--	<select name="city_name" id="city_name" onchange="change_city();">
				<option  value="all">All</option>
				{section name=i loop=$city_arr}
				<option  value="{$city_arr[i].city}" {if $smarty.get.city_name eq $city_arr[i].city} selected="selected"{/if}>{$city_arr[i].city}</option>
				{/section}
			</select>-->
			<!--<textarea name="to" class="text_area5" rows="3" cols="60" id="to"></textarea>-->
                <input name="city_name" id="city_name"/>&nbsp;&nbsp;<label>Radius</label>
                  <input name="radius" id="radius" value="20" style="width:100px;"/>
                        <input type="button" value="Submit" onclick="change_city();"/><br/>
                  <div class="error" htmlfor="city_name" generated="true"></div>      
                </td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
		<td>&nbsp;</td>
		   <td height="71%" class="fade_back_1" align="left">
			<div style="display:none" id="userlist">

		     	</div>
		    </td>
		 </tr> 
		
		 <tr>
		    <td width="20%" height="25" align="right" class="fade_back" valign="top"><span style="color:red">*</span>&nbsp;Subject:&nbsp;</td>
		    <td width="100%" height="25"  align="left" class="fade_back_1"><input name="subject" type="text" id="subject" value="" class="text_box4" size="60">&nbsp;</td>
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
	    </td>
	  </tr>
      </table>
    </form>
</div>
{include file=$footer} 