{include file=$header1}
{literal}
<script type="text/javascript">
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
<h3 align="left"><b>Manage Active Deals</b></h3>
<div align="center" id="msg">{$msg}</div>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
  <tr>
  	<td></td>
    <td align="right">
	<form name="form1" method="get" id="form1" action="">
	<table width="100%" align="right" cellpadding="0" cellspacing="0">
      <tr>
	<td width="20%" align="left"><!--<img align="absmiddle" src="{$siteroot}/templates/{$templatedir}/images/icons/add.png"/><a href="{$siteroot}/admin/sitemodules/feedback/add_feedback.php"  title="Add Feedback">Add Feedback</a>--></td>
        <td width="68%" align="right"><label>
          <input name="search" type="text" id="search" value="" size="35" class="search" />
        </label></td>
        <td width="12%" align="left"><input type="submit" name="button" id="button" value="Search" class="searchbutton" /></td>
      </tr>
    </table></form></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="center"><form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
        <table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
          <tr class="headbg">
            <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
<!-- 	    <td width="5%" align="center" valign="top">Sr.No</td>	 -->
<!--             <td width="15%" align="center" valign="top">User</td> -->
	    <td width="15%" align="center" valign="top">Product Name</td>	
	    <td width="15%" align="center" valign="top">Start Deal Date/Time</td>
	    <td width="15%" align="center" valign="top">End Deal Date/Time</td>		
	    <td width="10%" align="center" valign="top">City</td>
	    <td width="10%" align="center" valign="top">Actual Price</td>
	    <td width="20%" align="center" valign="top">Action</td>
          </tr>
          {section name=i loop=$deal}
          <tr class="grayback" id="tr_{$deal[i].product_id}">
            <td align="center" valign="top"><input type="checkbox" name="product_id[]" value="{$deal[i].product_id}" /></td>
            <td align="left" valign="top">{$deal[i].product_name|substr:0:20}</td>
           <td align="left" valign="top">{$deal[i].deal_start_date}</td>
	   <td align="center" valign="top">{$deal[i].deal_end_date}</td>	
	    <td align="left" valign="top">{$deal[i].product_city}</td>	
            <td align="left" valign="top">{$deal[i].product_act_price}</td>
         
	    <td align="center" valign="top">
			<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />&nbsp;<a href="{$siteroot}/admin/sitemodules/deal/view_product.php?id={$deal[i].product_id}&act=view"><strong>View</strong></a> |
			<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="edit_product.php?id={$deal[i].product_id}&act=edit"><strong>Edit</strong></a>
	    </td>
          </tr>
          {sectionelse}
          <tr>
            <td colspan="5" align="center" height="25" class="error">Active deals not found.</td>
          </tr>
          {/section}
	{if $deal}
          <tr>
            <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left" colspan="3"><select name="action" id="action">
                <option value="">--Action--</option>
                <option value="delete">Delete</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
              <input type="submit" name="submit" id="submit" value="Go"  class="headbg"/>
              <span id="acterr" class="error"></span></td>
            <td colspan="6" align="right">{if $showpaging eq "yes" }{$pgnation}{/if}</td>
          </tr>
	{/if}
        </table>
      </form></td>
  </tr>
</table>
<div class="clr"></div>
{include file=$footer} 