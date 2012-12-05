{include file=$header1}
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{literal}
<script language="JavaScript">

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
            //document.getElementById('span4').innerHTML =  parseInt(document.getElementById("listing").value)  + parseInt(document.getElementById("listing_t").value);
            if(document.getElementById("option_selected").value)
                document.getElementById("option_selected").value=document.getElementById("option_selected").value + "," + optionid;
            else
                document.getElementById("option_selected").value= optionid;
                        
            if(optionid == 6){ 
            document.getElementById("web").style.display=""; }
            if(optionid == 7)	{	 	
            document.getElementById("addr").style.display="";
            document.getElementById("addr1").style.display=""; 
        }
        }
        else
        {
            document.getElementById("listing").value=parseInt(document.getElementById("listing").value) - parseInt(pr);
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
            if(optionid == 7){			
            document.getElementById("addr").style.display="none";
            document.getElementById("addr1").style.display="none";
        }
        }
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
        $.get(page,{finalfee:finalFee},function(data){ $('#estimatedfees').val(data)});
    }
    
}

function getPercentage(orgPrice)
{
    var gbPrice = document.getElementById('price').value;
    var saving = parseFloat(orgPrice) - parseFloat(gbPrice);
    var percentage = ((parseFloat(saving) * 100) / parseFloat(orgPrice));
    document.getElementById('quantity').value = percentage;
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
</script>
{/literal}
{include file=$header2}

<div class="breadcrumb">
	<h3 class="fl width20" style="color:black;">Deal Quote</h3><br/>
	<span class="fr"><a href="view-deal.php"><strong>Back</strong></a></span>
</div>
<div class="holdthisTop">
{if $msg}<div align="center">{$msg}<br/></div>{/if}
    <form action="" method="post" name='frm' id="frm" enctype="multipart/form-data">
    <input type="hidden" name="sellerid" id="sellerid" value="{$product.seller_id}">
    <input type="hidden" name="option_selected" id="option_selected" value="{$product.option_selected}">
    <input type="hidden" name="payment_type" id="payment_type" value="{$product.payment_method}">
    <table width="70%" align="center" cellpadding="5" cellspacing="5">
        <col width="30%">
        <col width="70%">
        <tr>
            <td align="right" valign="top"><span class="red">*</span> Deal Category: </td>
            <td colspan="2" align="left">
                <input type="text" name="category" id="category" class="textbox" value="{$category}" readonly="true">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top"><span class="red">*</span> Deal Sub Category: </td>
            <td colspan="2" align="left">
                <input type="text" name="subcategory" id="subcategory" class="textbox" value="{$subcategory}" readonly="true">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top"><span class="red">*</span> Title: </td>
            <td colspan="2" align="left"><input type="text" name="title1" class="textbox" id="title1" value="{$product.title}" readonly="true">
            </td>
        </tr>	

        <tr>
            <td align="right" valign="top"><span class="red">*</span> Description: </td>
            <td colspan="2" align="left"> <textarea cols="60" rows="8" name="description" id="description">{$product.description}</textarea></td>
        </tr>

        <tr>
            <td align="right" valign="top"><span class="red">*</span> Highlight: </td>
            <td colspan="2" align="left"> <textarea cols="60" rows="8" name="highlight" id="highlight">{$product.highlight}</textarea></td>
        </tr>

        <tr>
            <td align="right" valign="top"><span class="red">*</span> Terms Fine Print: </td>
            <td colspan="2" align="left"><textarea cols="60" rows="8" name="fineprint" id="fineprint">{$product.fineprint}</textarea> </td>
        </tr>
        {if $product.deal_type eq "product"}
        <tr>
            <td align="right" valign="top"><span class="red">*</span> Delivery Cost: </td>
            <td colspan="2" align="left"><input type="text" class="textbox" name="delivery_cost" id="delivery_cost" value="{$product.sub_delivery_cost}"/>
            </td>
        </tr>	
        <tr>
            <td align="right" valign="top"><span class="red">*</span> Payment Method Accepted: </td>
            <td colspan="2" align="left">
                <table align="left" width="30%"></td>
                    {section name=i loop=$payment}
                    <tr>
                        <td> <input type="checkbox" name="{$payment[i].payment_method}" id="{$payment[i].payment_method}" value="{$payment[i].payment_method}" {if $payment[i].payment_method|in_array:$pay} checked="true" {/if}  onclick="addPaymentType(this);"/> </td>
                        <td>{$payment[i].payment_method} </td>
                    </tr>
                    {/section}
                </table>
            </td>
        </tr>
        {/if}	
        <tr>
            <td align="right" valign="top"><span class="red">*</span> Video Link: </td>
            <td colspan="2" align="left"><input type="text" name="videolink" id="videolink" class="textbox" value="{$product.vedio_link}">
            </td>
        </tr>

        <tr>
            <td align="right" valign="top"><span class="red">*</span> Group Buy Price &pound;: </td>
            <td colspan="2" align="left"><input type="text" name="price" id="price" value="{$product.groupbuy_price}" class="textbox" onchange="getEstiValue();">
            </td>
        </tr>

        <tr>
            <td align="right" valign="top"><span class="red">*</span> Original Price &pound;: </td>
            <td colspan="2" align="left"><input type="text" name="originalprice" id="originalprice" value="{$product.orignal_price}" class="textbox" onchange="getPercentage(this.value)">
            </td>
        </tr>

        <tr>
            <td align="right" valign="top"> Customer Savings: </td>
            <td colspan="2" align="left"><input type="text" name="quantity" id="quantity" value="{$product.quantity}" class="textbox">
            </td>
        </tr>

        <tr>
            <td align="right" valign="top"><span class="red">*</span> Minimum Buyers Required: </td>
            <td colspan="2" align="left"><input type="text" name="min_buyer" id="min_buyer" value="{$product.min_buyer}" class="textbox" onchange="getEstiValue();">
            </td>
        </tr>

        <tr>
            <td align="right" valign="top"><span class="red">*</span> Maximum Number Of Buyers: </td>
            <td colspan="2" align="left"><input type="text" name="max_buyer" id="max_buyer" value="{$product.max_buyer}" class="textbox">
            </td>
        </tr>
        <tr>
            <td align="right"><span class="red">*</span> Start Date: </td>
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
        <tr>
            <td align="right"><span class="red">*</span> End Date: </td>
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

            </td>
        </tr>
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
       
        <tr {if $flag1 eq "1"}{else} style="display:none" {/if} id="web">
            <td align="right"> Website:&nbsp;</td>
            <td>
                <input type="text" name="website" value="{$product.option_website}" id="website" class="textbox"/>
            </td>
        </tr>
        <tr {if $flag2 eq "2"}{else} style="display:none" {/if} id="addr1">
            <td align="right">Address: </td>
            <td >
        <input type="text"  name="deal_addr" id="deal_addr" value="{$product.deal_address}" class="textbox" >
        </td>
        </tr>

         <tr {if $flag2 eq "2"}{else} style="display:none" {/if} id="addr">
            <td align="right">High St/ Shop Location: </td>
            <td >
                <input type="text" name="shop_addr" id="shop_addr" value="{$product.shop_location}" class="textbox" />
            </td>
        </tr>
         <tr>
            <td align="right">Other Option: </td>
            <td>
                <input type="checkbox" name="optionoth" {if $product.shipping_assitance eq 'yes'} checked="true"{/if}><span style="font-size:12;font-weight:bold">Request shipping assistance</span> 
            </td>
        </tr>
        <tr>
            <td align="right"> Final Fees &pound;: </td>
            <td> <input type="text" name="estimatedfees" id="estimatedfees" class="textbox" value="{$product.final_value}" ></td>
        </tr>
        <tr>
            <td align="right"> Listing Fees &pound;: </td>
            <td> <input type="text" name="listing" id="listing" class="textbox" value="{$product.listing_value}"></td>
        </tr>
        <tr>
            <td align="right"> Percentage Charged %: </td>
            <td> <input type="text" name="chargepercentage" id="chargepercentage" class="textbox" value="{$deal_quote.charged_percentage}"></td>
        </tr>
         <tr>
            <td align="right" valign="top"> Comments: </td>
            <td><p>{$product.comments|stripslashes}</p> </td>
        </tr>
         <tr>
            <td align="right" valign="top"> Group Buy IT Comment: </td>
            <td><textarea rows="6"  cols="60" name="gbi_comment" id="gbi_comment">{$gbi_comment|html_entity_decode}</textarea></td>
        </tr>
        
        <tr>
            <td align="right" > <input type="submit" name="quote" id="quote" value="Quote"> </td>
            <td><input type="submit" name="edit" id="edit" value="Edit"></td>
        </tr>
    </table>
    </form>
 

{include file=$footer}
