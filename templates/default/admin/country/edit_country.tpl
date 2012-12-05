{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function(){

$.validator.addMethod("numdotOnly", function(value, element){
		var temp;
		temp = true;
		str = /[^0-9.]/;
		temp = !str.test(value);
		
		if(temp)
		{
			var prodDiscprice = value;
			var totDotInprodDiscprice = 0;
			var noFirstDotInprodDiscprice = 'no';
			for(var i=0; i<prodDiscprice.length;i++)
			{
				if(prodDiscprice[0] == '.')
				{
					noFirstDotInprodDiscprice = 'yes';
				}
			
				if(prodDiscprice[i] == '.')
				{
					totDotInprodDiscprice++;
				}
			}
			if(totDotInprodDiscprice > 1 || noFirstDotInprodDiscprice == 'yes'){
				temp = false;
			}else{
				temp = true;
			}
		}
		return temp;
	}, "Only numbers and .(decimal) is allowed.");

//  $.validator.addMethod("numonly", function(value, element){
//                 var temp;
//                 temp = true;
//                 str = /[^0-9].[^0-9]/;
//                 temp = !str.test(value);
//                 return temp;
//          }, "Only 0-9 is allowed.");

jQuery.validator.addMethod("forprice", function(value, element){
                var temp;
                temp = true;
//                 str= /[^\d*].[^\d*]/;
		 str= /[^\d*\$].[^\d*\$]/;
                temp = !str.test(value);
                return temp;
         }, "Only 0 to 9 and . is allowed.");


   	$.validator.addMethod("alphaOnly", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z -]/;
                temp = !str.test(value);
                return temp;
         }, "Only a to z, A to Z and - is allowed.");

	jQuery("#frmCountry").validate({
		errorElement:'div',
		rules: {
			country: {
				required: true,
				alphaOnly:true,
				maxlength:50,
				remote: {url:SITEROOT + "/admin/country/ajax_check_name.php?countryid="+$('#countryid').val(),type:"post"}
		 	},
		 	vat:{
		 	        required: true,
		 	        forprice: true,
				numdotOnly : true
		 	}
		},
		messages: {
			country: {
					required: "Please enter country name",
					maxlength: $.format("Enter maximum {0} characters"),
					remote: "This name is already in use"
		 	},
		 	vat:{
		 	            required: "Please enter VAT value",
                                    forprice: "Please enter numbers only",
				   numdotOnly: "Please enter numbers only"
		 	}
		}
	});
});
</script>
{/literal}

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/country/country_list.php">Country List</a>
 &gt; {if $country.countryid}Edit Country{else}Add Country{/if}</div>
<br />

<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{$sitetitle} {if $country.countryid}Edit{else}Add{/if} Country</h3>
        </div>
        <div class="clr">
        </div>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>
    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv" >
    <div>
        <form name="frmCountry" id="frmCountry" method="post" action="" enctype="multipart/form-data">
	<input type="hidden" name="countryid" id="countryid" value="{$country.countryid}" />
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><a href="{$siteroot}/admin/country/country_list.php">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Country Name:</td>
                <td align="left" width="60%">
			<input name="country" type="text" id="country" value="{$country.country}"  size="15" class="textbox" style="color:#000000;"/>
		</td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> VAT:</td>
                <td align="left" width="60%">
			<input name="vat" type="text" id="vat" value="{$country.vat}"  size="15" class="textbox" style="color:#000000;" maxlength="5"/>
		</td>
            </tr>
            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td align="left"><input type="Submit" name="Submit" value="{if $country.countryid}Update{else}Add{/if}" /></td>
            </tr>
            </table>
        </form>
        </div>
        </div>
    </div>
</div>
{include file=$footer}