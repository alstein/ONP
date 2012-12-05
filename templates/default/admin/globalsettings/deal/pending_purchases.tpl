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
<!--<div class="breadcrumb">--><p class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Pending Deals</p></div>
<br/>

<div class="holdthisTop">
<div>
 <h3 align="left"><b>Pending Deals</b></h3>
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
<form name="frmSearch" id="frmSearch" method="GET">	
    <table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px" class="fl">
  
<tr >
	<td>
<!--	      <div class="fl">-->
	  <strong>Seller Name: </strong>
	  <select name="deal_from_seller_name" id="deal_from_seller_name" onchange="javascript:this.form.submit();">
	                <option value="all">All</option>
			{section name=i loop=$deal_from_seller_names}
				<option value="{$deal_from_seller_names[i].userid}" {if $deal_from_seller_names[i].userid eq $smarty.get.deal_from_seller_name} selected="selected" {/if} >{$deal_from_seller_names[i].fullname}</option>
		{/section}
	  </select>
	   <input type="hidden" name="dltype" id="dltype" value="{$smarty.get.dltype}">
	</td>
</tr>
<!--	  </div>-->	
    </table>
    </form>
   
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
				<td width="1%" align="center"><input type="checkbox" id="checkall" /></td>
				<td width="10%" align="left" valign="top">Deal Name</td>
                               
                                <td width="9%" align="left" valign="top">Seller Name</td>
				<td width="6%" align="left" valign="top">Start Date</td>	
				<td width="6%" align="left" valign="top">End Date</td>		
				<!--<td width="8%" align="left" valign="top">Deal Type</td>	-->
				<!--<td width="8%" align="left" valign="top">Deal Type</td>-->	
<!--	    			<td width="20%" align="left" valign="top">Description</td>-->
				<!--<td width="8%" align="left" valign="top">City</td>-->
				<td width="5%" align="left" valign="top">Price</td>
				<td width="8%" align="left" valign="top">Original Price</td>
				<td width="6%" align="left" valign="top">% Saved</td>	
				  <td width="10%" align="left" valign="top">Action</td>
							
					<!--            <td width="8%" align="left">Close Date</td>-->
			    </tr>
			    {section name=i loop=$deal}
			    <tr class="grayback" id="tr_{$gift[i].id}">
				<td align="center"><input type="checkbox" name="deal_id[]" value="{$deal[i].deal_unique_id}" /></td>
				<td align="left" valign="top">{if $deal[i].recommend eq '1'}<font  style="weight:bold;font-size:10px" color="Red"><strong>R -</strong></font>{else}{/if}{if $deal[i].featured eq '1'} <font  style="weight:bold;font-size:10px" color="Red"><strong>F -</strong></font>{/if}  {$deal[i].title|html_entity_decode|ucfirst}</td>
				

				<td align="left" valign="top">{$deal[i].deal_from_seller_name}</td>

				<td align="left" valign="top">{$deal[i].start_date}</td>
				<td align="left" valign="top">{$deal[i].end_date}</td>
			
            			<td align="left" align="left" valign="top">{$deal[i].deal_currency_type}{$deal[i].groupbuy_price}</td>
            			<td align="left" valign="top">{$deal[i].deal_currency_type}{$deal[i].orignal_price}</td>
				<td valign="top">{$deal[i].quantity} %</td>	
	    		         <td align="left" valign="top">
				<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
<strong><a href="{$siteroot}/admin/globalsettings/deal/edit_product.php?back=pend&id={$deal[i].deal_unique_id}">Edit</a> |<strong>
<a href="javascript:void(0);" onclick="javascript:alert('comming soon');">
					<strong>Preview</strong></a>
					{if $deal[i].featured eq '0'}|<a href="{$siteroot}/admin/globalsettings/deal/manage_deal.php?id={$deal[i].deal_unique_id}&featured=set" style="text-decoration:none;">Set Featured</a>
					{else}|<a href="{$siteroot}/admin/globalsettings/deal/manage_deal.php?id={$deal[i].deal_unique_id}&featured=unset" style="text-decoration:none;"> Unset Featured</a>{/if}
					</strong></a>
				</td>
			     </tr>
			    {sectionelse}
			    <tr align="center" class="trbgprj02">
				    <td colspan="12" class="success" align="center"><b>No record found</b></td>
			    </tr>
			    {/section}
                            {if $deal}
			    <tr>
				<td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
				<td align="left" colspan="2">
                                    <select name="action" id="action">
				      <option value="">--Action--</option>
				      <option value="approve">Approve</option>
				      <option value="reject">Reject</option>
				      <option value="delete">Delete</option>
				      <!--<option value="Unrecommended">Unrecommended</option>
				      <option value="recommended">Recommended</option>-->
				    </select>
				    <input type="submit"  value="Go" class="" />&nbsp;
				    <br><span id="acterr" class="error"></span>
				</td> 
				{if $showpgnation eq 'yes' }
				<td colspan="9" align="right">{$pagenation}</td>
				{/if}
			    </tr>
                            {/if}
        		</table>
		        </form>
	             </td>
               </tr>
        </table>
</div>
{include file=$footer}
