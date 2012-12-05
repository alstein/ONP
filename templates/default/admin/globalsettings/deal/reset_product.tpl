{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/add_deal.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script type="text/javascript" src="{$siteroot}/js/jquery.jSuggest.1.0.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/ajaxget_category.js"></script>
{/strip}

{literal}
<script language="JavaScript">
var dealtypeonload = '{/literal}{$deal_info.deal_type}{literal}';

$(document).ready(function(){
    if(dealtypeonload == "service")
    {
        $('#list_service').show();
        $('#list_product').hide();
    }
    else
    {
        $('#list_service').hide();
        $('#list_product').show();
    }

});

function addit(optionid, pr){
    if((optionid == 1)|| (optionid == 2))
    {
        document.getElementById(optionid).checked=true;
    }
    else
    {
        var chk=document.getElementById(optionid).checked;
        if(chk == true){
        var final_value;
        var listing;
        
            document.getElementById("listing").value = parseInt(document.getElementById("listing").value) + parseInt(pr);
            $('#span1').html(document.getElementById("listing").value);
            //document.getElementById('span4').innerHTML =  parseInt(document.getElementById("listing").value)  + parseInt(document.getElementById("listing_t").value);
            if(document.getElementById("option_selected").value)
                document.getElementById("option_selected").value=document.getElementById("option_selected").value + "," + optionid;
            else
                document.getElementById("option_selected").value= optionid;
                        
            if(optionid == 6){ 
            document.getElementById("web").style.display=""; }
            if(optionid == 7)	{	 	
            document.getElementById("addr").style.display=""; }
        }
        else
        {
            document.getElementById("listing").value=parseInt(document.getElementById("listing").value) - parseInt(pr);
            $('#span1').html(document.getElementById("listing").value);
            //document.getElementById('span4').innerHTML = parseInt(document.getElementById("listing").value)  +parseInt(document.getElementById("listing_t").value) ;

            var str = document.getElementById("option_selected").value;
            var mytool_array=str.split(",");
            var newstr='';
            for(i=0;i<mytool_array.length;i++)
            {
                if(optionid!=mytool_array[i])
                {
                    if(newstr)
                    newstr=newstr + "," + mytool_array[i];
                    else
                    newstr= mytool_array[i];
                }
            }
            document.getElementById("option_selected").value= newstr;

            if(optionid == 6)
            document.getElementById("web").style.display="none";
            if(optionid == 7)			
            document.getElementById("addr").style.display="none";
        }
    }
}


function getSelleroptions(sId)
{
    var page = SITEROOT+"/admin/globalsettings/deal/get-seller-option.php";
    $.get(page,{sid:sId},function(data){$('#rep_s').html(data)});
}
var count={/literal}{$deal_img_cnt}{literal};
function addmore()
{
    if(count < 8)
    {
        var str = $('#morefile').html();

        str = str + "<tr><td colspan='2' align='left'><input type='file' name='dealimage[]' id='dealimage'></td>   </tr>";
        $('#morefile').html(str);
    }
    else
    {
        alert("You can not upload more that 8 files.");
    }
    count++;
}

function setCat(cat)
{
    var page = SITEROOT+"/my-account/ajaxset_main_cat/";
    $.get(page,{cat:cat},function(data){ });
}

function addPaymentType(newstr)
{

    var chk=newstr.checked;
    if(chk == true){
    
        if(document.getElementById("payment_type").value)
            document.getElementById("payment_type").value=document.getElementById("payment_type").value + "," + newstr.value;
        else
            document.getElementById("payment_type").value= newstr.value;
    }
    else
    {
        var str = document.getElementById("payment_type").value;
        
        var mytool_array=str.split(",");
        var newstr1='';
        for(i=0;i<mytool_array.length;i++)
        {
            if(newstr.value!=mytool_array[i])
            {
                if(newstr1)
                newstr1=newstr1 + "," + mytool_array[i];
                else
                newstr1= mytool_array[i];
            }
        }
        document.getElementById("payment_type").value= newstr1;
    }
}

function changePayment(deal_type)
{
    //var lis  ={/literal}{$list_service}{literal};
    //var pro  ={/literal}{$list_pro}{literal};
    var page = SITEROOT+"/my-account/ajaxset_deal_type/";
    if(deal_type == "product")
    {
        //dtype = "product";
        document.getElementById('div_payment').style.display = "";
        document.getElementById('del_cost').style.display = "";
        $("#list_product").show();
        $("#list_voucher").hide();
      //  $("#listing_t").val(pro);
	//$("#del_cost").show();
        //document.getElementById('span4').innerHTML =  parseInt(document.getElementById("listing").value)  +parseInt(document.getElementById("listing_t").value);
        
        $.get(page,{dtype:deal_type},function(data){ });
    }
    else
    {
        //dtype = "service";
        document.getElementById('div_payment').style.display = "none";
        document.getElementById('del_cost').style.display = "none";
        $("#list_product").hide();
        $("#list_voucher").show();
//         $("#listing_t").val(lis);
// 	$("#del_cost").hide();
        //document.getElementById('span4').innerHTML =  parseInt(document.getElementById("listing").value)  +parseInt(document.getElementById("listing_t").value);

        $.get(page,{dtype:deal_type},function(data){ });
    }
}

function getEstiValue()
{
    var gbPrice = document.getElementById('price').value;
    var minBuy = document.getElementById('min_buyer').value;
    if(((minBuy != "") && !isNaN(minBuy)) && (gbPrice != "") && !isNaN(gbPrice))
    {
        var finalFee = parseFloat(minBuy) * parseFloat(gbPrice);
        var page = SITEROOT+"/my-account/getfinalvalue/";
        $.get(page,{finalfee:finalFee},function(data){ $('#final_value').val(data); $('#span3').html(data);});
    }
}
</script>
{/literal}

{include file=$header2}

<div class="breadcrumb">
	<h3 class="fl width20" style="color:black;">&nbsp;&nbsp; Reset Deal</h3><br/>
	<span class="fr width10"><a href="javascript:void(0);" onclick="history.go)-1);">Back</a></span>
</div>
<div class="holdthisTop">
{if $msg}<div align="center">{$msg}</div>{/if}

    <form action="" method="post" name='frm' id="frm" enctype="multipart/form-data">
      <input type="hidden" id="dealId" name="dealId" value="{$smarty.get.id}"/>
      <input type="hidden" id="final_value" name="final_value" value="{if $deal_info.final_value}{$deal_info.final_value}{else}0{/if}" />
      <input type="hidden" id="listing" name="listing" value="{if $deal_info.listing_value}{$deal_info.listing_value}{else}0{/if}" />
      <input type="hidden" id="option_selected" value="{$deal_info.option_selected}" name="option_selected">
      <input type="hidden" name="payment_type" id="payment_type" value="{$deal_info.payment_method}">
      <input type="hidden" name="seller_id" id="seller_id" value="{$deal_info.seller_id}" />
      <input type="hidden" name="small_img" id="small_img" value="{$deal_info.small_image}" />
      <input type="hidden" name="medium_img" id="medium_img" value="{$deal_info.medium_image}" />
      <input type="hidden" name="big_img" id="big_img" value="{$deal_info.big_image}" />
	<input type="hidden" name="admin_userid" id="admin_userid" value="{$deal_info.admin_userid}" />

      {if $errormsg}<div align="center">{$errormsg}</div>{/if}

      <table width="70%" cellspacing="5" cellpadding="5">
	    <tr>
		<td align="right" valign="top">Select Deal Type: </td>
		<td colspan="2" align="left" valign="top">
		    <input type="radio" name="deal_type" id="deal_type1" value="service" {if $deal_info.deal_type eq 'service'} checked="true" {/if} onchange="changePayment(this.value);"> Voucher&nbsp;&nbsp;&nbsp; <input type="radio" name="deal_type" id="deal_type2" value="product" {if $deal_info.deal_type eq 'product'} checked="true" {/if} onchange="changePayment(this.value);"> Product
		</td>
	    </tr> 
	    <tr>
		<td align="right" valign="top"><span class="red">*</span> Deal Category: </td>
		<td colspan="2" align="left">
		    <input type="text" name="category" id="category" class="textbox" value="{$deal_info.category}" autocomplete="off" onblur="setCat(this.value)"/>
		</td>
	    </tr>
	    <tr>
		<td align="right" valign="top"><span class="red">*</span> Deal Sub Category: </td>
		<td colspan="2" align="left">
		    <div id="replace">
			<input type="text" name="subcategory" id="subcategory" class="textbox" value="{$deal_info.sub_category}" autocomplete="off" />
		    </div>
		</td>
	    </tr>
	    <tr>
		<td align="right" valign="top"><span class="red">*</span> Title: </td>
		<td colspan="2" align="left"><input type="text" name="title1" class="textbox" id="title1" value="{$deal_info.title}">
		</td>
	    </tr>
	    <tr>
		<td align="right" valign="top"><span class="red">*</span> Show Deal Tag: </td>
		<td colspan="2" align="left">
		    <select name="show_deal_tag" id="show_deal_tag" style="width:150px">
			<option value="yes" {if $deal_info.show_deal_tag eq 'yes'} selected="selected" {/if}>Yes</option>
			<option value="no" {if $deal_info.show_deal_tag eq 'no'} selected="selected" {/if}>No</option>
		    </select>
		</td>
	    </tr>	
	    <tr>
		<td align="right" valign="top"><span class="red">*</span> Deal Tag: </td>
		<td colspan="2" align="left"><input type="text" name="deal_tag" class="textbox" id="deal_tag" value="{$deal_info.deal_tag}">
		</td>
	    </tr>
	    <tr>
		<td align="right" valign="top"><span class="red">*</span> Description: </td>
		<td colspan="2" align="left">{$oFCKeditor}<!-- <textarea cols="60" rows="8" name="description" id="description">{$deal_info.description}</textarea>--></td>
	    </tr>
  
	    <tr>
		<td align="right" valign="top"><span class="red">*</span> Highlight: </td>
		<td colspan="2" align="left">{$oFCKeditor1}<!--<textarea cols="60" rows="8" name="highlight" id="highlight">{$deal_info.highlight}</textarea>--></td>
	    </tr>
  
	    <tr>
		<td align="right" valign="top"><span class="red">*</span> Terms Fine Print: </td>
		<td colspan="2" align="left">{$oFCKeditor2}<!--<textarea cols="60" rows="8" name="fineprint" id="fineprint">{$deal_info.fineprint}</textarea> --></td>
	    </tr>
	    <tr>
		<td align="right" valign="top"> Comment: </td>
		<td colspan="2" align="left"><textarea cols="60" rows="8" name="comments" id="comments">{$deal_info.comments}</textarea> </td>
	    </tr>
	    
	    <tr id="del_cost" {if $deal_info.deal_type eq 'service'} style="display:none" {/if} >
		<td align="right" valign="top"><span class="red">*</span> Delivery Cost: </td>
		<td colspan="2" align="left">
		    <input type="text" class="textbox" name="delivery_cost" id="delivery_cost" value="{$deal_info.sub_delivery_cost}"/>
		</td>
	    </tr>	
	    <tr id="div_payment" {if $deal_info.deal_type eq 'service'} style="display:none" {/if} >
		<td align="right" valign="top"><span class="red">*</span> Payment Method Accepted: </td>
		<td colspan="2" align="left">
		    <table align="left" width="30%">
		    {section name=i loop=$payment}
		    <tr>
			<td> <input type="checkbox" name="{$payment[i].payment_method}" id="{$payment[i].payment_method}" value="{$payment[i].payment_method}" {if $payment[i].payment_method|in_array:$pay} checked="true" {/if}  onclick="addPaymentType(this);"/> </td>
			<td>{$payment[i].payment_method} </td>
		    </tr>
		    {/section}
		    </table>
		</td>
	    </tr>
	    </div>	
	    
	    
	    <tr>
		<td align="right" valign="top"><span class="red">*</span> Upload Image: </td>
		<td colspan="2" align="left" valign="top">
		<input type="button" name="add" id="add" value="Upload Image(s)" onclick="javascript:tb_show('Upload Image(s)', '{$siteroot}/modules/my-account/uploadmain.php?&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=720&modal=false', tb_pathToImage);">
		{section name=j loop=$deal_img}
		    <br/><img src="{$siteroot}/uploads/product/thumb32X32/{$deal_img[j]}" /><br/>
		{/section}
		</td>
	    </tr>
	    <tr><td></td><td colspan="2"><div id="morefile"></div></td></tr>
	    <tr>
	      <td align="right" valign="top"><span class="red">*</span> Video Link: </td>
	      <td colspan="2" align="left"><input type="text" name="videolink" id="videolink" value="{$deal_info.vedio_link}" class="textbox">
	      </td>
	    </tr>
  
	    <tr>
	      <td align="right" valign="top"><span class="red">*</span> Group Buy Price: </td>
	      <td colspan="2" align="left"><input type="text" name="price" id="price" value="{$deal_info.groupbuy_price}" onchange="getEstiValue()" class="textbox">
	      </td>
	    </tr>
  
	    <tr>
	      <td align="right" valign="top"><span class="red">*</span> Original Price: </td>
	      <td colspan="2" align="left"><input type="text" name="originalprice" id="originalprice" value="{$deal_info.orignal_price}" class="textbox">
	      </td>
	    </tr>
  
	    <tr>
	      <td align="right" valign="top"><span class="red">*</span> Customer Savings: </td>
	      <td colspan="2" align="left"><input type="text" name="quantity" id="quantity" value="{$deal_info.quantity}" class="textbox">
	      </td>
	    </tr>
  
	    <tr>
	      <td align="right" valign="top"><span class="red">*</span> Minimum Buyers Required: </td>
	      <td colspan="2" align="left"><input type="text" name="min_buyer" id="min_buyer" value="{$deal_info.min_buyer}" onchange="getEstiValue()" class="textbox">
	      </td>
	    </tr>
  
	    <tr>
	      <td align="right" valign="top"><span class="red">*</span> Maximum Number Of Buyers: </td>
	      <td colspan="2" align="left"><input type="text" name="max_buyer" id="max_buyer" value="{$deal_info.max_buyer}" class="textbox">
	      </td>
	    </tr>
  
	    <tr height="25">	
	      <td valign="top" align="right"><span class="red">*</span> Start Date: </td>
	      <td align="left" valign="top">
		{if $start_date}
		<script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD','{$start_date}');</script>
		{else}
		<script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD');</script>
		{/if}
	      </td>
	    </tr>
	    <tr height="25">
		<td valign="top" align="right"><span class="red">*</span> Start Time: </td>
		<td align="left" valign="top">
		  <select name="start_hour" id="start_hour">
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
		<td valign="top" align="right"><span class="red">*</span> End Date: </td>
		<td colspan="2" align="left" valign="top">
		  {if $end_date}
		  <script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD','{$end_date}');</script>
		  {else}
		  <script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD');</script>
		  {/if}
		</td>
	    </tr>
	    <tr height="25">
	      <td valign="top" align="right"><span class="red">*</span> End Time: </td>
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
		<div id="err_date" style="display:none"></div>
	      </td>
	  </tr>
	  <tr height="25">
	      <td valign="top" align="right"><span class="red">*</span> Shipping Assistance: </td>
	      <td align="left" valign="top">
		  <select name="shipping" id="shipping">
		    <option value=""> Select </option>
		    <option value="yes" {if $deal_info.shipping_assitance eq 'yes'} selected="selected"{/if}>Yes</option>
		    <option value="no" {if $deal_info.shipping_assitance eq 'no'} selected="selected"{/if}>No</option>
		  </select>
	      </td>
	  </tr>
	  <tr height="25">
	      <td valign="top" align="right"><span class="red">*</span> Seller Type: </td>
	      <td align="left" valign="top">
		  <select name="sellertype" id="sellertype" style="width:160px;" onchange="javascript: getSelleroptions(this.value);">
		    <option value=""> Select Seller Type </option>
		    {section name=i loop=$seller1}
		    <option value="{$seller1[i].seller_type_id}" {if $seller_type eq $seller1[i].seller_type_id} selected="selected"{/if}>{$seller1[i].seller_type_name}</option>
		    {/section}
		  </select>
	      </td>
	  </tr>
  
	  <tr>
	      <td align="right" valign="top"> </td>
	      <td colspan="2" align="left">
		    <table>
			<tr id="list_product" style=""><td align="right" >
			{if $seller_type eq 1}
			{if $selleroption[0].seller1 neq "NA"}
			<input type="checkbox" name="{$selleroption[0].sell_id}" id="{$selleroption[0].sell_id}" value="{if $selleroption[0].seller1 eq 'Free'}0 {else} {$selleroption[0].seller1} {/if}" onclick="javascript: addit('{$selleroption[0].sell_id}',{if $selleroption[0].seller1 eq 'Free'}0 {else} {$selleroption[0].seller1} {/if});"/>
			</td><td>
			{$selleroption[0].sell_type_name} - &pound;{$selleroption[0].seller1} 
			
			{/if}
			{elseif $seller_type eq 2}
			{if $selleroption[0].seller2 neq "NA"}
			<input type="checkbox" name="{$selleroption[0].sell_id}" id="{$selleroption[0].sell_id}" value="{if $selleroption[0].seller2 eq 'Free'}0 {else} {$selleroption[0].seller2} {/if}" onclick="javascript: addit('{$selleroption[0].sell_id}',{if $selleroption[0].seller2 eq 'Free'}0 {else} {$selleroption[0].seller2} {/if});"/>
			</td><td>
			{$selleroption[0].sell_type_name} - &pound;{$selleroption[0].seller2} 
			
			{/if}
			{elseif $seller_type eq 3}
			{if $selleroption[0].seller3 neq "NA"}
			<input type="checkbox" name="{$selleroption[0].sell_id}" id="{$selleroption[0].sell_id}" value="{if $selleroption[0].seller3 eq 'Free'}0 {else} {$selleroption[0].seller3} {/if}" onclick="javascript: addit('{$selleroption[0].sell_id}',{if $selleroption[0].seller3 eq 'Free'}0 {else} {$selleroption[0].seller3} {/if}); " checked="true"/>
			</td><td>
			{$selleroption[0].sell_type_name} - &pound;{$selleroption[0].seller3} 
			
			{/if}
			{elseif $seller_type eq 4}
			{if $selleroption[0].seller4 neq "NA"}
			<input type="checkbox" name="{$selleroption[0].sell_id}" id="{$selleroption[0].sell_id}" value="{if $selleroption[0].seller4 eq 'Free'}0 {else} {$selleroption[0].seller4} {/if}" onclick="javascript: addit('{$selleroption[0].sell_id}',{if $selleroption[0].seller4 eq 'Free'}0 {else} {$selleroption[0].seller4} {/if});"/>
			</td><td>
			{$selleroption[0].sell_type_name} - &pound;{$selleroption[0].seller4} 
			
			{/if}
			{elseif $seller_type eq 5}
			{if $selleroption[0].seller5 neq "NA"}
			<input type="checkbox" name="{$selleroption[0].sell_id}" id="{$selleroption[0].sell_id}" value="{if $selleroption[0].seller5 eq 'Free'}0 {else} {$selleroption[0].seller5} {/if}" onclick="javascript: addit('{$selleroption[0].sell_id}',{if $selleroption[0].seller5 eq 'Free'}0 {else} {$selleroption[0].seller5} {/if});"/>
			</td><td>
			{$selleroption[0].sell_type_name} - &pound;{$selleroption[0].seller5} 
			
			{/if}
			{/if}
			</td></tr>    
	
			<tr id="list_voucher" style=""><td align="right" >
			{if $seller_type eq 1}
			{if $selleroption[1].seller1 neq "NA"}
			<input type="checkbox" name="{$selleroption[1].sell_id}" id="{$selleroption[1].sell_id}" value="{if $selleroption[1].seller1 eq 'Free'}0 {else} {$selleroption[1].seller1} {/if}" onclick="javascript: addit('{$selleroption[1].sell_id}',{if $selleroption[1].seller1 eq 'Free'}0 {else} {$selleroption[1].seller1} {/if});"/>
			</td><td>
			{$selleroption[1].sell_type_name} - &pound;{$selleroption[1].seller1} 
			{assign var='listing_val' value=$selleroption[1].seller1}
			
			{/if}
			{elseif $seller_type eq 2}
			{if $selleroption[1].seller2 neq "NA"}
			<input type="checkbox" name="{$selleroption[1].sell_id}" id="{$selleroption[1].sell_id}" value="{if $selleroption[1].seller2 eq 'Free'}0 {else} {$selleroption[1].seller2} {/if}" onclick="javascript: addit('{$selleroption[1].sell_id}',{if $selleroption[1].seller2 eq 'Free'}0 {else} {$selleroption[1].seller2} {/if});"/>
			</td><td>
			{$selleroption[1].sell_type_name} - &pound;{$selleroption[1].seller2} 
			{assign var='listing_val' value=$selleroption[1].seller2}
			
			{/if}
			{elseif $seller_type eq 3}
			{if $selleroption[1].seller3 neq "NA"}
			<input type="checkbox" name="{$selleroption[1].sell_id}" id="{$selleroption[1].sell_id}" value="{if $selleroption[1].seller3 eq 'Free'}0 {else} {$selleroption[1].seller3} {/if}" onclick="javascript: addit('{$selleroption[1].sell_id}',{if $selleroption[1].seller3 eq 'Free'}0 {else} {$selleroption[1].seller3} {/if});" checked="true"/>
			</td><td>
			{$selleroption[1].sell_type_name} - &pound;{$selleroption[1].seller3} 
			{assign var='listing_val' value=$selleroption[1].seller3}
			
			{/if}
			{elseif $seller_type eq 4}
			{if $selleroption[1].seller4 neq "NA"}
			<input type="checkbox" name="{$selleroption[1].sell_id}" id="{$selleroption[1].sell_id}" value="{if $selleroption[1].seller4 eq 'Free'}0 {else} {$selleroption[1].seller4} {/if}" onclick="javascript: addit('{$selleroption[1].sell_id}',{if $selleroption[1].seller4 eq 'Free'}0 {else} {$selleroption[1].seller4} {/if});"/>
			</td><td>
			{$selleroption[1].sell_type_name} - &pound;{$selleroption[1].seller4} 
			{assign var='listing_val' value=$selleroption[1].seller4}
			
			{/if}
			{elseif $seller_type eq 5}
			{if $selleroption[1].seller5 neq "NA"}
			<input type="checkbox" name="{$selleroption[1].sell_id}" id="{$selleroption[1].sell_id}" value="{if $selleroption[1].seller5 eq 'Free'}0 {else} {$selleroption[1].seller5} {/if}" onclick="javascript: addit('{$selleroption[1].sell_id}',{if $selleroption[1].seller5 eq 'Free'}0 {else} {$selleroption[1].seller5} {/if});"/>
			</td><td>
			{$selleroption[1].sell_type_name} - &pound;{$selleroption[1].seller5} 
			{assign var='listing_val' value=$selleroption[1].seller5}
			
			{/if}
			{/if}
			</td></tr>
		    </table>
		  <div id="rep_s"> 
		    <table>
			{section name=i loop=$selleroption start=2}
			{if $seller_type eq 1}
			{if $selleroption[i].seller1 neq "NA"}
			<tr><td align="right">
			<input type="checkbox" name="{$selleroption[i].sell_id}" id="{$selleroption[i].sell_id}" {if $selleroption[i].sell_id|in_array:$opt} checked="true" {/if} onclick="javascript: addit('{$selleroption[i].sell_id}',{if $selleroption[i].seller1 eq 'Free'}0 {else} {$selleroption[i].seller1} {/if});"/>
			</td><td>
			{$selleroption[i].sell_type_name} - &pound;{$selleroption[i].seller1} 
			</td></tr>
			{/if}
			{/if}
		
			{if $seller_type eq 2}
			{if $selleroption[i].seller2 neq "NA"}
			<tr><td align="right">
			<input type="checkbox" name="{$selleroption[i].sell_id}" id="{$selleroption[i].sell_id}" {if $selleroption[i].sell_id|in_array:$opt} checked="true" {/if} onclick="javascript: addit('{$selleroption[i].sell_id}',{if $selleroption[i].seller2 eq 'Free'}0 {else} {$selleroption[i].seller2} {/if});"/>
			</td><td>
			{$selleroption[i].sell_type_name} - &pound;{$selleroption[i].seller2} 
			</td></tr>
			{/if}
			{/if}
		
			{if $seller_type eq 3}
			{if $selleroption[i].seller3 neq "NA"}
			<tr><td align="right">
			<input type="checkbox" name="{$selleroption[i].sell_id}" id="{$selleroption[i].sell_id}" {if $selleroption[i].sell_id|in_array:$opt} checked="true" {/if} onclick="javascript: addit('{$selleroption[i].sell_id}',{if $selleroption[i].seller3 eq 'Free'}0 {else} {$selleroption[i].seller3} {/if});"/>
			</td><td>
			{$selleroption[i].sell_type_name} - &pound;{$selleroption[i].seller3} 
			</td></tr>
			{/if}
			{/if}
		
			{if $seller_type eq 4}
			{if $selleroption[i].seller4 neq "NA"}
			<tr><td align="right">
			<input type="checkbox" name="{$selleroption[i].sell_id}" id="{$selleroption[i].sell_id}" {if $selleroption[i].sell_id|in_array:$opt} checked="true" {/if} onclick="javascript: addit('{$selleroption[i].sell_id}',{if $selleroption[i].seller4 eq 'Free'}0 {else} {$selleroption[i].seller4} {/if});"/>
			</td><td>
			{$selleroption[i].sell_type_name} - &pound;{$selleroption[i].seller4} 
			</td></tr>
			{/if}
			{/if}
		
			{if $seller_type eq 5}
			{if $selleroption[i].seller5 neq "NA"}
			<tr><td align="right">
			<input type="checkbox" name="{$selleroption[i].sell_id}" id="{$selleroption[i].sell_id}" {if $selleroption[i].sell_id|in_array:$opt} checked="true" {/if} onclick="javascript: addit('{$selleroption[i].sell_id}',{if $selleroption[i].seller5 eq 'Free'}0 {else} {$selleroption[i].seller5} {/if});"/>
			</td><td>
			{$selleroption[i].sell_type_name} - &pound;{$selleroption[i].seller5} 
			</td></tr>
			{/if}
			{/if}
			{/section}
		    </table>
		  </div>
	      </td>
	  </tr>
	    <tr {if $deal_info.option_website eq ""} style="display:none" {/if} id="web">
		<td align="right">Website:</td>
		<td>
		    <input type="text" name="website" value="{$deal_info.option_website}" id="website" class="textbox"/>
		</td>
	    </tr>
	    <tr {if $deal_info.shop_location eq ""} style="display:none" {/if} id="addr">
		<td align="right">High St/ Shop Location: </td>
		<td >
		    <input type="text" name="shop_addr" id="shop_addr" value="{$deal_info.shop_location}" class="textbox" />
		</td>
	    </tr>
	    <tr>
		<td align="right" valign="top"><strong>  Listing Fee: </strong></td>
		<td colspan="2" align="left"><span id="span1">{if $deal_info.listing_value}{$deal_info.listing_value}{else}Cxxxxx&Prime;{/if}</span> </td>
	    </tr>
	    <tr>
		<td align="right" valign="top"><strong>  Estimated Final Value Fee: </strong></td>
		<td colspan="2" align="left"><span id="span3">{if $deal_info.final_value}{$deal_info.final_value}{else}xxxxx{/if}</span></td>
	    </tr>
	    <tr>
		<td>&nbsp;</td>
		<td colspan="2"><input type="submit" value="Reset" name="Submit"/> <input type="button" value="Cancel" onclick="javascript:history.go(-1);"/> </td>
	    </tr>	
      </table>

  </form>
    </div>
{include file=$footer}
