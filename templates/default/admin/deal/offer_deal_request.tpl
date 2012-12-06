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

		var alen = $("input[id=offer_deal_id]:checked").length;
		if(alen<=0)
			flag=false;


		if (flag == false) {
			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action ?'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
</script>

<script type="text/javascript">
function redirect_deal(url,deal_id)
{
   //alert("url: "+url+" DEal id: "+deal_id);
     window.location = url+"/admin/globalsettings/deal/pending-deal.php?prod_deal_id="+deal_id;
}

</script>

{/literal}

{include file=$header2}
<!--<div class="breadcrumb">--><p class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Deals By Consumers</p></div>
<br/>

<div class="holdthisTop">
<div>
 <h3 align="left"><b>Deals By Consumers</b></h3>
	  </div>
          <div class="clr">&nbsp;</div>
	<div class="fr">
		<form name="frmSearch" action="" method="get">
			<table align="right" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="right">
						<label>
							<input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search"/> 
						</label>
					</td>
					<td align="left">
						<input type="submit" name="button" id="button" value="Search" class="searchbutton" />
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="clr">&nbsp;
<div>

   
</div>

	<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">
  		

  		<tr>
		    <td  colspan="2">
			<div align="center"  id="msg" >{$msg}</div>
			{if $smarty.get.prod_deal_id neq ""}
			  <div align="left"><strong>Deal:</strong> <strong class="success">{$deal_arr[0].product_name|@ucfirst}</strong></div>
			  <div align="right" class="success" style="padding-bottom:5px;"></div>
			{/if}

      			<form name="frmAction" id="frmAction" method="post" action="">
			  <table cellpadding="6" cellspacing="2" align="center" width="100%" border="0" class="listtable">
			    <tr class='headbg' align="center">
				<td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
				<td width="25%" align="left" valign="top">Offered By</td>
				<td width="25%" align="left" valign="top">Offered To</td>
				<td width="25%" align="left" valign="top">Merchant Category</td>
				
                 <!--<td width="25%" align="left" valign="top">Address</td>-->
                             <!--   <td width="25%" align="left" valign="top">Phone No</td>-->
				<td width="15%" align="left" valign="top">Amount To Be Spend</td>	
				<td width="15%" align="left" valign="top">Discount Requested</td>
                               <!-- <td width="5%" align="left" valign="top">OutFlow</td>-->
				<td width="10%" align="left" valign="top">Net Amount To Spend</td>
				<!--<td width="10%" align="left" valign="top">Accepted to paid</td>-->
                                <td width="25%" align="left" valign="top">Redeem From</td>
				<td width="25%" align="left" valign="top">Redeem To</td>
				<td width="25%" align="left" valign="top">Bid Valid Till</td>
				
				<td width="25%" align="left" valign="top">Status</td>			
					<!--            <td width="8%" align="left">Close Date</td>-->
			    </tr>
			    {section name=i loop=$offer_deal}
			    <tr class="grayback" id="tr_{$offer_deal[i].offer_deal_id}" >
				<td  valign="top"><input type="checkbox" value="{$offer_deal[i].offer_deal_id}" name="offer_deal_id[]" id="offer_deal_id"/></td>
				<td align="left" valign="top">{$offer_deal[i].fullname}</td>
				<td align="left" valign="top">{$offer_deal[i].business_name}</td>

				<td align="left" valign="top">{$offer_deal[i].category}</td>
				
				<!--<td align="left" valign="top">{$offer_deal[i].address1}</td>-->
				<td align="left" valign="top">{$offer_deal[i].amount_spend}</td>
				<td align="left" valign="top">{$offer_deal[i].discount}</td>
				<!--<td align="left" valign="top">{$offer_deal[i].outflow}</td>-->
				<td align="left" valign="top">{$offer_deal[i].amt_to_pin}</td>
				<!--<td align="left" valign="top">{$offer_deal[i].accepted_to_paid}</td>	-->
				<td align="left" valign="top">{$offer_deal[i].redeem_from|date_format:$smarty_date_format}</td>
				<td align="left" valign="top">{$offer_deal[i].redeem_to|date_format:$smarty_date_format}</td>
				<td align="left" valign="top">{$offer_deal[i].bid_validity|date_format:$smarty_date_format}</td>
				
				
				<!--<td align="left" valign="top">{if $offer_deal[i].status eq 'no'}<a href="{$siteroot}/admin/deal/offer_deal_request.php?status=yes&id={$offer_deal[i].offer_deal_id}">Accept</a> <a href="{$siteroot}/admin/deal/offer_deal_request.php?status=rejected&id={$offer_deal[i].offer_deal_id}">Reject</a>{elseif $offer_deal[i].status eq 'yes'}Accepted {else} Rejected {/if}</td>-->

<td align="left" valign="top">{if $offer_deal[i].status eq 'no'}Pending{elseif $offer_deal[i].status eq 'yes'} Accepted{elseif $offer_deal[i].status eq 'rejected'}Rejected{/if}</td>

			     </tr>
			    {sectionelse}
			    <tr align="center" class="trbgprj02">

				    <td colspan="12" class="success" align="center"><b>No record found</b></td>
			    </tr>
			    {/section}
                            <tr>
		      <td align="left" colspan="1">
			  <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif" />
		      </td>
		      <td align="left" colspan="2">
			  <select name="action" id="action">
			      <option value="">--Action--</option>
			      <option value="delete">Delete</option>
			  </select>
			  <input type="submit" name="submit" id="submit" value="Go" />
			  <br><span id="acterr" class="error"></span>
			</td>
			<td colspan="9" align="right"> {$pgnation} </td>
		    </tr>
        		</table>
		        </form>
	             </td>
               </tr>
        </table>
</div>
{include file=$footer}