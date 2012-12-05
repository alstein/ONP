{include file=$header1}
{include file=$header2}

<div class="breadcrumb">
  <a href="{$siteroot}/admin/index.php">Home</a>  &gt;  <a href="{$siteroot}/admin/modules/admanagement/Ads.php">Ad Management </a>  &gt;  View Ad
</div><!--<div class="clr">&nbsp;</div>--><br/>
<h3>View Ad Information</h3> 

<div class="holdthisTop">
<div align="right"><h3><a href="Ads.php">Back</a></h3>
</div>

   <table width="100%" cellpadding="2" cellspacing="2" border="0">
      <tr>
	<td>
	   <table width="100%" cellpadding="2" cellspacing="2" border="0" class="conttableDkBg conttable">
              <tr>
		
		  <td valign="top">
		      <table width="100%" cellpadding="3" cellspacing="6" border="0">
                        <tr><td>&nbsp;</td></tr>
                         <tr>
                             {if $ad.ad_embedded_code}
			      <td   width="20%" align="right"><strong>Embedded code </strong></td>
                              <td align="left">
		                {$ad.ad_embedded_code|html_entity_decode}
                            </td>
                            {else}
			    <td width="20%" align="right" style="vertical-align:top;"><strong>Image : </strong></td>
			    <td  align="left"><img src="{$siteroot}/uploads/ad/{$ad.ad_image}" border="1" height="{$ad.height}" width="{$ad.width}"/></td>
			    {/if}
			</tr> 
			<tr>
			    <td width="20%" align="right"><strong>Title : </strong></td>
			    <td  align="left">{$ad.ad_title|@ucfirst}</td>
			</tr>
			<!--<tr>
			    <td width="20%" align="right"><strong>Alignment : </strong></td>
			    <td  align="left">{$ad.ad_align|@ucfirst}</td>
			</tr>-->
			<tr>
			    <td width="20%" align="right"><strong>Description : </strong></td>
			    <td  align="left">{$ad.ad_desc|@ucfirst}</td>
			</tr>
		      </table>
		  </td>
		</tr>
	     </table> 
     	   </td>
        </tr>
    </table>
</div>
{include file=$footer}
