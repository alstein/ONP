{include file=$header1}
{include file=$header2}
<script type="text/javascript">
{literal}
$(document).ready(function()
{
	$("#checkall").click(function()
 	{
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function()
		{
			this.checked = checked_status;
			change(this);	
		});
 	});
	$("input[@type=checkbox]").click(function()
 	{
		change(this);
 	});
	function change(chk)
	{
		var $tr = $(chk).parent().parent();
		if($tr.attr('id'))
		{
			if($tr.attr('class')=='selectedrow' && !chk.checked)
				$tr.removeClass('selectedrow').addClass('grayback');
			else
				$tr.removeClass('grayback').addClass('selectedrow');
		}
	}
	var flag = false;
	$("#frmAction").submit(function(){
		
//		if($("#action").attr('value')=='')
//		{
//			$("#acterr").text("Please Select Action.").show().fadeOut(3000);
//			return false;
//		}
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
		
//		if (flag == false) {
//			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
//			return false;
//		}
//		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
//			return true;
//		else
//			return false;
    });
	$("#msg").fadeOut(5000);
});
{/literal}
</script>

    <form name="frmSearch" id="frmSearch" method="GET">	
    <table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px">
        
      <tr>
	<td valign="top">	
	  <strong>Slider: </strong>
	  <select name="slid" id="slid">
	      <option value="">Select Option</option> 
	      <option value="on" {if $slid eq 'on'} selected="selected" {/if} onclick="window.location.href='{$siteroot}/admin/globalsettings/deal/recommended-deals.php?slider=on'">Slider On</option>
	     <option value="off" {if $slid eq 'off'} selected="selected" {/if} onclick="window.location.href='{$siteroot}/admin/globalsettings/deal/recommended-deals.php?slider=off'">Slider Off</option>
	  </select>			
	  </td>	
      </tr>
    </table>
    </form>
<br />
<h3> &nbsp;Recommended Deals</h3>
{if $msg}
<div align="center" class="success">{$msg}</div>
{/if}
<div class="holdthisTop">
 <form name="frmAction" id="frmAction" method="post" action="">
<!--<input type="hidden" value="{$smarty.get.product}" name="product"/>-->
<table  class="listtable" width="97%">


<tr class="headbg">
       
			<td width="10%" align="left" valign="top">Deal Name</td>
			<td width="10%" align="left" valign="top">Seller Name</td>
			<td width="8%" align="left" valign="top">Start Date</td>	
			<td width="8%" align="left" valign="top">End Date</td>	
			<td width="8%" align="left" valign="top">Deal Type</td>
			<td width="9%" align="left" valign="top">City</td>
			<td width="8%" align="left" valign="top">Price In &#163;</td>
			<td width="12%" align="left" valign="top">Original Price In &#163;</td>	
                        <td width="10%" align="right" valign="top">Action</td>
          </tr>

{section name=i loop=$deal}


		      <tr class="grayback" id="tr_{$deal[i].deal_unique_id}">
			
			<td align="left" valign="top"><!--{if $deal[i].recommend eq '1'}<img align="absmiddle" src="{$siteimg}/icons/bullet-fingerpoint.gif"/>{/if}-->{$deal[i].title|ucfirst}</td>
			<td align="left" valign="top">{$deal[i].s_firstname} {$deal[i].s_lastname}</td>
			<td align="left" valign="top">{$deal[i].start_date}</td>
			<td align="left" valign="top">{$deal[i].end_date}</td>
			<td  valign="top">{$deal[i].deal_type|ucfirst}</td>
			<td valign="top">{$deal[i].deal_city}</td>
			<td  valign="top">{$deal[i].groupbuy_price}</td>
			<td valign="top">{$deal[i].orignal_price}</td>	
<td align="right">
Order
<input type="text" size="2" name="{$deal[i].deal_unique_id}" id="{$deal[i].deal_unique_id}" value="{$deal[i].sizeorder2}" />

</td>

</tr>
{/section}

   <tr>
       

             <td colspan="10" align="right">
<input type="submit" name="submit"  value="update" /></td>
      
          
   </tr>
   
  </table>
</form>
</div>
{include file=$footer}