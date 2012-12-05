{include file=$header_seller1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/seller/add_deal.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script type="text/javascript" src="{$siteroot}/js/jquery.jSuggest.1.0.js"></script>
{*<!--<script type="text/javascript" src="{$siteroot}/js/validation/ajaxget_category.js"></script>-->*}
{/strip}

{*<!--if $deal_info.deal_main_type eq '3'-->*}
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
		window.location=SITEROOT+'/admin/seller/deal/edit_product.php?id='+deal_id+'&delete='+imgs;
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


</script>
{/literal}
{include file=$header_seller2}
{*<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;
{if $smarty.get.back && $smarty.get.back eq 'up'}
<a href="{$siteroot}/admin/seller/deal/upcoming_deal.php"> Manage Upcoming Deals</a>
{elseif $smarty.get.back &&  $smarty.get.back eq 'ex'}
<a href="{$siteroot}/admin/seller/deal/expired_deal.php"> Manage Expired Deals</a>
{elseif $smarty.get.back && $smarty.get.back eq 'pend'}
<a href="{$siteroot}/admin/seller/deal/pending-deal.php"> Manage Pending Deals</a>
{else}
<a href="{$siteroot}/admin/seller/deal/manage_deal.php"> Manage Active Deals</a>
{/if}
&gt; Edit Deal
</div><br/>-->*}

<section id="maincont" class="ovfl-hidden">

	<section class="grybg">
		<div class="pagehead">
			<div class="grpcol">
				<ul class="reset ovfl-hidden tab1">
					<li><a href="{$siteroot}/admin/seller/my-profile-view.php">My Account</a> </li>
					<li><a href="{$siteroot}/admin/seller/deal/add_product.php" class="active">Deal Management</a> </li>
					<li><a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php">Masters</a> </li>
					<li><a href="{$siteroot}/admin/seller/login-log.php">Tools</a> </li>
				</ul>
                <div class="SubNav">
                <a href="{$siteroot}/admin/seller/deal/add_product.php">Add New Deal</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/pending-deal.php">Pending Deals ({$deal_notice_info_seller.tot_pending})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/manage_deal.php">Active Deals ({$deal_notice_info_seller.tot_actv1})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/featured_deal.php">Featured Deals ({$deal_notice_info_seller.tot_fea})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/rejected-deals.php">Rejected Deals ({$deal_notice_info_seller.tot_rej})</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/upcoming_deal.php">Upcoming Deals ({$deal_notice_info_seller.tot_upcom})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/expired_deal.php">Expired Deals ({$deal_notice_info_seller.tot_exp})</a>
                </div>
			
           
			</div>
		</div>
		<div class="innerdesc">
 <h3 class="pagehead2" style="float:left">{if $smarty.get.id}Edit{else}Add{/if} Deal</h3>
				<h3 class="pagehead2" style="float:right; font-size:13px">
                {if $smarty.get.back && $smarty.get.back eq 'up'}
			<a href="upcoming_deal.php"><strong>Back</strong></a>
            {elseif $smarty.get.back &&  $smarty.get.back eq 'ex'}
                <a href="expired_deal.php"><strong>Back</strong></a>
            {elseif $smarty.get.back && $smarty.get.back eq 'pend'}
                <a href="pending-deal.php"><strong>Back</strong></a>
            {else}
                <a href="manage_deal.php"><strong>Back</strong></a>
            {/if}
                </h3>
				<div style="clear:both;"></div>        
                <div class="border"></div>
                {if $msg}<br/><div align="center" id="msg">{$msg}</div>{/if}
                {if $errormsg}<br/><div align="center" >{$errormsg}</div>{/if}

    <form action="" method="post" name='frm' id="frm" enctype="multipart/form-data">
    <input type="hidden" id="dealId" name="dealId" value="{$smarty.get.id}"/>
    {*<!--<input type="text" id="final_value" name="final_value" value="{if $deal_info.final_value}{$deal_info.final_value}{else}0{/if}" />-->*}
    <input type="hidden" id="listing" name="listing" value="{if $deal_info.listing_value}{$deal_info.listing_value}{else}0{/if}" />
    <input type="hidden" id="option_selected" value="{$deal_info.option_selected}" name="option_selected">
    <input type="hidden" name="payment_type" id="payment_type" value="{$deal_info.payment_method}">
    <div id="show2" style="display:block">
    <ul class="form_pro">
        <li><label><span class="red">*</span> Deal Countries:</label>
        <div class="fl">
            <select name="dealcountry[]" id="dealcountry" class="textbox fl" size="6" multiple="true" onchange="javascript:fillStates(this);">
            <optgroup label="--Select Deal Countries--">
            {section name=i loop=$country}
            <option value="{$country[i].countryid}" {if in_array($country[i].countryid, $deal_countries_arr)} selected='selected' {/if}   {if $deal_info.deal_country eq $country[i].countryid} selected='selected'{/if}>{$country[i].country}</option>
            {/section}
            </select>
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=1}</span></a>
            <div class="clr"></div>
            <span><a href="javascript:void(0);" onclick="javascript:selectAllCountry(getElementById('dealcountry'));">Select All</a> <strong>|</strong> <a  href="javascript:void(0);" onclick="javascript:unselectAllCountry(getElementById('dealcountry'));">Unselect All</a></span> <strong>|</strong> (Ctrl + Mouse left key to select multiple)
            <div class="error" id="countryerror"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Is National Deal:</label>
        <div class="fl">
            <input type="checkbox" name="is_national" id="is_national" {if $deal_info.is_national eq 'yes'} checked="true" {/if}   onclick="javascript:showHideStateCity(this.checked);">
        </div>
        <div class="clr"></div>
        </li>
        
         <li id="div_stateDD_hideshow"><label><span class="red">*</span> Deal Counties / States:</label>
        <div class="fl">
            <div id="state" class="fl">
            <select name="dealstate[]" id="dealstate" class="textbox fl" size="6" multiple="true" onchange="javascript:fillCities(this);">
            <optgroup label="--Select Deal States--">
            {section name=i loop=$state}
            <option value="{$state[i].id}" {if in_array($state[i].id, $deal_states_arr)} selected='selected' {/if} {if $deal_info.deal_state eq $state[i].id} selected='selected'{/if}>{$state[i].state_name}</option>
            {/section}
            </optgroup>
            </select>
            </div>
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=2}</span></a>
            <div class="clr"></div>
            <span><a href="javascript:void(0);" onclick="javascript:selectAllState(getElementById('dealstate'));">Select All</a> <strong>|</strong> <a  href="javascript:void(0);" onclick="javascript:unselectAllState(getElementById('dealstate'));">Unselect All</a></span> <strong>|</strong> (Ctrl + Mouse left key to select multiple)
            <div class="error" id="stateerror"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li id="div_cityDD_hideshow"><label><span class="red">*</span> Deal Cities / Towns:</label>
        <div class="fl">
            {*<!--<input type="text" name="category" id="category" class="textbox" autocomplete="off" onblur="setCat(this.value)"/>-->*}
            <div id="city" class="fl">
            <select name="dealcity[]" id="dealcity" class="textbox fl" size="6" multiple="true">
            <optgroup label="--Select Deal Cities--">
            {section name=i loop=$city}
            <option value="{$city[i].city_id}" {if in_array($city[i].city_id, $deal_cities_arr)} selected='selected' {/if}   {if $deal_info.deal_city eq $city[i].city_id} selected='selected'{/if}>{$city[i].city_name}</option>
            {/section}
            </optgroup>
            </select>
            </div>
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=3}</span></a>
            <div class="clr"></div>
            
            <span><a href="javascript:void(0);" onclick="javascript:selectAllCity();">Select All</a> <strong>|</strong> <a  href="javascript:void(0);" onclick="javascript:unselectAllCity();">Unselect All</a></span> <strong>|</strong> (Ctrl + Mouse left key to select multiple)
            <div class="error" id="cityerror"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red"> *</span>Select Deal Currency:</label>
        <div class="fl">
                <select name="deal_currency" id="deal_currency"  class="textbox fl" onchange="javascript:setCurrency(this.value);">
                <option value="pound" {if $deal_info.deal_currency eq 'pound'} selected="selected" {/if}>Pound(&#163;)</option>
                <option value="euro" {if $deal_info.deal_currency eq 'euro'} selected="selected" {/if}>Euro(&#8364;)</option>
                <option value="dollar" {if $deal_info.deal_currency eq 'dollar'} selected="selected" {/if}>Dollar($)</option>
                </select>
                <a class="tooltip_css fl" href="javascript:void(0);">
                <span class="classic_css">{tooltip label_id=4}</span></a>
                <div class="clr"></div>
                <div class="error" id="deal_currency"></div>
            {*<!--
                <input type="radio" name="deal_currency" id="deal_currency_pound" value="pound" {if $deal_info.deal_currency eq 'pound'} checked="true" {/if} onclick="javascript:setCurrency(this.value);">&nbsp;&#163; &nbsp;&nbsp;
                <input type="radio" name="deal_currency" id="deal_currency_dollar" value="dollar"  {if $deal_info.deal_currency eq 'dollar'} checked="true" {/if} onclick="javascript:setCurrency(this.value);">&nbsp; $	
                -->*}
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red"> *</span>Select Deal Type:</label>
        <div class="fl">
            <select name="dealmaintype" id="dealmaintype" class="textbox fl" onchange="javascript:showHidePrices(this.value);" >
            <option value="">Select Deal Main Type</option>
            {section name=i loop=$deal}
            <option value="{$deal[i].typeid }" {if $deal_info.deal_main_type  eq $deal[i].typeid} selected='selected'{/if}>{$deal[i].dealtype}</option>
            {/section}
            </select>
            <input type="hidden" name="price_option" id="price_option" value="{$dealprice_option}">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=5}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="dealmaintype" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red">*</span> Select Category:</label>
        <div class="fl">
            {*<!--<input type="text" name="category" id="category" class="textbox" autocomplete="off" onblur="setCat(this.value)"/>-->*}
            <select name="maincategory" id="maincategory" class="textbox fl"
            onchange="javascript: getsubcat(this.value,'{$siteroot}');">
            {*<!--<select name="maincategory" id="maincategory" style="width:180px;" class="selectbox">-->*}
            
            <option value=""{if $dealcat.id neq ""} selected='selected'{/if}>--Select Main Category--</option>
            {section name=i loop=$category}
            <option value="{$category[i].id}" {if $deal_info.category eq $category[i].category} selected='selected'{/if}>{$category[i].category}</option>
            
            {/section}
            </select>
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=6}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="maincategory" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Sub Category: </label>
        <div class="fl">
            {*<!-- <input type="text" name="subcategory" id="subcategory" class="textbox" autocomplete="off" />-->*}
				<div id="city_div" class="fl">
                    <select name="subcategory" id="subcategory"  class="textbox fl" onchange="javascript: getsubsubcat(this.value);" >
                    <option value="">--Select Sub Category--</option>
                    {section name=i loop=$state_con}
                    <option value="{$state_con[i].id}"  {if $deal_info.deal_subcat eq $state_con[i].id} selected='selected'{/if} >{$state_con[i].category}</option>
                    {sectionelse}
                    
                    {/section}
                    </select>
                    </div>
                    <a class="tooltip_css fl" href="javascript:void(0);">
                    <span class="classic_css">{tooltip label_id=7}</span></a>
                    <div class="clr"></div>
                    <div class="error" htmlfor="subcategory" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        {*<!--/////////////////////start-->*}
        <li><label>Sub Sub Category:</label>
        <div class="fl">
           {*<!-- <input type="text" name="subcategory" id="subcategory" class="textbox" autocomplete="off" />-->*}
			<div id="sub_div" class="fl">
                <select name="subsubcategory" id="subsubcategory"  class="textbox fl" >
                <option value="">--Select Sub Sub-Category--</option>
                {section name=i loop=$state_sub}
                <option value="{$state_sub[i].id}"  {if $deal_info.deal_subsubcat eq $state_sub[i].id} selected='selected'{/if} >{$state_sub[i].category}</option>
                {sectionelse}
                
                {/section}
                </select>
                </div>
                <a class="tooltip_css fl" href="javascript:void(0);">
                <span class="classic_css">{tooltip label_id=8}</span></a>
                <div class="clr"></div>
                <div class="error" htmlfor="subsubcategory" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Sub Sub Sub Category:</label>
        <div class="fl">
            {*<!-- <input type="text" name="subcategory" id="subcategory" class="textbox" autocomplete="off" />-->*}
            <div id="subsub_div" class="fl">
            <select name="subsubsubcategory" id="subsubsubcategory"  class="textbox fl"  >
            <option value="">--Select SubSubSub-Category--</option>
            {section name=i loop=$state_subsub}
            <option value="{$state_subsub[i].id}"   {if $deal_info.deal_subsubsubcat eq $state_subsub[i].id} selected='selected'{/if}>{$state_subsub[i].category}</option>
            {sectionelse}
            
            {/section}
            </select>
            </div>
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=9}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="subsubsubcategory" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        {*<!--/////////////////////end-->*}
        
        <li><label><span class="red">*</span> Title:</label>
		<div class="fl">
			<input type="text" name="title1" class="textbox" id="title1" value="{$deal_info.title|stripslashes|html_entity_decode|strip_tags|trim}" maxlength="255" style="width:550px;">
		<div><div class="clr"></div>
		<font color="#999999" size="2">Please enter upto 255 characters.</font></div>
				{*<!--{$oFCKeditorTitle}-->*}
		<div class="clr"></div>
		<div class="error" htmlfor="title1" generated="true"></div>
        </div>
        <a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=10}</span></a>
        </li>
        
        <li><label><span class="red">*</span>Sub-Title:</label>
		<div class="fl">
			<input type="text" name="subtitle" class="textbox" id="subtitle" value="{$deal_info.subtitle|stripslashes|html_entity_decode|strip_tags|trim}" maxlength="255" style="width:550px;">
		<div><div class="clr"></div>
		<font color="#999999" size="2">Please enter upto 255 characters.</font></div>
				{*<!--{$oFCKeditorSubtitle}-->*}
		<div class="clr"></div>
		<div class="error" htmlfor="subtitle" generated="true"></div>
        </div>
        <a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=11}</span></a>
        </li>
        
        <li><label>Slogan:</label>
		<div class="fl">
			<input type="text" name="slogan" class="textbox" id="slogan" value="{$deal_info.slogan|stripslashes|html_entity_decode|strip_tags|trim}" maxlength="255" style="width:550px;">
		<div><div class="clr"></div>
		<font color="#999999" size="2">Please enter upto 255 characters.</font></div>
				{*<!--{$oFCKeditorSlogan}-->*}
        </div>
        <a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=12}</span></a>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red">*</span> Seller Account Number:</label>
        <div class="fl">
            <span style="float:left; margin-right:5px;">#</span><input type="text" name="seller_account_no" class="textbox fl" id="seller_account_no" value="{$deal_info.seller_account_no}" maxlength="20">
            <input type="hidden" name="seller_account_no_other" id="seller_account_no_other" value="{$deal_info.seller_account_no}" maxlength="20">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=13}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="seller_account_no" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red">*</span> Seller Name:</label>
        <div class="fl">
            <input type="text" name="deal_from_seller_name_other" class="textbox fl" id="deal_from_seller_name_other" value="{$deal_info.deal_from_seller_name_other}" maxlength="255">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=14}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="deal_from_seller_name_other" generated="true"></div>
            <div><font color="#999999" size="2">Please enter upto 255 characters.</font></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red">*</span> Seller Post Code:</label>
        <div class="fl">
            <input type="text" name="zipcode" class="textbox fl" id="zipcode" value="{$deal_info.seller_zipcode}" maxlength="255">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=16}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="zipcode" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red">*</span> {*<!--Description-->*}Key Features: </label>
        <div class="fl">
            <div class="fl">{$oFCKeditor}{*<!-- <textarea cols="60" rows="8" name="description" id="description">{$deal_info.description}</textarea>-->*}</div>
            <a class="tooltip_css fl" href="javascript:void(0);"> <span class="classic_css">{tooltip label_id=17}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red">*</span> Highlights: </label>
        <div class="fl">
            <div class="fl">{$oFCKeditor1} {*<!--<textarea cols="60" rows="8" name="highlight" id="highlight">{$deal_info.highlight}</textarea>-->*}</div>
            <a class="tooltip_css fl" href="javascript:void(0);"> <span class="classic_css">{tooltip label_id=18}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li style="display:none;"><label><span class="red">*</span> Delivery Charges <span id="span_dlcurr_delchargess">{if $deal_info.deal_currency eq 'pound'}&#163;{/if}{if $deal_info.deal_currency eq 'euro'}&#8364;{/if}{if $deal_info.deal_currency eq 'dolor'}${/if}</span>:</label>
        <div class="fl">
            <input type="text" name="sub_delivery_cost" class="textbox fl" id="sub_delivery_cost" value="{$deal_info.sub_delivery_cost}">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=19}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="sub_delivery_cost" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red">*</span> Delivery Charges <span id="span_dlcurr_delcharges">{if $deal_info.deal_currency eq 'pound'}&#163;{/if}{if $deal_info.deal_currency eq 'euro'}&#8364;{/if}{if $deal_info.deal_currency eq 'dolor'}${/if}</span>:</label>
        <div class="fl">
		<table border="1" cellpadding="5" cellspacing="1" style="border-width:3px; border-style:solid;" width="850px" class="fl">
			<tr>
				<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;" width="2%">Sr. No.</th>
				<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;" width="13%">Select / Deselect</th>
				<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;">Delivery Service Option Name</th>
				<th colspan="3">Delivery Charges</th>
			</tr>
			<tr>
				<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Pound (&#163;)</th>
				<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Euro (&#8364;)</th>
				<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Dollar ($)</th>
			</tr>
			{section name=i loop=$data_delivery_chr}
			<tr id="tr_{$smarty.section.i.iteration}">
				<th>{$smarty.section.i.iteration}</th>
				<td align="center">
					<input type="hidden" name="delivery_service_option_{$smarty.section.i.iteration}" id="delivery_service_option_{$smarty.section.i.iteration}" value="{$data_delivery_chr[i].value}">
					<input type="checkbox" name="delivery_service_option_chk_{$smarty.section.i.iteration}" id="delivery_service_option_chk_{$smarty.section.i.iteration}" onchange="onChkChange('{$smarty.section.i.iteration}')" {if $data_delivery_service_chr[i].is_selected eq 'yes'} checked="true" {elseif $data_delivery_service_chr[i].is_selected neq 'no' && $smarty.section.i.iteration eq '1'} checked="true" {/if}>
				</td>
				<td>{$data_delivery_chr[i].value}</td>
				<td align="center">
					{if $smarty.section.i.iteration == 1}
						<input type="hidden" name="delivery_charges_pound_{$smarty.section.i.iteration}" id="delivery_charges_pound_{$smarty.section.i.iteration}" value="0" class="textbox" maxlength="4" style="width:40px;"/>----
					{else}
						<input type="text" name="delivery_charges_pound_{$smarty.section.i.iteration}" id="delivery_charges_pound_{$smarty.section.i.iteration}" value="{$data_delivery_service_chr[i].delivery_charges_pound}" class="textbox" maxlength="4" style="width:40px;"/>
					{/if}
					<div style="clear:both;"></div>
					<div style="display:none;" htmlfor="delivery_charges_pound_{$smarty.section.i.iteration}" generated="true" class="error"></div>
				</td>
				<td align="center">
					{if $smarty.section.i.iteration == 1}
						<input type="hidden" name="delivery_charges_euro_{$smarty.section.i.iteration}" id="delivery_charges_euro_{$smarty.section.i.iteration}" value="0" class="textbox" maxlength="4" style="width:40px;"/>----
					{else}
						<input type="text" name="delivery_charges_euro_{$smarty.section.i.iteration}" id="delivery_charges_euro_{$smarty.section.i.iteration}" value="{$data_delivery_service_chr[i].delivery_charges_euro}" class="textbox" maxlength="4" style="width:40px;"/>
					{/if}
					<div style="clear:both;"></div>
					<div style="display:none;" htmlfor="delivery_charges_euro_{$smarty.section.i.iteration}" generated="true" class="error"></div>
				</td>
				<td align="center">
					{if $smarty.section.i.iteration == 1}
						<input type="hidden" name="delivery_charges_dollar_{$smarty.section.i.iteration}" id="delivery_charges_dollar_{$smarty.section.i.iteration}" value="0" class="textbox" maxlength="4" style="width:40px;"/>----
					{else}
						<input type="text" name="delivery_charges_dollar_{$smarty.section.i.iteration}" id="delivery_charges_dollar_{$smarty.section.i.iteration}" value="{$data_delivery_service_chr[i].delivery_charges_dollar}" class="textbox" maxlength="4" style="width:40px;"/>
					{/if}
					<div style="clear:both;"></div>
					<div style="display:none;" htmlfor="delivery_charges_dollar_{$smarty.section.i.iteration}" generated="true" class="error"></div>
				</td>
			</tr>
			{/section}
		</table>
			<a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=19}</span></a>
			<div style="clear:both;"></div>
			<input type="hidden" name="delivery_service_options" id="delivery_service_options" value=""/>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Seller Support Email: </label>
        <div class="fl">
            <input type="text" name="seller_support_email" class="textbox fl" id="seller_support_email" value="{$deal_info.seller_support_email}">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=20}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="seller_support_email" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Seller Support Email: </label>
        <div class="fl">
            <input type="text" name="seller_support_email" class="textbox fl" id="seller_support_email" value="{$deal_info.seller_support_email}">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=20}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="seller_support_email" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Tracking URL Code: </label>
        <div class="fl">
            <input type="text" name="trackURL" class="textbox fl" id="trackURL" value="{$deal_info.trackURL}">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=21}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="trackURL" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Delivered Tracking URL Code: </label>
        <div class="fl">
           <input type="text" name="delivered_tracking_url_code" class="textbox fl" id="delivered_tracking_url_code" value="{$deal_info.delivered_tracking_url_code}">
	       <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=22}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="delivered_tracking_url_code" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Refund Policy:  </label>
        <div class="fl">
          <div class="fl">{$oFCKeditorRefundPolicy}{*<!--<textarea cols="60" rows="8" name="refund_policy" id="refund_policy"></textarea>-->*} </div>
          <a class="tooltip_css fl" href="javascript:void(0);"> <span class="classic_css">{tooltip label_id=23}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red">*</span> Fine Print: </label>
        <div class="fl">
          <div class="fl">{$oFCKeditor2}{*<!--<textarea cols="60" rows="8" name="fineprint" id="fineprint">{$deal_info.fineprint}</textarea> -->*}</div>
          <a class="tooltip_css fl" href="javascript:void(0);"> <span class="classic_css">{tooltip label_id=24}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
         <li><label>QR Code (Link):  </label>
        <div class="fl">
          <input type="text" name="qr_code_link" class="textbox fl" id="qr_code_link" value="{$qrcode.value}" readonly="true">
	       <a href="{$qrcode.value}" style="float: left;margin-left:10px;padding-top:7px;" target="_blank"><strong>Live QR Code Link</strong></a>
	       <a class="tooltip_css fl" href="javascript:void(0);">
			<span class="classic_css">{tooltip label_id=25}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
         <li><label>Upload QR Code Image:</label>
        <div class="fl">
          {*<!--<textarea cols="60" rows="8" name="qr_code_image" id="qr_code_image" style="float:left;">{$deal_info.qr_code_image}</textarea>-->*}
	      <input type="file" id="qr_code_image" name="qr_code_image" value="{$deal_info.qr_code_image}" contenteditable="false" style="float: left;">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=26}</span></a><div class="clr"></div>
            {if $deal_info.qr_code_image}
            <img src="{$siteroot}/uploads/qr_code/51X50/{$deal_info.qr_code_image}" />
            {/if}
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Other Product/Services URL:</label>
        <div class="fl">
            <input type="text" name="otherproductURL" class="textbox fl" id="otherproductURL" value="{$deal_info.otherproductURL}">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=27}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="otherproductURL" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Address And Locations: </label>
        <div class="fl">
            <textarea cols="60" rows="8" name="addressandlocation" id="addressandlocation" class="textbox" style="width:400px;">{$deal_info.addressandlocation}</textarea> 
			<a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=28}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Video Link: </label>
        <div class="fl">
            <input type="text" name="videolink" id="videolink" value="{$deal_info.videolink}" class="textbox fl">
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=29}</span></a>
			<div class="clr"></div>
			<div><font color="#999999" size="2">You can paste "you tube" video URL here.</font></div>
			<div class="error" htmlfor="videolink" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label><span class="red">*</span> Upload Image:</label>
        <div class="fl">
            {*<!--<input type="button" name="add" id="add" value="Upload Image(s)" onclick="javascript:tb_show('Upload Image(s)', '{$siteroot}/modules/my-account/uploadmain.php?&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=720&modal=false', tb_pathToImage);">-->*}
            <input type="button" name="add" id="add" value="Upload Image(s)" onclick="javascript:tb_show('Upload Image(s)', '{$siteroot}/admin/seller/deal/uploadmain-admin.php?&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=720&modal=false', tb_pathToImage);" style="float:left;">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=30}</span></a>
            <div class="clr"></div>
            {section name=j loop=$deal_img}
            {if $deal_img[j]}
            <br/><img src="{$siteroot}/uploads/product/thumb76X64/{$deal_img[j]}" />
            &nbsp;&nbsp;<a href="javascript:void(0);" onclick="confirmDelete('{$deal_info.deal_unique_id}','{$deal_img[j]}');">Delete</a>&nbsp;&nbsp;
            {if $smarty.section.j.index neq 0}
            <a href="{$siteroot}/admin/seller/deal/edit_product.php?id={$deal_info.deal_unique_id}&mode=swap&order={$smarty.section.j.index}"/>Make it default image</a>
            {else}
            Default Image
            {/if}
            <br/>
            {/if}
            {/section}
        </div>
        <div class="clr"></div>
        </li>
        
        <li><div id="morefile"></div></li>
        
        <li><label>Comment:</label>
        <div class="fl">
            <textarea cols="60" rows="8" name="comments" class="textbox" style="width:400px;" id="comments">{$deal_info.comments}</textarea>
			 <a class="tooltip_css fl" href="javascript:void(0);"> <span class="classic_css">{tooltip label_id=31}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Retailer WebSite URL:</label>
        <div class="fl">
            <input type="text" name="retailerwebURL" class="textbox fl" id="retailerwebURL" value="{$deal_info.retailerwebURL}">
            <a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=32}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="retailerwebURL" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Retailer WebSite Affiliate Link:</label>
        <div class="fl">
            <input type="text" name="retailer_website_affiliate_link" 
	      class="textbox fl" id="retailer_website_affiliate_link" value="{$deal_info.retailer_website_affiliate_link}">
	       <a class="tooltip_css fl" href="javascript:void(0);">
			<span class="classic_css">{tooltip label_id=33}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li><label>Retailer WebSite Affiliate Code:</label>
        <div class="fl">
            <textarea cols="60" rows="8" name="retailer_website_affiliate_code"
		  class="textbox" style="width:400px;" id="retailer_website_affiliate_code">{$deal_info.retailer_website_affiliate_code}</textarea>
		<a class="tooltip_css fl" href="javascript:void(0);">
		<span class="classic_css">{tooltip label_id=34}</span></a>
		<div class="clr"></div>		
		<div><font size="2" color="#999999">Retailer website code to become an affiliate</font></div>
        </div>
        <div class="clr"></div>
        </li>
        
        
        <li id="usortdPrice" {if $deal_info.deal_main_type|in_array:$dealprice_option_array} style="display:none;" {/if}>
        <label><span class="red">*</span> Usortd Buy Price <span id="span_dlcurr_ubuyprice">{if $deal_info.deal_currency eq 'pound'}&#163;{/if}{if $deal_info.deal_currency eq 'euro'}&#8364;{/if}{if $deal_info.deal_currency eq 'dolor'}${/if}</span>: </label>
        <div class="fl">
            <input type="text" name="price" id="price" value="{$deal_info.groupbuy_price}" onchange="getEstiValue()" class="textbox fl" maxlength="7">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=35}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="price" generated="true"></div>
            {*<!--<div class="error" id="price" style="display:none;"></div>-->*}
        </div>
        <div class="clr"></div>
        </li>
        
        <li>
        <label><span class="red">*</span> Original Price <span id="span_dlcurr_actprice">{if $deal_info.deal_currency eq 'pound'}&#163;{/if}{if $deal_info.deal_currency eq 'euro'}&#8364;{/if}{if $deal_info.deal_currency eq 'dolor'}${/if}</span>: </label>
        <div class="fl">
			<input type="text" onchange="getPercentage(this.value),fill5column(this.value),clearAllBuyPrices()" name="originalprice" id="originalprice" value="{$deal_info.orignal_price}" class="textbox fl" maxlength="7">
			<a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=36}</span></a>
			<div class="clr"></div>
			<div class="error" id="originalprice" style="display:none;"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li id="cusSaving" {if $deal_info.deal_main_type|in_array:$dealprice_option_array} style="display:none;" {/if} >
        <label><span class="red">*</span> Customer Savings %: </label>
        <div class="fl">
           <input type="text" name="quantity" id="quantity" value="{$deal_info.quantity}"
			 class="textbox fl">
			<a class="tooltip_css fl" href="javascript:void(0);">
           <span class="classic_css">{tooltip label_id=70}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li id="minBuy" {if $deal_info.deal_main_type|in_array:$dealprice_option_array} style="display:none;" {/if}>
        <label><span class="red">*</span> Minimum Buyers Required: </label>
        <div class="fl">
            <input type="text" name="min_buyer" id="min_buyer" value="{$deal_info.min_buyer}" onchange="getEstiValue()" class="textbox fl" maxlength="3">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=38}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="min_buyer" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li id="maxBuy" {if $deal_info.deal_main_type|in_array:$dealprice_option_array} style="display:none;" {/if}>
        <label><span class="red">*</span> Maximum Number Of Buyers: </label>
        <div class="fl">
            <input type="text" name="max_buyer" id="max_buyer" value="{$deal_info.max_buyer}" class="textbox fl" maxlength="3">
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=39}</span></a>
            <div class="clr"></div>
            <div class="error" htmlfor="max_buyer" generated="true"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li id="groupBuyData" {if $deal_info.deal_main_type|in_array:$dealprice_option_array} {else} style="display:none;" {/if}>
        <label><span class="red">*</span> Prices on Buyer Range:</label>
        <div class="fl">
            <table border="1" width="100%" cellpadding="5">
					<tr align="center">
						<td width="10%">Check For Deal Drop</td>
						<td width="20%">Min Buyers</td>
						<td width="20%">Max Buyers</td>
						<td width="20%">Usortd Buy Price <span id="span_dlcurr_ubuyprice1">{if $deal_info.deal_currency eq 'pound'}&#163;{/if}{if $deal_info.deal_currency eq 'euro'}&#8364;{/if}{if $deal_info.deal_currency eq 'dolor'}${/if}</span></td>
						<td width="15%">Original Price <span id="span_dlcurr_actprice1">{if $deal_info.deal_currency eq 'pound'}&#163;{/if}{if $deal_info.deal_currency eq 'euro'}&#8364;{/if}{if $deal_info.deal_currency eq 'dolor'}${/if}</span></td>
						<td width="15%">Customer Savings %</td>
					</tr>
					<tr align="center">
						<td id="chk1">
							<input type="checkbox" name="chk_1" id="chk_1" checked="true" onclick="javascript:return false;"/>
						</td>
						<td id="min_buyer1">
							<input type="text" name="min_buyer_1" id="min_buyer_1" value="{$deal_info.min_buyer_1}" style="width:70px;"/>
						</td>
						<td>
							<input type="text" name="max_buyer_1" id="max_buyer_1" value="{$deal_info.max_buyer_1}" onchange="javascript:fillMin(this.value,'min_buyer2','min_buyer_2')" style="width:70px;"/>
						</td>
						<td>
							<input type="text" name="groupbuy_price_1" id="groupbuy_price_1" value="{$deal_info.buy_price_1}" onchange="javascript:getPercentageForGroupBuy(this.value,'cus_saving1','cus_saving_1')" style="width:70px;"/>
						</td>
						<td id="org_price1">{$deal_info.orignal_price}</td>
						<td id="cus_saving1">{$deal_info.discount_1}</td>
						<td style="display:none;">
							{*<!--<input type="hidden" name="min_buyer_1" id="min_buyer_1" value="{$deal_info.min_buyer_1}"/>-->*}
							<input type="hidden" name="org_price_1" id="org_price_1" value="{$deal_info.orignal_price}"/>
							<input type="hidden" name="cus_saving_1" id="cus_saving_1" value="{$deal_info.discount_1}"/>
						</td>
					</tr>
					<tr align="center">
						<td id="chk2">
							<input type="checkbox" name="chk_2" id="chk_2" onclick="javascript:chkUnchk(this)" {if $deal_info.range_2 eq 'true'} checked="true" {/if}/>
						</td>
						<td id="min_buyer2">
							<input type="text" name="min_buyer_2" id="min_buyer_2" value="{$deal_info.min_buyer_2}" style="width:70px; {if $deal_info.range_2 eq 'false'} display:none; {/if}"/>
							<div htmlfor="min_buyer_2" generated="true" class="error" style="display: none;"></div>
							<div class="min_buyer_2" {if $deal_info.range_2 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<input type="text" name="max_buyer_2" id="max_buyer_2" value="{$deal_info.max_buyer_2}" onchange="javascript:fillMin(this.value,'min_buyer3','min_buyer_3')" style="width:70px; {if $deal_info.range_2 eq 'false'} display:none; {/if}"/>
							<div htmlfor="max_buyer_2" generated="true" class="error" style="display: none;"></div>
							<div class="max_buyer_2" {if $deal_info.range_2 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<input type="text" name="groupbuy_price_2" id="groupbuy_price_2" value="{$deal_info.buy_price_2}" onchange="javascript:getPercentageForGroupBuy(this.value,'cus_saving2','cus_saving_2')" style="width:70px; {if $deal_info.range_2 eq 'false'} display:none; {/if}"/>
							<div htmlfor="groupbuy_price_2" generated="true" class="error" style="display: none;"></div>
							<div class="groupbuy_price_2" {if $deal_info.range_2 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<div id="org_price2" {if $deal_info.range_2 eq 'false'} style="display:none;" {/if}>{$deal_info.orignal_price}</div>
							<div id="org_price_disable2" {if $deal_info.range_2 eq 'true'} style="display:none;" {/if}>----</div>
						</td>
						<td>
							<div id="cus_saving2" {if $deal_info.range_2 eq 'false'} style="display:none;" {/if}>{$deal_info.discount_2}</div>
							<div id="cus_saving_disable2" {if $deal_info.range_2 eq 'true'} style="display:none;" {/if}>----</div>
						</td>
						<td style="display:none;">
							{*<!--<input type="hidden" name="min_buyer_2" id="min_buyer_2" value="{$deal_info.min_buyer_2}"/>-->*}
							<input type="hidden" name="org_price_2" id="org_price_2" value="{$deal_info.orignal_price}"/>
							<input type="hidden" name="cus_saving_2" id="cus_saving_2" value="{$deal_info.discount_2}"/>
						</td>
					</tr>
					<tr align="center">
						<td id="chk3">
							<input type="checkbox" name="chk_3" id="chk_3" onclick="javascript:chkUnchk(this)" {if $deal_info.range_3 eq 'true'} checked="true" {/if}/>
						</td>
						<td id="min_buyer3">
							<input type="text" name="min_buyer_3" id="min_buyer_3" value="{$deal_info.min_buyer_3}" style="width:70px; {if $deal_info.range_3 eq 'false'} display:none; {/if}"/>
							<div htmlfor="min_buyer_3" generated="true" class="error" style="display: none;"></div>
							<div class="min_buyer_3" {if $deal_info.range_3 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<input type="text" name="max_buyer_3" id="max_buyer_3" value="{$deal_info.max_buyer_3}" onchange="javascript:fillMin(this.value,'min_buyer4','min_buyer_4')" style="width:70px; {if $deal_info.range_3 eq 'false'} display:none; {/if}"/>
							<div htmlfor="max_buyer_3" generated="true" class="error" style="display: none;"></div>
							<div class="max_buyer_3" {if $deal_info.range_3 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<input type="text" name="groupbuy_price_3" id="groupbuy_price_3" value="{$deal_info.buy_price_3}" onchange="javascript:getPercentageForGroupBuy(this.value,'cus_saving3','cus_saving_3')" style="width:70px; {if $deal_info.range_3 eq 'false'} display:none; {/if}"/>
							<div htmlfor="groupbuy_price_3" generated="true" class="error" style="display: none;"></div>
							<div class="groupbuy_price_3" {if $deal_info.range_3 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<div id="org_price3" {if $deal_info.range_3 eq 'false'} style="display:none;" {/if}>{$deal_info.orignal_price}</div>
							<div id="org_price_disable3" {if $deal_info.range_3 eq 'true'} style="display:none;" {/if}>----</div>
						</td>
						<td>
							<div id="cus_saving3" {if $deal_info.range_3 eq 'false'} style="display:none;" {/if}>{$deal_info.discount_3}</div>
							<div id="cus_saving_disable3" {if $deal_info.range_3 eq 'true'} style="display:none;" {/if}>----</div>
						</td>
						<td style="display:none;">
							{*<!--<input type="hidden" name="min_buyer_3" id="min_buyer_3" value="{$deal_info.min_buyer_3}"/>-->*}
							<input type="hidden" name="org_price_3" id="org_price_3" value="{$deal_info.orignal_price}"/>
							<input type="hidden" name="cus_saving_3" id="cus_saving_3" value="{$deal_info.discount_3}"/>
						</td>
					</tr>
					<tr align="center">
						<td id="chk4">
							<input type="checkbox" name="chk_4" id="chk_4" onclick="javascript:chkUnchk(this)" {if $deal_info.range_4 eq 'true'} checked="true" {/if}/>
						</td>
						<td id="min_buyer4">
							<input type="text" name="min_buyer_4" id="min_buyer_4" value="{$deal_info.min_buyer_4}" style="width:70px; {if $deal_info.range_4 eq 'false'} display:none; {/if}"/>
							<div htmlfor="min_buyer_4" generated="true" class="error" style="display: none;"></div>
							<div class="min_buyer_4" {if $deal_info.range_4 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<input type="text" name="max_buyer_4" id="max_buyer_4" value="{$deal_info.max_buyer_4}" onchange="javascript:fillMin(this.value,'min_buyer5','min_buyer_5')" style="width:70px; {if $deal_info.range_4 eq 'false'} display:none; {/if}"/>
							<div htmlfor="max_buyer_4" generated="true" class="error" style="display: none;"></div>
							<div class="max_buyer_4" {if $deal_info.range_4 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<input type="text" name="groupbuy_price_4" id="groupbuy_price_4" value="{$deal_info.buy_price_4}" onchange="javascript:getPercentageForGroupBuy(this.value,'cus_saving4','cus_saving_4')" style="width:70px; {if $deal_info.range_4 eq 'false'} display:none; {/if}"/>
							<div htmlfor="groupbuy_price_4" generated="true" class="error" style="display: none;"></div>
							<div class="groupbuy_price_4" {if $deal_info.range_4 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<div id="org_price4" {if $deal_info.range_4 eq 'false'} style="display:none;" {/if}>{$deal_info.orignal_price}</div>
							<div id="org_price_disable4" {if $deal_info.range_4 eq 'true'} style="display:none;" {/if}>----</div>
						</td>
						<td>
							<div id="cus_saving4" {if $deal_info.range_4 eq 'false'} style="display:none;" {/if}>{$deal_info.discount_4}</div>
							<div id="cus_saving_disable4" {if $deal_info.range_4 eq 'true'} style="display:none;" {/if}>----</div>
						</td>
						<td style="display:none;">
							{*<!--<input type="hidden" name="min_buyer_4" id="min_buyer_4" value="{$deal_info.min_buyer_4}"/>-->*}
							<input type="hidden" name="org_price_4" id="org_price_4" value="{$deal_info.orignal_price}"/>
							<input type="hidden" name="cus_saving_4" id="cus_saving_4" value="{$deal_info.discount_4}"/>
						</td>
					</tr>
					<tr align="center">
						<td id="chk5">
							<input type="checkbox" name="chk_5" id="chk_5" onclick="javascript:chkUnchk(this)" {if $deal_info.range_5 eq 'true'} checked="true" {/if}/>
						</td>
						<td id="min_buyer5">
							<input type="text" name="min_buyer_5" id="min_buyer_5" value="{$deal_info.min_buyer_5}" style="width:70px; {if $deal_info.range_5 eq 'false'} display:none; {/if}"/>
							<div htmlfor="min_buyer_5" generated="true" class="error" style="display: none;"></div>
							<div class="min_buyer_5" {if $deal_info.range_5 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							{*<!--Above
							<input type="hidden" name="max_buyer_5" id="max_buyer_5" value="above" style="width:70px;"/>
							-->*}
							<input type="text" name="max_buyer_5" id="max_buyer_5" value="{$deal_info.max_buyer_5}" style="width:70px; {if $deal_info.range_5 eq 'false'} display:none; {/if}"/>
							<div htmlfor="max_buyer_5" generated="true" class="error" style="display: none;"></div>
							<div class="max_buyer_5" {if $deal_info.range_5 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<input type="text" name="groupbuy_price_5" id="groupbuy_price_5" value="{$deal_info.buy_price_5}" onchange="javascript:getPercentageForGroupBuy(this.value,'cus_saving5','cus_saving_5')" style="width:70px; {if $deal_info.range_5 eq 'false'} display:none; {/if}"/>
							<div htmlfor="groupbuy_price_5" generated="true" class="error" style="display: none;"></div>
							<div class="max_buyer_5" {if $deal_info.range_5 eq 'true'} style="display: none; {/if}">----</div>
						</td>
						<td>
							<div id="org_price5" {if $deal_info.range_5 eq 'false'} style="display:none;" {/if}>{$deal_info.orignal_price}</div>
							<div id="org_price_disable5" {if $deal_info.range_5 eq 'true'} style="display:none;" {/if}>----</div>
						</td>
						<td>
							<div id="cus_saving5" {if $deal_info.range_5 eq 'false'} style="display:none;" {/if}>{$deal_info.discount_5}</div>
							<div id="cus_saving_disable5" {if $deal_info.range_5 eq 'true'} style="display:none;" {/if}>----</div>
						</td>
						<td style="display:none;">
							{*<!--<input type="hidden" name="min_buyer_5" id="min_buyer_5" value="{$deal_info.min_buyer_5}"/>-->*}
							<input type="hidden" name="org_price_5" id="org_price_5" value="{$deal_info.orignal_price}"/>
							<input type="hidden" name="cus_saving_5" id="cus_saving_5" value="{$deal_info.discount_5}"/>
						</td>
					</tr>
				</table>
        </div>
        <a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=69}</span></a>
        <div class="clr"></div>
        </li>
        
         <li>
        <label><span class="red">*</span> Start Date:</label>
        <div class="fl">
            <span  style="float:left;">
            {if $start_date}
            <script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD','{$start_date}');</script>
            {else}
            <script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD');</script>
            {/if}</span>
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=40}</span></a>
            <div class="clr"></div>
            <div class="error" id="error_dealStartDate" style="display:none;"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li>
        <label><span class="red">*</span> Start Time: </label>
        <div class="fl">
            <span  style="float:left;">
            <select name="start_hour" id="start_hour">
            {section name=i loop=$hr}
            <option value="{$hr[i]}" {if $s_hr eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
            {/section}
            </select>&nbsp;&nbsp;&nbsp;
            <select name="start_min" id="start_min">
            {section name=i loop=$min}
            <option value="{$min[i]}" {if $s_min eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
            {/section}
            </select>
            </span>
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=41}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li>
        <label><span class="red">*</span> End Date:  </label>
        <div class="fl">
            <span  style="float:left;">
            {if $end_date}
            <script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD','{$end_date}');</script>
            {else}
            <script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD');</script>
            {/if}
            </span>
            <a class="tooltip_css fl" href="javascript:void(0);"> <span class="classic_css">{tooltip label_id=42}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li>
        <label><span class="red">*</span>End Time:   </label>
        <div class="fl">
            <span  style="float:left;">
            <select name="end_hour" id="end_hour">
            {section name=i loop=$rev_hr}
            <option value="{$rev_hr[i]}" {if $e_hr eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
            {/section}
            </select>&nbsp;&nbsp;&nbsp;
            <select name="end_min" id="end_min">
            {section name=i loop=$rev_min}
            <option value="{$rev_min[i]}" {if $e_min eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
            {/section}
            </select></span>
            <a class="tooltip_css fl" href="javascript:void(0);"> <span class="classic_css">{tooltip label_id=43}</span></a>
             <div class="clr"></div>
             <div class="error" id="error_dealEndDate" style="display:none;"></div>
            {*<!--<div id="err_date" style="display:none;"></div>-->*}
        </div>
        <div class="clr"></div>
        </li>
        
         <li>
        <label><span class="red">*</span>End Time:   </label>
        <div class="fl">
            <span  style="float:left;">
            <select name="end_hour" id="end_hour">
            {section name=i loop=$rev_hr}
            <option value="{$rev_hr[i]}" {if $e_hr eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
            {/section}
            </select>&nbsp;&nbsp;&nbsp;
            <select name="end_min" id="end_min">
            {section name=i loop=$rev_min}
            <option value="{$rev_min[i]}" {if $e_min eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
            {/section}
            </select></span>
            <a class="tooltip_css fl" href="javascript:void(0);"> <span class="classic_css">{tooltip label_id=43}</span></a>
             <div class="clr"></div>
            {*<!--<div id="err_date" style="display:none;"></div>-->*}
        </div>
        <div class="clr"></div>
        </li>
        
        <li id="validfrom">
        <label><span class="red">*</span> Valid from:</label>
        <div class="fl">
            <span  style="float:left;">
            {if $fromdates!="0000-00-00"}
            <script type="text/javascript">DateInput('validfrom', true, 'YYYY-MM-DD','{$fromdates}');</script>
            {else}
            <script type="text/javascript">DateInput('validfrom', true, 'YYYY-MM-DD');</script>
            {/if}
            </span>
            <a class="tooltip_css fl" href="javascript:void(0);">
            <span class="classic_css">{tooltip label_id=71}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li  id="validto">
        <label><span class="red">*</span> Valid to: </label>
        <div class="fl">
           <span  style="float:left;">
	      {if $todates!="0000-00-00"}
	      <script type="text/javascript">DateInput('validto', true, 'YYYY-MM-DD','{$todates}');</script>
	      {else}
	      <script type="text/javascript">DateInput('validto', true, 'YYYY-MM-DD');</script>
	      {/if}
	      </span>
		<a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=72}</span></a>
        <div class="clr"></div>
        <div class="error" id="error_toEndDate" style="display:none;"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li style="display:none;">
         <label><span class="red"></span> Ending Soon: </label>
        <div class="fl">
           <input type="radio" name="endingsoon" id="endingsoon" {if $deal_info.deal_ending=='yes' } checked="true" {/if} value="yes">Yes
          <input type="radio" name="endingsoon" id="endingsoon" value="no" {if $deal_info.deal_ending=='no' } checked="true" {/if}>No
        </div>
        <div class="clr"></div>
        
        </li>
        
        <li>
         <label>Voucher Text: </label>
        <div class="fl">
        <textarea cols="60" rows="8" name="free_voucher_text" id="free_voucher_text" class="textbox" style="width:400px;">{$deal_info.voucher_text}</textarea>
        <a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=44}</span></a>
        <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </li>
        
        <li>
         <label>How It Work Text: </label>
        <div class="fl">
        <div class="fl">
        {$oFCKeditorHowItWork}
        </div>
        <a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=73}</span></a>
        </div>
        <div class="clr"></div>
        </li>
        
        <li>
        <label>&nbsp;</label>
        <div class="fl btnmain" style="margin-right:15px"> 
        <input type="submit" value="Save" name="Submit" class="buybtn2" /> 
        </div>
         <div class="fl btnmain">
        <input type="button" value="Cancel" onclick="javascript: location='{if $smarty.get.back && $smarty.get.back eq 'up'}upcoming_deal.php{elseif $smarty.get.back &&  $smarty.get.back eq 'ex'}expired_deal.php{elseif $smarty.get.back && $smarty.get.back eq 'pend'}pending-deal.php{else}manage_deal.php{/if}';" class="buybtn2"/>
        </div>
        </li>
        
        
	</ul>
    </div>
	  
	</form>
{literal}
	<script language="JavaScript" type="text/javascript">
		showHideStateCity(document.getElementById('is_national').checked);
	</script>
{/literal}
</div>
</div></section>
</section>
{include file=$footer_seller}
