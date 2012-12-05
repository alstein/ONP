{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
{/strip}

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
			$("#acterr").text("Please select action.").show().fadeOut(3000);
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
			$("#acterr").text("Please select checkbox.").show().fadeOut(3000);
			return false;
		}	
		
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });
	
});
</script>
<script type="text/javascript">
function printlabel(payid)
{


window.open(SITEROOT+'/admin/globalsettings/deal/print-label.php?pay_id_info='+payid,'Print Label','left=420,top=320,width=400,height=200,toolbar=0,resizable=0');


}

function viewcomment(payid)
{


window.open(SITEROOT+'/admin/globalsettings/deal/view-comment.php?pay_id_info='+payid,'Print Label','left=420,top=320,width=400,height=200,toolbar=0,resizable=0');


}
function check(id,dealid,id2){
	    if(confirm('Are you sure this buyer has paid you?'))
		{
		window.location.href =SITEROOT+"/admin/globalsettings/deal/view_product.php?type="+id2+"&id1="+dealid+"&id="+id+"&mark=1";
		return true;
		}
		else
		{	
		return false;
		}
	}

function checkdisp(id,dealid,id2){
	    if(confirm('Are you sure this product is dispatched?'))
		{
		window.location.href =SITEROOT+"/admin/globalsettings/deal/view_product.php?type="+id2+"&id1="+dealid+"&id="+id+"&mark=2";
		return true;
		}
		else
		{	
		return false;
		}
	}
</script>
{/literal}
{include file=$header2}
	<div class="accntsec fl" style="width:60%;vertical-align:top;">
	  <h3 class="allCaps">Monitor Product Sales<span style="float:right;padding-right:5px;vertical-align:top;"><a href="javascript:void(0);" onclick="history.go(-1);">Back</a></span></h3><br/>
	  <input type="hidden" id="readType" name="readType" value=""/>
	  <input type="hidden" id="mesg_id" name="mesg_id" value=""/>

	  <form name="frmAction" method="POST" id="frmAction" action="">
	      <table cellpadding="5" cellspacing="1" border="0" class="inboxtable">
                  <col width="2"/>
                  <col width="100"/>
                  <col width="50"/>
		  <col align="center" width="90"/>	
                  <col width="90"/>
                  <col width="80"/>
                  <col width="100"/>
                  <col width="100"/>
                  <col width="100"/>

	      <tr><td>&nbsp;</td></tr>
	      <tr>
                <td colspan="2"><a href="{$siteroot}/admin/globalsettings/deal/add-new.php?dealid={$smarty.get.id1}&type={$smarty.get.type}"><strong>Add Buyer</strong></a></td>
                <td colspan="3"><b>Total Buyers: </b>{if $cnt} {$cnt}{else}0{/if}</td>
		<td colspan="2" align="right"> Done: <img src="{$siteroot}/templates/default/images/icn.png"  />&nbsp; Not Done: <img src="{$siteroot}/templates/default/images/icons/delpoll.gif"  /></td>
<td>
 <a href="javascript:void(0);" class="strong" style="color:#87B400" onclick="javascript:tb_show('Notes', '{$siteroot}/admin/globalsettings/deal/notes.php?dealid={$smarty.get.id1}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=230&width=400&modal=false', tb_pathToImage);"> 
<strong>Notes</strong></a></td>
</tr>
	      <tr><td>&nbsp;</td>


</tr>
{if $user_list!=""}
<tr><td colspan="3"><img src="{$siteimg}/icons/excel.gif" align="top"> <a href="{$siteroot}/admin/globalsettings/deal/view_product.php?id1={$smarty.get.id1}&type={$smarty.get.type}&act=view&view=excel" target="_blank"><strong>Deal Report </strong></a></td></tr>
{/if}
	      <tr>
		    <th><input type="checkbox" id="checkall" /></th>
                    <th><strong>Buyer Name</strong></th>
		    <th><strong>Trans Id</strong></th>	
		    <th align="center"><strong>Quantity</strong></th> 
		    <th><strong>Deal Price</strong></th>		
		    <th><strong>Charges</strong></th>
		    <th><strong>Payment</strong></th> 	
		    <th><strong>Dispatched</strong></th>
		    <th><strong>Other</strong></th>
		</tr>
		{section name=i loop=$user_list}
		      {if $user_list[i].payment_done eq 'yes'}
		      <tr class="grayback" id="tr_{$user_list[i].pay_id}">
			<td><input type="checkbox" name="pay_id[]" value="{$user_list[i].pay_id}" /></td>
			<td>{$user_list[i].first_name}&nbsp;{$user_list[i].last_name}</td>
			<td>{$user_list[i].transaction_id}</td>
			<td align="center" >{$user_list[i].deal_quantity}</td>
			<td >&pound;{$user_list[i].pro_price}</td>
			<td >&pound;{$user_list[i].deal_price}</td>
			<td ><img src="{$siteroot}/templates/default/images/icn.png"  />
{ if $user_list[i].paymethod eq 'paypal'} {if $user_list[i].payment_refunded eq 'no'}<a href="{$siteroot}/RefundCode3.php?id={$user_list[i].pay_id}">Refund</a>{else}Refunded{/if}{/if}

			</td>
			<td >{if $user_list[i].dispatched eq '0000-00-00'} <a href="javascript:void(0);" onclick="return checkdisp('{$user_list[i].pay_id}','{$user_list[i].deal_id}','{$smarty.get.type}')" style="color:green"><b>Dispatched?</b></a>{else}{$user_list[i].dispatched|date_format}{/if}</td>
			<td>{if $user_list[i].comment}<a href="" style="color:green"  onclick="javascript: viewcomment({$user_list[i].pay_id});">Comment</a><br/>{/if}<a href="javascript:void(0);" style="color:green" onclick="javascript: printlabel({$user_list[i].pay_id});">Print Label</a>
			
			
			{if $user_list[i].release_fine eq 'no'}<br/>	<img src="{$siteroot}/templates/default/images/icons/delpoll.gif"  />
			<a href="{$siteroot}/admin/globalsettings/deal/get_sel_pro_release.php?dealid={$smarty.get.id1}&VendorTxCode={$user_list[i].VendorTxCode}" target="_blank">Get Fine</a>
			{/if}
			</td>
		      </tr>
		     {elseif $user_list[i].payment_done eq 'no'}
		      <tr height="40px" class="grayback" id="tr_{$user_list[i].pay_id}">
			  <td><input type="checkbox" name="pay_id[]" value="{$user_list[i].pay_id}" /></td>
			  <td >{$user_list[i].first_name}&nbsp;{$user_list[i].last_name}</td>
			  <td>{$user_list[i].transaction_id}</td>
			  <td align="center" >{$user_list[i].deal_quantity}</td>
			  <td >&pound;{$user_list[i].pro_price}</td> 	
			  <td >&pound;{$user_list[i].deal_price}</td>
			  <td > {if $user_list[i].pay_status eq '1'} 
			<img src="{$siteroot}/templates/default/images/check_amber.png"  /> 
				{/if}
			{if $user_list[i].pay_status eq '0'} 
			<img src="{$siteroot}/templates/default/images/icons/delpoll.gif"  /> {/if}
			<a href="javascript:void(0);" onclick="return check('{$user_list[i].pay_id}','{$user_list[i].deal_id}','{$smarty.get.type}')" style="color:green"><strong>Mark Done</strong></a>

			

</td>
			  <td >{if $user_list[i].dispatched eq '0000-00-00'} <a href="javascript:void(0);" onclick="return checkdisp('{$user_list[i].pay_id}','{$user_list[i].deal_id}','{$smarty.get.type}')" style="color:green"><b>Dispatched?</b></a>{else}{$user_list[i].dispatched|date_format}{/if}</td>
			  <td>{if $user_list[i].comment}<a href="" style="color:green"  onclick="javascript: viewcomment({$user_list[i].pay_id});">Comment</a><br />{/if}<a href="javascript:void(0);" style="color:green" onclick="javascript: printlabel({$user_list[i].pay_id});">Print Label</a>
			
			{if $user_list[i].release_fine eq 'no'}<br/>	<img src="{$siteroot}/templates/default/images/icons/delpoll.gif"  />
			<a href="{$siteroot}/admin/globalsettings/deal/get_sel_pro_release.php?dealid={$smarty.get.id1}&VendorTxCode={$user_list[i].VendorTxCode}" target="_blank">Get Fine</a>
			{/if}
										
			</td>
		          </tr>
		    {/if}
		  {sectionelse}
		  <tr><td align="center" colspan="4" style="padding:5px"><strong>No payment information available</strong></td></tr>
		  {/section}	
		</table>
		<table>
		<tr>
		    <td align="left" colspan="8">
		      <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
			<select name="action" id="action">
			<option value="">--Action--</option>
			<!--<option value="active">Publish</option>-->
			<option value="delete">Delete</option>
			<!--<option value="delete">Delete</option>-->
			</select>
			<input type="submit" name="submit" id="submit" value="Go"/>
		     </td>
		  </tr>
		  <tr><td><span id="acterr" class="error"></span></td></tr>
		</table>
   		</form>
            </div>
<!-- Maincontent ends -->
{include file=$footer} 
