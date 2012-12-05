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
<h3 align="left"><b>Newsletter Promostion Deals List</b></h3>
<div align="center" id="msg">{$msg}</div>
<table cellpadding="2" cellspacing="2" border="0" width="80%">
  <tr>
  	<td></td>
    <td align="right">
	<form name="form1" method="get" id="form1" action="">
	<table width="100%" align="right" cellpadding="0" cellspacing="0">
     <!-- <tr>
	<td width="20%" align="left"><img align="absmiddle" src="{$siteroot}/templates/{$templatedir}/images/icons/add.png"/><a href="{$siteroot}/admin/sitemodules/feedback/add_feedback.php"  title="Add Feedback">Add Feedback</a></td>
        <td width="68%" align="right"><label>
          <input name="search" type="text" id="search" value="" size="35" class="search" />
        </label></td>
        <td width="12%" align="left"><input type="submit" name="button" id="button" value="Search" class="searchbutton" /></td>
      </tr>-->
    </table></form></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="center"><form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
        <table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
          <tr class="headbg">
          <!--  <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>-->
<!-- 	    <td width="5%" align="center" valign="top">Sr.No</td>	 -->
<!--             <td width="15%" align="center" valign="top">User</td> -->
	    <td width="15%" align="center" valign="top">Product Name</td>	
	    <td width="15%" align="center" valign="top">Start Deal Date/Time</td>
	    <td width="15%" align="center" valign="top">End Deal Date/Time</td>		
	    <td width="10%" align="center" valign="top">City</td>
	    <td width="10%" align="center" valign="top">Actual Price</td>
	    
          </tr>
          {section name=i loop=$deal}
          <tr class="grayback" id="tr_{$deal[i].product_id}">
           <!-- <td align="center" valign="top"><input type="checkbox" name="product_id[]" value="{$deal[i].product_id}" /></td>-->
            <td align="left" valign="top">{$deal[i].title|substr:0:20}</td>
           <td align="left" valign="top">{$deal[i].start_date|date_format}</td>
	   <td align="center" valign="top">{$deal[i].end_date|date_format}</td>	
	    <td align="left" valign="top">{$deal[i].deal_city }</td>	
            <td align="left" valign="top">{$deal[i].groupbuy_price}</td>
         
	    
          </tr>
          {sectionelse}
          <tr>
            <td colspan="5" align="center" height="25" class="error">Active deals not found.</td>
          </tr>
          {/section}
	
        </table>
      </form></td>
  </tr>
</table>
<div class="clr"></div>
{include file=$footer} 