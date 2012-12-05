{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/add_deal.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script type="text/javascript" src="{$siteroot}/js/jquery.jSuggest.1.0.js"></script>
<!--<script type="text/javascript" src="{$siteroot}/js/validation/ajaxget_category.js"></script>-->
{/strip}

<!--{*if $deal_info.deal_main_type eq '3'*}-->
{if $deal_info.deal_main_type|in_array:$dealprice_option_array}
	{literal}
		<script language="JavaScript">
			$(document).ready(function(){
				$("#price").val("0");
			});
		</script>
	{/literal}
{/if}
{literal}
<script language="JavaScript">
var dealtypeonload = '{/literal}{$deal_info.deal_type}{literal}';

var xmlHttp
function GetXmlHttpObject(){
var xmlHttp=null;
try{
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}

function getsubcat(str, SITEROOT)
{
//alert(str);
	xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null)
    {
          alert ("Your browser does not support AJAX!");
          return;
      }

	var url = SITEROOT+"/comman/show_category.php";
    url=url+"?cnid="+str;
    xmlHttp.onreadystatechange=state_value;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}
function state_value(){
    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
		document.getElementById('city_div').innerHTML=response;
	}
}




 function getsubsubcat(str)
{
//alert(str);
	xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null)
    {
          alert ("Your browser does not support AJAX!");
          return;
      }

	var url = SITEROOT+"/comman/show_subsubcategory.php";
    url=url+"?cnid="+str;
    xmlHttp.onreadystatechange=subcat_value;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}
function subcat_value(){
    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
		document.getElementById('sub_div').innerHTML=response;
	}
}

function getsubsubsubcat(str)
{
//alert(str);
	xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null)
    {
          alert ("Your browser does not support AJAX!");
          return;
      }

	var url = SITEROOT+"/comman/show_subsubsubcategory.php";
    url=url+"?cnid="+str;
    xmlHttp.onreadystatechange=subsubcat_value;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}
function subsubcat_value(){
    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
		document.getElementById('subsub_div').innerHTML=response;
	}
}




$(document).ready(function(){
    
    if(dealtypeonload == "service")
    {
        $('#list_voucher').show();
        $('#list_product').hide();
    }
    else
    {
        $('#list_voucher').hide();
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
function getPercentage(orgPrice)
{

	var gbPrice = document.getElementById('price').value;
	var saving = parseFloat(orgPrice) - parseFloat(gbPrice);	
	var percentage = ((parseFloat(saving) * 100) / parseFloat(orgPrice));
	document.getElementById('quantity').value = percentage.toFixed(0);
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

function getEstiValue()
{
    var gbPrice = document.getElementById('price').value;
    var minBuy = document.getElementById('min_buyer').value;
    if(((minBuy != "") && !isNaN(minBuy)) && (gbPrice != "") && !isNaN(gbPrice))
    {
        var finalFee = parseFloat(minBuy) * parseFloat(gbPrice);
        var page = SITEROOT+"/my-account/getfinalvalue/";
        $.get(page,{finalfee:finalFee},function(data){ $('#final_value').val(data);$('#span3').html(data);});
    }
}

// code for deleting images
function confirmDelete(deal_id,imgs){
	var Dele = confirm('Are you sure that you want to delete this image');
	if(Dele == true){
		window.location=SITEROOT+'/admin/globalsettings/deal/edit_product.php?id='+deal_id+'&delete='+imgs;
	}
}
//end

function getPercentageForGroupBuy(buyPrice,cus_savingHtmlId,cus_savingHiddenId)
{
	var orgPrice = document.getElementById('originalprice').value;
	var saving = parseFloat(orgPrice) - parseFloat(buyPrice);	
	var percentage = ((parseFloat(saving) * 100) / parseFloat(orgPrice));
	percentage=Math.round(percentage);
	if(percentage.toString() != 'NaN')
	{
		document.getElementById(cus_savingHtmlId).innerHTML = percentage.toFixed(0);
		document.getElementById(cus_savingHiddenId).value = percentage.toFixed(0);
	}else
	{
		document.getElementById(cus_savingHtmlId).innerHTML = "";
		document.getElementById(cus_savingHiddenId).value = "";
	}
}

function clearAllBuyPrices()
{
	$('#groupbuy_price_1').val('');
	$('#cus_saving1').html('');
	$('#cus_saving_1').val('');

	$('#groupbuy_price_2').val('');
	$('#cus_saving2').html('');
	$('#cus_saving_2').val('');

	$('#groupbuy_price_3').val('');
	$('#cus_saving3').html('');
	$('#cus_saving_3').val('');

	$('#groupbuy_price_4').val('');
	$('#cus_saving4').html('');
	$('#cus_saving_4').val('');

	$('#groupbuy_price_5').val('');
	$('#cus_saving5').html('');
	$('#cus_saving_5').val('');
}

function chkUnchk(chkObj)
{
	var chkId = chkObj.id;
	var chkVal = chkObj.checked;

	if(chkVal == true)
	{
		for (i=parseInt(chkId.substr(4))-parseInt(0);i>=2;i--)
		{
			$("#chk_"+i).attr("checked", true);
			$("#min_buyer_"+(i)).show();
			$("#max_buyer_"+(i)).show();
			$("#groupbuy_price_"+(i)).show();

			tempMin_buyer = "min_buyer_"+(i);
			$("div[class="+tempMin_buyer+"]").hide();
			tempMax_buyer = "max_buyer_"+(i);
			$("div[class="+tempMax_buyer+"]").hide();
			tempGroupbuy_price = "groupbuy_price_"+(i);
			$("div[class="+tempGroupbuy_price+"]").hide();

			$("#cus_saving"+(i)).show();
			$("#cus_saving_disable"+(i)).hide();

			$("#org_price"+(i)).show();
			$("#org_price_disable"+(i)).hide();
		}
	}else
	{
		for (i=parseInt(chkId.substr(4))+parseInt(0);i<=5;i++)
		{
			$("#chk_"+i).attr("checked", false);
			$("#min_buyer_"+(i)).hide();
			$("#max_buyer_"+(i)).hide();
			$("#groupbuy_price_"+(i)).hide();

			$("#min_buyer_"+(i)).val("");
			$("#max_buyer_"+(i)).val("");
			$("#groupbuy_price_"+(i)).val("");
			$("#cus_saving"+(i)).html("0");
			$("#cus_saving_"+(i)).val(0);

			tempMin_buyer = "min_buyer_"+(i);
			$("div[htmlfor="+tempMin_buyer+"]").html("");
			$("div[class="+tempMin_buyer+"]").html("----");
			$("div[class="+tempMin_buyer+"]").show();
			tempMax_buyer = "max_buyer_"+(i);
			$("div[htmlfor="+tempMax_buyer+"]").html("");
			$("div[class="+tempMax_buyer+"]").html("----");
			$("div[class="+tempMax_buyer+"]").show();
			tempGroupbuy_price = "groupbuy_price_"+(i);
			$("div[htmlfor="+tempGroupbuy_price+"]").html("");
			$("div[class="+tempGroupbuy_price+"]").html("----");
			$("div[class="+tempGroupbuy_price+"]").show();

			$("#cus_saving"+(i)).hide();
			$("#cus_saving_disable"+(i)).show();

			$("#org_price"+(i)).hide();
			$("#org_price_disable"+(i)).show();
		}
	}
}


$(document).ready(function(){
    
  //add_rows();

});

function add_rows()
{
var val=document.getElementById('txt_discount').value;
var dealId=document.getElementById('dealId').value;

	if(val<5)
	{
		var id1=val;
// 		id++;
		$.get(SITEROOT+"/admin/globalsettings/deal/tr_repeat_edit.php?id="+val+"&dealId="+dealId,function(data){
		$("input#i").val(val);
		$("#rept_data_"+id1).after("<tr id="+val+">"+data);
// 		id++;
  		})
	}
}

</script>
{/literal}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;
{if $smarty.get.back && $smarty.get.back eq 'up'}
<a href="{$siteroot}/admin/globalsettings/deal/upcoming_deal.php"> Manage Upcoming Deals</a>
{elseif $smarty.get.back &&  $smarty.get.back eq 'ex'}
<a href="{$siteroot}/admin/globalsettings/deal/expired_deal.php"> Manage Expired Deals</a>
{elseif $smarty.get.back && $smarty.get.back eq 'pend'}
<a href="{$siteroot}/admin/globalsettings/deal/pending-deal.php"> Manage Pending Deals</a>
{else}
<a href="{$siteroot}/admin/globalsettings/deal/manage_deal.php"> Manage Active Deals</a>
{/if}
&gt; Edit Deal
</div><br/>

<div class="breadcrumb">
	<h3 class="fl width20" style="color:black;">&nbsp;&nbsp; {if $smarty.get.id}Edit{else}Add{/if} Deal</h3><br/>
	<span class="fr">
		{if $smarty.get.back && $smarty.get.back eq 'up'}
			<a href="upcoming_deal.php"><strong>Back</strong></a>
		{elseif $smarty.get.back &&  $smarty.get.back eq 'ex'}
			<a href="expired_deal.php"><strong>Back</strong></a>
		{elseif $smarty.get.back && $smarty.get.back eq 'pend'}
			<a href="pending-deal.php"><strong>Back</strong></a>
		{else}
			<a href="manage_deal.php"><strong>Back</strong></a>
		{/if}
	</span>
</div>
<div class="holdthisTop">
{if $msg}<br/><div align="center">{$msg}</div>{/if}

    <form action="" method="post" name='frm' id="frm" enctype="multipart/form-data"  >
    <input type="hidden" id="txt_discount" name="txt_discount" value="{$count_discount}"/>
    <input type="hidden" id="dealId" name="dealId" value="{$smarty.get.id}"/>
    <!--<input type="text" id="final_value" name="final_value" value="{if $deal_info.final_value}{$deal_info.final_value}{else}0{/if}" />-->
    <input type="hidden" id="listing" name="listing" value="{if $deal_info.listing_value}{$deal_info.listing_value}{else}0{/if}" />
    <input type="hidden" id="option_selected" value="{$deal_info.option_selected}" name="option_selected">
    <input type="hidden" name="payment_type" id="payment_type" value="{$deal_info.payment_method}">

    {if $errormsg}<tr><td colspan="2" align="center">{$errormsg}</td></tr>{/if}

	<tr>
	  <tr colspan="2">
	    <div id="show2" style="display:block">
	      <table width="90%" cellspacing="10" cellpadding="5" align="center">
		

			<tr>
				<td align="right" valign="top" width="300"><span class="red"> *</span>Select Deal Currency:</td>
				<td>
					<select name="deal_currency" id="deal_currency" style="width: 225px;" class="selectbox fl" onchange="javascript:setCurrency(this.value);">
						<option value="pound" {if $deal_info.deal_currency eq 'pound'} selected="selected" {/if}>Pound(&#163;)</option>
						<option value="euro" {if $deal_info.deal_currency eq 'euro'} selected="selected" {/if}>Euro(&#8364;)</option>
						<option value="dollar" {if $deal_info.deal_currency eq 'dollar'} selected="selected" {/if}>Dollar($)</option>
					</select>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=4}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" id="deal_currency"></div>
					
				</td>
			</tr>

{section name=cc1 loop=$deal_discount_city}
			<tr>
			<td align="right" valign="top"><span class="red">*</span> Deal Countries: </td>
			<td colspan="2" align="left">
				<select name="dealcountry[]" id="dealcountry_{$smarty.section.cc1.index+1}" style="width:180px;" class="selectbox fl" onchange="javascript:fillStates(this,{$smarty.section.cc1.index+1});">
					
					<option value="">Select Deal Countries</option>
					{section name=i loop=$country}
					<option value="{$country[i].countryid}" {if $country[i].countryid eq $deal_discount_city[cc1].country_id} selected='selected' {/if}   {if $deal_info.deal_country eq $country[i].countryid} selected='selected'{/if}>{$country[i].country}</option>
					{/section}
				</select>&nbsp;&nbsp;
				<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=1}</span></a>
                                             <div class="clr"></div>
				<div class="error" id="countryerror"></div>
			</td>
		</tr>
		<tr id="div_stateDD_hideshow">
			<td align="right" valign="top"><span class="red" style="display:none;">*</span> Deal Counties / States: </td>
			<td colspan="2" align="left">
				<div id="state_{$smarty.section.cc1.index+1}" style="width:180px;" class="fl">
					<select name="dealstate[]" id="dealstate_{$smarty.section.cc1.index+1}" style="width:100%;" class="selectbox fl"  onchange="javascript:fillCities(this,{$smarty.section.cc1.index+1});">
						<option value="">Select Deal States</option>
							{section name=i loop=$state_discount}
								<option value="{$state_discount[i].id}"                                                    {if $state_discount[i].id eq $deal_discount_city[cc1].state_id} selected='selected' {/if}   {if $deal_info.deal_state eq $state_discount[i].id} selected='selected'{/if}>{$state_discount[i].state_name}</option>
							{/section}
						
					</select>&nbsp;&nbsp;
				</div>
				<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=2}</span></a>
                                             <div class="clr"></div>
				<div class="error" id="stateerror"></div>
			</td>
		</tr>
		<tr id="div_cityDD_hideshow">
			<td align="right" valign="top"><span class="red" style="display:none;">*</span> Deal Cities / Towns: </td>
			<td colspan="2" align="left">
				<!--<input type="text" name="category" id="category" class="textbox" autocomplete="off" onblur="setCat(this.value)"/>-->
				<div id="city_{$smarty.section.cc1.index+1}" style="width:180px;" class="fl">
					<select name="dealcity[]" id="dealcity_{$smarty.section.cc1.index+1}" style="width:100%;" class="selectbox fl" >
					<option value="">Select Deal Cities</option>
							{section name=i loop=$city}
								<option value="{$city[i].city_id}"						  {if $city[i].city_id eq $deal_discount_city[cc1].city_id} selected='selected' {/if}   {if $deal_info.deal_city eq $city[i].city_id} selected='selected'{/if}>{$city[i].city_name}</option>
							{/section}
						
					</select>&nbsp;&nbsp;
				</div>
				<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=3}</span></a>
                                             <div class="clr"></div>
				<div class="error" id="cityerror"></div>
			</td>
		</tr>
<tr id="div_cityDD_hideshow">
		<td align="right" valign="top"><span class="red" style="display:none;">*</span> Deal Discount: </td>
		<td colspan="2" align="left">
			<input type="text" name="deal_discount[]" id="deal_discount_{$smarty.section.cc1.index+1}" value="{$deal_discount_city[cc1].discount}" >
		</td>
	</tr>
{/section}
<input type="hidden" name="txt_id" id="txt_id" value=""><input type="hidden" name="txt_id1" id="txt_id1" value="">

	  <!--/////////////////////end-->

		<tr>
			<td align="right" valign="top"><span class="red">*</span> Title: </td>
			<td  align="left">
				<!--{$oFCKeditorTitle}-->
<input type="text" name="title1" id="title1" value="{$deal_info.title|html_entity_decode}">
			</td>
			<td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=10}</span></a></td>
		</tr>
		   
		    <tr>
			<td align="right" valign="top"> Description: </td>
			<td  align="left">
				<!--{*<input type="text" name="slogan" class="textbox" id="slogan" value="{$deal_info.slogan}" maxlength="255" style="width:550px;">
				<div><font color="#999999" size="2">Please enter upto 255 characters.</font></div>*}-->
				{$oFCKeditor}
			</td>
			<td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=12}</span></a></td>
		    </tr>	
	  		
		 <tr>
	      <td align="right" valign="top"><span class="red">*</span> <!--Description--><!--Key Features--> Why Buy: </td>
	      <td  align="left">{$oFCKeditorwhybuy} <!--<textarea cols="60" rows="8" name="description" id="description"></textarea>--></td>
	      <td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=84}</span></a></td>
	  </tr>


		<tr>
	      <td align="right" valign="top"><span class="red">*</span> Seller Account Number: </td>
	      <td colspan="2" align="left"><span  style="float:left;">#</span><input type="text" name="seller_account_no" class="textbox fl" id="seller_account_no" value="{$deal_info.seller_account_no}" maxlength="20">
		<input type="hidden" name="seller_account_no_other" id="seller_account_no_other" value="{$deal_info.seller_account_no}" maxlength="20">
		
		<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=13}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="seller_account_no" generated="true"></div>
		
	      </td>
	  </tr>
		<tr>
			<td align="right" valign="top"><span class="red">*</span> Seller Name: </td>
			<td colspan="2" align="left"><!--{*<input type="text" name="deal_from_seller_name" class="textbox" id="deal_from_seller_name" value="{$deal_info.deal_from_seller_name}" maxlength="255">
			<div><font color="#999999" size="2">Please enter upto 255 characters.</font></div>*}-->
			<select name="deal_from_seller_name" id="deal_from_seller_name"  class="selectbox fl " style="width:225px;" onchange="javascript:checkSellerDet(this);" >
				<option value="other_seller">--Select Seller--</option>
				{section name=i loop=$sellerList}
					<option value="{$sellerList[i].userid}" {if $deal_info.deal_from_seller_name eq $sellerList[i].userid} selected="selected"{/if}>{$sellerList[i].first_name} {$sellerList[i].last_name}</option>
				{/section}
				
			</select>
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=14}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="deal_from_seller_name" generated="true"></div>
	
			
				
			</td>
		</tr>
		<tr>
			<td align="right" valign="top"><span class="red">*</span> Seller Post Code: </td>
			<td  align="left">
				<input type="text" name="zipcode" class="textbox fl" id="zipcode" value="{$deal_info.seller_zipcode}" maxlength="255">
				<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=16}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="zipcode" generated="true"></div>
			</td>
		</tr>
                   
		
		<tr>
	      <td align="right" valign="top"><span class="red">*</span> <!--Highlights-->Terms and Conditions: </td>
	      <td  align="left">{$oFCKeditor1}<!-- <textarea cols="60" rows="8" name="highlight" id="highlight"></textarea>--></td>
	      <td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=85}</span></a></td>
	  </tr>

	

	  <tr>
	      <td align="right" valign="top"> Seller Support Email: </td>
	      <td colspan="2" align="left"><input type="text" name="seller_support_email" class="textbox fl" id="seller_support_email" value="{$deal_info.seller_support_email}">
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=20}</span></a>
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="seller_support_email" generated="true"></div>
	      </td>
	  </tr>

	  <tr>
	      <td align="right" valign="top"> Tracking URL Code: </td>
	      <td colspan="2" align="left"><input type="text" name="trackURL" class="textbox fl" id="trackURL" value="{$deal_info.trackURL}">
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=21}</span></a>
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="trackURL" generated="true"></div>
	      </td>
	  </tr>

	  <tr>
	      <td align="right" valign="top"> Delivered Tracking URL Code: </td>
	      <td colspan="2" align="left"><input type="text" name="delivered_tracking_url_code" class="textbox fl" id="delivered_tracking_url_code" value="{$deal_info.delivered_tracking_url_code}">
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=22}</span></a>
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="delivered_tracking_url_code" generated="true"></div>
	      </td>
	  </tr>
	 
		  <tr>
	      <td align="right" valign="top">Refund Policy: </td>
	      <td  align="left">{$oFCKeditorRefundPolicy}<!--<textarea cols="60" rows="8" name="refund_policy" id="refund_policy"></textarea>--> 	      
	      </td>
	      <td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=23}</span></a></td>
	  </tr>
	  <tr>
	      <td align="right" valign="top"><span class="red">*</span> Fine Print: </td>
	      <td align="left">{$oFCKeditor2}<!--<textarea cols="60" rows="8" name="fineprint" id="fineprint"></textarea>--> </td>
	       <td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=24}</span></a></td>
	  </tr>
	<tr>
	      <td align="right" valign="top"> Other Product/Services URL: </td>
	      <td colspan="2" align="left"><input type="text" name="otherproductURL" class="textbox fl" id="otherproductURL" value="{$deal_info.otherproductURL}">
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=27}</span></a>
                                             <div class="clr"></div>
                                            <div class="error" htmlfor="otherproductURL" generated="true"></div>
	      </td>
	  </tr>
		<tr>
		<td align="right" valign="top"> Address And Locations: </td>
			<td colspan="2" align="left"><textarea cols="60" rows="8" name="addressandlocation" style="float:left;" id="addressandlocation">{$deal_info.addressandlocation}</textarea> 
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=28}</span></a>
			</td>
		</tr>
	  
		    <tr>
			<td align="right" valign="top"><span class="red">*</span> Upload Image: </td>
			<td colspan="2" align="left" valign="top">
                        <!--{*<input type="button" name="add" id="add" value="Upload Image(s)" onclick="javascript:tb_show('Upload Image(s)', '{$siteroot}/modules/my-account/uploadmain.php?&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=720&modal=false', tb_pathToImage);">*}-->
			<input type="button" name="add" id="add" value="Upload Image(s)" onclick="javascript:tb_show('Upload Image(s)', '{$siteroot}/admin/globalsettings/deal/uploadmain-admin.php?&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=720&modal=false', tb_pathToImage);" style="float:left;">
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=30}</span></a><div class="clr"></div>
      		        {section name=j loop=$deal_img}
				{if $deal_img[j]}
					<br/><img src="{$siteroot}/uploads/product/thumb76X64/{$deal_img[j]}" />
					&nbsp;&nbsp;<a href="javascript:void(0);" onclick="confirmDelete('{$deal_info.deal_unique_id}','{$deal_img[j]}');">Delete</a>&nbsp;&nbsp;
					{if $smarty.section.j.index neq 0}
					<a href="{$siteroot}/admin/globalsettings/deal/edit_product.php?id={$deal_info.deal_unique_id}&mode=swap&order={$smarty.section.j.index}"/>Make it default image</a>
					{else}
					Default Image
					{/if}
					<br/>
				{/if}
			{/section}
                        </td>
		    </tr>
                    <tr><td></td><td colspan="2"><div id="morefile"></div></td></tr>

		<tr>
			<td align="right" valign="top"> Comment: </td>
			<td colspan="2" align="left">
			<textarea cols="60" rows="8" name="comments" id="comments" style="float:left;">{$deal_info.comments}</textarea> 
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=31}</span></a>
			</td>
		</tr>
				<tr id="usortdPrice" {if $deal_info.deal_main_type|in_array:$dealprice_option_array} style="display:none;" {/if}>
				<td align="right" valign="top"><span class="red">*</span>Buy Price <span id="span_dlcurr_ubuyprice">{if $deal_info.deal_currency eq 'pound'}&#163;{/if}{if $deal_info.deal_currency eq 'euro'}&#8364;{/if}{if $deal_info.deal_currency eq 'dolor'}${/if}</span>: </td>
				<td colspan="2" align="left"><input type="text" name="price" id="price" value="{$deal_info.groupbuy_price}"
				 onchange="getEstiValue()" class="textbox fl" maxlength="7">
				 <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=35}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="price" generated="true"></div>
					<!--<div class="error" id="price" style="display:none;"></div>-->
				</td>
			</tr>

		    <tr>
		      <td align="right" valign="top"><span class="red">*</span> Original Price <span id="span_dlcurr_actprice">{if $deal_info.deal_currency eq 'pound'}&#163;{/if}{if $deal_info.deal_currency eq 'euro'}&#8364;{/if}{if $deal_info.deal_currency eq 'dolor'}${/if}</span>: </td>
		      <td colspan="2" align="left"><input type="text" onblur="getPercentage(this.value)" name="originalprice" id="originalprice" value="{$deal_info.orignal_price}" class="textbox fl" maxlength="7">
		       <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=36}</span></a>
                                             <div class="clr"></div>
             		<div class="error" id="originalprice" style="display:none;"></div>
		      </td>
		    </tr>

		<!--<tr id="cusSaving" {if $deal_info.deal_main_type eq '3'} style="display:none;" {/if}>-->
		<tr id="cusSaving" {if $deal_info.deal_main_type|in_array:$dealprice_option_array} style="display:none;" {/if}>
			<td align="right" valign="top"><span class="red">*</span> Customer Savings %: </td>
			<td colspan="2" align="left"><input type="text" name="quantity" id="quantity" value="{$deal_info.quantity}"
			 class="textbox fl"  style="background:#D4D0C8">
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=70}</span></a>
			</td>
		</tr>

		<!--<tr id="minBuy" {if $deal_info.deal_main_type eq '3'} style="display:none;" {/if}>-->
		<tr id="minBuy" {if $deal_info.deal_main_type|in_array:$dealprice_option_array} style="display:none;" {/if}>
			<td align="right" valign="top"><span class="red">*</span> Minimum Buyers Required: </td>
			<td colspan="2" align="left"><input type="text" name="min_buyer" id="min_buyer" value="{$deal_info.min_buyer}" onchange="getEstiValue()" class="textbox fl" maxlength="3">
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=38}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="min_buyer" generated="true"></div>
			</td>
		</tr>

		<tr id="maxBuy" {if $deal_info.deal_main_type|in_array:$dealprice_option_array} style="display:none;" {/if}>
			<td align="right" valign="top"><span class="red">*</span> Maximum Number Of Buyers: </td>
			<td colspan="2" align="left"><input type="text" name="max_buyer" id="max_buyer" value="{$deal_info.max_buyer}" class="textbox fl" maxlength="3">
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=39}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="max_buyer" generated="true"></div>
			</td>
		</tr>

	<tr height="25">
	    <td valign="top" align="right"><span class="red">*</span> Redeem From: </td>
	    <td align="left" valign="top" style="float:left;"><span  style="float:left;">
	      {if $redeemfrom}
	      <script type="text/javascript">DateInput('redeemfrom', true, 'YYYY-MM-DD','{$redeemfrom}');</script>
	      {else}
	      <script type="text/javascript">DateInput('redeemfrom', true, 'YYYY-MM-DD');</script>
	      {/if}</span>
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=81}</span></a>
                                             <div class="clr"></div>
                                            <!-- <div class="error" htmlfor="max_buyer" generated="true"></div>-->
              <div class="error" id="error_dealStartDate" style="display:none;"></div>
	    </td>
	  </tr>



	  <tr height="25">
	    <td valign="top" align="right"><span class="red">*</span> Redeem To: </td>
	    <td align="left" valign="top" style="float:left;"><span  style="float:left;">
	      {if $redeemto}
	      <script type="text/javascript">DateInput('redeemto', true, 'YYYY-MM-DD','{$redeemto}');</script>
	      {else}
	      <script type="text/javascript">DateInput('redeemto', true, 'YYYY-MM-DD');</script>
	      {/if}</span>
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=82}</span></a>
                                             <div class="clr"></div>
                                            <!-- <div class="error" htmlfor="max_buyer" generated="true"></div>-->
              <div class="error" id="error_dealStartDate" style="display:none;"></div>
	    </td>
	  </tr>
		<tr height="25">	
			<td valign="top" align="right"><span class="red">*</span> Start Date: </td>
			<td align="left" valign="top"><span  style="float:left;">
				{if $start_date}
				<script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD','{$start_date}');</script>
				{else}
				<script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD');</script>
				{/if}</span>
	                                   <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=40}</span></a>
                                             <div class="clr"></div>
				<div class="error" id="error_dealStartDate" style="display:none;"></div>
			</td>
		</tr>
		    <tr height="25">
			<td valign="top" align="right"><span class="red">*</span> Start Time: </td>
			<td align="left" valign="top"><span  style="float:left;">
			  <select name="start_hour" id="start_hour">
			  {section name=i loop=$hr}
			  <option value="{$hr[i]}" {if $s_hr eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
			  {/section}
			  </select>&nbsp;&nbsp;&nbsp;
			  <select name="start_min" id="start_min">
			  {section name=i loop=$min}
			  <option value="{$min[i]}" {if $s_min eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
			  {/section}
			  </select></span>
		<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=41}</span></a>
			</td>
		    </tr>
		    <tr height="25">
			<td valign="top" align="right"><span class="red">*</span> End Date: </td>
			<td colspan="2" align="left" valign="top"><span  style="float:left;">
			  {if $end_date}
			  <script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD','{$end_date}');</script>
			  {else}
			  <script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD');</script>
			  {/if}
			  </span>
		              <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=42}</span></a>
			</td>
		    </tr>
		    <tr height="25">
		      <td valign="top" align="right"><span class="red">*</span>End Time: </td>
		      <td align="left" valign="top"><span  style="float:left;">
			<select name="end_hour" id="end_hour">
			{section name=i loop=$rev_hr}
			<option value="{$rev_hr[i]}" {if $e_hr eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
			{/section}
			</select>&nbsp;&nbsp;&nbsp;
			<select name="end_min" id="end_min">
			{section name=i loop=$rev_min}
			<option value="{$rev_min[i]}" {if $e_min eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
			{/section}
			</select>
			</span>
	               <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=43}</span></a>
                                             <div class="clr"></div>
                        <!--<div id="err_date" style="display:none;"></div>-->
		      </td>
		  </tr>
		<tr height="25">
			<td valign="top" align="right">&nbsp;</td>
			<td align="left" valign="top"><div class="error" id="error_dealEndDate" style="display:none;"></div></td>
		</tr>
       <!-- <tr height="25" id="validfrom">
	    <td valign="top" align="right" id="validfrom" ><span class="red">*</span> Valid from: </td>
	    <td align="left" valign="top"><span  style="float:left;">
	      {if $fromdates!="0000-00-00"}
	      <script type="text/javascript">DateInput('validfrom', true, 'YYYY-MM-DD','{$fromdates}');</script>
	      {else}
	      <script type="text/javascript">DateInput('validfrom', true, 'YYYY-MM-DD');</script>
	      {/if}
	      </span>
		<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=71}</span></a>
	    </td>
	  </tr>

        <tr height="25" id="validto">
	    <td valign="top" align="right"><span class="red">*</span> Valid to: </td>
	    <td align="left" valign="top"><span  style="float:left;">
	      {if $todates!="0000-00-00"}
	      <script type="text/javascript">DateInput('validto', true, 'YYYY-MM-DD','{$todates}');</script>
	      {else}
	      <script type="text/javascript">DateInput('validto', true, 'YYYY-MM-DD');</script>
	      {/if}
	      </span>
		<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=72}</span></a>
	    </td>
	  </tr>-->
	 <!-- <tr height="25">
	    <td valign="top" align="right">&nbsp;</td>
	    <td align="left" valign="top"><div class="error" id="error_toEndDate" style="display:none;"></div></td>
	</tr>-->
       <!--  <tr height="25" style="display:none;">
		      <td valign="top" align="right"><span class="red"></span> Ending Soon: </td>
		      <td align="left" valign="top">
			  <input type="radio" name="endingsoon" id="endingsoon" {if $deal_info.deal_ending=='yes' } checked="true" {/if} value="yes">Yes
          <input type="radio" name="endingsoon" id="endingsoon" value="no" {if $deal_info.deal_ending=='no' } checked="true" {/if}>No
		      </td>
		  </tr>
 
     -->
		<tr>
			<td align="right" valign="top">Voucher Text: </td>
			<td colspan="2" align="left">
				<textarea cols="60" rows="8" name="free_voucher_text" id="free_voucher_text" style="float:left;">{$deal_info.voucher_text}</textarea>
				<a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=44}</span></a>
				<div class="clr"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top">How It Work Text: </td>
			<td colspan="2" align="left">
				{$oFCKeditorHowItWork}
			</td>
			<td valign="top"><a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=73}</span></a></td>
		</tr>
<tr>
		<td align="right" valign="top">Send To: </td>
		<td colspan="2" align="left">
			<input type="checkbox" name="only_fans" id="only_fans" value="Only Fans" {if $send_to_fan eq 'Only Fans'} checked="true" {/if}>Only Fans<input type="checkbox" name="all_who_choose_category" id="all_who_choose_category" value="All who choose category"  {if $send_to_other eq 'All who choose category'} checked="true" {/if}>All who choose category
		</td>
		<td valign="top"><a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=80}</span></a></td>
	</tr>


                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><input type="submit" value="Create and Send Deal" name="Submit"/> <input type="button" value="Cancel" onclick="javascript: location='manage_deal.php';" /> </td>
                    </tr>
	      </table>
	    </div>
	  </td>
	</tr>
    </form>
    </table>

{*literal*}
	<script language="JavaScript" type="text/javascript">
		//showHideStateCity(document.getElementById('is_national').checked);
	</script>
{*/literal*}
{include file=$footer}
