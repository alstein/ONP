{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function(){
   	$.validator.addMethod("alphaOnly", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z -]/;
                temp = !str.test(value);
                return temp;
         }, "Only a to z, A to Z and - is allowed.");

	jQuery("#frmState").validate({
		errorElement:'div',
		rules: {
// 			countries: {
// 				required: true
// 		 	},
			states: {
				required: true,
				alphaOnly:true,
				maxlength:50,
				//remote: {url:SITEROOT + "/admin/state/ajax_check_name.php?stateid="+$('#stateid').val()+"&countryid="+$('#countries').val(),type:"post"}
				remote: {url:SITEROOT + "/admin/state/ajax_check_name.php?countryid="+$('#countryid').val()+"&stateid="+$('#stateid').val(),type:"post"}
		 	}
		},
		messages: {
// 			countries: {
// 					required: "Please select country"
// 			},
			states: {
					required: "Please enter County/State",
					maxlength: $.format("Enter maximum {0} characters"),
					remote: "This name is already in use"
		 	}
		}
	});
});
</script>
{/literal}
{literal}
<script language="JavaScript">
$(document).ready(function()
{

$('#frmState').submit(function(){
                    if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#Add').attr('disabled','disabled'); 
            }
        });
});




</script>
{/literal}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;  
<a href="{$siteroot}/admin/country/country_list.php">Country List</a> &gt;  
<a href="{$siteroot}/admin/state/state_list.php?contryid={$country.countryid}">County/State</a> &gt; {if $state.id}Edit County/State{else}Add County/State{/if}</div>
<br />
<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{$sitetitle} {if $state.id}Edit{else}Add{/if} County/State</h3>
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

        <form name="frmState" id="frmState" method="post" action="" enctype="multipart/form-data">
	<input type="hidden" name="stateid" id="stateid" value="{$state.id}" />
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><a href="{$siteroot}/admin/state/state_list.php?contryid={$country.countryid}">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Country:</td>
                <td align="left" width="60%">
			<!--<select name="countries" id="countries" style="color:#000000;">
				{section name=i loop=$country}
				<option value="{$country[i].countryid}" {if $state.country_id eq $country[i].countryid} selected="true" {/if} >{$country[i].country}</option>
				{/section}
			</select>-->
			<input type="hidden" name="countryid" id="countryid" style="color:#000000;" value="{$country.countryid}">
			<!--<input type="text" name="countries" id="countries" style="color:#000000;" value="{$country.country|ucfirst}" readonly="true">-->
			<h3>{$country.country|ucfirst}</h3>
		</td>
            </tr>
		<tr>
		<td align="right" colspan="2">&nbsp;</td>
		</tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> County/State:</td>
                <td align="left" width="60%">
			<input name="states" type="text" id="states" value="{$state.state_name}"  size="15" class="textbox" style="color:#000000;"/>
		</td>
            </tr>
            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td align="left"> <div id="buttonregister" style="width:10px;" ><input type="submit" name="Add" id="Add" value="{if $state.id}Update{else}Add{/if}" /></div></td>
            </tr>
            </table>
        </form>
        </div>
        </div>
    </div>
</div>
{include file=$footer}