{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/pagelist.js"></script>

{include file=$header2}
<div class="holdthisTop">

	<h3 class="fl width50">Demand Request List</h3>
	
	<div class="clr"></div>

	<div id="msg" align="center">{$msg}</div>
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
			<form name="frmAction" id="frmAction" method="post" action="">
        <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
          <tr class="headbg">
           
            <td width="30%" align="left" valign="top">Seller Name</td>
            <td width="40%" align="left" valign="top">Product Name</td>
            <td width="39%" align="center" valign="top">Interested</td>
          </tr>
          {section name=i loop=$demand}
          <tr class="grayback" id="tr_{$demand[i].id}">
            
            <td align="left" valign="top">{$demand[i].full_name|ucfirst}</td>
            <td align="left" valign="top" >{$demand[i].product_name|ucfirst}</td>
	    <td align="center" valign="top" >Yes</td>	
				<!--<td align="center" valign="top"><img src="{$siteimg}/icons/application_edit.png" align="absmiddle" /> <a href="{$siteroot}/admin/globalsettings/deal/add-demand.php?id={$demand[i].id}" class="admintxt"><strong>Edit</strong></a></td>-->
          </tr>
		  {sectionelse}
		  <tr><td colspan="4"><strong>No Record Found.</strong></td></tr>
          {/section}
		 <!-- <tr><td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td><td colspan="3" align="left"><select name="action" id="action"><option value="">--Action--</option><option value="delete">Delete</option></select>
      <input type="submit" name="submit" id="submit" value="Go" /><span id="acterr" class="error"></span></td></tr>-->
        </table></form></td>
    </tr>
	{if $pgnation}<tr><td align="right">{$pgnation}</td></tr>{/if}
  </table>
</div>
</div>
{include file=$footer}