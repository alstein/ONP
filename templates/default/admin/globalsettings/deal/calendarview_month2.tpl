{include file=$header1}
{*include file=$header2*}

{strip}
<script type="text/javascript" src="{$siteroot}/js/tips/wz_tooltip.js"></script>
<!-- <script type="text/javascript" src="{$siteroot}/js/animatedcollapse.js"></script> -->
<script type="text/javascript" language="javascript" src="{$siteroot}/js/calendarDateInput.js"></script>
{/strip}


{literal}
<script type="text/javascript">
	function getCity(val)
	{
		ajax.sendrequest("GET", SITEROOT+"/admin/sitemodules/deal/get_city.php", {val:val}, '', 'replace');
	}
</script>
<script type="text/javascript">
function chkdeal()
{
alert("hi");
return false();
}
</script>
{/literal}

<div id="maincont02">
  <div id="myWardrobe">
    
   
  <div id="myArea"> 
    <div class="holdthis">
<table cellpadding="2" cellspacing="2" border="0" width="100%">
  <tr>
  	<td></td>
    <td align="right">
	<form name="form1" method="get" id="form1" action="">
	<table width="100%" align="right" cellpadding="0" cellspacing="0">
      <tr>
	<td width="10%" align="left"><!--<img align="absmiddle" src="{$siteroot}/templates/{$templatedir}/images/icons/add.png"/><a href="{$siteroot}/admin/sitemodules/feedback/add_feedback.php"  title="See Deals">See Deals</a>--></td>
       <!-- <td width="40%" valign="top" align="right">
	<select name="country" onchange="javascript: getCity(this.value);">
		{section name=i loop=$country}
		<option {if $smarty.get.country eq $country[i].countryid} selected="selected" {/if} value="{$country[i].countryid}">{$country[i].country}</option>
		{/section}
	</select>-->
	<!--<label>
          <input name="search" type="text" countryid="search" value="" size="35" class="search" />
        </label>--></td>
        <td width="1%" align="center" valign="top">	
		<div id="replace">
			<select name="city">
			{if $city_arr}
				<option value="">Select City</option>
				{section name=i loop=$city_arr}
				<option {if $smarty.get.city eq $city_arr[i].city_name} selected="selected" {/if} value="{$city_arr[i].city_name}">{$city_arr[i].city_name}</option>
				{/section}
			{/if}
			</select>
		</div>
	</td>
	<td width="1%"><input type="submit" name="submit" id="button" value="Search" /></td>
      </tr>
    </table></form></td>
  </tr>
</table>
      <div class="consumer-left">
        <h1 class="header"><label style="float:left;">Deal Calendar for {if $smarty.get.city}{$smarty.get.city} {else}{$city_arr[0].city_name}{/if}</label>
		<div class="clr"></div>
	</h1>
	<br>{if $suc_msg}<div align="center">{$suc_msg}</div><br>{/if}
	{if $smarty.get.id}<div align="right"><a href="assign_deal.php?id={$smarty.get.product_id}&city={$smarty.get.city_id}"><strong>Assign Deal</strong></a></div>{/if}
        <div class="marginTop">
          <div class="tabone">
            <ul>
             
             
            </ul>
          </div>
          <div class="tabcontent">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="module05TL"></td>
                <td class="module05TR"></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
               
              <tr>
                <td colspan="2" class="bgwhtmodule"><div id="nav-personal2">
                    <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" >
                      <tr class="greenBg">
                        <td width="34%" align="center"><a href="{$selfpath}?country={$getCountry}&city={$city_rep}&year={if $last_year neq ''}{$last_year}{else}{$year}{/if}&amp;today={$today}&amp;month={$last_month}" class="traingleLeft"><img src="{$siteroot}/templates/{$templatedir}/images/resultset_previous.png" border="0" />&nbsp; &nbsp; &nbsp; &nbsp;</a> </td>
                        <td width="33%" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="50%" align="right"><h1 class="CalPageTitle">{$sql_date|date_format:"%B"} </h1></td>
                              <td width="2%">&nbsp;</td>
                              <td width="48%" align="left"><h1 class="CalPageTitle">{$sql_date|date_format:"%Y"}</h1></td>
                            </tr>
                          </table></td>
                        <td width="33%" align="center"><a href="{$selfpath}?country={$getCountry}&city={$city_rep}&year={if $next_year neq ''}{$next_year}{else}{$year}{/if}&amp;today={$today}&amp;month={$next_month}{if $next_month>12}&amp;act=next{/if}" class="traingleRight"><img src="{$siteroot}/templates/{$templatedir}/images/resultset_next.png" border="0" />&nbsp; &nbsp; &nbsp; &nbsp;</a> </td>
                      </tr>
                      <tr>
                        <td colspan="3" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                            <tr class="grnBg"> {foreach from= $alldays item=value}
                              <td align="center"><b>{$value}</b></td>
                              {/foreach} </tr>
                            <tr class="greenBack"> {section name= k loop=$dayone }
                              {assign var="i" value="`$smarty.section.k.index+1`"}
                              <td class="blank" style="vertical-align:top;height:70px;width:100px;">&nbsp;</td>
                              {/section}  
                              {section name=zz loop=$numdays }
                              {assign var="zzz" value="`$smarty.section.zz.index+1`"}
			       {if $i >= 7} </tr>
                            <tr class="greenBack">{assign var="i" value="`1`"} {/if}
                              {assign var="result_found" value="`0`"} 
			  {if $result_found neq 1}
                              {if $month lt 10}
                              {assign var="monthd" value="`0|cat:$month`"}
                              {else}
                              {assign var="monthd" value="`$month`"}
                              {/if}
                              {if $zz lt 10}
                              {assign var="zzd" value="`0|cat:$zzz`"}
                              {else}
                              {assign var="zzd" value="`$zzz`"}
                              {/if}
                              {/if }
                              {if $result_found neq 1}
				
                              <td align="right" style="vertical-align:top;height:70px;width:100px;"  {if $consumer_status[zz] eq 'free'} class="free_consucal"{elseif $consumer_status[zz] eq 'busy'} class="red1 normal" {/if}><a href="javascript:;" style="text-align:top;"> 
				<b style="vertical-align:top;">{$zzz}</b></a>
				{assign var="finals" value=$deals[zz].final_deals}
				{section name=k loop=$finals}
					<!--<a href="{$siteroot}/admin/sitemodules/deal/view_product.php?id={$finals[k].product_id}&act=view" class="newone1">--><font style="color:#111;">{$finals[k].product_name|substr:0:9}</font>{if $finals[k].deal_type eq 1}-<font style="color:#1D2EEF;">(main deal)</font>{else}-<font style="color:#DF0000;">(side deal)</font>{/if}</a>{if $smarty.section.i.iteration gt 1}<br>{/if}
				{/section}
			      </td>
                              {/if }
                              {assign var="result_found" value="`0`"}
                              {assign var="i" value="`$i+1`"}
                              {/section}
                              {if $create_emptys eq 7} {assign var="create_emptys" value="`0`"}{/if}
                              {if $create_emptys neq 0}
                              {section name=c loop=$create_emptys}
                              <td valign="middle" align="center">&nbsp;</td>
                              {/section}
                              {/if} </tr>
                          </table></td>
                      </tr>
			<tr>
			  <td colspan="3">
				<table width="100%" cellpadding="2" cellspacing="2" border="0">
				</table>
			  </td>
			</tr>
                    </table>
                  </div></td>
              </tr>
              <tr>
                <td class="module04BL"></td>
                <td class="module04BR"></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="consumer-right">
        <div class="contrgt_inner1">
          <div class="holdthis"> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="clr">
    <!-- this div is to be kept at the bottom of any parent div which is not floated but has the child elements floated-->
  </div>
</div>
<!-- / main containt section starts -->
</div>
{include file=$footer}
<!--{if $consumer_status[zz] eq 'free'}<a href={$siteroot}/admin/sitemodules/calender/create_event.php?year={$year}&amp;day={$zzz}&amp;month={$month}>Assign Deal <\/a>{/if}-->