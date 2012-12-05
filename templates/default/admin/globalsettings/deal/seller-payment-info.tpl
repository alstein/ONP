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
        function check(id,dealid,id1){
	    if(confirm('Are you sure this user has Claimed Voucher.'))
		{
		window.location.href =SITEROOT+"/admin/globalsettings/deal/view_product.php?id="+id+"&id1="+dealid+"&type="+id1;
		return true;
		}
		else
		{	
		return false;
		}
	}
	
	function check1(id,dealid,type1){
	    if(confirm('Are you sure this buyer has paid you?'))
	    {
	    window.location.href =SITEROOT+"/admin/globalsettings/deal/view_product.php?pay_id_info="+id+"&id1="+dealid+"&type="+type1+"&act=view";
	    return true;
	    }
	    else
	    {	
	    return false;
	    }
	}
	
	function fake(dealid,type1){
		var fk= prompt('Enter fake user count');
		if(fk > 0)
		{
		window.location.href =SITEROOT+"/admin/globalsettings/deal/view_product.php?fk="+fk+"&id1="+dealid+"&type="+type1+"&act=view";
		//return true; 
		}
	}	
	
</script>
{/literal}
{include file=$header2}

<!-- Maincontent starts -->

	    <div class="accntsec fl" style="width:950px">
        	<h3 class="allCaps">Monitor Voucher Sales <span style="float:right;padding-right:5px"><a href="javascript:void(0);" onclick="javascript: history.go(-1);">Back</a></span></h3>		
		<input type="hidden" id="mesg_id" name="mesg_id" value=""/>
		<form name="frmAction" method="POST" id="frmAction" action="">
		<table cellpadding="10" cellspacing="1" border="0" class="inboxtable" style="width:950px">
		    <tr><Td>&nbsp;</Td></tr>
		    <tr>
                        <td colspan="3">
                          <a href="{$siteroot}/admin/globalsettings/deal/add-new.php?dealid={$smarty.get.id1}&type={$smarty.get.type}"><strong>Add Buyer</strong></a><br /><a href="javascript:void(0);" onclick="javascript: fake({$smarty.get.id1},'{$smarty.get.type}')" style="cursor:pointer;"><strong>Change Fake Buyer Count</strong></a>
                        </td>
			<td colspan="2"><b>Total Buyers: </b> {if $cnt} {$cnt}{else}0{/if}<br /><b>Fake Buyers: </b>{$fake}</td>
                        <td colspan="3" style="padding-left:100px;">Done: <img src="{$siteroot}/templates/default/images/icn.png"  /> Not Done: <img src="{$siteroot}/templates/default/images/icons/delpoll.gif"  /></td>
<td>
 <a href="javascript:void(0);" class="strong" style="color:#87B400" onclick="javascript:tb_show('How It Work', '{$siteroot}/admin/globalsettings/deal/howitwork.php?dealid={$smarty.get.id1}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=400&width=700&modal=false', tb_pathToImage);"> 
<strong>How It Work</strong></a></td>

<td ><strong><a target="_blank" style="color:#87B400" href="{$siteroot}/admin/globalsettings/deal/dealbuy_voucher_pdf.php?id={$smarty.get.id1}">Preview</a></strong></td>

                    </tr>
		    <tr><td>&nbsp;</td></tr>
		    <tr><Td>&nbsp;</Td></tr>
{if $user_list!=""}
<tr><td colspan="3"><img src="{$siteimg}/icons/excel.gif" align="top"> <a href="{$siteroot}/admin/globalsettings/deal/view_product.php?id1={$smarty.get.id1}&type={$smarty.get.type}&act=view&view=excel" target="_blank"><strong>Deal Report </strong></a></td></tr>
{/if}
		    <tr>
			<td ><input type="checkbox" id="checkall"/></td>
			<td width="150px"><strong>Buyer Name</strong></td>
			<td width="150px"><strong>Voucher Code</strong></td>
                      <td width="150px"><strong>Transation Id</strong></td>	
			<td width="100px"><strong>Quantity</strong></td> 
			<td width="100px"><strong>Price</strong></td>
		        <td width="150px"><strong>Issued</strong></td>
			<td width="150px"><strong>Payment</strong></td> 	
			<td width="250px"><strong>Mark</strong></td>
			<td width="250px"><strong>Claimed</strong></td>
		    </tr>
		    {section name=i loop=$user_list}
		    <tr height="30px;" class="grayback" id="tr_{$user_list[i].pay_id}">
			<td><input type="checkbox" name="pay_id[]" value="{$user_list[i].pay_id}" /></td>
			<td >{$user_list[i].first_name}&nbsp;{$user_list[i].last_name}</td>
			<td>{$user_list[i].pay_unique_id}</td>
                         <td> {$user_list[i].transaction_id}</td>
			<td>{$user_list[i].deal_quantity}</td>
			<td>&pound;{$user_list[i].deal_price}</td>
			<td>

{if $setmanual eq 'on' && $user_list[i].issue_manualy!='yes'}
 <a href="{$siteroot}/PHP-Kit/issuemanualy.php?dealid={$smarty.get.id1}&VendorTxCode={$user_list[i].VendorTxCode}">
   Issue Coupon
</a>
{else}{$user_list[i].expiry_date|date_format}{/if}

</td>
			<td>{if $user_list[i].payment_done eq 'yes'}<img src="{$siteroot}/templates/default/images/icn.png"  />
{ if $user_list[i].paymethod eq 'paypal'} {if $user_list[i].payment_refunded eq 'no'}<a href="{$siteroot}/RefundCode1.php?id={$user_list[i].pay_id}">Refund</a>{else}Refunded{/if}{/if}

{else}<img src="{$siteroot}/templates/default/images/icons/delpoll.gif"  /><a href="https://groupbuyit.co.uk/admin/globalsettings/deal/get_releasae.php?dealid={$smarty.get.id1}&VendorTxCode={$user_list[i].VendorTxCode}">Get Release</a>{/if}</td>
			<td>{if $user_list[i].mark_done eq 'yes'}<img src="{$siteroot}/templates/default/images/icn.png"  />{else}<a href="javascript:void(0);" onclick="return check1({$user_list[i].pay_id},{$user_list[i].deal_id},'{$smarty.get.type}')" style="color:green"><strong>Mark Done?</strong></a>{/if}</td>
			<td>{if $user_list[i].redumded eq '0000-00-00'} <a href="javascript:void(0);" onclick="return check('{$user_list[i].pay_id}','{$user_list[i].deal_id}','{$smarty.get.type}')" style="color:green"><b>Voucher Claimed?</b></a>{else}{$user_list[i].redumded|date_format}{/if}</td>
		    </tr>
		    {sectionelse}
		    <tr><td align="center" colspan="8" style="padding:5px"><strong>No Payment Information Available</strong></td></tr>
		    {/section}
		    <tr><td>&nbsp;</td></tr>
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
