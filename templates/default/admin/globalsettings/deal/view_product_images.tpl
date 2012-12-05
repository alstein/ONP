{include file=$header1}
{literal}
<script type="text/javascript">
	function getCity(val)
	{
		ajax.sendrequest("GET", SITEROOT+"/admin/sitemodules/deal/get_city.php", {val:val}, '', 'replace');
	}
	function getMerchants(val)
	{
		ajax.sendrequest("GET", SITEROOT+"/admin/sitemodules/deal/get_merchant.php", {val:val}, '', 'replace');
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
<div class="breadcrumb">
<table width="100%">
<tr><Td width="80%">
<a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="manage_deal.php">Manage Deals</a> &gt;  View Images</td>
<td width="5%">
<a href="manage_deal.php">Back</a></td>
</tr>
<tr><td colspan="2"><a href="add_image.php?id={$smarty.get.id}" ><img src="{$siteroot}/templates/default/images/icons/add.png" alt="add" /> Add image</a></td></tr>
</table></div>


 <h3 align="left"><b>View Images</b></h3>
<br/>
<div align="center" id="msg">{$msg}</div>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
  	<tr>
	  <td align="right">
	 <form method="post" name="frmAction" id="frmAction" action="">
		<table width="100%" align="right" cellpadding="0" cellspacing="0">


		<tr>
			<td colspan="2" valign="top" align="center">
				<form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
     				<table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable1">
          			<tr class="headbg">
            			<td width="1%" align="center" valign="top">
								<input type="checkbox" id="checkall" />
							</td>
							<td width="70%" align="center" valign="top">Image</td>	

	    					    <td width="30%" align="center" valign="top">Action</td>
          			</tr>
          			{section name=i loop=$allimages}
         			 <tr class="grayback" id="tr_{$allimages[i].image_id}">
                                                <td align="center" valign="top">
								<input type="checkbox" name="deal_id[]" value="{$allimages[i].image_id}" />
							</td>
            			   <td align="left" valign="top"><img name="photo1" id="photo1" src="{$siteroot}/display_image.php?path=uploads/product/thumbnail/{$allimages[i].thumbnail}&amp;width=200&amp;height=150"  /></td>

<td align="center" valign="middle">
								<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="{$siteroot}/admin/sitemodules/deal/add_image.php?image_id={$allimages[i].image_id}&id={$smarty.get.id}&&act=Edit"><strong>Edit</strong></a></td>

				</tr>
          			{sectionelse}
          				<tr>
            				<td colspan="5" align="center" height="25" class="error">Images not found.</td>
          				</tr>
          			{/section}
						{if $allimages}
          				<tr>
            				<td align="right">
									<img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
								</td>
            				<td align="left" colspan="3">
									<select name="action" id="action">
                					<option value="">--Action--</option>
                					<option value="delete">Delete</option>
                					<!--<option value="active">Active</option>
                					<option value="inactive">Inactive</option>-->
              					</select>
              						<input type="submit" name="submit" id="submit" value="Go"  class="headbg"/>
              						<span id="acterr" class="error"></span></td>
            					<td colspan="4" align="right">
										<!--{if $showpaging eq "yes" }
										{$pgnation}
										{/if}-->
								</td>
          				</tr>
						{/if}
        				</table>
      			</form>
				</td>
  			</tr>
		</table>
	<div class="clr">
</div>
{include file=$footer} 
