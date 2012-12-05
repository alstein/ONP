{include file=$header1}
<!--<script type="text/javascript">
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
			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
{/literal}
</script>-->
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Payment Report</div><br/>
<h3>Payment Report List</h3>

 {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
 
    <div class="holdthisTop">
    </div>
        <div class="holdthisTop"> 
            <form name="frmAction" id="frmAction" method="post" action="">
                <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
                    <tr class="headbg">
                    <!-- <td width="1%" align="left" valign="top"><input type="checkbox" id="checkall"/></td>-->
                        <td width="5%" align="left" valign="top"><strong>Sr.No.</strong></td>
                        <td width="15%" align="left" valign="top"><strong>User Name</strong></td>
                        <td width="15%" align="left" valign="top"><strong>Subscription Date</strong></td>
                        <td width="12%" align="left" valign="top"><strong>Expiration Date</strong></td>
                        <td width="25%" align="left" valign="top"><strong>Current Subscription Status/Package</strong></td>
                        <td width="10%" align="left" valign="top">NO. of Payment</td>
                        <td width="10%" align="left" valign="top">Total Payment</td>
                        <td width="8%" align="left" valign="top">Action</td>
                    </tr>
        {section name=i loop=$list}
                <tr class="grayback"  id="tr_{$smarty.section.i.list}">
                    <!-- <td align="left" valign="top"><input name="log[]" id="log[]" value="{$list[i].id}" type="checkbox" /> </td>-->
                     <td align="left" valign="top">{$smarty.section.i.iteration}</td>
                     <td align="left" valign="top">{$list[i].first_name}&nbsp;{$list[i].last_name}</td>
                     <td align="left" valign="top">{$list[i].signup_date|date_format:"%d-%m-%Y"}</td>
                     <td align="left" valign="top">{$list[i].last_expiration_date|date_format:"%d-%m-%Y"}</td>
                     <td align="left" valign="top">{if $list[i].subscribe_status eq 'Expired'}Deleted ({$list[i].subs_pack_name})
                     {elseif $list[i].subscribe_status eq 'Subscribed'}{$list[i].subscribe_status}
                      ({$list[i].subs_pack_name}){else}-----{/if}</td>
                     <td align="left" valign="top">{$list[i].no_of_pay}</td>
                     <td align="left" valign="top">{if $list[i].totalpay neq ''}${$list[i].totalpay}{/if}</td>
                     <td align="left" valign="top">{if $list[i].totalpay neq ''}
                     <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /> 
                     <a href="view_payment_report.php?edit_id={$list[i].userid}" title="View">View</a>{/if}</td>
                </tr>
        {sectionelse}
                <tr>
                    <td colspan="8" class="error" align="center">No Records Found.</td>
                </tr>
        {/section}
                    <tr>
                        <!--<td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                        <td align="left"><select name="action" id="action">
                            <option value="">--Action--</option>
                            <option value="delete">Delete</option>
                        </select>
                        <input type="submit" name="submit" id="submit" value="Go" />
                        <span id="acterr" class="error"></span></td>-->
                        <td colspan="8" align="right">{$pgnation}</td>
                    </tr>
                </table>
            </form>
        </div>
{include file=$footer} 

