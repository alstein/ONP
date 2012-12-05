{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/add_deal.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script type="text/javascript" src="{$siteroot}/js/jquery.jSuggest.1.0.js"></script>
<!--<script type="text/javascript" src="{$siteroot}/js/validation/ajaxget_category.js"></script>-->
{/strip}

{literal}
<script language="JavaScript">
// JavaScript Document
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
/*
function getsubcat(str)
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
}*/
function state_value(){
    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
		document.getElementById('city_div').innerHTML=response;
	}
}
/*


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
 */

/*
function addit(optionid, pr){
    if((optionid == 1)|| (optionid == 2))
    {
        document.getElementById(optionid).checked=true;
    }

        var chk=document.getElementById(optionid).checked;
        if(chk == true){
        var final_value;
        var listing;

            document.getElementById("listing").value = parseInt(document.getElementById("listing").value) + parseInt(pr);
            $('#span1').html(document.getElementById("listing").value);
            //document.getElementById('span4').innerHTML =  parseInt(document.getElementById("listing").value)  + parseInt(document.getElementById("listing_t").value);

            if(document.getElementById("option_selected").value){
                document.getElementById("option_selected").value=document.getElementById("option_selected").value + "," + optionid;
            }
            else{
                document.getElementById("option_selected").value= optionid;
            }

            if(optionid == 6){ 
            document.getElementById("web").style.display=""; }
            if(optionid == 7)	{	 	
                document.getElementById("addr").style.display=""; 
                document.getElementById("li_city").style.display="";
            }
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
            {
                document.getElementById("addr").style.display="none";
                document.getElementById("li_city").style.display="none";
            }
        }
}*/

// function getSelleroptions(sId)
// {
//     var dtype = "";
//     if(document.getElementById('deal_type1').checked == true)
//     {
//         dtype = "service";
//     }
//     else
//     {
//         dtype = "product";
//     }
// 
//     var page = SITEROOT+"/admin/globalsettings/deal/get-seller-option.php?type="+dtype;
//     $.get(page,{sid:sId},function(data){$('#rep_s').html(data)});
// }


// var count=1;
// function addmore()
// {
//     if(count < 8)
//     {
//         var str = $('#morefile').html();
// 
//         str = str + "<tr><td colspan='2' align='left'><input type='file' name='dealimage[]' id='dealimage'></td>   </tr>";
//         $('#morefile').html(str);
//     }
//     else
//     {
//         alert("You can not upload more that 8 files.");
//     }
//     count++;
// }

function getEstiValue()
{
    var gbPrice = document.getElementById('price').value;
    var minBuy = document.getElementById('min_buyer').value;
    if(((minBuy != "") && !isNaN(minBuy)) && (gbPrice != "") && !isNaN(gbPrice))
    {
        var finalFee = parseFloat(minBuy) * parseFloat(gbPrice);
        var page = SITEROOT+"/my-account/getfinalvalue/";
        $.get(page,{finalfee:finalFee},function(data){ $('#span3').html(data); $('#final_value').val(data)});
    }
    else
    {
        $('#span3').html("xxxx"); $('#final_value').val(0);
    }
}

function getPercentage(orgPrice)
{
	var gbPrice = document.getElementById('price').value;
	var saving = parseFloat(orgPrice) - parseFloat(gbPrice);	
	var percentage = ((parseFloat(saving) * 100) / parseFloat(orgPrice));
	percentage=Math.round(percentage);
	document.getElementById('quantity').value = percentage.toFixed(0);
}

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

// function clearAllBuyPrices()
// {
// 	$('#groupbuy_price_1').val('');
// 	$('#cus_saving1').html('');
// 	$('#cus_saving_1').val('');
// 
// 	$('#groupbuy_price_2').val('');
// 	$('#cus_saving2').html('');
// 	$('#cus_saving_2').val('');
// 
// 	$('#groupbuy_price_3').val('');
// 	$('#cus_saving3').html('');
// 	$('#cus_saving_3').val('');
// 
// 	$('#groupbuy_price_4').val('');
// 	$('#cus_saving4').html('');
// 	$('#cus_saving_4').val('');
// 
// 	$('#groupbuy_price_5').val('');
// 	$('#cus_saving5').html('');
// 	$('#cus_saving_5').val('');
// }

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
			$("#cus_saving"+(i)).html("");
			$("#cus_saving_"+(i)).val("");

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

// function setCat(cat)
// {
//     var page = SITEROOT+"/my-account/ajaxset_main_cat/";
//     $.get(page,{cat:cat},function(data){ });
// }

function tbl_show_func(catId1, catId2, catId3, catId4)
{
 	tb_show('Upload Image(s)', SITEROOT+"/admin/globalsettings/deal/uploadmain-admin.php?catId1="+catId1+"&catId2="+catId2+"&catId3="+catId3+"&catId4="+catId4+"&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=720&modal=false", tb_pathToImage);
}
</script>
{/literal}

{literal}
<script language="JavaScript">
	$(document).ready(function()
{

$('#frm').submit(function(){
                    if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#Submit').hide(); 
                $('#buttonregister').append("<input type='button' name='Submit' id='Submit' value='Create and Send Deal' />"); 
            }
        });
});

function add_rows(id)
{

	if(id<5)
	{
		var id1=id;
		id++;
		$.get(SITEROOT+"/admin/globalsettings/deal/tr_repeat.php?id="+id,function(data){
		$("input#i").val(id);
		$("#rept_data_"+id1).after("<tr id="+id+">"+data);
		id++;
  		})
	}
}


</script>
{/literal}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Add Deal</div><br/>

<div class="breadcrumb">
	<h3 class="fl width20" style="color:black;">&nbsp;&nbsp; {if $smarty.get.id}Edit{else}Add{/if} Deal</h3><br/>
	<span class="fr"><a href="manage_deal.php"><strong>Back</strong></a></span>
</div>
<div class="holdthisTop">
{if $msg}<br/><div align="center">{$msg}</div>{/if}

    <form action="" method="post" name='frm' id="frm" enctype="multipart/form-data">
    <input type="hidden" id="final_value" name="final_value" value="0" />
    <input type="hidden" id="listing" name="listing" value="0" />
    <input type="hidden" id="option_selected" value="" name="option_selected">
    {if $errormsg}<div align="center">{$errormsg}</div>{/if}
    <table width="90%" cellspacing="5" cellpadding="5">
	  <col width="30%">
	  <col width="70%">
	  <tr>
	      <td colspan="3">Fields marked<span class="red"> *</span> are required</td>
	  </tr>

	  <tr>
	     <td align="right" valign="top"><span class="red"> *</span>Select Deal Currency:</td>
	     <td>
			<select name="deal_currency" id="deal_currency" style="width: 225px;" class="selectbox fl" >
				<option value="pound">Pound(&#163;)</option>
				<option value="euro">Euro(&#8364;)</option>
				<option value="dollar">Dollar($)</option>
			</select>
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=4}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" id="deal_currency"></div>
	     </td>
	</tr>


	<tr>
		<td align="right" valign="top"><span class="red">*</span> Deal country or countries: </td>
		<td colspan="2" align="left">
			<select name="dealcountry[]" id="dealcountry_1" style="width:180px;" class="selectbox fl"  onchange="javascript:fillStates(this,1);">
				<optgroup label="--Select Deal Countries--">
				{section name=i loop=$country}
				<option value="{$country[i].countryid}">{$country[i].country}</option>
				{/section}
			</select>&nbsp;&nbsp;
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=1}</span></a>
                                             <div class="clr"></div>
			<!--<span><a href="javascript:void(0);" onclick="javascript:selectAllCountry(getElementById('dealcountry'));">Select All</a> <strong>|</strong> <a  href="javascript:void(0);" onclick="javascript:unselectAllCountry(getElementById('dealcountry'));">Unselect All</a></span> <strong>|</strong> (Ctrl + Mouse left key to select multiple)-->
			
			<div class="error" id="countryerror"></div>
		</td>
	</tr>

	<tr id="div_stateDD_hideshow">
		<td align="right" valign="top"><span class="red" style="display:none;">*</span> Deal Counties / States: </td>
		<td colspan="2" align="left">
			<div id="state_1" style="width:180px" class="fl">
				<select name="dealstate[]" id="dealstate_1" style="width:100%;" class="selectbox fl" onchange="javascript:fillCities(this,1);">
					<optgroup label="--Select Deal States--">
						{*section name=i loop=$state}
							<option value="{$state[i].id}">{$state[i].state_name}</option>
						{/section*}
					</optgroup>
				</select>&nbsp;&nbsp;
			</div>
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=2}</span></a>
                                             <div class="clr"></div>
			<!--<span><a href="javascript:void(0);" onclick="javascript:selectAllState(getElementById('dealstate'));">Select All</a> <strong>|</strong> <a  href="javascript:void(0);" onclick="javascript:unselectAllState(getElementById('dealstate'));">Unselect All</a></span> <strong>|</strong> (Ctrl + Mouse left key to select multiple)-->
			<div class="error" id="stateerror"></div>
		</td>
	</tr>
	<tr id="div_cityDD_hideshow">
		<td align="right" valign="top"><span class="red" style="display:none;">*</span> Deal Cities / Towns: </td>
		<td colspan="2" align="left">
			<div id="city_1" style="width:180px" class="fl">
				<select name="dealcity[]" id="dealcity_1" style="width:100%;" class="selectbox fl" >
					<optgroup label="--Select Deal Cities--">
						{*section name=i loop=$city}
							<option value="{$city[i].city_id}">{$city[i].city_name}</option>
						{/section*}
					</optgroup>
				</select>&nbsp;&nbsp;
			</div>
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=3}</span></a>
                                             <div class="clr"></div>
			<!--<span><a href="javascript:void(0);" onclick="javascript:selectAllCity();">Select All</a> <strong>|</strong> <a  href="javascript:void(0);" onclick="javascript:unselectAllCity();">Unselect All</a></span> <strong>|</strong> (Ctrl + Mouse left key to select multiple)-->
			<div class="error" id="cityerror"></div>
		</td>
	</tr>
	<tr id="div_cityDD_hideshow">
		<td align="right" valign="top"><span class="red" style="display:none;">*</span> Deal Discount: </td>
		<td colspan="2" align="left">
			<input type="text" name="deal_discount[]" id="deal_discount_1" >
		</td>
	</tr>
<tr id="rept_data_1"></tr>
								
	<tr id="div_cityDD_hideshow">
		<td align="right" valign="top"> </td>
		<td colspan="2" align="left">
		<a href="javascript:void(0);" onclick="javascript:add_rows($('#i').val());" ><strong> Add More</strong> </a>
<!--<input type="hidden" name="itemid" id="itemid" value="<?=$_GET['itemid'];?>">
<input type="hidden" name="tbl_id" id="tbl_id" value="<?=$_GET['tblid'];?>">-->
<input type="hidden" name="i" id="i" value="1"><input type="hidden" name="txt_id" id="txt_id" value=""><input type="hidden" name="txt_id1" id="txt_id1" value="">
		</td>
	</tr>


	<tr>
		<td align="right" valign="top"><span class="red">*</span> Title: </td>
		<td align="left">

			<input type="text" name="title1" id="title1" value="">
               </td>
		<td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=10}</span></a></td>
	</tr>


	  <tr>
	      <td align="right" valign="top"><span class="red">*</span> <!--Description--><!--Key Features--> Description: </td>
	      <td  align="left">{$oFCKeditor} <!--<textarea cols="60" rows="8" name="description" id="description"></textarea>--></td>
	      <td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=17}</span></a></td>
	  </tr>

	  <tr>
	      <td align="right" valign="top"><span class="red">*</span> <!--Description--><!--Key Features--> Why Buy: </td>
	      <td  align="left">{$oFCKeditorwhybuy} <!--<textarea cols="60" rows="8" name="description" id="description"></textarea>--></td>
	      <td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=17}</span></a></td>
	  </tr>

	  <tr>
	      <td align="right" valign="top"><span class="red">*</span> Seller Account Number: </td>
	      <td colspan="2" align="left"><span  style="float:left;">#</span><input type="text" name="seller_account_no" class="textbox fl" id="seller_account_no" value="{$sellerAccNo}" maxlength="20">
		<input type="hidden" name="seller_account_no_other" id="seller_account_no_other" value="{$sellerAccNo}" maxlength="20">
		
		<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=13}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="seller_account_no" generated="true"></div>
		
	      </td>
	  </tr>
	  <tr>
	      <td align="right" valign="top"><span class="red">*</span> Seller Name: </td>
	      <td colspan="2" align="left">
		<select name="deal_from_seller_name" id="deal_from_seller_name"  class="selectbox fl" style="width:225px;"  >
			<option value="">--Select Seller--</option>
			{section name=i loop=$sellerList}
				<option value="{$sellerList[i].userid}">{$sellerList[i].first_name} {$sellerList[i].last_name}</option>
			{/section}
			
		</select>
		<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=14}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="deal_from_seller_name" generated="true"></div>
		


	      </td>
	  </tr>

	  <tr>
	      <td align="right" valign="top"><span class="red">*</span>Seller Post Code : </td>
	      <td colspan="2" align="left"><input type="text" name="zipcode" class="textbox fl" id="zipcode" value="">
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=16}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="zipcode" generated="true"></div>
	      </td>
	  </tr>

<!--	<tr>
		<td align="right" valign="top"><span class="red">*</span>Key Features: </td>
		<td  align="left">
			
			{$oFCKeditorSubtitle}	
		</td>
		<td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=11}</span></a></td>
	</tr>
-->

	  <tr>
	      <td align="right" valign="top"><span class="red">*</span> <!--Highlights-->Terms and Conditions: </td>
	      <td  align="left">{$oFCKeditor1}<!-- <textarea cols="60" rows="8" name="highlight" id="highlight"></textarea>--></td>
	      <td valign="top"><a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=18}</span></a></td>
	  </tr>



	  <tr>
	      <td align="right" valign="top"> Seller Support Email: </td>
	      <td colspan="2" align="left"><input type="text" name="seller_support_email" class="textbox fl" id="seller_support_email" value="">
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=20}</span></a>
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="seller_support_email" generated="true"></div>
	      </td>
	  </tr>

	  <tr>
	      <td align="right" valign="top"> Tracking URL Code: </td>
	      <td colspan="2" align="left"><input type="text" name="trackURL" class="textbox fl" id="trackURL" value="">
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=21}</span></a>
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="trackURL" generated="true"></div>
	      </td>
	  </tr>

	  <tr>
	      <td align="right" valign="top"> Delivered Tracking URL Code: </td>
	      <td colspan="2" align="left"><input type="text" name="delivered_tracking_url_code" class="textbox fl" id="delivered_tracking_url_code" value="">
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
	      <td colspan="2" align="left"><input type="text" name="otherproductURL" class="textbox fl" id="otherproductURL" value="">
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=27}</span></a>
                                             <div class="clr"></div>
                                            <div class="error" htmlfor="otherproductURL" generated="true"></div>
	      </td>
	  </tr>

	  <tr>
	      <td align="right" valign="top"> Address And Locations: </td>
	      <td  align="left"><textarea cols="60" rows="8" name="addressandlocation" id="addressandlocation" style="float: left;"></textarea> <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=28}</span></a></td>
	  </tr>

	  <tr>
	      <td align="right" valign="top"> Upload Image: </td>
	     
		<td  align="left">
		<!--<input type="button" name="add" id="add" value="Upload Image(s)" onclick="javascript:tb_show('Upload Image(s)', '{$siteroot}/modules/my-account/uploadmain.php?&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=720&modal=false', tb_pathToImage);">-->
		<input type="button" style="float: left;" name="add" id="add" value="Upload Image(s)" onclick="javascript:tbl_show_func($('#maincategory').val(),$('#subcategory').val(),$('#subsubcategory').val(),$('#subsubsubcategory').val());">
		<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=30}</span></a></td>
	  </tr>
	  <tr><td></td><td colspan="2"><div id="morefile"></div></td></tr>

<!--	  <tr>
	      <td align="right" valign="top"> Comment: </td>
	      <td  align="left"><textarea cols="60" rows="8" name="comments" id="comments" style="float: left;"></textarea>
	       <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=31}</span></a></td>
	  </tr>-->
	  <tr id="usortdPrice">
	    <td align="right" valign="top"><span class="red">*</span> Buy Price <span id="span_dlcurr_ubuyprice">&#163;</span>: </td>
	    <td colspan="2" align="left"><input type="text" name="price" id="price" value="" class="textbox fl" onchange="getEstiValue();" maxlength="7">
	    <a class="tooltip_css fl" href="javascript:void(0);" id="up">
                    <span class="classic_css" >{tooltip label_id=35}</span></a>
                        <div class="clr"></div>
                    <div class="error" htmlfor="price" generated="true"></div>
                    <!--  <div class="error" id="error_usortprice" style="display:none;"></div>-->
	    </td>
	  </tr>
	  <tr>
	    <td align="right" valign="top"><span class="red">*</span> Original Price <span id="span_dlcurr_actprice">&#163;</span>: </td>
	    <td colspan="2" align="left"><input type="text" name="originalprice" id="originalprice" value="" class="textbox fl" onchange="getPercentage(this.value)" maxlength="7">
	    <a class="tooltip_css fl" href="javascript:void(0);">
                    <span class="classic_css">{tooltip label_id=36}</span></a>
                        <div class="clr"></div>
                        <div class="error" htmlfor="originalprice" generated="true"></div>
                        <!--<div class="error" id="error_originalprice" style="display:none;"></div>-->
	    </td>
	  </tr>

	  <tr id="cusSaving">
	    <td align="right" valign="top"> Customer Savings %: </td>
	    <td colspan="2" align="left"><input type="text" name="quantity" id="quantity" 
                class="textbox fl" style="background:#D4D0C8">
                <a class="tooltip_css fl" href="javascript:void(0);" id="cs">
                    <span class="classic_css">{tooltip label_id=70}</span></a>
            </td>
	  </tr>

	  <tr id="minBuy">
	    <td align="right" valign="top"><span class="red">*</span> Minimum Purchases  Required: </td>
	    <td colspan="2" align="left"><input type="text" name="min_buyer" id="min_buyer"
                class="textbox fl" onchange="getEstiValue();" maxlength="3">
                <a class="tooltip_css fl" href="javascript:void(0);" id="mbr">
                    <span class="classic_css">{tooltip label_id=38}</span></a>
                        <div class="clr"></div>
                        <div class="error" htmlfor="min_buyer" generated="true"></div>
	    </td>
	  </tr>

	  <tr id="maxBuy">
	    <td align="right" valign="top"><span class="red">*</span> Maximum Number of Purchases: </td>
	    <td colspan="2" align="left"><input type="text" name="max_buyer" id="max_buyer" class="textbox fl" maxlength="3">
	    <a class="tooltip_css fl" href="javascript:void(0);" id="mnob">
                <span class="classic_css">{tooltip label_id=39}</span></a>
                    <div class="clr"></div>
                    <div class="error" htmlfor="max_buyer" generated="true"></div>
	    </td>
	  </tr>

	<tr id="groupBuyData" style="display:none;">
		<td align="right" valign="top"><span class="red">*</span> Prices on Buyer Range: </td>
		<td colspan="1" align="left">
			<table border="1" width="100%" cellpadding="5">
				<tr align="center">
					<td width="10%">Check For Deal Drop</td>
					<td width="20%">Min Buyers</td>
					<td width="20%">Max Buyers</td>
					<td width="20%">Usortd Buy Price <span id="span_dlcurr_ubuyprice1">&#163;</span></td>
					<td width="15%">Original Price <span id="span_dlcurr_actprice1">&#163;</span></td>
					<td width="15%">Customer Savings %</td>
				</tr>
				<tr align="center">
					<td id="chk1">
						<input type="checkbox" name="chk_1" id="chk_1" checked="true" onclick="javascript:return false;"/>
					</td>
					<td id="min_buyer1">
						<input type="text" name="min_buyer_1" id="min_buyer_1" value="1" style="width:70px;"/>
					</td>
					<td>
						<input type="text" name="max_buyer_1" id="max_buyer_1" value="" onchange="javascript:fillMin(this.value,'min_buyer2','min_buyer_2')" style="width:70px;"/>
					</td>
					<td>
						<input type="text" name="groupbuy_price_1" id="groupbuy_price_1" onchange="javascript:getPercentageForGroupBuy(this.value,'cus_saving1','cus_saving_1')" style="width:70px;"/>
					</td>
					<td id="org_price1">&nbsp;</td>
					<td id="cus_saving1">&nbsp;</td>
					<td style="display:none;">
						<!--<input type="hidden" name="min_buyer_1" id="min_buyer_1" value="1"/>-->
						<input type="hidden" name="org_price_1" id="org_price_1" value=""/>
						<input type="hidden" name="cus_saving_1" id="cus_saving_1" value=""/>
					</td>
				</tr>
				<tr align="center">
					<td id="chk2">
						<input type="checkbox" name="chk_2" id="chk_2" onclick="javascript:chkUnchk(this)"/>
					</td>
					<td id="min_buyer2">
						<input type="text" name="min_buyer_2" id="min_buyer_2" value="" style="width:70px; display:none;"/>
						<div htmlfor="min_buyer_2" generated="true" class="error" style="display: none;"></div>
						<div class="min_buyer_2" style="display: block;">----</div>
					</td>
					<td>
						<input type="text" name="max_buyer_2" id="max_buyer_2" value="" onchange="javascript:fillMin(this.value,'min_buyer3','min_buyer_3')" style="width:70px; display:none;"/>
						<div htmlfor="max_buyer_2" generated="true" class="error" style="display: none;"></div>
						<div class="max_buyer_2" style="display: block;">----</div>
					</td>
					<td>
						<input type="text" name="groupbuy_price_2" id="groupbuy_price_2" onchange="javascript:getPercentageForGroupBuy(this.value,'cus_saving2','cus_saving_2')" style="width:70px; display:none;"/>
						<div htmlfor="groupbuy_price_2" generated="true" class="error" style="display: none;"></div>
						<div class="groupbuy_price_2" style="display: block;">----</div>
					</td>
					<td>
						<div id="org_price2" style="display:none;">&nbsp;</div>
						<div id="org_price_disable2">----</div>
					</td>
					<td>
						<div id="cus_saving2" style="display:none;">&nbsp;</div>
						<div id="cus_saving_disable2">----</div>
					</td>
					<td style="display:none;">
						<!--<input type="hidden" name="min_buyer_2" id="min_buyer_2" value="0"/>-->
						<input type="hidden" name="org_price_2" id="org_price_2" value=""/>
						<input type="hidden" name="cus_saving_2" id="cus_saving_2" value=""/>
					</td>
				</tr>
				<tr align="center">
					<td id="chk3">
						<input type="checkbox" name="chk_3" id="chk_3" onclick="javascript:chkUnchk(this)"/>
					</td>
					<td id="min_buyer3">
						<input type="text" name="min_buyer_3" id="min_buyer_3" value="" style="width:70px; display:none;"/>
						<div htmlfor="min_buyer_3" generated="true" class="error" style="display: none;"></div>
						<div class="min_buyer_3" style="display: block;">----</div>
					</td>
					<td>
						<input type="text" name="max_buyer_3" id="max_buyer_3" value="" onchange="javascript:fillMin(this.value,'min_buyer4','min_buyer_4')" style="width:70px; display:none;"/>
						<div htmlfor="max_buyer_3" generated="true" class="error" style="display: none;"></div>
						<div class="max_buyer_3" style="display: block;">----</div>
					</td>
					<td>
						<input type="text" name="groupbuy_price_3" id="groupbuy_price_3" onchange="javascript:getPercentageForGroupBuy(this.value,'cus_saving3','cus_saving_3')" style="width:70px; display:none;"/>
						<div htmlfor="groupbuy_price_3" generated="true" class="error" style="display: none;"></div>
						<div class="groupbuy_price_3" style="display: block;">----</div>
					</td>
					<td>
						<div id="org_price3" style="display:none;">&nbsp;</div>
						<div id="org_price_disable3">----</div>
					</td>
					<td>
						<div id="cus_saving3" style="display:none;">&nbsp;</div>
						<div id="cus_saving_disable3">----</div>
					</td>
					<td style="display:none;">
						<!--<input type="hidden" name="min_buyer_3" id="min_buyer_3" value="0"/>-->
						<input type="hidden" name="org_price_3" id="org_price_3" value=""/>
						<input type="hidden" name="cus_saving_3" id="cus_saving_3" value=""/>
					</td>
				</tr>
				<tr align="center">
					<td id="chk4">
						<input type="checkbox" name="chk_4" id="chk_4" onclick="javascript:chkUnchk(this)"/>
					</td>
					<td id="min_buyer4">
						<input type="text" name="min_buyer_4" id="min_buyer_4" value="" style="width:70px; display:none;"/>
						<div htmlfor="min_buyer_4" generated="true" class="error" style="display: none;"></div>
						<div class="min_buyer_4" style="display: block;">----</div>
					</td>
					<td>
						<input type="text" name="max_buyer_4" id="max_buyer_4" value="" onchange="javascript:fillMin(this.value,'min_buyer5','min_buyer_5')" style="width:70px; display:none;"/>
						<div htmlfor="max_buyer_4" generated="true" class="error" style="display: none;"></div>
						<div class="max_buyer_4" style="display: block;">----</div>
					</td>
					<td>
						<input type="text" name="groupbuy_price_4" id="groupbuy_price_4" onchange="javascript:getPercentageForGroupBuy(this.value,'cus_saving4','cus_saving_4')" style="width:70px; display:none;"/>
						<div htmlfor="groupbuy_price_4" generated="true" class="error" style="display: none;"></div>
						<div class="groupbuy_price_4" style="display: block;">----</div>
					</td>
					<td>
						<div id="org_price4" style="display:none;">&nbsp;</div>
						<div id="org_price_disable4">----</div>
					</td>
					<td>
						<div id="cus_saving4" style="display:none;">&nbsp;</div>
						<div id="cus_saving_disable4">----</div>
					</td>
					<td style="display:none;">
						<!--<input type="hidden" name="min_buyer_4" id="min_buyer_4" value="0"/>-->
						<input type="hidden" name="org_price_4" id="org_price_4" value=""/>
						<input type="hidden" name="cus_saving_4" id="cus_saving_4" value=""/>
					</td>
				</tr>
				<tr align="center">
					<td id="chk5">
						<input type="checkbox" name="chk_5" id="chk_5" onclick="javascript:chkUnchk(this)"/>
					</td>
					<td id="min_buyer5">
						<input type="text" name="min_buyer_5" id="min_buyer_5" value="" style="width:70px; display:none;"/>
						<div htmlfor="min_buyer_5" generated="true" class="error" style="display: none;"></div>
						<div class="min_buyer_5" style="display: block;">----</div>
					</td>
					<td>
						<!--
						Above
						<input type="hidden" name="max_buyer_5" id="max_buyer_5" value="above" style="width:70px;"/>
						-->
						<input type="text" name="max_buyer_5" id="max_buyer_5" value="" style="width:70px; display:none;"/>
						<div htmlfor="max_buyer_5" generated="true" class="error" style="display: none;"></div>
						<div class="max_buyer_5" style="display: block;">----</div>
					</td>
					<td>
						<input type="text" name="groupbuy_price_5" id="groupbuy_price_5" onchange="javascript:getPercentageForGroupBuy(this.value,'cus_saving5','cus_saving_5')" style="width:70px; display:none;"/>
						<div htmlfor="groupbuy_price_5" generated="true" class="error" style="display: none;"></div>
						<div class="groupbuy_price_5" style="display: block;">----</div>
					</td>
					<td>
						<div id="org_price5" style="display:none;">&nbsp;</div>
						<div id="org_price_disable5">----</div>
					</td>
					<td>
						<div id="cus_saving5" style="display:none;">&nbsp;</div>
						<div id="cus_saving_disable5">----</div>
					</td>
					<td style="display:none;">
						<!--<input type="hidden" name="min_buyer_5" id="min_buyer_5" value="0"/>-->
						<input type="hidden" name="org_price_5" id="org_price_5" value=""/>
						<input type="hidden" name="cus_saving_5" id="cus_saving_5" value=""/>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
	                                   <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=69}</span></a></td>
		
	</tr>




	  <tr height="25">
	    <td valign="top" align="right"><span class="red">*</span> Redeem From: </td>
	    <td align="left" valign="top" style="float:left;"><span  style="float:left;">
	      {if $start_date}
	      <script type="text/javascript">DateInput('redeemfrom', true, 'YYYY-MM-DD','{$start_date}');</script>
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
	      {if $start_date}
	      <script type="text/javascript">DateInput('redeemto', true, 'YYYY-MM-DD','{$start_date}');</script>
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


			<tr height="25"  style="display:none;" id="tr3">
				<td colspan="2"><div id="error_RedeemFromDate1" class="error" style="display:none;padding-left:200px;">Redeem From date should be greater than or equal to Redeem To date</div></td>
			</tr>
	










	  <tr height="25">
	    <td valign="top" align="right"><span class="red">*</span> Start Date: </td>
	    <td align="left" valign="top" style="float:left;"><span  style="float:left;">
	      {if $start_date}
	      <script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD','{$start_date}');</script>
	      {else}
	      <script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD');</script>
	      {/if}</span>
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=40}</span></a>
                                             <div class="clr"></div>
                                            <!-- <div class="error" htmlfor="max_buyer" generated="true"></div>-->
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
	      <td colspan="2" align="left" valign="top" ><span  style="float:left;">
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
	    <td valign="top" align="right"><span class="red">*</span> End Time: </td>
	    <td align="left" valign="top" style="float:left;"><span  style="float:left;">
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
	      <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=43}</span></a>
                                             <div class="clr"></div>
	    </td>
	</tr>
	
			<tr height="25"  style="display:none;" id="tr1">
				<td colspan="2"><div id="error_EndDate1" class="error" style="display:none;padding-left:200px;">End Date/Time should be greater than or equal to Start Date/Time</div></td>
			</tr>
	
 
	<!--<tr height="25" id="validfrom">
		<td valign="top" align="right" id="validfrom" ><span class="red">*</span> Valid from: </td>
		<td align="left" valign="top"><span  style="float:left;">
			{if $start_date}
				<script type="text/javascript">DateInput('validfrom', true, 'YYYY-MM-DD','{$start_date}');</script>
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
	    <td align="left" valign="top" ><span  style="float:left;">
	      {if $start_date}
	      <script type="text/javascript">DateInput('validto', true, 'YYYY-MM-DD','{$start_date}');</script>
	      {else}
	      <script type="text/javascript">DateInput('validto', true, 'YYYY-MM-DD');</script>
	      {/if}
	      </span>
		<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=72}</span></a>
	    </td>
	  </tr>-->
	 <!-- <tr height="25" id="tr4" style="display:none;">
	    <td valign="top" align="right">&nbsp;</td>
	    <td align="left" valign="top"><div class="error" id="error_toEndDate" style="display:none;"></div></td>
	</tr>-->
	   <tr>
	      <td align="right" valign="top">Voucher Text: </td>
	      <td colspan="2" align="left">
		<textarea cols="60" rows="8" name="free_voucher_text" id="free_voucher_text" style="float:left;"></textarea>
		<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=44}</span></a>
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
			<input type="checkbox" name="only_fans" id="only_fans" value="Only Fans">Only Fans<input type="checkbox" name="all_who_choose_category" id="all_who_choose_category" value="All who choose category">All who choose category
		</td>
		<td valign="top"><a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=80}</span></a></td>
	</tr>


	<!--<tr height="25">
	    <td valign="top" align="right"><span class="red">*</span> Seller Type: </td>
	    <td align="left" valign="top">
		<select name="sellertype" id="sellertype" style="width:160px;" onchange="javascript: getSelleroptions(this.value);">
		  <option value=""> Select Seller Type </option>
		  {section name=i loop=$seller1}
		  <option value="{$seller1[i].seller_type_id}">{$seller1[i].seller_type_name}</option>
		  {/section}
		</select>
	    </td>
	</tr>-->

	 <!-- <tr>
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
		  </div>
	      </td>
	  </tr>
	  <tr {if $deal_info.option_website eq ""} style="display:none" {/if} id="web">
	      <td align="right">Website:&nbsp;</td>
	      <td>
		  <input type="text" name="website" value="{$deal_info.option_website}" id="website" class="textbox"/>
	      </td>
	  </tr>
	  <tr {if $deal_info.shop_location eq ""} style="display:none" {/if} id="addr">
	      <td align="right"> Address:</td>
	      <td >
		  <input type="text" name="shop_addr" id="shop_addr" value="" class="textbox" />
	      </td>
	  </tr>
	  <tr {if $deal_info.shop_location eq ""} style="display:none" {/if} id="li_city">
	      <td align="right"> High St/ Your Shop Location: </td>
	      <td >
		  <input type="text" name="shop_city" id="shop_city" value="" class="textbox" />
	      </td>
	  </tr>-->
	  <!--<tr>
	      <td align="right" valign="top"><strong> Listing Fee &pound;: </strong></td>
	      <td colspan="2" align="left"><span id="span1">xxxxx</span> </td>
	  </tr>
	  <tr>
	      <td align="right" valign="top"><strong> Estimate Final Value Fee &pound;: </strong></td>
	      <td colspan="2" align="left">&pound;<span id="span3">Cxxxxx</span></td>
	  </tr>	-->
          <tr>
	      <td>&nbsp;</td>
	      <td colspan="2"> <span id="buttonregister"><input type="submit" value="Create and Send Deal" name="Submit" id="Submit"/></span> <input type="button" value="Cancel" onclick="javascript: location='manage_deal.php';"/> </td>
	  </tr>
      </table>
    </form>
</div>
{include file=$footer}