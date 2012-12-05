{include file=$header1}
<script type="text/javascript" src="{$sitejs}/ajax.js"></script>
{literal}
	<script language="JavaScript">
		var cnt = {/literal}{$count}{literal};
		var newRowNum = {/literal}{$newRow}{literal};
		var cnt1 = {/literal}{$count1}{literal};
		var newRowNum1 = {/literal}{$newRow1}{literal};
		var cnt2 = {/literal}{$count2}{literal};
		var newRowNum2 = {/literal}{$newRow2}{literal};
	</script>
{/literal}
{strip}
	<script type="text/javascript" src="{$sitejs}/validator.js"></script>
	<script src="{$sitejs}/add_highlights.js" type="text/javascript"></script>
	<script src="{$sitejs}/add_reviews.js" type="text/javascript"></script>
	<script src="{$sitejs}/add_quick_details.js" type="text/javascript"></script>
	<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
	<script language="javascript" type="text/javascript" src="{$siteroot}/js/neel_highlight_validation.js"> </script>
{/strip}

{literal}
<script type="text/javascript">

$(document).ready(function()
{
    $("#frm").validate({
                                        errorElement:'div',
                                                    rules: {
                                                                photo:
                                                                {
                                                                       accept: "jpg|jpeg|png|gif"

                                                                }
             						},
                                                messages:
                                                        {
                                                            photo:
                                                            {
                                                                    accept: "Please upload jpg,jpeg,png,gif image only"
                                                            }
							}
                                });

});

	function textCounter(field,cntfield,maxlimit) 
 {
   if (field.value.length > maxlimit) // if too long...trim it!
   field.value = field.value.substring(0, maxlimit);
   // otherwise, update 'characters left' counter
   else
   cntfield.value = maxlimit - field.value.length;
}


	function validate()
	{	
		var state = document.getElementById('cities').value;
		var product_name = document.getElementById('product_name').value;
// 		var dealtitle = document.getElementById('product_slogan').value;
// 		var product_image = document.getElementById('product_image').value;
		var product_act_price = document.getElementById('product_act_price').value;
		var product_disc_price = document.getElementById('product_disc_price').value;
		var min_quantity = document.getElementById('min_quantity').value;
		var hid = document.getElementById('hid').value;
		var product_disc_price_percent= document.getElementById('product_disc_price_percent').value;
		var product_sell_price= document.getElementById('product_sell_price').value;
		var product_sell_price_percent= document.getElementById('product_sell_price_percent').value;	
                var deal_card_details= document.getElementById('deal_card_details').value;
                var buy_now_price= document.getElementById('buy_now_price').value;
                var deal_description_title= document.getElementById('deal_description_title').value;

               //////// validate fck editor --->>> nilesh pangul //////////////////////
	       var fckBody= FCKeditorAPI.GetInstance("product_description");
	       var proddesc = fckBody.GetXHTML(true);

	
		if(state =='')
		{
			alert("Please select city");	
			document.getElementById('cities').focus();
			return false;
		}
		var merchanideas = document.getElementById('merchant_id');
		if(!merchanideas)
		{
			alert("Please select city which have Business Name");
			document.getElementById('cities').focus();
			return false;
		}

		if(!(validator.isEmptyValue(product_name)))
		{
			alert("Please enter deal name");
			document.getElementById('product_name').focus();
			return false;
		}

		if(!(validator.isEmptyValue(deal_description_title)))
		{
			alert("Please enter description title");
			document.getElementById('deal_description_title').focus();
			return false;
		}

                if(!(validator.isEmptyValue(deal_card_details)))
		{
			alert("Please enter deal card details");
			document.getElementById('deal_card_details').focus();
			return false;
		}

	/////// validate the dynamically generated highlights ////// created by nilesh pangul 11/10/2010////////
		var chkhighlight=chkHighlights("heighlight[]","heighlight_");
		if(chkhighlight!="alldatafill")
		{
			var highid=chkhighlight;
			document.getElementById(highid).focus();
			alert("Please make sure all Highlights are entered!");
			return false;
		}


		if(!(validator.isEmptyValue(proddesc)))
		{
			alert("Please enter description");
			document.getElementById('product_description').focus();
			return false;
		}

		if(!(validator.isEmptyValue(product_act_price)))
		{
			alert("Please enter Original Value");
			document.getElementById('product_act_price').focus();
			return false;
		}
		if(!(validator.isEmptyValue(product_disc_price)))
		{
			alert("Please enter Discount Value");
			document.getElementById('product_disc_price').focus();
			return false;
		}
		if(parseInt(product_disc_price) > parseInt(product_act_price))
		{
			alert("Discount Value should be less than Original Value");
			document.getElementById('product_disc_price').focus();
			return false;
		}

              if(!(validator.isEmptyValue(product_disc_price_percent)))
		{
			alert("Please enter Discount Value % Discount");
			document.getElementById('product_disc_price_percent').focus();
			return false;
		}

                if(!(validator.isEmptyValue(product_sell_price)))
		{
			alert("Please enter Sell Out Value");
			document.getElementById('product_sell_price').focus();
			return false;
		}

		if( !(validator.isEmptyValue(product_sell_price_percent)))
		{
			alert("Please enter Sell Out Value % Discount");
			document.getElementById('product_sell_price_percent').focus();
			return false;
		}

              if( !(validator.isEmptyValue(buy_now_price)))
		{
			alert("Please enter buy now price");
			document.getElementById('buy_now_price').focus();
			return false;
		}

		if(!(validator.isEmptyValue(min_quantity)))
		{
			alert("Please enter Quantity");
			document.getElementById('min_quantity').focus();
			return false;
		}

			
	}

</script>
<script language="JavaScript">
	function getmerchant(val)
	{
		ajax.sendrequest("GET", SITEROOT+"/admin/globalsettings/deal/get_merchant.php", {val:val}, '', 'replaceDiv');
	}
</script>
{/literal}
{include file=$header2}
<!--<div class="holdthisTop">
	<h3 class="fl width20">&nbsp;&nbsp; {if $smarty.get.id}Edit{else}Add{/if} Deal</h3>-->
<div class="breadcrumb">
	<h3 class="fl width20" style="color:black;">&nbsp;&nbsp; {if $smarty.get.id}Edit{else}Add{/if} Deal</h3>
<table width="100%">
<tr><TD></TD>
<td width="5%">
<a href="manage_deal.php">Back</a></td>
</tr>
</table></div>
{if $msg}<div align="center">{$msg}</div>{/if}
<form action="" method="post" name='frm' id="frm" enctype="multipart/form-data" onsubmit="return validate();">
<input type="hidden" name="hid" id="hid" value="{$hid}" />
<table width="100%" cellspacing="5" cellpadding="5">
		{if $errormsg}<tr><td colspan="2" align="center">{$errormsg}</td></tr>{/if}
    <tr>
      <td colspan="2"><div id="show2" style="display:block">
          <table width="100%" cellspacing="5" cellpadding="2">
        <tr height="25">
                        <td valign="top" align="right">Is main Deal</td>
                        <td align="left" valign="top"> <input type="checkbox" name="featured_deal" id="featured_deal" value="featured" {if $product.featured_deal eq 'yes'} checked="true" {/if}> </td>
        </tr>
	 <tr height="25">
			
			<td valign="top" align="right">Start date <span class="red">*</span> : </td>
			<td align="left" valign="top">
				{if $start_date}
				<script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD','{$start_date}');</script>
				{else}
				<script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD');</script>
				{/if}
			</td>
	 </tr>
	<tr height="25">
			
			<td valign="top" align="right">Start time <span class="red">*</span> : </td>
			<td align="left" valign="top">
				<select name="start_hour">
				{section name=i loop=$hr}
				<option value="{$hr[i]}" {if $s_hr eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
				{/section}
				</select>&nbsp;&nbsp;&nbsp;
				<select name="start_min">
				{section name=i loop=$min}
				<option value="{$min[i]}" {if $s_min eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
				{/section}
				</select>
			</td>
	 </tr>
	 <tr height="25">
			<td valign="top" align="right">End date <span class="red">*</span> : </td>
			<td colspan="2" align="left" valign="top">
				{if $end_date}
				<script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD','{$end_date}');</script>
				{else}
				<script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD');</script>
				{/if}
			</td>
	 </tr>
	 <tr height="25">
			
			<td valign="top" align="right">End time <span class="red">*</span> : </td>
			<td align="left" valign="top">
				<select name="end_hour">
				{section name=i loop=$rev_hr}
				<option value="{$rev_hr[i]}" {if $e_hr eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
				{/section}
				</select>&nbsp;&nbsp;&nbsp;
				<select name="end_min">
				{section name=i loop=$rev_min}
				<option value="{$rev_min[i]}" {if $e_min eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
				{/section}
				</select>

			</td>
	 </tr>
	    <tr>
		<td width="30%" valign="top" align="right">City <span class="red">*</span> : </td>
		<td align="left" width="70%">
			<!--<select name="cities" id="cities" onchange="javascript: getmerchant(this.value);" >-->
			<select name="cities" id="cities" >
				<option value="">Select City</option>
			    {section name=i loop=$city}
				<option value="{$city[i].city_name}" {if $city[i].city_name eq $product.product_city} selected="selected" {/if}>{$city[i].city_name}</option>
			    {/section}
			</select>
		</td>
		<td>&nbsp;</td>
	    </tr>

	   <tr>
         <td align="right" valign="top">Deal category <span class="red">*</span> : </td>
              <td colspan="2" align="left">
			<div id="replaceDiv">
			<select name="merchant_id" id="merchant_id">
			<option value="">Select Category</option>
			{section name=i loop=$merchantsarr}
			<option value="{$merchantsarr[i].id}" {if $product.deal_category eq $merchantsarr[i].id} selected="selected" {/if}>{$merchantsarr[i].category|ucfirst} </option>
									
			{/section}
			</select>
			</div>
          </td>
      </tr>


	    <tr>
              <td align="right" valign="top">Deal Name <span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="text" name="product_name" class="textbox" id="product_name" value="{$product.product_name}">
              </td>
            </tr>

	    <tr>
              <td align="right" valign="top">Description Title<span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="text" name="deal_description_title" class="textbox" id="deal_description_title" value="{$product.deal_description_title}">
              </td>
            </tr>


	    <tr>
              <td align="right" valign="top">Deal Card Details <span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="text" name="deal_card_details" class="textbox" id="deal_card_details" value="{$product.deal_card_details}">
              </td>
            </tr>


	{if $hight}	
	    <tr>
              <td align="right" valign="top"  style="padding-top:10px">Highlights<span class="red">*</span> :&nbsp;&nbsp;</td>
              <td colspan="2" align="left">
		<table>
			{section name=i loop=$hight}
			<tr id="myrows_{$smarty.section.i.index}">
			<td width="80%">
<input type="text" name="heighlight[]" id="heighlight_{$smarty.section.i.index}" value="{$hight[i].highlights}" class="textbox input_c">
			</td>
			<td width="20%">
				{if $smarty.section.i.index eq 0}<a  href="javascript: void(0);" id="addnew"><strong>Add</strong></a>{else}<a href="" class="remove"  id="frmAction" ><strong>Delete</strong></a>{/if}
			</td>
			</tr>
			{/section}
		</table>
              </td>
            </tr>
	{else}	
	    <tr>
              <td align="right" valign="top"  style="padding-top:10px">Highlights<span class="red">*</span> :&nbsp;&nbsp;</td>
              <td colspan="2" align="left">
		<table>
			<tr id="myrows_0">
			<td width="80%">
	<input type="text" name="heighlight[]" id="heighlight_0" value="" class="textbox input_c">
			</td>
			<td width="20%">
				<a  href="javascript: void(0);" id="addnew"><strong>Add</strong></a>
			</td>
			</tr>
		</table>
              </td>
            </tr>
	{/if}
	
	    <tr>
              <td align="right" valign="top">Description <span class="red">*</span> : </td>
              <td colspan="2" align="left">
				{oFCKeditor->Create}
	      </td>
            </tr>

	    <tr>
              <td align="right" valign="top">Original Value &nbsp;&nbsp;(in $) <span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="text" name="product_act_price" id="product_act_price" value="{$product.product_act_price}" class="textbox">
              </td>
            </tr>
	    <tr>
              <td align="right" valign="top">Discount Value (in $) <span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="text" name="product_disc_price" id="product_disc_price" value="{$product.product_disc_price}" class="textbox">
              </td>
            </tr>
	    <tr>
              <td align="right" valign="top">Discount Value % Discount <span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="text" name="product_disc_price_percent" id="product_disc_price_percent" value="{$product.product_disc_price_percent}" class="textbox">
              </td>
            </tr>
             <tr>
              <td align="right" valign="top">Sell Out Value (in $) <span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="text" name="product_sell_price" id="product_sell_price" value="{$product.product_sell_price}" class="textbox">
              </td>
            </tr>
	    <tr>
              <td align="right" valign="top">Sell Out Value % Discount <span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="text" name="product_sell_price_percent" id="product_sell_price_percent" value="{$product.product_sell_price_percent}" class="textbox">
              </td>
            </tr>

	    <tr>
              <td align="right" valign="top">Buy Now (in $)  <span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="text" name="buy_now_price" id="buy_now_price" value="{$product.buy_now_price}" class="textbox">
              </td>
            </tr>


	    <tr>
              <td align="right" valign="top">Quantity <span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="text" name="min_quantity" id="min_quantity" value="{$product.min_quantity}" class="textbox">
              </td>
            </tr>

	    <tr>
              <td align="right" valign="top">Photo <span class="red">*</span> : </td>
              <td colspan="2" align="left"><input type="file" name="photo" id="photo" class="textbox">
              </td>
            </tr>
 	<tr>
              <td align="right" valign="top">&nbsp;</td>
              <td colspan="2" align="left"><IMG src="{$siteroot}/uploads/bussiness_photo/thumbnail/{$product.product_thumbnail}" /></td>
            </tr>


	    <tr>
		<td>&nbsp;</td>
		<td colspan="2"><input type="submit" onclick="" value="Save" name="submit"/>
			<input type="button" value="Cancel" onclick="javascript: location='manage_deal.php';"/>
		</td>
	    </tr>	
           </table>
        </div></td>
    </tr>
</table>
</form>
</div>
</div>
{include file=$footer}
