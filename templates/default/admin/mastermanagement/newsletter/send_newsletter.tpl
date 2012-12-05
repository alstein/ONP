{include file=$header1}
{include file=$header2}
{strip}
	<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
	
{/strip}

{strip}<script language="javascript" src="{$siteroot}/js/news_letter.js"></script>{/strip}
{literal}
<script language="javascript">
function selectpagecontent()
	{
		
		var nlid = document.getElementById("newsletter").value;
		window.location = "send_newsletter.php?news="+nlid;
	}

function openpopup(phpfile)
{  
	
		var url_val=phpfile;
      	//window.open("add_to_user.php");
		window.open("add_to_user.php",null,' height=500 , width=500 , left=100,  top=100,resizable=yes,scrollbars=yes,toolbar=no,status=yes');
	   
} 

function openpopup1(phpfile,id)
{	

		var url_val=phpfile;
		var url1 = 'add_to_sub.php?city='+id;
      	window.open(url1,null,' height=500 , width=500 , left=100,  top=100,resizable=yes,scrollbars=yes,toolbar=no,status=yes');
}

function show()
{
	if(document.getElementById('all').checked == true)
	{
	document.getElementById('sub').style.display = "none";
	document.getElementById('to').style.display = "none";
	document.getElementById('to1').style.display = "none";
	}else
	{
	document.getElementById('sub').style.display = "block";
	document.getElementById('to').style.display = "block";
	document.getElementById('to1').style.display = "block";
	}
}
window.onerror = null;
 var bName = navigator.appName;
 var bVer = parseInt(navigator.appVersion);
 var NS4 = (bName == "Netscape" && bVer >= 4);
 var IE4 = (bName == "Microsoft Internet Explorer" 
 && bVer >= 4);
 var NS3 = (bName == "Netscape" && bVer < 4);
 var IE3 = (bName == "Microsoft Internet Explorer" 
 && bVer < 4);
 var blink_speed=500;
 var i=0;
 
if (NS4 || IE4) {
 if (navigator.appName == "Netscape") {
 layerStyleRef="layer.";
 layerRef="document.layers";
 styleSwitch="";
 }else{
 layerStyleRef="layer.style.";
 layerRef="document.all";
 styleSwitch=".style";
 }
}
</script>
{/literal}
{literal}
<script type="text/javascript">
	function getCity(val)
	{
		ajax.sendrequest("GET", SITEROOT+"/admin/sitemodules/deal/get_city.php", {val:val}, '', 'replace');
	}
</script>
{/literal}
<h3>Send Newsletter</h3>

<div id="Content"> 
	<form name="frm_send_news" id="frm_send_news" action = "" method="POST" onsubmit="javascript:return new_letter();">
	<table width="100%" height="129"  border="0" align="center" cellpadding="2" cellspacing="1" class="brdall" >
	
	  <tr>
	    <td align="center" class="red">{$msg}</td>
	  </tr>
	     <tr>
              <td>
                <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="Greenback" >
		 <tr>
			<td  height="25" align="right" class="fade_back"><span style="color:red">*</span>&nbsp;Newsletter :</td>
			<td  height="25" align="left" class="fade_back_1">
			<select class="text_box1" name="newsletter" id="newsletter" onChange="selectpagecontent();" >
			<option value="0">-Select-</option>
			{section name=sec1 loop=$title}
			<option value="{$title[sec1].nl_id}" {if $nlid eq $title[sec1].nl_id} selected="selected"{/if}>{$title[sec1].nl_title}</option>
			{/section}
                        </select></td>
  		 </tr>
		<Tr><td colspan="2">&nbsp;</td></Tr>
			<tr>
						<td height="25" align="right" class="fade_back"><span style="color:red">*</span>&nbsp;City :</td>
						<td valign="top">	
								<select name="city" id="city">
									<option value="0">Select City</option>
									{section name=i loop=$city_arr}
									<option {if $smarty.post.city eq $city_arr[i].city_id} selected="selected" {/if} value="{$city_arr[i].city_id}">{$city_arr[i].city_name}</option>
									{/section}
								</select>
						</td>
					</tr>
		
		<Tr><td colspan="2">&nbsp;</td></Tr>
			<tr>
              <td width="20%" height="25" align="right" valign="top"class="fade_back"><span style="color:red">*</span>&nbsp;To :</td>
              <td height="71%" class="fade_back_1" valign="middle"><textarea name="to" class="text_area5" rows="3" cols="60"></textarea></td>
            </tr>
		<tr>
			<td width="20%" height="25" align="left" class="fade_back">&nbsp;</td>
			<td height="71%" class="fade_back_1" align="left">
			<table><TR><TD>
				<div id="sub" style="display:block">	<a href="#" class="left_menu" onClick="return openpopup1('add_to_sub',document.getElementById('city').value);"><u>Subscribed Users</u></a></div></TD><td>&nbsp;&nbsp;&nbsp;
				<input type="checkbox" name="all" id="all" value="check" onclick="return show();" >
				<strong>All Subscribers</strong>
				</TD></TR>
			</table>
			</td>
		</tr> 
		 <tr>
			<td width="20%" height="25" align="right" class="fade_back"><span style="color:red">*</span>&nbsp;Subject :</td>
			<td width="100%" height="25"  align="left" class="fade_back_1"><input name="subject" type="text" id="subject" value="" class="text_box4" size="60">&nbsp;</td>
		</tr> 

<Tr><td colspan="2">&nbsp;</td></Tr>
<tr>
                <td valign="top" align="right"><span style="color:red">*</span>&nbsp;Newsletter Content :</td>
                <td valign="top">
						{oFCKeditor->Create}

                </td>
            </tr>

<Tr><td colspan="2">&nbsp;</td></Tr>

		<tr>
                        <td width="20%" height="25" align="center" class="fade_back">&nbsp;</td>
			<td height="71%"  align="left" class="fade_back_1">&nbsp;
			<input type="submit" name="submit" value="Send Newsletter" class="button1"></td>
		</tr>
	 </table>
	</td>
        </tr>
	
</table>
</form>
</div>
{include file=$footer} 