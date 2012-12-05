{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<!--<script type="text/javascript" src="{$siteroot}/js/validation/admin/get_country_state_city.js"></script>-->
<script type="text/javascript">
{literal}
$(document).ready(function()
{
   	$.validator.addMethod("alphaOnly", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z -]/;
                temp = !str.test(value);
                return temp;
         }, "Only a to z, A to Z and - is allowed.");

    	$("#frmCity").validate({
		errorElement:'div',
				rules: {
					contryid: {
						required: true
					},
					stateid: {
						required: true
					},
					cname:
					{
						required: true,
						minlength: 1,
						maxlength:50,
						alphaOnly:true,
						//remote: SITEROOT + "/admin/city/ajax_check_name.php"
						remote: {url:SITEROOT + "/admin/city/ajax_check_name.php?cityid="+$('#cityid').val()+"&stateid="+$('#stateid').val(),type:"post"}
					}
					},
			messages:
				{
					contryid: {
							required: "Country is required for city"
					},
					stateid: {
						required: "Country/State  is required for city"
					},
					cname:
					{
						required: "Please enter City/Town",
						minlength:  $.format("Enter at least {0} characters"),
						maxlength: $.format("Enter maximum {0} characters"),
						remote: "This name is already in use"
					}
				}
	});

$("#msg").fadeOut(5000);
});
</script>
{/literal}
{literal}
<script type="text/javascript">
function getCity(val){
//alert(val);
ajax.sendrequest("GET", SITEROOT+"/admin/user/get_city.php", {val:val}, '', 'replace');
}
</script>
{/literal}
{literal}
<script language="JavaScript">
	$(document).ready(function()
{
   

$('#frmCity').submit(function(){
                    if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#Submit').attr('disabled','disabled'); 
               // $('#buttonregister').append("<input type='button' name='Submit' id='Submit' value='Add' />"); 
            }
        });
});
</script>
{/literal}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <!--<a href="{$siteroot}/admin/city/city_list.php?stateid={$state.id}&countryid={$country.countryid}">City List</a>
&gt;-->
<a href="{$siteroot}/admin/country/country_list.php">Country List</a> &gt; 
<a href="{$siteroot}/admin/state/state_list.php?stateid={$state.id}&contryid={$country.countryid}">County/State</a> &gt; 
<a href="{$siteroot}/admin/city/city_list.php?stateid={$state.id}&countryid={$country.countryid}">City/Town</a> &gt;
   {if $smarty.get.cid != ""}Edit City/Town{else}Add City/Town{/if}
</div>
<br />

<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{$sitetitle}{if $smarty.get.cid != ""} Edit City/Town{else} Add City/Town{/if}</h3>
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
    {if $smarty.get.cid == ""}
       <div>
        <form name="frmCity" id="frmCity" method="post" action="" enctype="multipart/form-data">
	<input type="hidden" name="cityid" id="cityid" value="" />
	<input type="hidden" name="task" id="task" value="Add" />
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
        <tr width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><a href="{$siteroot}/admin/city/city_list.php?stateid={$state.id}&countryid={$country.countryid}">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Country Name:</td>
                <td align="left" width="60%">
			<!--<select name="countries" id="countries" style="width:180px;" class="selectbox" onchange="javascript: getState(this.value,'{$siteroot}');">
				<option value="">Select Country</option>
				{section name=i loop=$country}
				<option value="{$country[i].countryid}">{$country[i].country}</option>
				{/section}
			</select>-->
			<input type="hidden" name="contryid" id="contryid" value="{$country.countryid}" />
			<h3>{$country.country|ucfirst}</h3>
		</td>
            </tr>
            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> County/State:</td>
                <td align="left" width="60%">
			<div id="statelist_div">
				<!--<select name="states" id="states"  class="selectbox" style="width:180px;" >
					{section name=i loop=$state_con}
						<option value="{$state_con[i].id}">{$state_con[i].state_name}</option>
					{sectionelse}
					<option value="">Select County/State</option>
					{/section}
				</select>--><!--<input type="text" name="country" id="country" value="{$country.country}" readonly="true">-->
				<input type="hidden" name="stateid" id="stateid" value="{$state.id}" />
				<h3>{$state.state_name|ucfirst}</h3>
			</div>
		</td>
            </tr>
            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> City/Town:</td>
                <td align="left" width="60%"><input name="cname" type="text" id="cname" value=""  size="15" class="textbox"/></td>
            </tr>
            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td align="left"> <span id="buttonregister"><input type="Submit" name="Submit" id="Submit" value="Add" /></span></td>
            </tr>
            </table>
        </form>
        </div>
        {else}
       <div>
       <form name="frmCity" id="frmCity" method="post" action="" enctype="multipart/form-data">
	<input type="hidden" name="cityid" id="cityid" value="{$cedit.city_id}" />
	<input type="hidden" name="task" id="task" value="Update" />
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><a href="javascript:history.go(-1);">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Country Name:</td>
                <td align="left" width="60%">
			<!--<select name="countries" id="countries" style="width:180px;" class="selectbox" onchange="javascript: getState(this.value,'{$siteroot}');">
				<option value="">Select Country</option>
				{section name=i loop=$country}
				<option value="{$country[i].countryid}" {if $cedit.country_id eq $country[i].countryid} selected="true" {/if} >{$country[i].country}</option>
				{/section}
			</select>--><h3>{$country.country|ucfirst}</h3>
			<input type="hidden" name="contryid" id="contryid" value="{$country.countryid}" />
			<input type="hidden" name="stateid" id="stateid" value="{$state.id}" />
		</td>
            </tr>
            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> County/State:</td>
                <td align="left" width="60%">
			<div id="statelist_div">
				<!--<select name="states" id="states"  class="selectbox" style="width:180px;" >
					{section name=i loop=$state_con}
						<option value="{$state_con[i].id}" {if $cedit.state_id eq $state_con[i].id} selected="true" {/if} >{$state_con[i].state_name}</option>
					{sectionelse}
					<option value="">Select</option>
					{/section}-->
				
				<h3>{$state.state_name|ucfirst}</h3>
			</div>
		</td>
            </tr>
            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> City/Town:</td>
                <td align="left" width="60%"><input name="cname" type="text" id="cname" value="{$cedit.city_name}"  size="15" class="textbox"/></td>
            </tr>
            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td align="left"> <span id="buttonregister"><input type="Submit" name="Submit" id="Submit" value="Update" /></span></td>
            </tr>
            </table>
        </form>
        </div>
            {/if}
        </div>
    </div>
</div>
{include file=$footer}