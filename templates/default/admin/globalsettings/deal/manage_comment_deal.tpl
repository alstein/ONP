{include file=$header1}
{literal}
<script type="text/javascript">
	function onchangeit(val)
	{
		location.href = SITEROOT+"/admin/sitemodules/deal/manage_comment_deal.php?deal_id="+val;
		return false;
	}
	
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
		if($("#action").attr('value')=='')
		{
			$("#acterr").text("Please Select Action.").show().fadeOut(3000);
			return false;
		}
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
		
		if (flag == false) {
			$("#acterr").text("Please select atleast one record.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action?'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
</script>
{/literal}
{include file=$header2}
<h3 align="left">Manage Deal Comments</h3>
{if $smarty.post.city}<div align="right"><a href="{$siteroot}/admin/sitemodules/calender/calendarview_month.php?city={$smarty.post.city}"><strong>View Calendar</strong></a></div><br>{/if}
<div align="center" id="msg">{$msg}</div>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
  <tr>
  	<!--<td width="20%" align="left"><img align="absmiddle" src="{$siteroot}/templates/{$templatedir}/images/icons/add.png"/><a href="{$siteroot}/admin/sitemodules/deal/add_comment_deal.php"  title="Add Feedback">Add Comment</a></td>-->
	<td align="right">
		<form name="form1" method="get" id="form1" action="">
		<table width="100%" align="right" cellpadding="0" cellspacing="0">
	<tr>
		<td width="40%"></td>
       <td width="55%" align="center" valign="top">	
		<strong>Select Deal: </strong>
			{if $arr}
			<select name="deal_id" onchange="javascript:onchangeit(this.value);">
			<option value="all" selected="selected">All</option>
				{section name=i loop=$arr}
				<option {if $smarty.get.deal_id eq $arr[i].product_id} selected="selected" {/if} value="{$arr[i].product_id}">{$arr[i].product_slogan|substr:0:30}</option>
				{/section}
			</strong>
			{/if}
	</td>	
	<td width="5%"></td>
      </tr>
    </table></form></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="center"><form name="frmAction" id="frmAction" method="get" action="" onsubmit="">
        <table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
          <tr class="headbg">
      	    <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
			    <td width="15%" align="center" valign="top">product name</td>	
	    		 <td width="15%" align="center" valign="top">Comment</td>
				 <td width="15%" align="center" valign="top">User name</td>
             <td width="10%" align="center" valign="top">Deal Time</td>	
	    		 <td width="10%" align="center" valign="top">Action</td>
          </tr>
          {section name=i loop=$deal}
          <tr class="grayback" id="tr_{$deal[i].id}">
            <td align="center" valign="top"><input type="checkbox" name="id[]" value="{$deal[i].id}" /></td>
            <td align="left" valign="top">{$deal[i].product_name|substr:0:30}</td>
         <td align="left" valign="top">{$deal[i].comment|stripcslashes|substr:0:40}</td>
				<td align="left" valign="top">{$deal[i].username|stripcslashes|substr:0:40}</td>
            <td align="center" valign="top">{$deal[i].comment_date|date_format}</td>	
	    <td align="center" valign="top">
<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="{$siteroot}/admin/sitemodules/deal/add_comment_deal.php?id={$deal[i].id}&act=edit"><strong>edit</strong></a>
          </tr>
          {sectionelse}
          <tr>
            <td colspan="8" align="center" height="25" class="error">Deal not found.</td>
          </tr>
          {/section}
	{if $deal}
          <tr>
            <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left" colspan="2"><select name="action" id="action">
                <option value="">--Action--</option>
                <option value="delete">Delete</option>
              </select>
              <input type="submit" name="submit" id="submit" value="Go"  class="headbg"/>
              <span id="acterr" class="error"></span></td>
            <td colspan="3" align="right">{if $showpaging eq "yes" }{$pgnation}{/if}</td>
          </tr>
	{/if}
        </table>
      </form></td>
  </tr>
</table>
<div class="clr"></div>
{include file=$footer} 